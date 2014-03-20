$(document).ready(function() {
    var $iBody = $("#iBody"),
        $window = $(window),
        $load = $(".load"),
        kind = location.pathname.split("/"),
        pageUrl = "",
        month = [0, "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        number = 1,
        //判断是否发送ajax
        onload = 0,
        screenHeight = document.documentElement.clientHeight;

    $window.on("scroll", function() {
        if($window.scrollTop() >= ($iBody.height() - screenHeight)) {
            //显示加载中
            $load.show();
            setTimeout(function(){
                $load.fadeOut(400);
            }, 400);

            //加载文章
            if(onload === 0) {
                onload = 1;

                if(!kind[kind.length - 1]) {
                    pageUrl = "/index.php/home/search/";
                } else {
                    kind = kind[kind.length - 1];
                    pageUrl = "/index.php/home/index/" + kind;
                }

                setTimeout(function() {
                    $.ajax({
                        url: pageUrl,
                        type: "post",
                        dataType: "json",
                        data: {
                            number: number
                        },
                        success: function(datas) {
                            if(datas.result === "true") {
                                var content = "",
                                    dataArray = datas.data;

                                for(var i = 0; i < datas.data.length; i++) {
                                    var nowMonth = dataArray[i].time.split("-");
                                    content += '<div class="articleBlock">' +
                                                '<div class="time">' +
                                                '<div class="month">' + month[window.parseInt(nowMonth[1])] + '</div>' +
                                                '<div class="day">' + nowMonth[2] + '</div>' +
                                                '<div class="year">' + nowMonth[0] + '</div>' +
                                                '</div>' +
                                                '<div class="text">' +
                                                '<h2 class="textTit"><a href="' + dataArray[i].link + '">' + dataArray[i].title + '</a></h2>' +
                                                '<p class="textKind">分类：' + dataArray[i].type + '</p>' +

                                                '<div class="textContent">' +
                                                dataArray[i].content +
                                                '</div>' +
                                                '</div>' +
                                                '</div>';
                                }//END for

                                $(content).insertBefore($load);
                                onload = 0;
                                number++;

                                if(datas.data.length < 5) {
                                    $load.html("请期待更多的精彩...");
                                    onload = 1;
                                }
                            } else {
                                $load.html("请期待更多的精彩...");
                                onload = 1;
                            }
                        }
                    });//END ajax
                }, 800);
            }
        }
    });
});
