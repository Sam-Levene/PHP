<?php
/*
 * This code is the Download Message View, this sets up the view as the outputted visual element to display
 * When the "Download Message Data" element is selected. It returns the HTML output to the parent to display in the
 * ProcessOutput
*/
	class CourseWorkDownloadMessageDataView extends CourseWorkWebPageTemplateView
	{
		private $c_arr_download_message_data_result;
		private $c_error_message;
		private $c_page_content;

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_arr_download_message_data_result = array();
			$this->c_error_message = '';
			$this->c_page_content = '';
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct() 
		{
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_create_output_page()
		{
			$this->do_assign_page_title();
			$this->do_create_relevant_error_message();
			$this->do_create_html_content();
			$this->create_web_page();
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_html_output()
		{
			return $this->c_html_page_output;
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_downloaded_message_data($p_arr_download_message_data_result)
		{
			$this->c_arr_download_message_data_result = $p_arr_download_message_data_result;
		}

	// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_assign_page_title()
		{
			$this->c_page_title = 'Download & Display M2M SMS Message Data';
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_relevant_error_message()
		{			
			$m_sanitised_message_data = '';
			if (isset($this->c_arr_download_message_data_result['sanitised-message-data']))
			{
				$m_sanitised_message_data = $this->c_arr_download_message_data_result['sanitised-message-data'];
				if (!$this->c_arr_download_message_data_result['sanitised-message-data'])
				{
					$this->c_error_message = 'Oops - there was a problem with the message data you entered';
				}
			}

			if (isset($this->c_arr_download_message_data_result['database-connection-error']))
			{
				if (!$this->c_arr_download_message_data_result['database-connection-error'])
				{
					$this->c_error_message = 'Oops - there was a problem connecting with the database';
				}
			}
			
			if (isset($this->c_arr_download_message_data_result['soap-server-connection-result-error']))
			{
				if (!$this->c_arr_download_message_data_result['soap-server-connection-result-error'])
				{
					$this->c_error_message = 'Oops - there was a problem connecting with the web service';
				}
			}

			if (isset($this->c_arr_download_message_data_result['soap-server-get-message-result-error']))
			{
				if (!$this->c_arr_download_message_data_result['soap-server-get-message-result-error'])
				{
					$this->c_error_message = 'Oops - there was a problem - the web service did not return any data for that message';
				}
			}

			if (isset($this->c_arr_download_message_data_result['message-data-available']))
			{
				if (!$this->c_arr_download_message_data_result['message-data-available'])
				{
					$this->c_error_message = 'No data for that message(' . $m_sanitised_message_data . ')';
				}
			}
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_html_content()
		{
			$m_page_content = '';

			if ($this->c_error_message != '')
			{
				$this->do_create_html_error_message();
			}
			else
			{
				$this->do_create_message_data_display();
			}

			$m_address = APP_ROOT_PATH;
			
			$this->c_html_page_content = <<< COURSEWORKDATARESULT
<div id="lg-form-container">
<h2>Downloaded M2M SMS Message Data</h2>
$this->c_page_content
<form method="post" action="$m_address">
<input type="hidden" name="module" value="enter-message-data" />
<label for="anothergo"><b>Another Message?</b></label>
<button name="feature" value="download_message_data">Download Message Data</button>
</label>
</form>
</p>
</div>
COURSEWORKDATARESULT;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_html_error_message()
		{
			$this->c_page_content = <<< COURSEWORKDATAERROR
<p class="result">$this->c_error_message</p>
COURSEWORKDATAERROR;
		}
		
 // ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_message_data_display()
		{
			foreach($this->c_arr_download_message_data_result['sanitised-message-data'] as $m_data)
			{
				$m_validated_message_data = $m_data;
			}
			
			$m_message_xml_data = $this->c_arr_download_message_data_result['raw-xml'];
			
			foreach($m_message_xml_data as $xml)
			{
				$m_message_xml_data = htmlentities($xml);
			};
			
			$this->c_page_content = <<< COURSEWORKDATARESULTS
<p>Download Successful</p>
COURSEWORKDATARESULTS;
		}
	}
?>