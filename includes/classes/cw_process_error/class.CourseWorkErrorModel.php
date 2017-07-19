<?php
/*
 * This is the code for the Error Model class, this configures the type of error returned into different 
 * types, storing the error into the database and passing it back to the controller, which then 
 * passes it to the view to be configured for display purposes.
*/
	class CourseWorkErrorModel
	  {
			private $c_obj_database_handle;
			private $c_error_type;
			private $c_output_error_message;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_obj_database_handle = null;
			$this->c_error_type = '';
			$this->c_output_error_message = '';
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_error_message()
		{
			return $this->c_output_error_message;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_database_handle($p_obj_database_handle)
		{
			$this->c_obj_database_handle = $p_obj_database_handle;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_error_type($p_error_type)
		{
			$this->c_error_type = $p_error_type;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_select_error_message()
		{
			switch ($this->c_error_type)
			{
				case 'class-not-found-error':
					$m_error_message = 'Something went wrong - please try again later';
					break;
				case 'file-not-found-error':
					$m_error_message = '404 File Not Found - please try again later';
					break;
				default:
					$m_error_message = 'Oops - there was an internal error - please try again later';
					break;
			}
			$this->c_output_error_message = $m_error_message;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_log_error_message()
		{
			$m_user_id = '';

			$m_number_of_inserted_messages = 0;

			$m_sql_query_string = CourseWorkSqlQuery::get_error_logging_query_string();
			$m_arr_sql_parameters = array(':logmessage' => $this->c_error_type);

			$this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_parameters);
			$m_number_of_inserted_messages = $this->c_obj_database_handle->count_rows();
		}
	}
?>