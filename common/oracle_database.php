<?php

function conn_db($servername, $username, $password){
	$conn = oci_connect($username, $password, $servername.'/orcl', 'utf8'); // 建立连接
	if (!$conn) {
		$e = oci_error();
		print htmlentities($e['message']);
		exit;
	}
	return $conn;
}

function conn_db_default() {
	//$conn = oci_connect("fuyang", "123456", 'ORCL'); // 默认建立本地连接
	//$conn = oci_connect("fuyang", "123456", '(DEscriptION=(ADDRESS=(PROTOCOL =TCP)(HOST=127.0.0.1)(PORT = 1521))(CONNECT_DATA =(SID=ORCL)))'); // 可建立远程连接
	$conn = conn_db('127.0.0.1', "fuyang", "123456"); // 可建立远程连接
	if (!$conn) {
		$e = oci_error();
		print htmlentities($e['message']);
		exit;
	}
	return $conn;
}

function do_query($sql, $conn) {
	$stid = oci_parse($conn, $sql); // 配置SQL语句，准备执行
	if (!$stid) {
		$e = oci_error($conn);
		print htmlentities($e['message']);
		exit;
	}

	$ret = oci_execute($stid, OCI_DEFAULT); // 执行SQL。OCI_DEFAULT表示不要自动commit
	if(!$ret) {
		$e = oci_error($stid);
		echo htmlentities($e['message']);
		exit;
	}
	return $stid;
}

function close_conn($conn) {
	if(oci_close($conn)==false)  
		echo "关闭连接失败!";
}
?>

