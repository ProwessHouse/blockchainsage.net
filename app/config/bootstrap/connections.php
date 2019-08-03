<?php
use lithium\data\Connections;

 Connections::add('default', array(
 	'type' => CONNECTION_TYPE,
 	'host' => array(CONNECTION,
		),
//	'replicaSet' => true,
 	'database' => CONNECTION_DB,
	'login' => CONNECTION_USER,
	'password' => CONNECTION_PASS,	
//	'setSlaveOkay' => true,
//	'readPreference' => Mongo::RP_NEAREST	
 ));
/*
 Connections::add('Distributor', array(
 	'type' => CONNECTIONDP_TYPE,
 	'host' => array(CONNECTIONDP,
		),
//	'replicaSet' => true,
 'database' => CONNECTIONDP_DB,
	'login' => CONNECTIONDP_USER,
	'password' => CONNECTIONDP_PASS,	
//	'setSlaveOkay' => true,
//	'readPreference' => Mongo::RP_NEAREST	
 ));
*/
?>