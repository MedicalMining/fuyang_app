<?php
function rank($conn){
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];

		$sql = "SELECT SCORE FROM PATIENT_SCORE WHERE BINGRENXH = ".$pid;
		
		$array = array();
		$stid = do_query($sql, $conn);
		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){	
			array_push($array, $row['SCORE']);
		}
		echo json_encode($array);
	}
}

function visitinfo($conn){
	if(isset($_GET['pid']) && isset($_GET['date'])){
		$pid = $_GET['pid'];
		$date = $_GET['date'];

		$sql = "SELECT XIUGAIRQ, ZHENDUANMC FROM MZZJ_ZHENDUANXX WHERE BINGRENXH = ".$pid." AND XIUGAIRQ LIKE '".$date."%' ORDER BY XIUGAIRQ";
		
		$array = array();
		$stid = do_query($sql, $conn);
		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){	
			$temp_array = array("time"=>$row['XIUGAIRQ'],"illness"=>$row['ZHENDUANMC']);
			array_push($array, $temp_array);
		}
		print_r($array);
		// echo json_encode($array);
	}
}

/*function payment($conn){
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];

		$sql = "SELECT MZGY_ZHENLIAO2.SHOURUXMMC, MZGY_ZHENLIAO2.SHIFUJE FROM MZGY_ZHENLIAO2, MZGY_ZHENLIAO1 WHERE MZGY_ZHENLIAO1.BINGRENXH = ".$pid." AND MZGY_ZHENLIAO2.ZHENLIAOBH = MZGY_ZHENLIAO1.LIUSHUIHAO";

		$array = array();
		$stid = do_query($sql, $conn);
		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){
			$temp_array = array("item"=>$row['SHOURUXMMC'],"payment"=>$row['SHIFUJE']);
			array_push($array, $temp_array);
		}
// 		print_r($array);
		echo json_encode($array, false);
	}
}*/


function score($conn){
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];

		$sql = "SELECT MAX(cost) AS MCOST FROM (SELECT SUM(ALL2015) AS cost FROM APP_COST2015 GROUP BY BINGRENXH)";
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$mCOST = $row['MCOST'];

		$sql = 'SELECT MAX (NUM) AS MSICKNESS FROM (SELECT COUNT(DISTINCT ZHENDUANMC) AS NUM FROM APP_ALL 
				WHERE RQ BETWEEN 20150101 AND 20151231 GROUP BY BINGRENXH)';
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$mSICKNESS = $row['MSICKNESS'];

		$pid = $_GET['pid'];


		$sql = "SELECT SUM(ALL2015) AS COST FROM APP_COST2015 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$cost = $row['COST'];


		$sql = "SELECT COUNT(DISTINCT ZHENDUANMC) AS NUM FROM APP_ALL 
				WHERE RQ BETWEEN 20150101 AND 20151231 AND BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$num = $row['NUM'];

		$score = 100 - 20*log($cost,2)/log($mCOST,2) - 20*log($num,2)/log($mSICKNESS,2);
//		$score = 80;
//		if ($score < 1) {
//			$score = 1;
//		}

//		$score = 100 - log($score, 2) * (40 / log(34745, 2));

/*		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){
			$temp_array = array("item"=>$row['SHOURUXMMC'],"payment"=>$row['SHIFUJE']);
			array_push($array, $temp_array);
		}*/
// 		print_r($score);
//		echo json_encode($score, false);

		$_SESSION['score'] = $score;
		$_SESSION['pid'] = $pid;
//		echo $score;
		$url = 'score.php';
		Header("Location:$url");

	}
}

function paymentTotal($conn){
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];

		//某个病人各年的总消费

		$array = array();

		$sql = "SELECT sum(ALL2011) as SUM FROM APP_COST2011 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[0] = $row['SUM'];
