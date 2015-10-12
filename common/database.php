<?php

function conn_db($servername,$database,$username,$password){
	$conn = mysqli_connect($servername,$username,$password);
	
	if (!$conn) {
		die ( 'Could not connect: ' . mysqli_error () );
	}
	
	mysqli_query($conn,"set names 'utf8'");
	mysqli_select_db($conn,$database);
	
	return $conn;	
}

function conn_db_default() {
	$conn = mysqli_connect ( 'localhost', 'root', 'ZJUccnt422+' );

	if (! $conn) {
		die ( 'Could not connect: ');//. mysqli_error () );
	}
	
	mysqli_query($conn, "set names 'utf8'");
	mysqli_select_db ( $conn, 'fuyang');

	return $conn;
}

function do_query($sql, $conn) {
	$res = mysqli_query ( $conn,$sql );
	if (! $res) {
		die ( 'Error: ');// . mysqli_error () );
	}

	return $res;
}

function close_conn($conn) {
	mysqli_close ( $conn );
}
?>