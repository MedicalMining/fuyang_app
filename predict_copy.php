<?php 
	$url = "http://php.weather.sina.com.cn/xml.php?city=%B8%BB%D1%F4&password=DJOYnieT8234jlsK&day=0";
	$contents = file_get_contents($url); 
	$pa1 = '%<temperature1.*?>(.*?)</temperature1>%si';
	$pa2 = '%<temperature2.*?>(.*?)</temperature2>%si';
	$pa3 = '%<direction1.*?>(.*?)</direction1>%si';
	$pa4 = '%<power1.*?>(.*?)</power1>%si';
	$pa5 = '%<pollution_s.*?>(.*?)</pollution_s>%si';
	$pa6 = '%<status1.*?>(.*?)</status1>%si';
	$pa7 = '%<status2.*?>(.*?)</status2>%si';

	preg_match_all($pa1,$contents,$match1);
	preg_match_all($pa2,$contents,$match2);
	preg_match_all($pa3,$contents,$match3);
	preg_match_all($pa4,$contents,$match4);
	preg_match_all($pa5,$contents,$match5);
	preg_match_all($pa6,$contents,$match6);
	preg_match_all($pa7,$contents,$match7);

	$temp1 = $match1[0][0];
	$temp2 = $match2[0][0];
	$temp3 = $match3[0][0];
	$temp4 = $match4[0][0];
	$temp5 = $match5[0][0];
	$temp6 = $match6[0][0];
	$temp7 = $match7[0][0];

	$temp6 = preg_replace("/<status1[^>]*>/","", $temp6);
	$temp6 = preg_replace("/<\/status1>/","", $temp6);

	$temp7 = preg_replace("/<status2[^>]*>/","", $temp7);
	$temp7 = preg_replace("/<\/status2>/","", $temp7);

	error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $array = array();
    $array = $_SESSION['predict'];
    $array0 = $array[0]['NUM'];
    $array1 = $array[1]['NUM'];
    $array2 = $array[2]['NUM'];
    $array3 = $array[3]['NUM'];
    $array4 = $array[4]['NUM'];
    $name0 = $array[0]['ZHENDUANMC'];
    $name1 = $array[1]['ZHENDUANMC'];
    $name2 = $array[2]['ZHENDUANMC'];
    $name3 = $array[3]['ZHENDUANMC'];
    $name4 = $array[4]['ZHENDUANMC'];

?>


<html>
<head>
	<title>健康预测</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta http-equiv="Content-Language" content="zh"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<style>
.box{
	text-align:center;
	bottom:20%;
}

button {
	text-align:center;
	font-size:120%;
	font-family:Helvetica;
	color:gray; }

#div1 {
	position:absolute;
	width:50%;
	height:auto;
	z-index:1;
	right: 10%;
	top: 40%;
	background-color:#f7f7f7;
	border-style:solid;
	border-width:1px; 
	border-color:#00CC32;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	text-align: center;
}

#div2 {
	position:absolute;
	width:100%;
	height:30%;
	left: 0%;
	top: 0%;
	background:url("png/wbg.png");
}

#div2
{
	font-size: 150%;
	font-family: "Helvetica";
	color:white;
	line-height: 150%;
}


#div3 {
	position:absolute;
	width:100%;
	height:auto;
	z-index:1;
	left: 5%;
	top: 30%;
}

#div4 {
	position:relative;
	text-align:center;


}

#div5 {
	position:relative;
	text-align:center;
	font-size: 50%;
	font-family: "Helvetica";
	color:white;
	line-height: 150%;

}

#div6 {
	position:relative;
	text-align:center;
	font-size: 50%;
	font-family: "Helvetica";
	color:white;
	line-height: 150%;

}

#div7 {
	position:relative;
	text-align:center;
	top:5%;
}

#div8 {
	position:absolute;
	text-align:left;
	font-size: 150%;
	top:2%;
	font-family: "Helvetica";
	color:white;
	line-height: 150%;
}

.axis path,
.axis line {
  fill: none;
  stroke: none;
  shape-rendering: crispEdges;
}
</style>



<body onload="showNone()">



<div id="div1">图中显示去年同期（最近一个月内）五种常见高发疾病确诊人数</div>

<div id="div3">
	<strong><H3>
	<IMG SRC="png/c-3.png" class=img-rounded 
  	align=center ALT="error" height=1% border=0%>微脉提醒您预防以下几种常见疾病
 	<a onmouseover="showBlock()" onmouseout="showNone()"> 
	<IMG SRC="png-1/-1.png" class=img-rounded 
  	align=center ALT="error" height=3% border=0%></IMG></a>
	</H3></strong>
	</div>

<br><br>




<script src="js/d3.js"></script>

<script>

var temp1 = '<?php echo $temp1; ?>';
var temp2 = '<?php echo $temp2; ?>';
var wind = '<?php echo $temp3; ?>';
var power = '<?php echo $temp4; ?>';
var pollution = '<?php echo $temp5; ?>';
var status1 = '<?php echo $temp6; ?>';
var status2 = '<?php echo $temp7; ?>';

