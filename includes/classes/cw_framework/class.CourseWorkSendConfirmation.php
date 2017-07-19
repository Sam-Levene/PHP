<?php
	
	class CourseWorkSendConfirmation
	{
		public $c_obj_soap_client_handle;
		public $c_arr_download_message_data;
		
		public function __construct()
		{
			$this->c_obj_soap_client_handle = null;
			$this->c_arr_download_message_data = array();
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
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
		public function do_create_soap_client()
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
		public function do_send_message_data()
		{
			if ($this->c_obj_soap_client_handle)
			{
				try
				{
					$username = "samlevene";
					$password = "Alphabet12";
					$deviceMsisdn = "+447950491677";
					$message = "A new message has arrived in the database.";
					$report = "1";
					$bearer = "SMS";
						
					$m_obj_message_data = $this->c_obj_soap_client_handle->sendMessage($username, $password, $deviceMsisdn, $message, $report, $bearer);
				}
				catch(SoapFault $m_obj_exception)
				{
					trigger_error($m_obj_exception);
				}
			}
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_download_message_data()
		{
			return $this->c_arr_download_message_data;
		}
	}

?>