<?php

/*
 * The following code acts as a router and directs the code to the appropriate module as defined by
 * either "Feature" or "Submit", it also passes the HTML output to the ProcessOutput, 
 * which displays the output.
 */
	class CourseWorkRouter
	{
		private $c_feature_in;
		private $c_feature;
		private $c_html_output;
		public $c_array;
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_feature_in = '';
			$this->c_feature = '';
			$this->c_html_output = '';
			$this->c_array = array();
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_routing()
		{
			$this->set_feature_name();
			$this->map_feature_name();
			$this->router_class();
			CourseWorkContainer::make_cw_process_output($this->c_html_output);			
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_html_output()
		{
			return $this->c_html_output;
		
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function set_feature_name()
		{
			if (isset($_POST['feature']))
			{
				$m_feature_in = $_POST['feature'];
			}
			else
			{
				$m_feature_in = 'index';
			}
			
			$this->c_feature_in = $m_feature_in;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		private function map_feature_name()
		{
			$m_feature_exists = false;
			// map the passed module name to an internal application feature name
			$m_features =
				array(
				'index' => 'index',
				'download_message_data' => 'download',
				'display_message_data' => 'display'
				);
			if (array_key_exists($this->c_feature_in, $m_features))
			{
				$this->c_feature = $m_features[$this->c_feature_in];
				$m_feature_exists =  true;
			}
			else
			{
				$m_obj_sessions_error = CourseWorkContainer::make_cw_error('feature-not-found-error');
			}
			return $m_feature_exists;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function router_class()
		{
			switch ($this->c_feature)
			{
				case 'index':
					$this->c_html_output = CourseWorkContainer::make_cw_index_controller();
					break;
				case 'download':
					$this->c_html_output = CourseWorkContainer::make_cw_download_message_data_controller();
					break;
				case 'display':
					$this->c_html_output = CourseWorkContainer::make_cw_display_stored_message_data_controller();
					break;
				default:
					break;
			}
		}
	}
?>