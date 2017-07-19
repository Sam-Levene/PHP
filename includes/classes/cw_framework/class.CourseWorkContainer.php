<?php
	class CourseWorkContainer
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
		// When called, this sets up the connection to the CourseWorkRouter and sets up the initial routing function
		// It also collects the returned value of the router's HTML output and returns it to the parent code.
		public static function make_cw_router()
		{
			$m_obj_router = new CourseWorkRouter();
			$m_obj_router->do_routing();
			$m_html_result = $m_obj_router->get_html_output();
			return $m_html_result;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		// When called, this sets up the connection to the CourseWorkError Controller and sets up the initial error reporting 
		// Function, it also collects the returned value of the error's HTML output and returns it to the parent code.
		public static function make_cw_error($p_error_type)
		{
			$m_obj_error = new CourseWorkErrorController();
			$m_obj_error->set_error_type($p_error_type);
			$m_obj_error->do_process_error();
			$m_obj_error->do_create_output();
			$m_error_message = $m_obj_error->get_html_output();
			return $m_error_message;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkErrorModel and sets up the initial database connection
		//function and it also collects the returned value of the error message and returns 
		//it to the parent code.
		public static function make_cw_error_model($p_error_type)
		{
			$m_arr_error_db_connection_details = CourseWorkConfig::get_user_database_connection_details();
			$m_obj_database_handle = CourseWorkContainer::make_cw_database_wrapper($m_arr_error_db_connection_details);

			$m_obj_error = new CourseWorkErrorModel();
			$m_obj_error->set_database_handle($m_obj_database_handle);
			$m_obj_error->set_error_type($p_error_type);
			$m_obj_error->do_select_error_message();
			$m_obj_error->do_log_error_message();

			$m_error_message = $m_obj_error->get_error_message();
			return $m_error_message;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkErrorView and sets up the initial view for the screen
		//the error view  itself and it also collects the returned value of the HTML output and returns
		//it to the parent code.
		public static function make_cw_error_view($p_output_error_message)
		{
			$m_obj_error = new CourseWorkErrorView();
			$m_obj_error->set_error_message($p_output_error_message);
			$m_obj_error->create_error_message();
			$m_error_message = $m_obj_error->get_html_output();
			return $m_error_message;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		//When called, this sets up the connection to the CourseWorkProcessOutput, which processes and displays te output for
		//all the views and models.
		public static function make_cw_process_output($p_html_result)
		{
			$m_obj_process_output = new CourseWorkProcessOutput();
			$m_obj_process_output->do_output($p_html_result);
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		//When called, this sets up the connection to the CourseWorkIndexController,  This creates the HTML for the index,
		//Returns the HTML output of the index and returns it to the parent code.
		public static function make_cw_index_controller()
		{
			$m_obj_form_controller = new CourseWorkIndexController();
			$m_obj_form_controller->do_create_html_output();
			$m_html_output = $m_obj_form_controller->get_html_output();
			return $m_html_output;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		//When called, this sets up the connection to the CourseWorkIndexView,  This creates the HTML form for the index,
		//Returns the HTML output of the index and returns it to the parent code.
		public static function make_cw_index_view()
		{
			$m_obj_form_view = new CourseWorkIndexView();
			$m_obj_form_view->do_create_form();
			$m_html_output = $m_obj_form_view->get_html_output();
			return $m_html_output;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		//When called, this sets up the connection to the CourseWorkDownloadMessageDataController,
		//This creates the HTML output for the downloaded messages, returns the HTML output of the index and 
		//returns it to the parent code.
		public static function make_cw_download_message_data_controller()
		{
			$m_obj_download_message_data_controller = new CourseWorkDownloadMessageDataController();
			$m_obj_download_message_data_controller->do_create_html_output();
			$m_html_output = $m_obj_download_message_data_controller->get_html_output();
			return $m_html_output;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkDownloadMessageDataValidate,
		//This sanitises the input of the message passed to it by the function's creation, gets the sanitised input
		//Back from the validate and passes it back to the parent code.
		public static function make_cw_download_message_data_validate($p_tainted)
		{
			$m_obj_download_message_data_validate = new CourseWorkDownloadMessageDataValidate();
			$m_obj_download_message_data_validate->do_sanitise_input($p_tainted);
			$m_arr_sanitised_input = $m_obj_download_message_data_validate->get_sanitised_input();
			
			return $m_arr_sanitised_input;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkDownloadMessageDataModel,
		//This sets up the database connections, creates the message data connection and then tells the model to create all
		//The outputs and returns them to the parent code.
		public static function make_cw_download_message_data_model()
		{
			$m_obj_download_message_data_model = new CourseWorkDownloadMessageDataModel();
			
			$m_obj_download_message_data_model->do_download_message_data();
			$m_arr_download_message_data_result_1 = $m_obj_download_message_data_model->get_downloaded_message_data_result();
			$m_arr_download_message_data_result_2 = $m_obj_download_message_data_model->return_message_data();
			$m_arr_download_message_data_result = array($m_arr_download_message_data_result_1, $m_arr_download_message_data_result_2);
			return $m_arr_download_message_data_result;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public static function make_cw_download_message_data_model_2($p_arr_sanitised_input)
		{
			$m_arr_database_connection_details = CourseWorkConfig::get_user_database_connection_details();
			$m_obj_database_handle = CourseWorkContainer::make_cw_database_wrapper($m_arr_database_connection_details);
			
			$m_obj_download_message_data_model = new CourseWorkDownloadMessageDataModel();
			
			$m_obj_download_message_data_model->set_database_handle($m_obj_database_handle);
			$m_obj_download_message_data_model->do_get_database_connection_result();
			
			$m_obj_download_message_data_model->set_message_data($p_arr_sanitised_input);
			$m_obj_download_message_data_model->do_store_downloaded_message_data();
			$m_arr_download_message_data_result = $m_obj_download_message_data_model->return_message_data();
			return $m_arr_download_message_data_result;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkDownloadMessageDataView,
		//This sets the download data in the View, creates the HTML output for the downloaded messages, 
		//returns the HTML output of the index and returns it to the parent code.
		public static function make_cw_download_message_data_view($p_arr_download_message_data_result)
		{
		  $m_obj_download_message_data_view = new CourseWorkDownloadMessageDataView();
		  $m_obj_download_message_data_view->set_downloaded_message_data($p_arr_download_message_data_result);
		  $m_obj_download_message_data_view->do_create_output_page();
		  $m_html_output = $m_obj_download_message_data_view->get_html_output();
		  return $m_html_output;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkDatabaseWrapper,
		//This creates the database settings, attempts to connect to the database and gets the connection messages.
		//Once retrieved the connection messages, it returns the whole array to the parent code.
		public static function make_cw_database_wrapper($p_arr_connection_settings)
		{
			$m_obj_database_handle = new CourseWorkDatabaseWrapper();
			$m_obj_database_handle->set_connection_settings($p_arr_connection_settings);
			$m_obj_database_handle->do_connect_to_database();
			$m_arr_database_connection_messages = $m_obj_database_handle->get_connection_messages();
			return $m_obj_database_handle;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkXMLParser,
		//This sets up the XML string to parse and parse the string to change it into a readable format
		//Once it is in a readable format, the data is returned to the code, then parsed back to the parent code.
		public static function make_cw_xml_parser_wrapper($p_xml_string_to_parse)
		{
			$m_obj_xml_parser_handle = new CourseWorkXmlParser();
			$m_obj_xml_parser_handle->set_xml_string_to_parse($p_xml_string_to_parse);
			$m_obj_xml_parser_handle->do_parse_the_xml_string();
			$m_arr_parsed_message_data = $m_obj_xml_parser_handle->get_parsed_message_data();
			return $m_arr_parsed_message_data;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		//When called, this sets up the connection to the CourseWorkDisplayStoredMessageDataController,
		//This creates the HTML output for the displayed messages, returns the HTML output of the display controller and
		//returns it to the parent code.
		public static function make_cw_display_stored_message_data_controller()
		{
			$m_obj_display_stored_message_data_controller = new CourseWorkDisplayStoredMessageDataController();
			$m_obj_display_stored_message_data_controller->do_create_html_output();
			$m_html_output = $m_obj_display_stored_message_data_controller->get_html_output();
			return $m_html_output;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkDisplayStoredMessageDataModel,
		//This retrieves the stored messages from the database, which is then stored and sent to the parent code.
		public static function make_cw_display_stored_message_data_model()
		{
			$m_obj_display_stored_message_data_model = new CourseWorkDisplayStoredMessageDataModel();
			$m_obj_display_stored_message_data_model->do_retrieve_stored_message_data();
			$m_arr_stored_message_data = $m_obj_display_stored_message_data_model->get_stored_message_data();
			return $m_arr_stored_message_data;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		//When called, this sets up the connection to the CourseWorkDisplayStoredMessageDataView,
		//This sets up the message data, creates the HTML output for the displayed messages, 
		//returns the HTML output of the display controller and returns it to the parent code.
		public static function make_cw_display_stored_message_data_view($p_arr_stored_message_data)
		{
			$m_obj_display_stored_message_data_view = new CourseWorkDisplayStoredMessageDataView();
			$m_obj_display_stored_message_data_view->set_stored_message_data($p_arr_stored_message_data);
			$m_obj_display_stored_message_data_view->do_create_output_page();
			$m_html_output = $m_obj_display_stored_message_data_view->get_html_output();
			return $m_html_output;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public static function make_send_confirmation()
		{
			$m_obj_confirmation = new CourseWorkSendConfirmation();
			$m_obj_confirmation->do_create_soap_client();
			$m_obj_confirmation->do_send_message_data();
			$m_returned_data = $m_obj_confirmation->get_download_message_data();
			return $m_returned_data;
		}
	}
?>