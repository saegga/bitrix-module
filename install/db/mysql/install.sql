CREATE TABLE IF NOT EXISTS `sm_section_option` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) NOT NULL,
  `CODE_SECTION` varchar(64) NOT NULL,
  `SORT` int(11) not null default '500',
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `sm_option_items` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `CODE_SECTION` varchar(64) NOT NULL,
  `ID_OPTION_ITEM` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `sm_option_item` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `CODE_OPTION_ITEM` varchar(255) NOT NULL,
  `DESCRIPTION_OPTION_ITEM` text NOT NULL,
  `VALUE` varchar(255) NOT NULL,
  `VALUE_TYPE` varchar(64) NOT NULL,
  `SORT` int(11) not null default '500',
  PRIMARY KEY (`ID`)
);