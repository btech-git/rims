<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

    'connectionString' => 'mysql:host=localhost;dbname=raperind_db',
//	'connectionString' => 'mysql:host=192.168.0.150;dbname=raperind_db',
	'emulatePrepare' => true,        
	'username' => 'raperind_admin',
        'password' => 'c8!raprap',
	'charset' => 'utf8',
	'tablePrefix' => 'rims_',
);
