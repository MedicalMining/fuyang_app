<html>
<head>
	<title>费用去向</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta http-equiv="Content-Language" content="zh"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel=stylesheet href="bootstrap.css" type="text/css">
</head>

<style>

td {text-align:center;font-size:100%;font-family: Helvetica; }

</style>

<body>
	<strong><H3>
	<IMG SRC="png/c-3.png" class=img-rounded 
  align=center ALT="error" height=2% border=0%>
	费用去向</H3></strong><br><br>

<script src="js/d3.js"></script>

<script>

function accSub(arg1, arg2) {
     var r1, r2, m, n;
     try {
         r1 = arg1.toString().split(".")[1].length;
     }
     catch (e) {
         r1 = 0;
     }
     try {
         r2 = arg2.toString().split(".")[1].length;
     }
     catch (e) {
         r2 = 0;
     }
     m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度
     n = (r1 >= r2) ? r1 : r2;
     return ((arg1 * m - arg2 * m) / m).toFixed(n);
}




var com_hos = 1000;//社区医院

var ind = 800;//个人支出

var med = accSub(com_hos, ind);//医疗支出

var device_width = document.body.clientWidth;
var device_height = document.documentElement.clientHeight;
//屏幕大小

var min;

var width = 0.9*device_width,
    height = 0.6*device_height,
    twoPi = 2 * Math.PI,
    format = d3.format("0.2f"),
    percentFormat = d3.format(".1%");

if(width >= height)
    min = height;
else
    min = width;


var arc = d3.svg.arc()
    .startAngle(0)
    .innerRadius(min*0.35)
    .outerRadius(min*0.45);
/*
var arc2 = d3.svg.arc()
    .startAngle(0)
    .innerRadius(min*0.35)
    .outerRadius(min*0.45);
*/
var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + (device_width / 2 - 10) + "," + min * 0.45+")");

var circle0 = svg.append("circle")
    .attr("cx",0)
    .attr("cy",0)
    .attr("r",min*0.45)
    .style("fill","#3EA2FF");

var circle1 = svg.append("circle")
    .attr("cx",0)
    .attr("cy",0)
    .attr("r",min*0.35)
    .style("fill","#BACDDE");
    
var circle2 = svg.append("circle")
    .attr("cx",0)
    .attr("cy",0)
    .attr("r",min*0.3)
    .style("fill","#FFF5D4");

var meter = svg.append("g")
    .attr("class", "progress-meter");

meter.append("path")
    .attr("class", "background")
    .style("fill", "#FF534B")
    .attr("d", arc.endAngle(med/com_hos*twoPi));
/*

var meter2 = svg.append("g")
    .attr("class", "progress-meter");

meter2.append("path")
    .attr("class", "background")
    .attr("d", arc2.endAngle(ind/com_hos*twoPi));
*/
var text = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "120%")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + -40*device_height/800 + ")");

var text2 = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "120%")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + 40*device_height/800 + ")");

text.text("社区医院支出");
text2.text(format(com_hos));

</script>
<hr>
<table width="95%" align=center>
<tr><td><img src='png/left-1.png' height = 50%></td>
<td>2011年</td>
<td><a href="2012.php"><img src='png/right-2.png' height = 50%></a></td></tr></table>
<hr>

<table width="95%" align=center>
<tr><td  width = "10%">1</td><td width = "20%"><img src='png/heart-1.png' height = 50%></td>
<td  width = "20%"><script>document.write(percentFormat(med/com_hos));</script></td>
<td  width = "25%">医疗支付</td>
<td  width = "25%"><script>document.write(format(med));</script></td></tr>
<tr><td>2</td><td><img src='png/user.png' height = 50%></td>
<td><script>document.write(percentFormat(ind/com_hos));</script></td>
<td>个人自付</td><td><script>document.write(format(ind));</script></td></tr>
</table>

</body>
</html>


