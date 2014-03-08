<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>our blog</title>
        <link rel="stylesheet" href="/css/reset.css" />
        <link rel="stylesheet" href="/css/index.css" />
    </head>
    <body>
        <div id="iBody" class="detailBody">
<?php include($header);?>
            <div class="main clearfix">
                <div class="content">
<?php foreach($articles as $a):?>
                    <div class="articleBlock">
                        <div class="time">
                            <div class="month"><?php echo $time_array[substr($a->time,5,2)];?></div>
                            <div class="day"><?php echo substr($a->time,8,2);?></div>
                            <div class="year"><?php echo substr($a->time,0,4);?></div>
                        </div>

                        <div class="text">
                        <h2 class="textTit"><a href="/index.php/detail/index/<?php echo $a->aid;?>"><?php echo $a->title;?></a></h2>

                        <p class="textKind">分类:<?php echo $t_array[$a->tid];?></p>

                            <div class="textContent">
<?php echo mb_substr($a->content,0,100,'utf-8')."......";?>
                            </div>
                        </div>
                    </div>
<?php endforeach;?>
                </div>
                <!-- END content -->

                <div class="aside">
                    <div id="coffee">
                        <img src="/img/coffee.png" alt="" />
                    </div>
<?php include($bar);?>

                </div>
                <!-- END aside -->
            </div>
            <!-- END main -->

            <div class="goto"></div>
        </div>
        <!-- END iBody -->
    </body>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/index.js"></script>
    <script type="text/javascript" src="/js/jquery.coffee.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#coffee").coffee({
                steams: ["Sam", "小复杂", "基佬","A","B","C"],//自定义飘动字
                steamFlyTime: 1000,//飞行时间
                makeSteamInterval: 1000,//制造间隔
		        steamMaxSize: 16,//最大字体
		        steamTopMax: 150,//飞行最高高度
                coffeeHandleWidth: 60
            });
        });
    </script>
</html>
