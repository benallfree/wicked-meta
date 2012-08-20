CREATE TABLE IF NOT EXISTS `meta_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_type` varchar(50) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `autoload` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

insert into meta_types (object_type, data_type, name) select class_name as object_type, 'string' as data_type, name from metas group by class_name, name;

ALTER TABLE  `metas` ADD  `meta_type_id` INT NOT NULL AFTER  `id`;

UPDATE metas SET meta_type_id = ( SELECT id
FROM meta_types
WHERE object_type = class_name
AND meta_types.name = metas.name );

ALTER TABLE  `metas` DROP  `class_name` ,
DROP  `name` ;

RENAME TABLE  `metas` TO  `meta_values` ;

ALTER TABLE  `meta_values` CHANGE  `meta_type_id`  `type_id` INT( 11 ) NOT NULL COMMENT  'MetaType';