<?php

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'	=> 'Mysql',
		// 'host'		=> 'localhost',
		'host'		=> '103.7.40.122',
		'username'	=> 'admin_root',
		'password'	=> 'c0nand0yle',
		'name'		=> 'admin_rmtstudio',
		'charset'	=> 'utf8'
		),
	'mail' => array(
		'from_name'	=> 'ohue.vn',
		'from_email'=> 'ohuevn@gmail.com',
		'smtp'		=> array(
				'server'	=> 'smtp.gmail.com',
				'port'		=> '465',
				'security'	=> 'ssl',
				'username'	=> 'ohuevn@gmail.com',
				'password'	=> 'c0nand0yle',
			),
		),
));