document.write('<div id="div2">');
document.write('<div id = "div7">');

if(status1 == "阴")
	document.write('<img src = "png-1/weather-1.png"');
else if(status1 == "多云")
	document.write('<img src = "png-1/weather-2.png"');
else if(status1 == "晴")
	document.write('<img src = "png-1/weather-3.png"');
else if(status1.indexOf("雪") > 0)
	document.write('<img src = "png-1/weather-4.png"');
else if(status1.indexOf("雨") > 0)
	document.write('<img src = "png-1/weather-5.png"');
else if(status1.indexOf("雷") > 0 || status1.indexOf("电") > 0)
	document.write('<img src = "png-1/weather-6.png"');
else
	document.write('<img src = "png-1/weather-1.png"');

document.write('style = "height:50%"></img></div>');
document.write('<div id = "div4">' + temp2 +' ~ ' + temp1 + '°' + '</div>');
document.write('<div id = "div5">' + wind + ' ' + power + '</div>');
document.write('<div id = "div6">' + pollution + '</div>');
document.write('</div>');
document.write('<div id = "div8">富阳市 <img src="png-1/local.png"></img><br>');
if(status1 == status2)
	document.write(status1 + '</div>');
else
	document.write(status1 + '转' + status2 + '</div>');

var total = 1000;//总分

var score = 200;//分数

var rem = total - score;

var device_width = document.body.clientWidth;
var device_height = document.documentElement.clientHeight;
//屏幕大小

var min;

var higher;
var lower;


var width = 0.9*device_width,
    height = 0.8*device_height,
    twoPi = 2 * Math.PI,
    format = d3.format("0.d"),
    percentFormat = d3.format(".1%");

if(width >= height)
    min = height;
else
    min = width;

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g");
//    .attr("transform", "translate(0," + min * 0.6+")");

var array0 = <?php echo $array0; ?>;
var array1 = <?php echo $array1; ?>;
var array2 = <?php echo $array2; ?>;
var array3 = <?php echo $array3; ?>;
var array4 = <?php echo $array4; ?>;

var name0 = '<?php echo $name0; ?>';
var name1 = '<?php echo $name1; ?>';
var name2 = '<?php echo $name2; ?>';
var name3 = '<?php echo $name3; ?>';
var name4 = '<?php echo $name4; ?>';


var dataset = [array0,array1,array2,array3,array4];  

var num = 5;  //数组的数量  

var xAxisScale = d3.scale.ordinal()  
	.domain([name0, name1, name2, name3, name4])  
	.rangeRoundBands([0,width], 0.5);  
                              
var yAxisScale = d3.scale.linear()  
	.domain([0,d3.max(dataset)])  
	.range([height/2,0]);  
                              
var xAxis = d3.svg.axis()
	.scale(xAxisScale)
	.orient("bottom");  
          
var yAxis = d3.svg.axis()
	.scale(yAxisScale)
	.orient("left");  
  
var xScale = d3.scale.ordinal()  
	.domain(d3.range(dataset.length))  
	.rangeRoundBands([0,width],0.5);  
                              
var yScale = d3.scale.linear()  
	.domain([0,d3.max(dataset)])  
	.range([0,height/2]);  
          
svg.selectAll("rect")  
	.data(dataset)  
	.enter()  
	.append("rect")  
   	.attr("x", function(d,i){  
   		return 0.05*width + xScale(i);  
  	 } )  
  	 .attr("y",function(d,i){  
  	 	return 0.9*height - yScale(d) ;  
  	 })  
  	 .attr("width", function(d,i){  
  	 	return xScale.rangeBand();  
  	 })  
  	 .attr("height",yScale)  
  	 .attr("fill","#FF5B56");  
       /*    
svg.selectAll("text")  
	.data(dataset)  
	.enter().append("text")  
	.attr("x", function(d,i){  
		return 0.05*width + xScale(i);  
	} )
	.attr("y",function(d,i){  
		return 0.9*height;  
	}) 
	.attr("dx", function(d,i){  
		return xScale.rangeBand()/3;  
	})
	.attr("dy", 15)  
	.attr("text-anchor", "begin")  
	.attr("font-size", 14)  
	.attr("fill","gray")
	.attr("transform", "rotate(10,0)")  
	.text(function(d,i){  
		return d;  
	});  */

svg.append("g") 
	.attr("class","axis")  
	.attr("transform","translate(" + 0.05*width + "," + 0.9*height + ")")
	.style("font-family", "Helvetica")
	.style("font-size", "12px")
//	.attr("transform", "rotate(0, 90)")
	.call(xAxis);  





function showNone(){
	document.getElementById('div1').style.display = "none";
}
function showBlock(){
	document.getElementById('div1').style.display = "block";
}




</script>


<center>
  <button style="position:absolute; height:10%; width:50%; bottom:0%; left:0%;">就诊档案</button>
  <button style="position:absolute; height:10%; width:50%; bottom:0%; right:0%;">费用报告</button>
</center>

</body>
</html>


