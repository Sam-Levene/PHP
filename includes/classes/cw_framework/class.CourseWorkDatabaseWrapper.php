<?php

	class CourseWorkDatabaseWrapper
	{
		private $c_arr_database_connect_details;
		private $c_arr_database_connection_messages;
		private $c_obj_database_handle;
		private $c_obj_stmt;
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_arr_database_connect_details = array();
			$this->c_obj_database_handle = null;
			$this->c_obj_stmt = null;
			$this->c_arr_database_connection_messages = array();
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct() 
		{
			$this->c_obj_database_handle = null;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This takes the database connection settings and stores them.
		public function set_connection_settings($p_arr_connection_settings)
		{
			$this->c_arr_database_connect_details = $p_arr_connection_settings;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This sets up the database connection and attempts to connect to the database
		public function do_connect_to_database()
		{
			$m_database_connection_error = true;
			$m_host_name = $this->c_arr_database_connect_details['host_name'];
			$m_user_name = $this->c_arr_database_connect_details['user_name'];
			$m_user_password = $this->c_arr_database_connect_details['user_password'];

			try
			{
				$this->c_obj_database_handle = new PDO($m_host_name, $m_user_name, $m_user_password);
				$this->c_arr_database_connection_messages['connection'] = 'Connected to the database.';
				$m_database_connection_error = false;
			}
			//If this fails, the returned values will be errors that are sent to the error controller.
			catch (PDOException $m_exception_object)
			{
				$this->c_arr_database_connection_messages['connection'] = 'Cannot connect to the database.';
				trigger_error($m_exception_object);
			}
			$this->c_arr_database_connection_messages['database-connection-error'] = $m_database_connection_error;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This function returns the connection messages to the parent code
		public function get_connection_messages()
		{
			return $this->c_arr_database_connection_messages;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This following code attempts to query the database with a query string and connection parameters
		public function safe_query($p_query_string, $p_arr_params)
		{
			$m_database_query_execute_error = true;
			$m_query_string = $p_query_string;
			$m_arr_query_parameters = $p_arr_params;

			try
			{
				$m_temp = array();
				$this->c_obj_database_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$this->c_obj_stmt = $this->c_obj_database_handle->prepare($m_query_string);
				
				// bind the parameters
				if (sizeof($m_arr_query_parameters) > 0)
				{
					foreach ($m_arr_query_parameters as $m_param_key => $m_param_values)
					{
						if (is_array($m_param_values))
						{
							foreach ($m_param_values as $m_param_value)
							{
								$this->c_obj_stmt->bindValue($m_param_key, $m_param_value);
							}
						}
						else
						{
							$this->c_obj_stmt->bindValue($m_param_key, $m_param_values);
						}
					}
				}
				
				// execute the query
				$m_execute_result = $this->c_obj_stmt->execute();
				$this->c_arr_database_connection_messages['execute-OK'] = $m_execute_result;
				$m_database_query_execute_error = false;
			}
			
			//If the attempt to query the database fails, then set up the error message and trigger the error; which breaks
			//The program and returns the error to the view.
			catch (PDOException $m_exception_object)
			{
				$m_error_information = print_r($this->c_obj_stmt->errorInfo(), true);
				$m_error_message  = 'PDO Exception caught. ';
				$m_error_message .= 'Error with the database access. ';
				$m_error_message .= 'SQL query: ' . $m_query_string;
				$m_error_message .= 'Error: ' . $m_error_information . "\n";
				$this->c_arr_database_connection_messages['sql-error'] = $m_error_message;
				$this->c_arr_database_connection_messages['pdo-error-code'] = $m_error_information;
				trigger_error($m_exception_object);
			}
			$this->c_arr_database_connection_messages['database-query-execute-error'] = $m_database_query_execute_error;
			return $this->c_arr_database_connection_messages;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This counts the number of rows in the query response and returns it.
		public function count_rows()
		{
			$m_num_rows = 0;
			if ($this->c_obj_stmt != null)
			{
				$m_num_rows = $this->c_obj_stmt->rowCount();
			}
			return $m_num_rows;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This counts the number of fields in the query response and returns it.
		public function count_fields($p_query_result)
		{
			$m_num_fields = 0;
			if ($this->c_obj_stmt != null)
			{
				$m_num_fields = $p_query_result->columnCount();
			}
			return $m_num_fields;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This fetches the rows of the returned array to the parent code.
		public function safe_fetch_row()
		{
			$m_record_set = null;
			$m_escaped_record_set = '';
			if ($this->c_obj_stmt != null)
			{
				$m_record_set = $this->c_obj_stmt->fetch(PDO::FETCH_NUM);
				$m_escaped_record_set = $this->do_escape_output_array($m_record_set);
			}
			return $m_escaped_record_set;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This fetches the returned array itself to the parent code.
		public function safe_fetch_array()
		{
			$m_record_set = null;
			$m_escaped_record_set = '';
			if ($this->c_obj_stmt != null)
			{
				$m_record_set = $this->c_obj_stmt->fetch(PDO::FETCH_ASSOC);
				$m_escaped_record_set = $this->do_escape_output_array($m_record_set);
			}
			return $m_escaped_record_set;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This fetches all results to the parent code.
		public function safe_fetch_all_results()
		{
			$m_record_set = null;
			$m_escaped_record_set = '';
			if ($this->c_obj_stmt != null)
			{
				$m_record_set = $this->c_obj_stmt->fetchAll();
				$m_escaped_record_set = $this->do_escape_output_array($m_record_set);
			}
			return $m_escaped_record_set;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This fetches the object of the escaped record and returns it to the parent code.
		public function safe_fetch_object()
		{
			$m_record_set = null;
			$m_escaped_record_set = '';
			if ($this->c_obj_stmt != null)
			{
				$m_record_set = $this->c_obj_stmt->fetchObject();
				$m_escaped_record_set = $this->do_escape_output_array($m_record_set);
			}
			return $m_escaped_record_set;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This fetches the last inserted ID from the sql query and returns it.
		public function last_inserted_id()
		{
			$m_sql_query = 'SELECT LAST_INSERT_ID()';

			$this->safe_query($m_sql_query);
			$m_arr_last_inserted_id = $this->safe_fetch_array();
			$m_last_inserted_id = $m_arr_last_inserted_id['LAST_INSERT_ID()'];
			return $m_last_inserted_id;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//This works with the escaped output array; sets up all the flags and creates the output for any escaped outputs.
		//Then returns it to the parent code.
		private function do_escape_output_array($p_arr_unescaped_output)
		{
			$m_arr_escaped_html_output = array();
			$m_encoding = 'UTF-8';
			$m_double_encode = false;

			if (phpversion()>= 5.4)
			{
				$m_ent_flags = ENT_QUOTES | ENT_SUBSTITUTE;
			}
			else
			{
				$m_ent_flags = ENT_QUOTES;
			}
			if ($p_arr_unescaped_output !== false)
			{
				foreach($p_arr_unescaped_output as $m_word => $m_word_value)
				{
					$m_arr_escaped_html_output[$m_word]= htmlentities($m_word_value, $m_ent_flags, $m_encoding, $m_double_encode);
				}
			}
			return $m_arr_escaped_html_output;
		}
	}
?>