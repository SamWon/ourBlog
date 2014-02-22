<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>our blog</title>
        <link rel="stylesheet" href="../css/reset.css" />
        <link rel="stylesheet" href="../css/index.css" />
    </head>
    <body>
        <div id="iWrap">
            <img src="../img/bg.jpg" alt="" class="wrapBg" />

            <div class="wrapTit">
                <img src="../img/cat.jpg" alt="我的头像" class="headImg" />

                <h1 class="userName titColor">Kirsten</h1>
            </div>

            <div class="wrapFoot">
                <h2 class="footTit titColor">欢迎来到我的世界</h2>
            </div>
        </div>
        <!-- END iWrap -->

        <div id="iBody">
            <div class="mainTit">
                <h1>Kirsten</h1>
                <p class="subTit">这里是副标题，比如什么口号一类的</p>
            </div>

            <div class="main clearfix">
                <div class="content">
                    <div class="articleBlock">
                        <div class="time">
                            <div class="month">十二月</div>
                            <div class="day">31</div>
                            <div class="year">2014</div>
                        </div>

                        <div class="text">
                            <h2 class="textTit"><a href="#">这是文章名称</a></h2>

                            <p class="textKind">分类：呵呵呵呵</p>

                            <div class="textContent">
                                ahdsakjdaskdsahdkjashdsakjdhsakdjasdjkaslhdasksahkjdhaskd
                                <img src="../img/bg.jpg" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="articleBlock">
                        <div class="time">
                            <div class="month">十二月</div>
                            <div class="day">31</div>
                            <div class="year">2014</div>
                        </div>

                        <div class="text">
                            <h2 class="textTit"><a href="#">这是文章名称</a></h2>

                            <p class="textKind">分类：呵呵呵呵</p>

                            <div class="textContent">
                                ahdsakjdaskdsahdkjashdsakjdhsakdjasdjkaslhdasksahkjdhaskd
                                <img src="../img/bg.jpg" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END content -->

                <div class="aside">
                    <div id="coffee">
                        <img src="../img/coffee.png" alt="" />
                    </div>

                    <div class="kind">
                        <h3>分类列表</h3>
                        <ul>
                          <li><a href="#">全部</a></li>
                          <li><a href="#">随笔</a></li>
                          <li><a href="#">技术</a></li>
                          <li><a href="#">呵呵呵呵</a></li>
                        </ul>
                    </div>
                </div>
                <!-- END aside -->
            </div>
            <!-- END main -->

            <div class="goto"></div>
        </div>
        <!-- END iBody -->
    </body>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/index.js"></script>
    <script type="text/javascript" src="../js/jquery.coffee.js"></script>
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
</html>