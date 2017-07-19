<?php
/* 
 * The following code validates the array passed to it by stripping it of all HTML tags and any other tags such as
 * PHP or SQL injection code.
*/
	class CourseWorkDownloadMessageDataValidate
	{
		private $c_arr_tainted;
		private $c_arr_cleaned;

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_arr_tainted = array();
			$this->c_arr_cleaned = array();
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_sanitised_input()
		{
			return $this->c_arr_cleaned;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_sanitise_input($p_arr_tainted)
		{
			$m_validated_message_data= false;
			$this->c_arr_tainted = $p_arr_tainted;
			
			$m_valid_details = false;
			$m_error_count = 0;
			
			if (isset($this->c_arr_tainted))
			{
				$m_message_data_to_validate = $this->c_arr_tainted;
			}
			else
			{
				$m_error_count++;
			}
			
			if ($m_error_count == 0)
			{
				$m_validated_message_data = filter_var_array($m_message_data_to_validate,FILTER_SANITIZE_STRING);
			}
			else
			{
				$m_validated_message_data = NULL;
			}
			$this->c_arr_cleaned['sanitised-message-data'] = $m_validated_message_data;
		}
	}
?>