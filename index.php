<!DOCTYPE html>
<!--
     Author idiotbaka
     CQ黄金契约模拟器
     兼容谷歌浏览器、Safari，其他没测试
     不兼容一小部分手机浏览器，定位和字体可能会有问题
     该项目的正式页面：iobaka.com/cq
-->
<?php
     // 钻石消耗数cookie
     if(!$_COOKIE["cost"]||$_COOKIE["cost"]==null||$_GET["clear"]==1){
          setcookie("cost", 0, time()+3600);
          $cost=0;
     }
     if($_GET["type"]==1){
          setcookie("cost", $_COOKIE["cost"]+6, time()+3600);
          $cost=$_COOKIE["cost"]+6;
     }
     else if($_GET["type"]==2){
          setcookie("cost", $_COOKIE["cost"]+50, time()+3600);
          $cost=$_COOKIE["cost"]+50;
     }
     else{
          $cost=$_COOKIE["cost"];
     }
     
?>
<html>
<head>
     <meta charset="UTF-8">
     <title>CQ 黄金契约模拟器</title>
    	<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
     <style type="text/css">
          @font-face { 
               font-family: pixel; 
               src: url("font/pixel.ttf"); 
          }
          .well{
               margin: 40px auto 40px auto;
               width: 870px;
          }
          .well.animated{
               text-align: center;
               margin: 40px auto 40px auto;
               width: 870px;
               height: 530px;
               background-image: url(img/background.png);
               font-family: pixel, "微软雅黑", "华文细黑", Arial, Helvetica, sans-serif;
          }
          #img_a {
               position: absolute;
               margin-left: -372px;
               margin-top: 230px;
               opacity: 0;
          }
          #img_a:hover{
               opacity: 1;
          }
          #img_b {
               position: absolute;
               margin-left: -199px;
               margin-top: 207px;
               opacity: 0;
          }
          #img_b:hover{
               opacity: 1;
          }
          .diamond{
               position: absolute;
               margin-left: 160px;
               margin-top: -6px;
          }
          
          .diamond span{
               color: DeepSkyBlue;
               font-size: 24px;
          }
          .diamond a{
               color: DeepSkyBlue;
               font-size: 16px;
               color: white;
          }
          
          .diamond img{
               width: 24px;
               margin-top: -6px;
          }
          .col-md-2{
               padding: 0px;
          }
          .row.ten-res p{
              margin-top: -30px; 
              width: 120px;
              margin-left: 48px;
          }
          #star {
               width: 12px;
               height: 12px;
          }
          .row .character{
               width: 200px;
          }
          .row p{
               margin-left: 0px;
          }
          #result_text p{
               margin-left: 18px;
          }
          .btn-group{
               margin-top: 10px;
          }
          #result_text .ico{
               width:26px;
               height:26px;
               position:absolute;
               margin-left: -135px;
               margin-top: 125px;
          }
          .ico{
               width:26px;
               height:26px;
               position:absolute;
               margin-left: 0px;
               margin-top:-50px;
          }
          #result_text .occu{
               width: 15px;
               height: 22px;
               position:absolute;
               margin-left: -75px;
               margin-top: 130px;
          }
          .occu{
               width: 15px;
               height: 22px;
               position:absolute;
               margin-left: 60px;
               margin-top:-46px;
          }
     </style>
     <script>
          $(document).on("ready", function(){
               // 图片的点击跳转
               $("#img_b").click(function(){
                    window.location.href='?type=2';
               });
               $("#img_a").click(function(){
                    window.location.href='?type=1';
               });
               // 结果页点击隐藏
               $("#result_img").click(function(){
                    $("#result_img").hide();
                    $("#result_text").hide();
                    $(".ten-res").hide();
               });
          });
     </script>
