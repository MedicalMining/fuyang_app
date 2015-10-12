<html>
<head>
	<title>医疗费用趋势</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta http-equiv="Content-Language" content="zh"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel=stylesheet href="bootstrap.css" type="text/css">
</head>

<style>

.axis path,
.axis line {
	fill: none;
	stroke: lightgray;
	shape-rendering: crispEdges;
}
.axis text {
	font-family: sans-serif;
	font-size: 70%;
	fill:#999;
}
.inner_line path,
.inner_line line {
	fill: none;
	stroke:#E7E7E7;
	shape-rendering: crispEdges;
}
.tiptools
{
	display:block;
	font-size:100%;
	font-family:Arial, Helvetica, sans-serif;
	cursor:pointer;
}

</style>
<body>
	<strong><H3>
	<IMG SRC="png/c-3.png" class=img-rounded 
  align=center ALT="error" height=2% border=0%>
	年度医疗费用趋势图</H3></strong><br><br>

<?php   
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $array = array();


    $array = $_SESSION['payTo'];
//    $myvar = 10;
    $array2011 = $array[0];
    if ($array2011 == null)
    	$array2011 = 0;
//    echo $array2011;
    $array2012 = $array[1];
    if ($array2012 == null)
		$array2012 = 0;
//    echo $array2012;
    $array2013 = $array[2];
//       echo $array2013;
    if ($array2013 == null)
    	$array2013 = 0;
    $array2014 = $array[3];
//        echo $array2014;
    if ($array2014 == null)
    	$array2014 = 0;
    $array2015 = $array[4];
//        echo $array2015;
    if ($array2015 == null)
    	$array2015 = 0;
   ?>


<script src="js/d3.js"></script>

<script>

var dataset = new Array(5);
dataset[0] =  <?php echo $array2011; ?>;
//document.write(dataset[0]);
dataset[1] =  <?php echo $array2012; ?>;
//document.write(dataset[1]);
dataset[2] =  <?php echo $array2013; ?>;
//document.write(dataset[2]);
dataset[3] =  <?php echo $array2014; ?>;
dataset[4] =  <?php echo $array2015; ?>;

var xMarks = [2011, 2012, 2013, 2014, 2015];//年份
var device_width = document.body.clientWidth;
var device_height = document.documentElement.clientHeight;

var w = device_width * 0.97;
var h = device_height * 0.8;

var padding = w*0.15;
var head_height = padding*0.5;
var foot_height = padding*0.5;

var format = d3.format("0.2f");


if(!(dataset[0] instanceof Array))
{
	var tempArr = [];
	tempArr.push(dataset);
	dataset = tempArr;
}
currentLineNum = dataset.length;

var svg = d3.select("body")
	.append("svg")
	.attr("width",w)
	.attr("height",h);

maxdata = getMaxdata(dataset);

var xScale = d3.scale.linear()
	.domain([0,dataset[0].length-1])
	.range([padding,w - padding]);

var yScale = d3.scale.linear()
	.domain([0, maxdata])
	.range([h - foot_height, head_height]);

var xInner = d3.svg.axis()
	.scale(xScale)
	.tickSize(-(h-head_height-foot_height),0,0)
	.tickFormat("")
	.orient("bottom")
	.ticks(dataset[0].length);

var xInnerBar = svg.append("g")
	.attr("class","inner_line")
	.attr("transform", "translate(0," + (h - foot_height) + ")")
	.call(xInner);

var yInner = d3.svg.axis()
	.scale(yScale)
	.tickSize(-(w-padding*2),0,0)
	.tickFormat("")
	.orient("left")
	.ticks(10);

var yInnerBar = svg.append("g")
	.attr("class", "inner_line")
	.attr("transform", "translate("+padding+",0)")
	.call(yInner);

var xAxis = d3.svg.axis()
	.scale(xScale)
	.orient("bottom")
	.ticks(dataset[0].length);

var xBar = svg.append("g")
	.attr("class","axis")
	.attr("transform", "translate(0," + (h - foot_height) + ")")
	.call(xAxis);

xBar.selectAll("text")
	.text(function(d){return xMarks[d];});

xBar.append("text")
	.attr("transform", "translate(" + (w - padding) + ", 0)")
	.text("年");

var yAxis = d3.svg.axis()
	.scale(yScale)
	.orient("left")
	.ticks(10);

var yBar = svg.append("g")
	.attr("class", "axis")
	.attr("transform", "translate("+padding+",0)")
	.call(yAxis);

yBar.append("text")
	.attr("transform", "translate(0," + foot_height/2 + ")")
	.text("单位：元");

lines = [];
for(i = 0;i < currentLineNum;i++)
{
	var newLine=new CrystalLineObject();
	newLine.init(i);
	lines.push(newLine);
}

function CrystalLineObject()
{
	this.group = null;
	this.path = null;
	this.init = function(id)
	{
		var arr = dataset[id];
		this.group = svg.append("g");
		var line = d3.svg.line()
			.x(function(d,i){return xScale(i);})
			.y(function(d){return yScale(d);});
		this.path = this.group.append("path")
		.attr("d",line(arr))
		.style("fill","none")
		.style("stroke-width",1)
		.style("stroke", "steelblue")
		.style("stroke-opacity",0.9);

		var area = d3.svg.area()
			.x(function(d,i){return xScale(i);})
			.y0(function(d) { return h - foot_height; })
			.y1(function(d){return yScale(d);});

		this.path = this.group.append("path")
			.attr("d",area(arr))
			.style("fill","#0083FF")
			.style("opacity", 0.2);


		this.group.selectAll("circle")
			.data(arr)
			.enter()
			.append("circle")
			.attr("cx", function(d,i) {
				return xScale(i);
			})
			.attr("cy", function(d) {
				return yScale(d);
			})
			.attr("cursor","pointer")
			.attr("r",5)
			.attr("stroke", "white")
			.attr("fill", "steelblue");
		
		this.group.selectAll("circle")
			.on("mouseover",function(d,i){
				d3.select(this)
				.style("stroke", "white")
				.style("fill", "#FF5A63")
                .transition()
        		.duration(500)
          		.attr("r", 10);
				var tx = parseFloat(d3.select(this).attr("cx"));
				var ty = parseFloat(d3.select(this).attr("cy"));
				var tips = svg.append("g")
					.attr("id","tips");
				var tipText = tips.append("text")
					.attr("class","tiptools")
					.text(format(d))
					.style("fill", "#FF5A63")
					.attr("x",tx)
					.attr("y",ty-15*device_width/800);
				})
		.on("mouseout",function(d,i){
			d3.select(this)
			.style("fill", "steelblue")
			.style("stroke", "white")
            .transition()
        	.duration(500)
        	.attr("r", 5);
		d3.select("#tips").remove();
	});
	};
}

function getMaxdata(arr)
{
	maxdata = 0;
	for(i = 0;i < arr.length;i++)
	{
		maxdata = d3.max([maxdata,d3.max(arr[i])]);
	}
	return maxdata;
}

</script>
</body>
</html>