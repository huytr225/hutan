<?php 

$host = 'localhost'; //host
$port = '9000'; //port
$timeout = 30;
$message = "Hello Server";
$fs=fsockopen($host,$port,$errnum,$errstr,$timeout) ;
if (!is_resource($fs)) {
    exit("connection fail: ".$errnum." ".$errstr) ;
} else {
fwrite($fs, $message) or die("Could not send data to server\n");
// get server response
	while (!feof($fs)) {
	    echo fgets($fs, 1024);
	}
}

 ?>