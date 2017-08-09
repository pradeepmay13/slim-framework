<?php
/*
function connect_db() {
	$config['displayErrorDetails'] = true;
	$config['addContentLengthHeader'] = false;

	$config['db']['host']   = "localhost";
	$config['db']['user']   = "root";
	$config['db']['pass']   = "";
	$config['db']['dbname'] = "slim_db";
	return $config;
}
*/
function connect_db() {
	$server = 'localhost'; // this may be an ip address instead
	$user = 'root';
	$pass = '';
	$database = 'slim_db';
	$connection=mysqli_connect($server,$user,$pass,$database);

	return $connection;
}