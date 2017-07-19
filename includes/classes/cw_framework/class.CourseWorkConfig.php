<?php
	class CourseWorkConfig
	{
		//CourseWorkConfig is a class, so it can be referenced by $this if neccesary. A class must contain a constructor
		//And a destructor, in this case and in all cases, I have used the magic functions __construct() and __destruct()
		public function __construct()
		{
		}
		
		public function __destruct()
		{
		}
		
		//The following code defines some definitions used by Bootstrap.php when called by bootstrap
		public static function do_definitions()
		{
			define ('DIRSEP', DIRECTORY_SEPARATOR);
			$m_class_path = realpath(dirname(__FILE__));
			$m_arr_class_path = explode(DIRSEP, $m_class_path, -1);
			$m_class_file_path = implode(DIRSEP, $m_arr_class_path) . DIRSEP;

			$m_app_root_path = $_SERVER['PHP_SELF'];
			$m_arr_app_root_path = explode('/', $m_app_root_path, -1);
			$m_app_root_path = implode('/', $m_arr_app_root_path) . '/';

			define ('CLASS_PATH', $m_class_file_path);
			define ('APP_ROOT_PATH', $m_app_root_path);
			define ('APP_NAME', 'CourseWork');
		}
		
		//When called, this function tells the calling code to use the database connection details as listed. To ensure it works
		//Remotely, I have changed it to a local address. This was to facilitate proper testing
		public static function get_user_database_connection_details()
		{
			$m_rdbms = 'mysql';
			$m_host = 'localhost';
			$m_port = '3306';
			$m_db_name = 'coursework_db';
			$m_host_name = $m_rdbms . ':host=' . $m_host. ';port=' . $m_port . ';dbname=' . $m_db_name;
			$m_user_name = 'courseworkuser';
			$m_user_password = 'courseworkpass';
			$m_arr_db_connect_details['host_name'] = $m_host_name;
			$m_arr_db_connect_details['user_name'] = $m_user_name;
			$m_arr_db_connect_details['user_password'] = $m_user_password;
			return $m_arr_db_connect_details;
		}
		
		//When called, this function returns the details of the connection to the messaging server. For this I have used both 
		//the online WSDL file and a local text file that can be read if the online file cannot be found (As is in this case)
		public static function get_sms_connection_details()
		{
			$m_arr_m2m_connect_details = array();
			$m_arr_m2m_connect_details['wsdl'] = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
			return $m_arr_m2m_connect_details;
		}
	}

?>