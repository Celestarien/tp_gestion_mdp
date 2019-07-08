CREATE TABLE `passes` (
	`id` int(6) NOT NULL auto_increment,  
	`nom` varchar(200) NOT NULL default '',  
	`adresse` varchar(200) NOT NULL default '',  
	`login` varchar(100) NOT NULL default '',  
	`pass` varchar(100) NOT NULL default '',  
	PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1