//		print($array[0]);
/*		$temp_array = array("2011"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$y2011 = $row['SUM']

		$sql = "SELECT SUM(ALL2012) as SUM FROM APP_COST2012 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[1] = $row['SUM'];
/*		$temp_array = array("2012"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$y2012 =  $row['SUM']

		$sql = "SELECT SUM(ALL2013) as SUM FROM APP_COST2013 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[2] = $row['SUM'];
/*		$temp_array = array("2013"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$array[2] = $row['SUM']

		$sql = "SELECT SUM(ALL2014) as SUM FROM APP_COST2014 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[3] = $row['SUM'];
/*		$temp_array = array("2014"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$array[3] = $row['SUM']

		$sql = "SELECT SUM(ALL2015) as SUM FROM APP_COST2015 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[4] = $row['SUM'];

		$_SESSION['payTo'] = $array;

		$url = 'line.php';
		Header("Location:$url");
//		print_r($array);
/*		$temp_array = array("2015"=>$row['SUM']);
		array_push($array, $temp_array);*/
/*		
		$_SESSION["temp"] = $array;

		$url = 'transTest.php';
		Header("Location:$url");*/
		


/*		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){
			$temp_array = array("item"=>$row['ZHENDUANMC'],"payment"=>$row['SUM']);
			array_push($array, $temp_array);
		}*/
// 		print_r($array);
//		echo json_encode($array, false);
	}
}
function paymentBl($conn){
	error_reporting(0);
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];

		//某个病人各年的总消费

		$array = array();


//		$array[3] = $row['SUM']
		
		$sql = "SELECT SUM(ALL2011) as SUM, SUM(ZF2011) FROM APP_COST2011 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[0][0] = $row['SUM'];
		$array[0][1] = $row['ZF2011'];
		if ($array[0][0] == null) $array[0][0] = 0;
		if ($array[0][1] == null) $array[0][1] = 0;
/*		$temp_array = array("2011"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$y2011 = $row['SUM']

		$sql = "SELECT SUM(ALL2012) as SUM, SUM(ZF2012) AS ZF2012 FROM APP_COST2012 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[1][0] = $row['SUM'];
		$array[1][1] = $row['ZF2012'];
		if ($array[1][0] == null) $array[1][0] = 0;
		if ($array[1][1] == null) $array[1][1] = 0;
/*		$temp_array = array("2012"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$y2012 =  $row['SUM']

		$sql = "SELECT SUM(ALL2013) as SUM, SUM(ZF2013) AS ZF2013 FROM APP_COST2013 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[2][0] = $row['SUM'];
		$array[2][1] = $row['ZF2013'];
		if ($array[2][0] == null) $array[2][0] = 0;
		if ($array[2][1] == null) $array[2][1] = 0;
/*		$temp_array = array("2013"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$array[2] = $row['SUM']

		$sql = "SELECT SUM(ALL2014) as SUM, SUM(ZF2014) AS ZF2014 FROM APP_COST2014 WHERE BINGRENXH = ".$pid;
		$stid = do_query($sql, $conn);
		$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		$array[3][0] = $row['SUM'];
		$array[3][1] = $row['ZF2014'];
		if ($array[3][0] == null) $array[3][0] = 0;
		if ($array[3][1] == null) $array[3][1] = 0;
/*		$temp_array = array("2014"=>$row['SUM']);
		array_push($array, $temp_array);*/
//		$array[3] = $row['SUM']

		// $sql = "SELECT SUM(ALL2015) as SUM, SUM(ZF2015) AS ZF2015 FROM APP_COST2015 WHERE BINGRENXH = ".$pid;
		// $stid = do_query($sql, $conn);
		// $row = oci_fetch_array($stid, OCI_RETURN_NULLS);
		// $array[4][0] = $row['SUM'];
		// $array[4][1] = $row['ZF2015'];
		// if ($array[4][0] == null) $array[4][0] = 0;
		// if ($array[4][1] == null) $array[4][1] = 0;

		
		$_SESSION['payBl'] = $array;

		$url = '2015.php';
		Header("Location:$url");
