<?php

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'	=> 'Mysql',
		'host'		=> 'localhost',
		// 'host'		=> '103.7.40.122',
		// 'username'	=> 'admin_root',
		// 'password'	=> 'c0nand0yle',
		'username'	=> 'root',
		'password'	=> 'root',
		'name'		=> 'admin_rmtstudio',
		'charset'	=> 'utf8'
	),
	'mail' => array(
		'from_name'	=> 'Quý Quốc',
		'from_email'=> 'npqquoc@gmail.com',
		'smtp'		=> array(
				'server'	=> 'smtp.gmail.com',
				'port'		=> '465',
				'security'	=> 'ssl',
				'username'	=> 'npqquoc@gmail.com',
				'password'	=> 'd0raem0n',
		),
		'to_email'	=> 'rmtarch@gmail.com'
	),
	'website' => 'http://rmt-studio.com'
));
