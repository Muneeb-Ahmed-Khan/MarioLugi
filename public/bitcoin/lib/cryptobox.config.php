<?php
/**
 *  ... Please MODIFY this file ...
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	"ec2-54-161-150-170.compute-1.amazonaws.com");				// hostname
 define("DB_USER", 	"bqmalfjiyoegah");		// database username
 define("DB_PASSWORD", 	"f6b0f4cfd87b9663d82f951abe16e082d91fd4a8662a37e604a2697a1e6da80e");		// database password
 define("DB_NAME", 	"d8lqb88rfpv77f");	// database name




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional)", "etc...");
 */

 $cryptobox_private_keys = array("52048AAtNOwwBitcoin77BTCPRVk7hmp8s3ew6pwgOMgxMq81F");




 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys);
         
?>
