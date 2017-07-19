<?php
/*
 * The following code is the Web Page Template for all Module Views. It sets up the HTML output with
 * every piece of information that is passed in, before returning the concatenated output back to the router
 * to display.
 */
	class CourseWorkWebPageTemplateView
	{
		private $c_menu_bar;
		protected $c_page_title;
		protected $c_html_page_content;
		protected $c_html_page_output;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_page_title = '';
			$this->c_html_page_content = '';
			$this->c_html_page_output = '';
			$this->c_menu_bar = '';
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function create_web_page()
		{
			$this->create_menu_bar();
			$this->create_web_page_meta_headings();
			$this->insert_page_content();
			$this->create_web_page_footer();
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*		
		public function insert_page_content()
		{
			$m_landing_page = APP_ROOT_PATH;
			$m_html_output = <<< HTML
<div id="banner-div">
<h1>M2M SMS Message Details</h1>
<p class="cent">
Page last updated on <script type="text/javascript">document.write(document.lastModified)</script>
<br />
Maintained by <a href="mailto:p10523696@myemail.dmu.ac.uk">p10523696@myemail.dmu.ac.uk</a>
</p>
<hr class="deepline"/>
</div>
<div id="clear-div"></div>
<div id="page-content-div">
$this->c_html_page_content
<p class="curr_page"><a href="$m_landing_page">Return to Home page</a></p>
</div>
HTML;
			$this->c_html_page_output .= $m_html_output;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function create_web_page_meta_headings()
		{
			$m_css_filename = 'css/coursework.css';
			$m_html_output = <<< HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en-gb" />
	<meta name="author" content="Samuel Levene" />
	<link rel="stylesheet" href="$m_css_filename" type="text/css" />
	<title>$this->c_page_title</title>
</head>
<body>
HTML;
			$this->c_html_page_output .= $m_html_output;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function create_menu_bar()
		{
			$m_menu_option_buttons = '';

			$m_landing_page = APP_ROOT_PATH;

			$this->c_menu_bar = <<< MENUBAR
<div id="navbar">
<form method="post" action="$m_landing_page">
$m_menu_option_buttons
</form>
</div>
MENUBAR;
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function create_web_page_footer()
		{
			$m_html_output = <<< HTML
</body>
</html>
HTML;
			$this->c_html_page_output .= $m_html_output;
		}
	}
?>