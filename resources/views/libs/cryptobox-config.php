<?php
/**
 *  ... Please MODIFY this file ...
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	"127.0.0.1");				// hostname
 define("DB_USER", 	config('db.username'));		// database username from .env file
 define("DB_PASSWORD", config('db.password'));		// database password from .env file
 define("DB_NAME", 	config('db.database'));	// database name from .env file




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional)", "etc...");
 */

 $cryptobox_private_keys = array("52048AAtNOwwBitcoin77BTCPRVk7hmp8s3ew6pwgOMgxMq81F");




 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys);
         
?>
