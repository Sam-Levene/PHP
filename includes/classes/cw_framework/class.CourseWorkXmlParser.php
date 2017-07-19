<?php

	class CourseWorkXmlParser
	{
		private $c_xml_parser;					// handle to instance of the XML parser
		private $c_arr_parsed_message_data;	  	// array holds extracted data
		private $c_element_name;	            // store the current element name
		private $c_arr_temporary_attributes;	// temporarily store tag attributes and values
		private $c_xml_string_to_parse;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
		
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		// release retained memory
		public function __destruct()
		{
			xml_parser_free($this->c_xml_parser);
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function set_xml_string_to_parse($p_xml_string_to_parse)
		{
			$this->c_xml_string_to_parse = $p_xml_string_to_parse;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_parsed_message_data()
		{
			return $this->c_arr_parsed_message_data;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_parse_the_xml_string()
		{
			// create the XML parser and return a handle
			$this->c_xml_parser = xml_parser_create();

			// allow the parser to operate within an object
			xml_set_object($this->c_xml_parser, $this);

			// assign functions to be called when a new element is entered and exited
			xml_set_element_handler($this->c_xml_parser, "open_element", "close_element");

			// assign the function to be used when an element contains data
			xml_set_character_data_handler($this->c_xml_parser, "process_element_data");

			$this->parse_the_data_string();
		}
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		// use the parser to step through the element tags
		private function parse_the_data_string()
		{
			xml_parse($this->c_xml_parser, $this->c_xml_string_to_parse);
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		// process an open element event & store the tag name
		// extract the attribute names and values, if any
		private function open_element($p_parser, $p_element_name, $p_attributes)
		{
			$this->c_element_name = $p_element_name;
			if (sizeof($p_attributes) > 0)
			{
				foreach ($p_attributes as $m_att_name => $m_att_value)
				{
					$m_tag_att = $p_element_name . "." . $m_att_name;
					$this->c_arr_temporary_attributes[$m_tag_att] = $m_att_value;
				}
			}
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		// process data from an element
		private function process_element_data($p_parser, $p_element_data)
		{
			$this->c_arr_parsed_message_data[$this->c_element_name] = $p_element_data;
			if (sizeof($this->c_arr_temporary_attributes) > 0)
			{
				foreach ($this->c_arr_temporary_attributes as $m_tag_att_name => $m_tag_att_value)
				{
					$this->c_arr_parsed_message_data[$m_tag_att_name] = $m_tag_att_value;
				}
			}
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		// process a close element event
		private function close_element($p_parser, $p_element_name)
		{
			// do nothing here
		}
	}
?>