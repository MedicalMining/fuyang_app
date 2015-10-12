<!DOCTYPE html>
<html lang="zh-CN">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
</html>

<?php
if (isset($_REQUEST['action'])) {

	session_start();

	list($c, $f) = explode('_', $_REQUEST['action']);
	require_once('common/oracle_database.php');
//	require_once('common/database.php');

	$conn = conn_db_default();
	
	require_once($c . '.php');
	eval($f . '($conn);');
}
?>
