<?php
/*
 * This is the code for the Display Stored Message Data Model, this retrieves the stored messages from the database
 * before storing it into an array, then passes the array to the Controller, which then send it to the view for
 * proccessing into readable output
*/
	class CourseWorkDisplayStoredMessageDataModel
	{
		private $c_obj_database_handle;
		private $c_arr_database_connection_messages;
		private $c_arr_stored_message_data;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __construct()
		{
			$this->c_obj_database_handle = null;
			$this->c_arr_database_connection_messages = array();
			$this->c_arr_stored_message_data = array();
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function __destruct()
		{
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function get_stored_message_data()
		{
			return $this->c_arr_stored_message_data;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public function do_retrieve_stored_message_data()
		{
			$con=mysqli_connect("localhost","courseworkuser","courseworkpass","coursework_db");		
			$SQL="SELECT id, source, destination, date, time, type, reference, data FROM cw_messages";
			
			$result = mysqli_query($con, $SQL);
			
			$rows = array();
				
			while ($data = mysqli_fetch_assoc($result))
			{
				$rows[] = array(
					"id" => $data["id"],
					"source" => $data["source"],
					"destination" => $data["destination"],
					"date" => $data["date"],
					"time" => $data["time"],
					"type" => $data["type"],
					"reference" => $data["reference"],
					"data" => $data["data"]);
			}
			
			$this->c_arr_stored_message_data['message-retrieved-data'] = $rows;
		}
	}
?>