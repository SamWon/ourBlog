<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>our blog</title>
        <link rel="stylesheet" href="/css/reset.css" />
        <link rel="stylesheet" href="/css/index.css" />
        <link rel="stylesheet" href="/css/fcie.css" />
    </head>
    <body>
        <div id="iBody" class="detailBody">
<?php include($header);?>
            <div class="main clearfix">
                <div class="content">
                    <div class="articleBlock">
                        <div class="text">
                            <div class="textContent">
<?php echo $error;?>
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
                steams: ["Sam", "小复杂", "基佬","A","B","C"],//自定义飘动字
                steamFlyTime: 1000,//飞行时间
                makeSteamInterval: 1000,//制造间隔
		        steamMaxSize: 16,//最大字体
		        steamTopMax: 150,//飞行最高高度
                coffeeHandleWidth: 60
            });
        });
    </script>
    <!--[if lt IE 8]>
        <script type="text/javascript" src="../js/fcie.js"></script>
    <![endif]-->
</html>
