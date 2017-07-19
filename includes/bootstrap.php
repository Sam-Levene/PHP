<?php
	//Bootstrap.php - controls the session and begins by creating the ClassWorkConfig.php page
	
	session_start();
	include_once 'classes\cw_framework\class.CourseWorkConfig.php';
	
	//Once created, it asks the CourseWorkConfig to run a function to set up the definitions and 
	//set up the router to handle the Models, Views and Controllers.
	
	CourseWorkConfig::do_definitions();
	$html_result = CourseWorkContainer::make_cw_router();
	
	//This function starts automatically upon reaching this point, as it is a magic function.
	
	function __autoload($p_class_name)
	{
		//This area sets up the file folder structure to allow the rest of the code to find each of the various different pages
		//If the folder structure is correct and the file is in the correct format (class.FILENAME.php); then it exists.
		
		$m_error_count = 0;
		$m_file_exists = false;
		$m_class_exists = true;
		$m_file_name = 'class.' . $p_class_name . '.php';
		$m_arr_directories =
			array('cw_framework', 'cw_index', 'cw_process_error', 'cw_display_stored_message_data', 'cw_download_message_data');
			
		foreach ($m_arr_directories as $m_directory)
		{
			$m_file_path_and_name = CLASS_PATH . $m_directory . DIRSEP . $m_file_name;
			if (file_exists($m_file_path_and_name))
			{
				$m_file_exists = true;
				break;
			}
		}
		
		//If the files exist, then check to see if the classes exist. 
		//These are set up by the function run earlier to set up definitions
		//If the file exists, but the class does not, add 1 to the error count
		//else if the file does not exist, add 1 to the error count
		//else do not add to the error count
		
		if ($m_file_exists)
		{
			require_once $m_file_path_and_name;
			if (!class_exists($p_class_name))
			{
				$m_class_exists = false;
				$m_error_count++;
			}
		}
		
		else
		{
			$m_error_count++;
		}
		
		
		//If there are more than 0 errors, this area asks if the error is a file not found or class not found, by
		//Checking to see if the file or class exists again, then outputting the error message to the screen and the
		//Database.
		
		if ($m_error_count > 0)
		{
			if (!$m_file_exists)
			{
				$error_message = CourseWorkContainer::make_cw_error('file-not-found-error');
			}
			if (!$m_class_exists)
			{
				$error_message = CourseWorkContainer::make_cw_error('class-not-found-error');
			}

			CourseWorkContainer::make_cw_process_output($error_message);
			exit;
		}
	}
			


?>