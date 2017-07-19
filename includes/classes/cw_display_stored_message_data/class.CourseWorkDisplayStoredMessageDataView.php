<?php
/*
 * This code is the Display Stored Message Data View, it configures the message data provided by the model into
 * a readable HTML format by splitting up the data into different fields, before arranging it in a tabular format
 * It then passes the HTML data to the parent to display in the ProcessOutput
*/
	class CourseWorkDisplayStoredMessageDataView extends CourseWorkWebPageTemplateView
	{
		private $c_arr_stored_message_data;
		private $c_error_message;
		private $c_page_content;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_arr_stored_message_data = array();
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
			$this->do_create_relevant_output();
			$this->create_web_page();
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_html_output()
		{
			return $this->c_html_page_output;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_stored_message_data($p_arr_stored_message_data)
		{
		  	$this->c_arr_stored_message_data = $p_arr_stored_message_data;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_assign_page_title()
		{
			$this->c_page_title = 'Display stored M2M SMS Message Data';
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_relevant_output()
		{
			if ($this->c_arr_stored_message_data == NULL)
			{
				$this->do_create_error_message();
			}
			else
			{
				$this->do_display_message_details();
			}
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_create_error_message()
		{
			$this->c_page_content = <<< SYMBOLERRORPAGE
<div id="lg-form-container">
<p class="error">Oops - there was a problem with the message
you selected/entered</p>
</div>
SYMBOLERRORPAGE;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function do_display_message_details()
		{
			$m_message_id = '';
			$m_message_source = '';
			$m_message_destination = '';
			$m_message_date = '';
			$m_message_time = '';
			$m_message_type = '';
			$m_message_ref = '';
		  	$m_message_data = '';
		  	$m_message_view = '';
		  	
		  	$m_address = APP_ROOT_PATH;
		  
		  	foreach($this->c_arr_stored_message_data['message-retrieved-data'] as $m_value)
		  	{
		  		$m_message_id = "<td>" . $m_value['id'] . "</td>";
		  		$m_message_source = "<td>" . $m_value['source'] . "</td>";
				$m_message_destination = "<td>" . $m_value['destination'] . "</td>";
				$m_message_date = "<td>" . $m_value['date'] . "</td>";
				$m_message_time = "<td>" . $m_value['time'] . "</td>";
				$m_message_type = "<td>" . $m_value['type'] . "</td>";
				$m_message_ref = "<td>" . $m_value['reference'] . "</td>";
		  		$m_message_data = "<td>" . $m_value['data'] . "</td>";
		  		
		  		$m_message_view .= "<tr>" . $m_message_id . $m_message_source . $m_message_destination . $m_message_date . $m_message_time . $m_message_type . $m_message_ref . $m_message_data . "</tr>";
		  	}

		 	$this->c_html_page_content = <<< VIEWSTOREDMESSAGEDATA
<div id="lg-form-container">
<h3>Message Data</h3>
<table border="1">
<tbody>
<tr>
<th>ID</th>
<th>Source</th>
<th>Destination</th>
<th>Date</th>
<th>Time</th>
<th>Type</th>
<th>Reference</th>
<th>Data</th>
</tr>
$m_message_view
</tbody>
</table>
<br />
<form method="post">
<button name="feature" value="display_message_data">Refresh Stored Messages</button>
</form>
</div>
VIEWSTOREDMESSAGEDATA;
		}
	}
?>