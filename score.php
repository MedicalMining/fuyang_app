<?php   
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  $score = $_SESSION['score'];
  $pid = $_SESSION['pid'];
//传递数据
?>
<html>
<head>
	<title>健康指数</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta http-equiv="Content-Language" content="zh"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<style>
.box{
	text-align:center;
	bottom:30%;
}

.background {
  fill: #C7C7C7;
}

button {
	text-align:center;
	font-size:120%;
	font-family:Helvetica;
	color:gray; }
/*
.popup a{text-decoration:none;}
.popup a:hover{text-decoration:none;background:none;}
.popup span{display:none;}
.popup a:hover span{display:block;}
*/

#div1 { 
		position:absolute;
	width:50%;
	height:auto;
	z-index:1;
	left: 10%;
	top: 10%;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	background-color:#BBBBBB;

} 
#div2 {
	position:absolute;
	width:auto;
	height:auto;
	z-index:1;
	left: 30%;
	bottom: 90%;

  width: 0px;
  height:0px;
  border-width: 8px;
  border-style: solid;
  border-color:  transparent   transparent  #BBBBBB transparent;
}

/*
#div1 {
	position:absolute;
	width:50%;
	height:auto;
	z-index:1;
	left: 10%;
	top: 10%;
	background-color:#f7f7f7;
	border-style:solid;
	border-width:1px; 
	border-color:#00CC32;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	line-height: 150%;
/*	text-align: center;

}/*健康指数弹窗*/

</style>

<body  onload="showNone()">
<div id="div1">健康指数是综合考虑用户医疗花费和生病情况计算得到的。</div>
<div id="div2"></div>
	<strong><H3>
	<IMG SRC="png/c-3.png" class=img-rounded 
  	align=center ALT="error" height=2% border=0%>
  	今日健康指数
 	<a ontouchstart="showBlock()"> 
	<IMG SRC="png-1/-1.png" class=img-rounded 
  	align=center ALT="error" height=3% border=0%></IMG></a>
	</H3></strong><br><br>

<script src="js/d3.js"></script>

<script>

var total = 100;//总分

var score = <?php echo $score; ?>;//健康得分

var rem = total - score;

var device_width = document.body.clientWidth;
var device_height = document.documentElement.clientHeight;
//屏幕大小

var min;

var width = 0.9*device_width,
    height = 0.6*device_height,
    twoPi = 2 * Math.PI,
    format = d3.format("0.1f"),
    percentFormat = d3.format(".1%");

if(width >= height)
    min = height;
else
    min = width;

var theta = score/total*twoPi;
var x = Math.sin(theta)*min*0.4;
var y = -Math.cos(theta)*min*0.4;


var arc = d3.svg.arc()
    .startAngle(0)
    .innerRadius(min*0.35)
    .outerRadius(min*0.45);

var arc2 = d3.svg.arc()
    .startAngle(0)
    .innerRadius(min*0.35)
    .outerRadius(min*0.45);

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + (device_width / 2 - 10) + "," + min * 0.45+")");
//svg画布

var b1 = svg.append("circle")
	.attr("cx", 0)
	.attr("cy", 0)
	.attr("r", min*0.45)
	.style("fill",  "#D0CAD4");

var b2 = svg.append("circle")
	.attr("cx", 0)
	.attr("cy", 0)
	.attr("r", min*0.35)
	.style("fill",  "white");

var gradient = svg.append("svg:defs")
	 .append("svg:linearGradient")
	 .attr("id", "gradient")
	 .attr("x1", "0%")
	 .attr("y1", "0%")
	 .attr("x2", "0%")
	 .attr("y2", "100%")
	 .attr("spreadMethod", "pad");

gradient.append("svg:stop")
	 .attr("offset", "0%")
	 .attr("stop-color", "#00FF2F")
	 .attr("stop-opacity", 1);

gradient.append("svg:stop")
	 .attr("offset", "100%")
	 .attr("stop-color", "#22C496")
	 .attr("stop-opacity", 1);

var color = d3.scale.linear()
    .domain([-0.325*min, 0.325*min])
    .range(["#00FF2F", "#22C496"]);
