<?php
/*
 * The following code provides SQL statements for the entire program.
 */
	class CourseWorkSqlQuery
	{

		public static function does_message_exist()
		{
			$m_sql_query_string  = "SELECT id ";
			$m_sql_query_string .= "FROM cw_messages ";
			$m_sql_query_string .= "WHERE source = :source_terminal ";
			$m_sql_query_string .= "AND destination = :destination_terminal ";
			$m_sql_query_string .= "AND date = :message_date ";
			$m_sql_query_string .= "AND time = :message_time ";
			$m_sql_query_string .= "AND type = :message_type ";
			$m_sql_query_string .= "AND reference = :message_reference ";
			$m_sql_query_string .= "AND data = :message_data ";
			$m_sql_query_string .= "LIMIT 1";
			return $m_sql_query_string;
		}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public static function does_sent_message_exist()
		{
			$m_sql_query_string  = "SELECT id ";
			$m_sql_query_string .= "FROM cw_messages ";
			$m_sql_query_string .= "WHERE id = :message_id ";
			$m_sql_query_string .= "LIMIT 1";
			return $m_sql_query_string;
		}
		
// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public static function store_message_data()
		{
			$m_sql_query_string  = "INSERT INTO cw_messages ";
			$m_sql_query_string .= "SET ";
			$m_sql_query_string .= "source = :source_terminal, ";
			$m_sql_query_string .= "destination = :destination_terminal, ";
			$m_sql_query_string .= "date = :message_date, ";
			$m_sql_query_string .= "time = :message_time, ";
			$m_sql_query_string .= "type = :message_type, ";
			$m_sql_query_string .= "reference = :message_reference, ";
			$m_sql_query_string .= "data = :message_data";
			return $m_sql_query_string;
		}
		

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
		public static function get_error_logging_query_string()
		{
			$m_sql_query_string  = "INSERT INTO cw_error_log ";
			$m_sql_query_string .= "SET ";
			$m_sql_query_string .= "log_message = :logmessage";
			return $m_sql_query_string;
		}
	}
?>