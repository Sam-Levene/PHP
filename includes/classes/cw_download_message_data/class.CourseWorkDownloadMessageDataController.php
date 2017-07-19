<?php
/*
 * This code is the Download Message Data Controller, this sets up the Download Message Data View and 
 * Download Message Data Model, this also validates the data from the Model element to ensure security from
 * attacks, before re-modelling to split up the data and sending the data to the View.
 * This code then retrieves the HTML output from the View and and returns the HTML output to display.
*/
	class CourseWorkDownloadMessageDataController extends CourseWorkControllerAbstract
	{
		public function do_create_html_output()
		{
			$m_arr_download_message_data = CourseWorkContainer::make_cw_download_message_data_model();

			$m_arr_sanitised_input_1 = CourseWorkContainer::make_cw_download_message_data_validate($m_arr_download_message_data[0]);
			$m_array = $m_arr_download_message_data[1];
			
			$m_arr_sanitised_input = array_merge($m_arr_sanitised_input_1,$m_array);
							
			if ($m_arr_sanitised_input != NULL)
			{
				$m_arr_download_message_data_result = CourseWorkContainer::make_cw_download_message_data_model_2($m_arr_sanitised_input);
			}
			else
			{
				$m_arr_download_message_data_result = NULL;
			}
			$this->c_html_output = CourseWorkContainer::make_cw_download_message_data_view($m_arr_download_message_data_result);
		}
	}
?>