//颜色渐变

var circle = svg.append("circle")
	.attr("cx", 0)
	.attr("cy", -min*0.4)
	.attr("r", min*0.05)
   	.style("fill",  "#00FF2F");

if(theta >= Math.PI)
	c = color(y);
else
	c = "#22C496";

var circle2 = svg.append("circle")
	.attr("cx", x)
	.attr("cy", y)
	.attr("r", min*0.05)
	.style("fill",  c);

var meter = svg.append("g")
    .attr("class", "progress-meter");

meter.append("path")
   	.style("fill", "url(#gradient)")
    .attr("d", arc.endAngle(score/total*twoPi));


var text = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "300%")
    .style("fill", "#22C496")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + -30*device_height/800 + ")");
//健康得分

var text2 = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "100%")
    .style("fill", "#666666")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + 35*device_height/800 + ")");
//健康状况评价

var text3 = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "70%")
    .style("fill", "#AAAAAA")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + 90*device_height/800 + ")");
//评估日期

var str;
if(score >= 90)
	str = "健康状况非常好";
else if(score >= 70)
	str = "健康状况良好";
else
	str = "健康状况需要注意咯"
text.text(format(score));
//text2.text(format(score));
text2.text(str);

var today = new Date();
//var date = today.getYear() + "." + today.getMonth() + "." + today.getDay();
text3.text("评估时间：" + today.getFullYear() + "." + (today.getMonth()+1) + "." + today.getDate());
/*
var xmlns = "http://www.w3.org/2000/svg";
var svg_img = document.createElementNS(xmlns, "image");
width=140;
height=105;
svg_img.href.baseVal = "png-1/ponit.png";
svg_img.setAttributeNS(null,"id","svg_img");
svg_img.setAttributeNS(null,"width",width);
svg_img.setAttributeNS(null,"height",height);
svg_img.setAttributeNS(null,"x","0");
svg_img.setAttributeNS(null,"y","0");
var svg=document.getElementById("svg");
svg.appendChild(svg_img);
*/

for(var i = 0; i < 60; i++){
	if(!(i%5==0)){
	var line = svg.append("line")
		.style("stroke", "#888888")
		.attr("x1",min*0.32*Math.cos(i*twoPi/60))
		.attr("y1",min*0.32*Math.sin(i*twoPi/60))
		.attr("x2",min*0.34*Math.cos(i*twoPi/60))
		.attr("y2",min*0.34*Math.sin(i*twoPi/60));
	}
	else
	{
		var line = svg.append("line")
			.style("stroke", "#000000")
			.attr("x1",min*0.33*Math.cos(i*twoPi/60))
			.attr("y1",min*0.33*Math.sin(i*twoPi/60))
			.attr("x2",min*0.34*Math.cos(i*twoPi/60))
			.attr("y2",min*0.34*Math.sin(i*twoPi/60));
	}
}

function showNone(){
	document.getElementById('div1').style.display = "none";
	document.getElementById('div2').style.display = "none";
}
function showBlock(){
	document.getElementById('div1').style.display = "block";
	document.getElementById('div2').style.display = "block";
	setTimeout(showNone, 5000);
}
</script>

<div class = "box">
<img src = "png-1/slogen.png" style = "width : 80%"/></div>

<center><a href = <?php echo "interfaceInfo.php?action=patientInfo_TIMELINE&pid=".$pid; ?>>
  <button style="position:absolute; height:10%; width:50%; bottom:0%; left:0%; -webkit-appearance: none;
  background: white;"
>就诊档案</button></a>
  <a href = <?php echo "interfaceInfo.php?action=patientInfo_paymentBl&pid=".$pid; ?>>
  <button style="position:absolute; height:10%; width:50%; bottom:0%; right:0%; -webkit-appearance: none;
  background: white;">费用报告</button></a>
</center>

<!table table width="95%" align=center 
style="position:absolute; top:90%; left:0%;" >
<!tr><!td><!/td>
<!td><!/td><!/tr><!/table>

</body>
</html>


