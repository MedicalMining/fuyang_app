<html>
<head>
    <title>费用去向</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="zh"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel=stylesheet href="bootstrap.css" type="text/css">
</head>

<style>

.background {
  fill: #FF534B;
}

td {text-align:center;font-size:100%;font-family: Helvetica; }

</style>

<body>
    <strong><H3>
    <IMG SRC="png/c-3.png" class=img-rounded 
  align=center ALT="error" height=1% border=0%>
    费用去向</H3></strong><br><br>

<script src="d3.js"></script>

<script>

var total = 1055.60;//总支出

var hos1 = 819.70;//社区医院

var hos2 = 235.90;//三甲医院

var device_width = document.body.clientWidth;
var device_height = document.documentElement.clientHeight;
//屏幕大小

var min;

var width = 0.8*device_width,
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
    .innerRadius(min*0.3)
    .outerRadius(min*0.35);

var arc2 = d3.svg.arc()
    .startAngle(0)
    .innerRadius(min*0.3)
    .outerRadius(min*0.35);

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + device_width / 2 + "," + min * 0.4+")");

var circle = svg.append("circle")
    .attr("cx",0)
    .attr("cy",0)
    .attr("r",min*0.3)
    .style("fill","#BACDDE");
    
var circle2 = svg.append("circle")
    .attr("cx",0)
    .attr("cy",0)
    .attr("r",min*0.28)
    .style("fill","#FFF5D4");

var meter = svg.append("g")
    .attr("class", "progress-meter");

meter.append("path")
    .attr("class", "background")
    .style("fill", "#3EA2FF")
    .attr("d", arc.endAngle(hos1/total*twoPi));


var meter2 = svg.append("g")
    .attr("class", "progress-meter");

meter2.append("path")
    .attr("class", "background")
    .attr("d", arc2.endAngle(hos2/total*twoPi-twoPi));

var text = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "200%")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + -40*device_height/800 + ")");

var text2 = meter.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", ".35em")
    .style("font-size", "200%")
    .style("font-family", "Helvetica")
    .attr("transform", "translate(0," + 40*device_height/800 + ")");

text.text("共支出");
text2.text(format(total));

</script>
<hr>
<table width="95%" align=center>
<tr><td><a href='2011.php'><img src='png/left-2.png'></a></td>
<td>2012年</td>
<td><a href='2013.php'><img src='png/right-2.png'></a></td></tr></table>
<hr>
<table width="95%" align=center>
<tr><td  width = "10%">1</td><td width = "20%"><img src='png/heart-1.png'></td>
<td  width = "20%"><script>document.write(percentFormat(hos1/total));</script></td>
<td  width = "25%"><a href = 'hos1.php?year=2012' style="text-decoration: none;">社区医院</a></td>
<td  width = "25%"><script>document.write(hos1);</script></td></tr>
<tr><td>2</td><td><img src='png/heart-1.png'></td>
<td><script>document.write(percentFormat(hos2/total));</script></td>
<td><a href = 'hos2.php?year=2012' style="text-decoration: none;">三甲医院</a></td><td><script>document.write(hos2);</script></td></tr>
</table>


</body>
</html>