//		print_r($array);

/*		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){
			$temp_array = array("item"=>$row['ZHENDUANMC'],"payment"=>$row['SUM']);
			array_push($array, $temp_array);
		}*/
 		
//		echo json_encode($array, false);
	}
}

function timeline($conn){
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];
		$sql = "SELECT RQ, SJJIGOUMC AS YIYUAN, ZHIXINGKSMC AS KESHI, ZHENDUANMC, BIAOZHUNJE  FROM APP_TIMELINE WHERE BINGRENXH = ".$pid. "ORDER BY RQ DESC, ZHENDUANMC";
	
		$array = array();
		$stid = do_query($sql, $conn);

		while($row = oci_fetch_array($stid, OCI_RETURN_NULLS)){

/*			if ($row["RQ"] == null) $row["RQ"] = "no info";
			if ($row["YIYUAN"] == null) $row["YIYUAN"] = "no info";
			if ($row["KESHI"] == null) $row["KESHI"] = "no info";
			if ($row["ZHENDUANMC"] == null) $row["ZHENDUANMC"] = "no info";
			if ($row["BIAOZHUNJE"] == null) $row["BIAOZHUNJE"] = 0;	*/

			$temp_array = array("RQ"=>$row['RQ'],"YIYUAN"=>$row['YIYUAN'],"KESHI"=>$row['KESHI'],"ZHENDUAN"=>$row['ZHENDUANMC'], "JE"=>$row['BIAOZHUNJE']);
//			print($temp_array["RQ"]);
			if ($temp_array["RQ"] == null || $temp_array["RQ"] == 0 ||$temp_array["RQ"] == "0")  continue;
			if ($temp_array["YIYUAN"] == null)  continue;
			if ($temp_array["KESHI"] == null) $temp_array["KESHI"] = "-";
			if ($temp_array["ZHENDUAN"] == null) $temp_array["ZHENDUAN"] = "-";
			if ($temp_array["JE"] == null)  $temp_array["JE"] = "-";

/*			if ($temp_array["RQ"] == null) continue;
			if ($temp_array["YIYUAN"] == null) continue;
			if ($temp_array["KESHI"] == null) continue;
			if ($temp_array["ZHENDUAN"] == null) continue;
			if ($temp_array["JE"] == null) continue;*/
			array_push($array, $temp_array);
		}
		
		$_SESSION['timeline'] = $array;

		$url = 'tline.php';
		Header("Location:$url");
//		print_r($array);
		echo json_encode($array, false);
//		print($array[0]["RQ"]);
	}
}


function predict($conn){
	if(isset($_GET['pid'])){
		$pid = $_GET['pid'];
		$now = date("Ymd H:i:s",time()) ;
		$start = date("Ymd H:i:s",strtotime("-380 day"));
		$end = date("Ymd H:i:s",strtotime("-350 day"));

		$a = intval($start);
		$b = intval($end);

		$sql = 'SELECT ZHENDUANMC, COUNT(DISTINCT BINGRENXH) AS NUM FROM APP_ALL 
				WHERE RQ BETWEEN '.$a.' AND '.$b.' GROUP BY ZHENDUANMC ORDER BY NUM DESC';

		$array = array();

		$stid = do_query($sql, $conn);
		for($i = 0; $i < 5; $i++)
		{
			$row = oci_fetch_array($stid, OCI_RETURN_NULLS);
			$temp_array = array("ZHENDUANMC"=>$row['ZHENDUANMC'],"NUM"=>$row['NUM']);
			array_push($array, $temp_array);
		}

		$_SESSION['predict'] = $array;
		$_SESSION['pid'] = $pid;

		$url = 'predict.php';
		Header("Location:$url");
//		print_r($array);
		echo json_encode($array, false);
//		print($array[0]["RQ"]);
	}
}

?>