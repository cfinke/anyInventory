CREATE TABLE `anyInventory_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `name` varchar(32) NOT NULL default '',
  UNIQUE KEY `id` (`id`),
  KEY `parent` (`parent`)
) TYPE=MyISAM;

CREATE TABLE `anyInventory_fields` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `input_type` enum('text','textarea','checkbox','radio','select','multiple') NOT NULL default 'text',
  `values` text NOT NULL,
  `default_value` varchar(32) NOT NULL default '',
  `size` int(11) NOT NULL default '0',
  `categories` text NOT NULL,
  `importance` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

CREATE TABLE `anyInventory_items` (
  `id` int(11) NOT NULL auto_increment,
  `item_category` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM;

CREATE TABLE `anyInventory_files` (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`key` INT NOT NULL ,
	`file_name` VARCHAR( 255 ) NOT NULL ,
	`file_size` INT NOT NULL ,
	`file_type` VARCHAR( 32 ) NOT NULL ,
	UNIQUE (
		`id`
	)
);