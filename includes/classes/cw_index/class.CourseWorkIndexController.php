<?php
/*
 * This is the code for the Index Controller, this sets up the Index View, before passing the returned value
 * to the parent code to display
 */
	class CourseWorkIndexController extends CourseWorkControllerAbstract
	{
		public function do_create_html_output()
		{
			$this->c_html_output = CourseWorkContainer::make_cw_index_view();
		}
	}

?>