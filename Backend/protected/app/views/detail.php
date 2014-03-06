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
<?php foreach($article as $article):?><?php endforeach;?>
            <div class="main clearfix">
                <div class="content">
                    <div class="articleBlock">
                        <div class="time">
                            <div class="month"><?php echo $time_array[substr($article->time,5,2)];?></div>
                            <div class="day"><?php echo substr($article->time,8,2);?></div>
                            <div class="year"><?php echo substr($article->time,0,4);?></div>
                        </div>

                        <div class="text">
                        <h2 class="textTit"><?php echo $article->title;?></h2>

                        <p class="textKind">分类：<?php echo $t_array[$article->tid];?></p>

                            <div class="textContent">
<?php echo $article->content;?>
                                <!-- Duoshuo Comment BEGIN -->
                                <div class="ds-thread"></div>
                                <!-- Duoshuo Comment END -->
                            </div>
                        </div>
                    </div>

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
                steams: ["Sam", "小复杂", "基佬"],//自定义飘动字
                steamFlyTime: 1000,//飞行时间
                makeSteamInterval: 1000,//制造间隔
		        steamMaxSize: 16,//最大字体
		        steamTopMax: 150,//飞行最高高度
                coffeeHandleWidth: 60
            });
        });
    </script>
    <script type="text/javascript">
        var duoshuoQuery = {short_name:"fuziang"};
        (function() {
            var ds = document.createElement('script');
            ds.type = 'text/javascript';ds.async = true;
            ds.src = 'http://static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0] 
                || document.getElementsByTagName('body')[0]).appendChild(ds);
            })();
    </script>
</html>
