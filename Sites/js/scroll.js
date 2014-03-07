$(document).ready(function() {
    var $iBody = $("#iBody"),
        $window = $(window),
        $load = $(".load"),
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
            setTimeout(function(){
                $.ajax({
                    url: "/index.php/home/index",
                    type: "post",
                    dataType: "json",
                    data: {
                        number: number
                    },
                    success: function(datas) {
                        if(datas.result === true) {
                            var content = "",
                                dataArray = datas.data,
                                nowMonth = dataArray.time.split("-");
                            for(var i = 0; i < datas.data.length; i++) {
                                content += '<div class="articleBlock">' +
                                            '<div class="time">' +
                                            '<div class="month">' + month[nowMonth[1]] + '</div>' +
                                            '<div class="day">' + month[nowMonth[2]] + '</div>' +
                                            '<div class="year">' + month[nowMonth[0]] + '</div>' +
                                            '</div>' +
                                            '<div class="text">' +
                                            '<h2 class="textTit"><a href="' + dataArray.link + '">' + dataArray.title + '</a></h2>' +
                                            '<p class="textKind">分类：' + dataArray.type + '</p>' +

                                            '<div class="textContent">' +
                                            dataArray.content +
                                            '</div>' +
                                            '</div>' +
                                            '</div>';
                            }//END for
                            $(content).insertBefore($load);
                        } else {
                            $load.html("请期待更多的精彩...");
                        }
                    }
                });//END ajax
            }, 800);
        }
    });
});
