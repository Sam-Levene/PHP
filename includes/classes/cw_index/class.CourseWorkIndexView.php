<?php
/*
 * This code is the Index View, this sets up the main index as the first outputted visual element to display
 * When the code is run for the first time. It returns the HTML output to the parent to display in the
 * ProcessOutput
 */
	class CourseWorkIndexView extends CourseWorkWebPageTemplateView
	{
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_create_form()
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
			$this->c_page_title = 'Coursework M2M SMS Messaging Index';
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function create_page_body()
		{
			$m_address = APP_ROOT_PATH;
			$m_info_text = 'Application will allow you to download an M2M SMS Message from an on-line source, or to review pre-stored messages.';

			$m_page_heading = 'CourseWork Messaging';

			$this->c_html_page_content = <<< HTMLFORM
<h2>$m_page_heading</h2>
<p>$m_info_text</p>
<form action="$m_address" method="post">
<p class="curr_page"></p>
<form action="index.php" method="post">
	<fieldset>
	<legend>Select option</legend>
	<br />
	<button name="feature" value="download_message_data">Download Message Data</button>
	<br />
	<br />
	<button name="feature" value="display_message_data">Review Stored Messages</button>
	</fieldset>
</form>
HTMLFORM;
		}
	}
?>