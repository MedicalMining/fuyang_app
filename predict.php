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

    $pid = $_SESSION['pid'];

?>


<html>
<head>
	<title>健康预测</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta http-equiv="Content-Language" content="zh"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
.tiptools
{
	display:block;
	font-size:100%;
	font-family:Arial, Helvetica, sans-serif;
}
/*
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
	line-height: 150%;
}*/

#div1 { 
		position:absolute;
	width:50%;
	height:auto;
	z-index:1;
	left: 30%;
	top: 42%;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	background-color:#BBBBBB;

} 
#div111 {
	position:absolute;
	width:auto;
	height:auto;
	z-index:1;
	left: 50%;
	bottom: 58%;

  width: 0px;
  height:0px;
  border-width: 8px;
  border-style: solid;
  border-color:  transparent   transparent  #BBBBBB transparent;
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
	width:90%;
	height:auto;
	z-index:1;
	font-size: 100%;
	top: 30%;
}

#div4 {
	position:relative;
	text-align:center;
	font-size: 80%;
	line-height: 150%;
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

#div81 {
	position:absolute;
	text-align:left;
	font-size: 120%;
	top:10%;
	font-family: "Helvetica";
	color:white;
	line-height: 150%;
}



#div9 {
	position:absolute;
	text-align:left;
	font-size: 80%;
	top:80%;
	width: 15%;
	font-family: "Helvetica";
	color:gray;
	line-height: 100%;
}
#div10 {
	position:absolute;
	text-align:left;
	font-size: 80%;
	top:80%;
	width: 15%;
	font-family: "Helvetica";
	color:gray;
	line-height: 100%;
}
#div11 {
	position:absolute;
	text-align:left;
	font-size: 80%;
	top:80%;
	width: 15%;
	font-family: "Helvetica";
	color:gray;
	line-height: 100%;
}
#div12 {
	position:absolute;
	text-align:left;
	font-size: 80%;
	top:80%;
	width: 15%;
	font-family: "Helvetica";
	color:gray;
	line-height: 100%;
}
#div13 {
	position:absolute;
	text-align:left;
	font-size: 80%;
	top:80%;
	width: 15%;
	font-family: "Helvetica";
	color:gray;
	line-height: 100%;
}


.axis path,
.axis line {
  fill: none;
  stroke: none;
  shape-rendering: crispEdges;
}
.axis text{
	font-size: 8px;
	font-family: "Helvetica";
}


.d3-tip {
  line-height: 1;
  font-weight: bold;
  padding: 5px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 1px;
}

/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 10px;
  width: 100%;
  line-height: 1;
  color: rgba(0, 0, 0, 0.8);
  content: "\25BC";
  position: absolute;
  text-align: center;
}

/* Style northward tooltips differently */
.d3-tip.n:after {
  margin: -1px 0 0 0;
  top: 100%;
  left: 0;
}

</style>



<body onload="showNone()">




<div id="div3">
	<strong><H3>
	<IMG SRC="png/c-3.png" class=img-rounded 
  	align=center ALT="error" height=2% border=0%>
  	微脉提醒您预防以下几种常见疾病
 	<a ontouchstart="showBlock()"> 
	<IMG SRC="png-1/-1.png" class=img-rounded 
  	align=center ALT="error" height=3% border=0%></IMG></a>
	</H3></strong>
	</div>

	<div id="div1">图中显示去年同期（最近一个月内）五种常见高发疾病确诊人数</div>

<div id="div111"></div>

<br><br>




<script src="js/d3.js"></script>
<script src="js/tip.js"></script>

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
document.write('<div id = "div8">富阳市 <img src="png-1/local.png"></img></div>');
if(status1 == status2)
	document.write('<div id = "div81">' + status1 + '</div>');
else
	document.write('<div id = "div81">' + status1 + '转' + status2 + '</div>');

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

var padding = 0.2*width;

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
	.rangeRoundBands([0,0.8*width], 0.5);  
                              
var yAxisScale = d3.scale.linear()  
	.domain([0,d3.max(dataset)])  
	.range([height/4,0]);  
                         
var xAxis = d3.svg.axis()
	.scale(xAxisScale)
	.orient("bottom");  
          
var yAxis = d3.svg.axis()
	.scale(yAxisScale)
	.orient("left");  
  
var xScale = d3.scale.ordinal()  
	.domain([0,1,2,3,4])  
	.rangeRoundBands([0,0.8*width], 0.5);  
                              
var yScale = d3.scale.linear()  
	.domain([0,d3.max(dataset)])  
	.range([0,height/4]);  