</head>
<body>
     <div class="well animated fadeInDown">
          <img id="img_a" src="img/2.png" />
          <img id="img_b" src="img/1.png" />
          <div class="diamond">
               <img src="img/diamond.png" />
               <span>
                    <?php
                    if($_GET["clear"]==1||$cost==null){
                         echo 0;
                    }
                    else {
                         echo $cost;   
                    }
                    ?>
               </span>
               <a href="?clear=1">重置</a>
          </div>
          <?php
               // 4*以及以上
               function goodResultJson($star=0){
                    $json_file = "json/result_good.json";
                    $json_string = file_get_contents($json_file);
                    $list = json_decode($json_string, true);
                    // 如果是最后一发保底
                    if($star==1){
                         $size = count($list);
                         // 遍历数组清除进化勇士
                         for($i=0; $i<$size; $i++){
                              if($list[$i]["type"]=="进化勇士"){
                                   unset($list[$i]);
                              }
                         }
                         // 重新排序索引
                         $list = array_values($list);
                         
                    }
                    return $list;
               }
               // 垃圾3星卡池
               function normalResultJson(){
                    $json_file = "json/result_normal.json";
                    $json_string = file_get_contents($json_file);
                    $list = json_decode($json_string, true);
                    return $list;
               }
               // 职业信息获取
               function getOccuResult($text, $rand_result){
                    if($text[$rand_result]["occu"]=="剑士"){
                         return "img/occu1.png";
                    }
                    else if($text[$rand_result]["occu"]=="骑士"){
                         return "img/occu2.png";
                    }
                    else if($text[$rand_result]["occu"]=="弓手"){
                         return "img/occu3.png";
                    }
                    else if($text[$rand_result]["occu"]=="猎人"){
                         return "img/occu4.png";
                    }
                    else if($text[$rand_result]["occu"]=="法师"){
                         return "img/occu5.png";
                    }
                    else if($text[$rand_result]["occu"]=="祭司"){
                         return "img/occu6.png";
                    }
                    else{
                         return 0;
                    }
               }
               // 根据星级结果抽取输出卡片
               function oneEchoResult($text, $star=3){
                    // 从数组中抽取一张卡作为结果
                    $rand_result = rand(1,count($text))-1;
                    // 三星
                    if($star==3){
                         return "
                         <div class='row'>
                              <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                   <img class='character' src='".$text[$rand_result]["img_url"]."' />
                                   <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                   <p>"."<img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name"]."</p>
                              </div>
                         </div>
                         ";
                    }
                    // 四星
                    else if($star==4){
                         // 如果是契约勇士，则样式为金色文本，ico金卷
                         if($text[$rand_result]["type"]=="契约勇士") {
                             return "
                              <div class='row'>
                                   <div class='col-md-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                        <img class='character' src='".$text[$rand_result]["img_url_4"]."' />
                                        <img class='ico' src='img/ico.png'/>
                                        <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                        <p style='color: gold'><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name_4"]."</p>
                                   </div>
                              </div>
                              "; 
                         }
                         // 进化勇士ico为白卷
                         else {
                              return "
                              <div class='row'>
                                   <div class='col-md-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                        <img class='character' src='".$text[$rand_result]["img_url_4"]."' />
                                        <img class='ico' src='img/ico_white.png'/>
                                        <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                        <p><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name_4"]."</p>
                                   </div>
                              </div>
                              ";
                         }
                         
                    }
                    else if($star==5){
                         if($text[$rand_result]["type"]=="契约勇士") {
                              return "
                              <div class='row'>
                                   <div class='col-md-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                        <img class='character' src='".$text[$rand_result]["img_url_5"]."' />
                                        <img class='ico' src='img/ico.png'/>
                                        <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                        <p style='color: gold'><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name_5"]."</p>
                                   </div>
                              </div>
                              ";
                         }
                         else{
                              return "
                              <div class='row'>
                                   <div class='col-md-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                        <img class='character' src='".$text[$rand_result]["img_url_5"]."' />
                                        <img class='ico' src='img/ico_white.png'/>
                                        <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                        <p><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name_5"]."</p>
                                   </div>
                              </div>
                              ";
                         }
                         
                    }
                    else if($star==6){
                         if($text[$rand_result]["type"]=="契约勇士") {
                              return "
                              <div class='row'>
                                   <div class='col-md-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                        <img class='character' src='".$text[$rand_result]["img_url_6"]."' />
                                        <img class='ico' src='img/ico.png'/>
                                        <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                        <p style='color: gold'><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name_6"]."</p>
                                   </div>
                              </div>
                              ";
                         }
                         else{
                              return "
                              <div class='row'>
                                   <div class='col-md-12 col-md-12 col-sm-12 col-xs-12' style='text-align: center'>
                                        <img class='character' src='".$text[$rand_result]["img_url_6"]."' />
                                        <img class='ico' src='img/ico_white.png'/>
                                        <img class='occu' src='".getOccuResult($text, $rand_result)."'/>
                                        <p><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><img id='star' src='img/star.png'/><br/>".$text[$rand_result]["type"]."<br/>".$text[$rand_result]["name_6"]."</p>
                                   </div>
                              </div>
                              ";
                         }
                         
                    }
                    
               }
               // 抽取星级
               function doResult($good=0){
                    // 保底4星契约
                    if($good==1){
                         $list = goodResultJson(1);
                         return oneEchoResult($list,4);
                    }
                    // 0~1000代表概率0.0% ~ 100.0%
                    $result = rand(0,1000);
                    // 0.6%
                    if($result<6){
                         $list = goodResultJson();
                         return oneEchoResult($list,6);
                    }
                    // 3.5%
                    else if($result<35){
                         $list = goodResultJson();
                         return oneEchoResult($list,5);
                    }
                    // 14.9%
                    else if($result<149){
                         $list = goodResultJson();
                         return oneEchoResult($list,4);
                    }
                    // 81%
                    else{
                         $list = normalResultJson();
                         return oneEchoResult($list);
                    }
               }
               // 抽取类型，1是单抽，2是10连
               if($_GET["type"]=='1'){
                    echo "<img id='result_img' src='img/3.png' style='width:380px; height: 400px; margin-top: 50px; margin-left: -180px; position: absolute'/>";
                    echo "<div id='result_text' style='padding-top: 120px; color: #fff'>".doResult()."</div>";
               }
               else if($_GET["type"]=='2'){
                    echo "<img id='result_img' src='img/4.png' style='width:760px; height: 572px; margin-top: -40px; margin-left: -380px; position: absolute'/>";
                    echo "
                    <div class='row ten-res' style='color: #fff; width: 800px; margin-left: 40px; margin-top: 30px;'>
                         <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                    "</div>".
                    "<div class='row ten-res' style='color: #fff; width: 800px; margin-top: -45px; margin-left: 40px; position: absolute'>
                         <div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2'>
                              ".doResult()."
                         </div>".
                         "<div class='col-md-2 col-md-2 col-sm-2 col-xs-2' style=''>
                              ".doResult(1)."
                         </div>".
                    "</div>";
               }
          ?>
     </div>
     <div class="text-zone well">
          <p>如果你的手机或浏览器版本过低不兼容该页面，可以点击按钮进行操作：
          <a href="?type=1"><button class="btn btn-primary">单抽</button></a>
          <a href="?type=2"><button class="btn btn-primary">十连抽</button></a></p>
          <p style="text-align: right; margin-top: 20px">Author idiotbaka</p>
          <p style="text-align: right">概率数据来自官方，图片数据以及图片流量来自着迷网<a href='http://wiki.joyme.com/cq' target='_black'>克鲁赛德战记WIKI区</a></p>
          <a href="https://github.com/idiotbaka/CQGachaSimulator"><button class="btn btn-default">View on Github</button></a>
     </div>
</body>
</html>
