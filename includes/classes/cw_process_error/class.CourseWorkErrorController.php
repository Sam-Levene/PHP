<?php
/*
 * This is the code for the Error Controller, this sets up the Error View and the
 * Error Model, before passing the returned value to the parent code to display
 */
	class CourseWorkErrorController
	{
		private $c_html_output;
		private $c_error_type;
		private $c_output_error_message;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_html_output = '';
			$this->c_error_type = '';
			$this->c_output_error_message = '';
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_html_output()
		{
			return $this->c_html_output;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_error_type($p_error_type)
		{
			$this->c_error_type = $p_error_type;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_process_error()
		{
			$this->c_output_error_message = CourseWorkContainer::make_cw_error_model($this->c_error_type);
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_create_output()
		{
			$this->c_html_output = CourseWorkContainer::make_cw_error_view($this->c_output_error_message);
		}
	}
?>