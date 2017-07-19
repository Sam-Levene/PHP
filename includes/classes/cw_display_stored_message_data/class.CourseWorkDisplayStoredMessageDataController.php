<?php
/*
 * This is the code for the Display Stored Message Controller, this sets up the Display Stored Message View and 
 * the Display Stored Message Model, before passing the returned value to the parent code to display
*/
	class CourseWorkDisplayStoredMessageDataController extends CourseWorkControllerAbstract
	{
		public function do_create_html_output()
		{
			$m_arr_display_stored_message_data_result = CourseWorkContainer::make_cw_display_stored_message_data_model();
			$this->c_html_output = CourseWorkContainer::make_cw_display_stored_message_data_view($m_arr_display_stored_message_data_result);
		}
	}
	
?>