var yBar = svg.append("g")
	.attr("class", "axis")
	.attr("transform", "translate(" + padding + "," + (0.8-0.25)*height + ")")
	.call(yAxis);

yBar.append("text")
	.attr("transform", "translate(0, -10)")
	.style("fill", "gray")
	.text("单位：人");

var tip = d3.tip()
  .attr('class', 'd3-tip')
  .offset([-10, 0])
  .html(function(d) {
    return "<span style='color:red'>" + d + "</span><strong>人</strong> ";
  })

    svg.call(tip);

svg.selectAll("rect")  
	.data(dataset)  
	.enter()
	.append("rect")  
   	.attr("x", function(d,i){  
   		return 0.15*width + xScale(i);  
  	 } )  
  	 .attr("y",function(d,i){  
  	 	return 0.8*height - yScale(d) ;  
  	 })  
  	 .attr("width", function(d,i){  
  	 	return xScale.rangeBand();  
  	 })  
  	 .attr("height",yScale)  
  	 .attr("fill","#FF5B56");  

  	 		svg.selectAll("rect")
			.on("mouseover",/*function(d,i){
				d3.select(this)
				.style("fill", "#00B5FF")
                .transition()
        		.duration(500);
				var tx = parseFloat(d3.select(this).attr("x"));
				var ty = parseFloat(d3.select(this).attr("y"));
				var tips = svg.append("g")
					.attr("id","tips");
				var tipText = tips.append("text")
					.attr("class","tiptools")
					.text(d)
					.style("fill", "#00B5FF")
					.attr("x",tx-10*device_width/800)
					.attr("y",ty-15*device_width/800);*/
				tip.show)//})
		.on("mouseout",/*function(d,i){
			d3.select(this)
			.style("fill", "#FF5B56")
            .transition()
        	.duration(500);*/
   //     d3.select("#tips").remove();
   tip.hide);
	//});
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

var axesG = svg.append("g")  
               .attr("class", "axes");  
  
    axesG.append("g")  
         .attr("class", "x axis")  
		 .attr("transform","translate(" + 0.15*width + "," + 0.85*height + ")")
		 .call(xAxis);  
    d3.selectAll("g.x g.tick text")  
         .attr("transform", "rotate(-15)");   
/*
svg.append("g") 
	.attr("class","axis")  
	.attr("transform","translate(" + 0.15*width + "," + 0.5*height + ")")
	.style("font-family", "Helvetica")
	.style("font-size", "12px")
//	.attr("transform", "rotate(0, 90)")
	.call(xAxis);  
*/

/*
var sickness0 = document.getElementById('div9');
sickness0.innerHTML = "name0";
var sickness1 = document.getElementById('div10');
sickness1.innerHTML = "name1";
var sickness2 = document.getElementById('div11');
sickness2.innerHTML = "name2";
var sickness3 = document.getElementById('div12');
sickness3.innerHTML = "name3";
var sickness4 = document.getElementById('div13');
sickness4.innerHTML = "name4";
*/
/*
document.write('<div id = "div9" style = "left:' + 0.23*width + '">' + name0 + '</div>');
document.write('<div id = "div10" style = "left:' + (0.23+0.145)*width  + '">' + name1 + '</div>');
document.write('<div id = "div11" style = "left:' + (0.23+0.145*2)*width  + '">' + name2 + '</div>');
document.write('<div id = "div12" style = "left:' + (0.23+0.145*3)*width + '">' + name3 + '</div>');
document.write('<div id = "div13" style = "left:' + (0.23+0.145*4)*width + '">' + name4 + '</div>');
*/

function showNone(){
	document.getElementById('div1').style.display = "none";
	document.getElementById('div111').style.display = "none";

}
function showBlock(){
	document.getElementById('div1').style.display = "block";
	document.getElementById('div111').style.display = "block";

	setTimeout(showNone, 5000);
}




</script>


<center><a href = <?php echo "interfaceInfo.php?action=patientInfo_TIMELINE&pid=".$pid; ?>>
  <button style="position:absolute; height:10%; width:50%; bottom:0%; left:0%; -webkit-appearance: none;
   background: white;">就诊档案</button></a>
     <a href = <?php echo "interfaceInfo.php?action=patientInfo_paymentBl&pid=".$pid; ?>>
  <button style="position:absolute; height:10%; width:50%; bottom:0%; right:0%; -webkit-appearance: none;
  background: white;">费用报告</button></a>
</center>

</body>
</html>


