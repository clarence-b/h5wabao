<?php 
return array (
	'DEBUG' => true,
	
	//route config
	'REWRITE_ON' => 'false', 		
	'REWRITE_RULE' =>array(
		//'<app>/<c>/<a>'=>'<app>/<c>/<a>',
	),
	
	//db config
	'DB'=>array(
		'default' => 
			array (
				'DB_TYPE' => 'mysqlpdo',
				'DB_HOST' => 'localhost',
				'DB_USER' => 'root',
				'DB_PWD' => '123456',
				'DB_PORT' => '3306',
				'DB_NAME' => 'h5_wabao',
				'DB_CHARSET' => 'utf8',
				'DB_PREFIX' => 'tdb_',
			),
	),
);