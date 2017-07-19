<?php
/*
 * The following code is the Download Message Data Model, it sets up the SOAP connection; the Database connection
 * retrieves the messages from the SOAP server, checks the database to determine if the message already exists,
 * it splits the data into chunks based upon the size of the fields in the database. If the data does not exist,
 * it stores the new chunks in their relevant fields in the database, and even if the data does exist, it sets up
 * the data to display, before passing the data to display back to the controller.
 */
	class CourseWorkDownloadMessageDataModel
	{
		private $c_obj_database_handle;
		private $c_obj_soap_client_handle;
		public $c_arr_download_message_data;
		private $c_arr_database_connection_messages;
		private $c_arr_prepared_message_data;
		public $c_raw_xml;
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_obj_database_handle = null;
			$this->c_obj_soap_client_handle = null;
			$this->c_arr_download_message_data = array();
			$this->c_arr_database_connection_messages = array();
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_database_handle($p_obj_database_handle)
		{
			$this->c_obj_database_handle = $p_obj_database_handle;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_get_database_connection_result()
		{
			$this->c_arr_database_connection_messages = $this->c_obj_database_handle->get_connection_messages();
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_message_data($p_arr_sanitised_input)
		{
			$m_sanitised_message_data = '';
			$m_raw_xml = '';
			if (isset($p_arr_sanitised_input['sanitised-message-data']))
			{
				$m_sanitised_message_data = $p_arr_sanitised_input['sanitised-message-data'];
			}
			if (isset($p_arr_sanitised_input['raw-xml']))
			{
				$m_raw_xml = $p_arr_sanitised_input['raw-xml'];
			}
			$this->c_arr_download_message_data['sanitised-message-data'] = $m_sanitised_message_data;
			$this->c_arr_download_message_data['raw-xml'] = $m_raw_xml;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_download_message_data()
		{
			$this->do_create_soap_client();
			$this->do_get_message_data();
			
			if ($this->c_arr_download_message_data['soap-server-get-message-result-error'])
			{
				$this->do_parse_downloaded_message_data();
				$this->do_check_message_data_available();
			}
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*

		public function return_message_data()
		{
			return $this->c_arr_download_message_data;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_downloaded_message_data_result()
		{
			return $this->c_raw_xml;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		private function do_create_soap_connection_parameters()
		{
			$m_arr_soapclient = array();
			$m_arr_dmu_proxy_settings = array();
			$m_arr_soapclient = array('trace' => true, 'exceptions' => true);
			$m_dmu_network = '146.227';
			$m_host_ip_address = getHostByName(getHostName());

			$m_local_host_network = substr($m_host_ip_address, 0, 7);

			if (strcmp($m_local_host_network, $m_dmu_network) == 0)
			{
				$m_arr_dmu_proxy_settings = array('proxy_host' => 'proxy.dmu.ac.uk', 'proxy_port' => 8080);
			}
			
			$m_arr_soapclient_settings = array_merge($m_arr_soapclient, $m_arr_dmu_proxy_settings);
			return $m_arr_soapclient_settings;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_soap_client()
		{
			$m_soap_server_connection_result_error = true;
			$m_arr_soapclient = array();

			$m_arr_message_data_connection_details = CourseWorkConfig::get_sms_connection_details();
			$m_wsdl = $m_arr_message_data_connection_details['wsdl'];

			$m_arr_soapclient_settings = $this->do_create_soap_connection_parameters();
			
			try
			{
				$this->c_obj_soap_client_handle = new SoapClient($m_wsdl, $m_arr_soapclient_settings);
				$m_soap_server_connection_result_error = false;
			}
			catch (SoapFault $m_obj_exception)
			{
				trigger_error($m_obj_exception);
			}
			$this->c_arr_download_message_data['soap-server-connection-result-error'] = $m_soap_server_connection_result_error;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_get_message_data()
		{
			$m_soap_server_get_message_result_error = false;
			$m_obj_message_data = null;
			$m_raw_xml = '';
			$m_sanitised_message_data = $this->c_arr_download_message_data;
			$m_arr_message_data = array('message' => $m_sanitised_message_data);

			if ($this->c_obj_soap_client_handle)
			{
				try
				{
					$username = "samlevene";
					$password = "Alphabet12";
					$count = "100";
					$deviceMsisdn = '';
					$countryCode = '';
					$m_obj_message_data = $this->c_obj_soap_client_handle->peekMessages($username, $password, $count, $deviceMsisdn, $countryCode);
					
					$this->c_raw_xml = $m_obj_message_data;

					if ($m_raw_xml = '' || strcmp($m_raw_xml, 'exception') != 0)
					{
						$m_soap_server_get_message_result_error = false;
					}
					
				}
				catch (SoapFault $m_obj_exception)
				{
					trigger_error($m_obj_exception);
				}
			}

			$this->c_arr_download_message_data['raw-xml'] = $this->c_raw_xml;
			$this->c_arr_download_message_data['soap-server-get-message-result-error'] = $m_soap_server_get_message_result_error;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_parse_downloaded_message_data()
		{
			$this->c_arr_download_message_data['download-message-data'] = CourseWorkContainer::make_cw_xml_parser_wrapper($this->c_arr_download_message_data['raw-xml']);
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_check_message_data_available()
		{
			$m_message_data_available = true;
			if ($this->c_arr_download_message_data['download-message-data']['LAST'] == '0.00')
			{
				$m_message_data_available = false;
			}
			$this->c_arr_download_message_data['message-data-available'] = $m_message_data_available;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_store_downloaded_message_data()
		{
			if ($this->c_arr_download_message_data != NULL)
			{
				$this->do_prepare_message_data();
				if (!$this->do_check_if_data_exists())
				{
					$this->do_store_new_data();
					$this->c_arr_download_message_data['soap-server-get-message-result-error'] = CourseWorkContainer::make_send_confirmation();
				}
			}
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_prepare_message_data()
		{
			$m_database_connection_error = $this->c_arr_database_connection_messages['database-connection-error'];
			
			if (!$m_database_connection_error)
			{
				foreach($this->c_arr_download_message_data['sanitised-message-data'] as $m_data)
				{
					$m_array = str_split($m_data,12);
					
					$this->c_arr_download_message_data['source-terminal'][] = $m_array[0];
					$this->c_arr_download_message_data['destination-terminal'][] = $m_array[1];
					
					$size = sizeof($m_array);
					$m_new_data = '';
					
					for($int = 2; $int < $size; $int = $int + 1)
					{
						$m_new_data .= $m_array[$int];
					}
					
					$m_array = str_split($m_new_data,10);
					
					$this->c_arr_download_message_data['message-date'][] = $m_array[0];
					
					$size = sizeof($m_array);
					$m_new_data = '';
					
					for($int = 1; $int < $size; $int = $int + 1)
					{
						$m_new_data .= $m_array[$int];
					}
					
					$m_array = str_split($m_new_data,9);
					
					$str=preg_replace('/\s+/', '', $m_array[0]);
					
					$this->c_arr_download_message_data['message-time'][] = $str;
					
					$size = sizeof($m_array);
					$m_new_data = '';
					
					for($int = 1; $int < $size; $int = $int + 1)
					{
						$m_new_data .= $m_array[$int];
					}
					
					$m_array = str_split($m_new_data,3);
					
					$this->c_arr_download_message_data['message-type'][] = $m_array[0];
					
					$size = sizeof($m_array);
					$m_new_data = '';
					
					for($int = 1; $int < $size; $int = $int + 1)
					{
						$m_new_data .= $m_array[$int];
					}
					
					$m_array = str_split($m_new_data,1);
					
					$this->c_arr_download_message_data['message-reference'][] = $m_array[0];
					$size = sizeof($m_array);
					$m_new_data = '';
					
					for($int = 1; $int < $size; $int = $int + 1)
					{
						$m_new_data .= $m_array[$int];
					}
					
					$this->c_arr_download_message_data['message-data'][] = $m_new_data;
				}
			}
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
    // check to see if the data values exist in the message values database table
		private function do_check_if_data_exists()
		{
			$this->correct_time_string();
			$this->correct_date_string();
			
			$m_message_source = $this->c_arr_download_message_data['source-terminal'];
			$m_message_destination = $this->c_arr_download_message_data['destination-terminal'];
			$m_message_date = $this->c_arr_download_message_data['message-date'];
			$m_message_time = $this->c_arr_download_message_data['message-time'];
			$m_message_type = $this->c_arr_download_message_data['message-type'];
			$m_message_reference = $this->c_arr_download_message_data['message-reference'];
			$m_message_data = $this->c_arr_download_message_data['message-data'];
			
			$m_sql_query_string = CourseWorkSqlQuery::does_message_exist();

			$m_arr_sql_query_parameters =
			array(	':source_terminal' => $m_message_source,
					':destination_terminal' => $m_message_destination,
					':message_date' => $m_message_date,
				  	':message_time' => $m_message_time,
				  	':message_type' => $m_message_type,
					':message_reference' => $m_message_reference,
					':message_data' => $m_message_data);

			$this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);

			$m_number_of_rows = $this->c_obj_database_handle->count_rows();
			$m_message_data_exists = false;
			if ($m_number_of_rows > 0)
			{
				$m_message_data_exists = true;
			}
		  return $m_message_data_exists;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_store_new_data()
		{
			$m_message_source = $this->c_arr_download_message_data['source-terminal'];
			$m_message_destination = $this->c_arr_download_message_data['destination-terminal'];
			$m_message_date = $this->c_arr_download_message_data['message-date'];
			$m_message_time = $this->c_arr_download_message_data['message-time'];
			$m_message_type = $this->c_arr_download_message_data['message-type'];
			$m_message_reference = $this->c_arr_download_message_data['message-reference'];
			$m_message_data = $this->c_arr_download_message_data['message-data'];

			$m_sql_query_string = CourseWorkSqlQuery::store_message_data();

			$m_arr_sql_query_parameters =
			array(	':source_terminal' => $m_message_source,
					':destination_terminal' => $m_message_destination,
					':message_date' => $m_message_date,
				  	':message_time' => $m_message_time,
				  	':message_type' => $m_message_type,
					':message_reference' => $m_message_reference,
					':message_data' => $m_message_data);


			$m_arr_database_execution_messages = $this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters);
			$m_new_message_data_stored = false;

			if ($m_arr_database_execution_messages['execute-OK'])
			{
				$m_new_message_data_stored = true;
			}
			$this->c_arr_download_message_data['message-details-stored']= $m_new_message_data_stored;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
    /** example of web service API update
     * time now has am/pm appended
     * so these now have to be stripped out
     * so that the database will accept this data
     */
		private function correct_time_string()
		{
			$m_message_time = $this->c_arr_download_message_data['message-time'];
			$m_message_time = str_replace('am', '', $m_message_time);
			$m_message_time = str_replace('pm', '', $m_message_time);
			$this->c_arr_download_message_data['message-time'] = $m_message_time;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*

		private function correct_date_string()
		{
			$m_date_fixed = array();
			foreach($this->c_arr_download_message_data['message-date'] as $m_date)
			{
				$m_arr_date = explode('/', $m_date);		
				$m_date_fixed[] .= "$m_arr_date[2]" . "-" . "$m_arr_date[1]" . "-" . "$m_arr_date[0]";
			}
			
			$this->c_arr_download_message_data['message-date'] = $m_date_fixed;
		}
	}
?>