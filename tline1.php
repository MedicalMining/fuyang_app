<!DOCTYPE html>
<!--[if IE 7]><html class="ie7" lang="zh"><![endif]-->
<!--[if gt IE 7]><!-->
<html lang="zh">
<body bgcolor="#F5F5DC">
<!--<![endif]-->
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
<script type="text/javascrīpt" src="json.js"></script>

<script>

document.bgColor = "#F5F5DC";

document.write('<div class="content">');
document.write('<div class="wrapper">');
  document.write('<div class="main">');
  document.write('<h1 class="title">诊疗记录</h1>');

var str='<?=$str?>';
//将PHP传来的字符串还原成数组
var dataset = JSON.parse(str);




    var currentYear = "-1";
    var currentMonthDay = "-1";
    var currentYIYUAN = "-1";
    var currentZHENDUAN = "-1";

    var thisYear = "-1";
    var thisMonthDay = "-1";
    var thisYIYUAN = "-1";
    var thisZHENDUAN = "-1";

    //document.write('<p> here </p>');
    
        //document.write('<div class="year">');
    //document.write('<h2><a href="#">2014年<i></i></a></h2>');
    //document.write('<h2><a href="#">' + dataset[0]["RQ"].substring(0,4) + '年<i></i></a></h2>');
    //document.write('</div>');
    
    //var firstYear = false;
    //var firstMonthDay = false;
    //var firstYIYUAN = false;

    //var match_div_more = true;
    //var match_div_more_2 = true;

    var need_1 = false;
    var need_2 = false;
    var need_3 = false;
    var totalJE = 0;
    var j = 0;
    for(var i = 0; i < dataset.length; i++){
      //document.write('<p>' + currentZHENDUAN + 'hello' + '</p>');
      thisYear = dataset[i]['RQ'].substring(0,4);
      thisMonthDay = dataset[i]['RQ'].substring(4,8);
      thisYIYUAN = dataset[i]['YIYUAN'];
      thisZHENDUAN = dataset[i]['ZHENDUAN'];
      totalJE = parseInt(dataset[i]['JE']);

      if(thisYear == currentYear){
        if(thisMonthDay == currentMonthDay){
          if(thisYIYUAN == currentYIYUAN){
            if(thisZHENDUAN == currentZHENDUAN){
                //document.write('<p>' + dataset[i]['ZHENDUAN'] + i + '</p>');

            }
            else{
              //document.write('<p>' + i + '</p>');
              document.write('<p>' + dataset[i]['ZHENDUAN'] + '</p>');
              currentZHENDUAN = thisZHENDUAN;
            }


          }
          else{
            //document.write('<p>' + dataset[i]['YIYUAN'] + '</p>');
            if(need_3){
              document.write('</div>'); 
              need_3 = false;
            }
            

            //match_div_more_2 = true;


            document.write('<p class="date" ' + 'id = "g'+ i + '">'+ thisMonthDay.substring(0,2) + '月' + thisMonthDay.substring(2,4) + '日</p>');
            document.getElementById('g' + i).style.visibility = "hidden";
            //document.write('<p class="intro">' + dataset[i]['YIYUAN'] + dataset[i]['JE'] + '</p>');
            j = i + 1;
            while (true) {
              if (j == dataset.length) break;
              if (thisMonthDay == dataset[j]['RQ'].substring(4,8) && thisYear == dataset[j]['RQ'].substring(0,4) && thisYIYUAN == dataset[j]['YIYUAN']) {
                totalJE = totalJE + parseInt(dataset[j]['JE']);
    //            document.write((dataset[j]['JE'])+' ');
                j++;
              }
              else break;

            }
//        document.write('<p class="intro">' + totalJE + '￥)'+ '</p>');
//        totalJE = 0;

            document.write('<p class="intro">' + '<B>' + dataset[i]['YIYUAN'] + ': ' + dataset[i]['KESHI'] + '</B>'  + '<br>'+' (花费：'+ totalJE + '￥)'+ '</p>');
//            totalJE = 0;
//            document.write('<p class="intro">' + dataset[i]['YIYUAN'] + ': ' + dataset[i]['KESHI'] + ' (花费：'+ dataset[i]['JE'] + '￥)'+ '</p>');
            document.write('<p class="version">&nbsp;</p>');

            document.write('<div class="more">');
            need_3 = true;
            document.write('<p>' + dataset[i]['ZHENDUAN'] + '</p>');

            currentYIYUAN = thisYIYUAN;
            currentZHENDUAN = thisZHENDUAN;

          }
        }
        else{
          if(need_3){
            document.write('</div>');
            need_3 = false;
          }

          if(need_2){
            document.write('</li>');
            need_2 = false;
          }



          document.write('<li class="cls">');
          need_2 = true;
          document.write('<p class="date">' + thisMonthDay.substring(0,2) + '月' + thisMonthDay.substring(2,4) + '日</p>');

          j = i + 1;
          while (true) {
            if (j == dataset.length) break;
            if (thisMonthDay == dataset[j]['RQ'].substring(4,8) && thisYear == dataset[j]['RQ'].substring(0,4) && thisYIYUAN == dataset[j]['YIYUAN']) {
              totalJE = totalJE + parseInt(dataset[j]['JE']);
  //            document.write((dataset[j]['JE'])+' ');
              j++;
            }
            else break;

          }
          document.write('<table class="intro"><tr><td><label bgcolor="Blue">住院</label></td><td>￥1099.00</td></tr></table>');
//          document.write('<p class="intro">' + '<B>' + dataset[i]['YIYUAN'] + ': ' + dataset[i]['KESHI'] + '</B>'  + '<br>'+' (花费：'+ totalJE + '￥)'+ '</p>');
          document.write('<p class="version">&nbsp;</p>');

          document.write('<div class="more">');
          need_3 = true;
          document.write('<p>' + dataset[i]['ZHENDUAN'] + '</p>');

        
          currentMonthDay = thisMonthDay;
          currentYIYUAN = thisYIYUAN;
          currentZHENDUAN = thisZHENDUAN;

        }
      }
      else{


          if(need_3){
            document.write('</div>');
            need_3 = false;
          }

          if(need_2){
            document.write('</li>');
            need_2 = false;
          }

          if(need_1){
            document.write('</ul>');      
            document.write('</div>');
            document.write('</div>');

            need_1 = false;

          }


          //        totalJE = 0;

        document.write('<div class="year">');
        document.write('<h2><a href="#">' + thisYear + '年<i></i></a></h2>');
        
        document.write('<div class="list">');
        document.write('<ul>');
        need_1 = true;

        document.write('<li class="cls">');
        need_2 = true;
        document.write('<p class="date">' + thisMonthDay.substring(0,2) + '月' + thisMonthDay.substring(2,4) + '日</p>');


        //document.write('<p class="intro">' + dataset[i]['YIYUAN'] + '</p>');
        j = i + 1;
        while (true) {
          if (j == dataset.length) break;
          if (thisMonthDay == dataset[j]['RQ'].substring(4,8) && thisYear == dataset[j]['RQ'].substring(0,4) && thisYIYUAN == dataset[j]['YIYUAN']) {
            totalJE = totalJE + parseInt(dataset[j]['JE']);
//            document.write(totalJE+' ');
            j++;
          }
          else break;

        }
//        document.write('<p class="intro">' + totalJE + '￥)'+ '</p>');
//        totalJE = 0;
/*        document.write(thisYear);
        document.write(thisMonthDay);
        document.write(thisYIYUAN);*/
//        document.write(thisYIYUAN);
        document.write('<p class="intro">' + '<B>' + dataset[i]['YIYUAN'] + ': ' + dataset[i]['KESHI'] + '</B>' +'<br>' + ' (花费：'+ totalJE + '￥)'+ '</p>');
        totalJE = 0;
        document.write('<p class="version">&nbsp;</p>');
            
        document.write('<div class="more">');
        need_3 = true;
        document.write('<p>' + dataset[i]['ZHENDUAN'] + '</p>');

        

        currentYear = thisYear;
        currentMonthDay = thisMonthDay;
        currentYIYUAN = thisYIYUAN;
        currentZHENDUAN = thisZHENDUAN;

        //firstMonthDay = false;

      }
    }

          if(need_3){
            document.write('</div>');
            need_3 = false;
          }

          if(need_2){
            document.write('</li>');
            need_2 = false;
          }


          if(need_1){
            document.write('</ul>');      
            document.write('</div>');
            document.write('</div>');

            need_1 = false;

          }



 

 
  document.write('</div>');
document.write('</div>');
document.write('</div>');




</script>
<script type="text/javascript" src="js/jquery.min.js"></script>

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
