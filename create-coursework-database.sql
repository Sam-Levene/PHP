CREATE DATABASE `coursework_db` DEFAULT CHARSET utf8;

USE `coursework_db`;

CREATE TABLE `cw_error_log` (
   `log_id` int(5) not null auto_increment,
   `log_message` varchar(300) default 'NULL',
   PRIMARY KEY (`log_id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `cw_messages` (
   `id` int(5) not null auto_increment,
   `source` varchar(12) not null,
   `destination` varchar(12) not null,
   `date` date not null,
   `time` time not null,
   `type` varchar(10) default 'NULL',
   `reference` int(5) not null,
   `data` varchar(35) default 'NULL',
   PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

GRANT SELECT, INSERT on coursework_db.* to 'courseworkuser'@'localhost' IDENTIFIED BY 'courseworkpass';