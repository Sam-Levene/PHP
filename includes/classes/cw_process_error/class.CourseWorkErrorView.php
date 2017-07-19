<?php
/*
 * This code is the Error View, it configures the error view into readable HTML format before collating
 * all the data into one variable, that it passes to the parent code for the ProcessOutput to display
*/
	class CourseWorkErrorView extends CourseWorkWebPageTemplateView
	{
		private $c_error_message;
		private $c_obj_db_handle;
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			parent::__construct();
			$this->c_error_message = '';
			$this->c_error_message = '';
			$this->c_obj_db_handle = null;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_error_message($p_error_message)
		{
			$this->c_error_message = $p_error_message;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_database_handle($p_obj_db_handle)
		{
			$this->c_obj_db_handle = $p_obj_db_handle;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function create_error_message()
		{
			$this->set_page_title();
			$this->create_page_body();
			$this->create_web_page();
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_html_output()
		{
			return $this->c_html_page_output;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function set_page_title()
		{
			$m_app_name = APP_NAME;
			$this->c_page_title = $m_app_name . ': processing error...';
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function create_page_body()
		{
			$m_address = APP_ROOT_PATH;
			$m_page_heading = 'M2M SMS Messaging System Error';
			$m_system_message = 'The System Administrator has been notified.';

			$m_html_output = <<< HTML
<h2>$m_page_heading</h2>
<p>$this->c_error_message</p>
<p>$m_system_message</p>
HTML;
			$this->c_html_page_content = $m_html_output;
		}
	}
?>