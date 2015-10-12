<?php

function conn_db($servername,$database,$username,$password){
	$conn = mysql_connect($servername,$username,$password);
	
	if (!$conn) {
		die ( 'Could not connect: ' . mysqli_error () );
	}
	
	mysql_select_db($database, $conn);
	mysql_query("set names 'utf8'", $conn);

	
	return $conn;	
}

function conn_db_default() {
	$conn = mysql_connect ( 'localhost', 'root', 'ZJUccnt422+' );

	if (! $conn) {
		die ( 'Could not connect: ');//. mysqli_error () );
	}
	
	mysql_query("set names 'utf8'",$conn);
	mysql_select_db ('fuyang', $conn);

	return $conn;
}

function do_query($sql, $conn) {
	$res = mysql_query ( $conn,$sql );
	if (! $res) {
		die ( 'Error: ');// . mysqli_error () );
	}

	return $res;
}

function close_conn($conn) {
	mysql_close ( $conn );
}
?>