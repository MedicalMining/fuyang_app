<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>诊疗时间轴</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php   
			error_reporting(E_ALL ^ E_NOTICE);
			session_start();
			$array = array();
			$array = $_SESSION['timeline'];
			$str=json_encode($array);
		?>
		<script type="text/javascrīpt" src="js/json.js"></script>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script>
			function WriteRecord(dataset, year, day, yiyuan, keshi, zhenduan, i){
				var je = 0;
				while(i < dataset.length &&
					dataset[i]['RQ'].substring(0,4) == year &&
					dataset[i]['RQ'].substring(4,8) == day &&
					dataset[i]['YIYUAN'] == yiyuan &&
					dataset[i]['KESHI'] == keshi &&
					dataset[i]['ZHENDUAN'] == zhenduan){
					je += parseInt(dataset[i]['JE']);
					i++;
				}
				document.write('<table class="intro"><tr><td><label>医院名称 <B>' + yiyuan + '<br>科室 '+ keshi + '</B></label></td><td><lable>￥:'+je  + '</lable></td></tr></table>');
				// document.write('<p class="intro"><B>' + yiyuan + ': ' + keshi + '</B><br>'+'(花费：'+ je + '￥)'+ '</p>');
				document.write('<p class="version">&nbsp;</p>');
				document.write('<table class="intro"><tr>日期 <B>'+ day.substring(0,2) + '月' + day.substring(2,4) + '日'+'</tr></table>');
				document.write('<div class="more"><p>' + zhenduan + '</p></div>');
				return i
			}
			function WriteYear(dataset, year, i){
				var day;
				var yiyuan;
				var keshi;
				var zhenduan;
				while(i < dataset.length && dataset[i]['RQ'].substring(0,4) == year){
					day = dataset[i]['RQ'].substring(4,8);
					yiyuan = dataset[i]['YIYUAN'];
					keshi = dataset[i]['KESHI'];
					zhenduan = dataset[i]['ZHENDUAN'];
					document.write('<li class="cls">');
					document.write('<p class="date">&nbsp;</p>');
					i = WriteRecord(dataset, year, day, yiyuan, keshi, zhenduan, i);
					document.write('</li>');
				}
				return i;
			}
			function WriteData(dataset){
				var i = 0;
				var year;
				while(i < dataset.length){
					year = dataset[i]['RQ'].substring(0,4);
					document.write('<div class="year">');
					document.write('<h2><a href="#">' + year + '年<i></i></a></h2>');
					document.write('<div class="list"><ul>');
					i = WriteYear(dataset, year, i)
					document.write('</ul></div></div>');
				}
			}
			function WriteBody(){
				document.bgColor = "#F5F5DC";
				document.write('<div class="content">');
				document.write('<div class="wrapper">');
				document.write('<div class="main">');
				document.write('<h1 class="title">诊疗记录</h1>');
				var str='<?=$str?>';
				var dataset = JSON.parse(str);//将PHP传来的字符串还原成数组
				WriteData(dataset);
				document.write('</div>');
				document.write('</div>');
				document.write('</div>');
			}
			WriteBody();
		</script>
		<script>
			$(".main .year .list").each(function (e, target) {
			var $target=  $(target),
			$ul = $target.find("ul");
			$target.height($ul.outerHeight()), $ul.css("position", "absolute");
			}); 
			$(".main .year>h2>a").click(function (e) {
			e.preventDefault();
			$(this).parents(".year").toggleClass("close");
			});
		</script>
	</body>
</html>
