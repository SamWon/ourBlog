$(document).ready(function() {
    var $wrapBg = $(".wrapBg"),
        $wrapTit = $(".wrapTit"),
        $iWrap = $("#iWrap"),
        $iBody = $("#iBody");

    //设置背景图片宽高
    $wrapBg.css("width", document.documentElement.clientWidth);
    $wrapBg.css("height", document.documentElement.clientHeight);

    //设置用户头像位置
    $wrapTit.css("top", ($iWrap.height() - $wrapTit.height()) / 2 - 95);
    $wrapTit.css("left", ($iWrap.width() - $wrapTit.width()) / 2);

    //显示主要内容
    $(".footTit").click(function() {
        $iWrap.animate({
            "marginTop": -document.documentElement.clientHeight - 4
        }, {
            duration: 700,
            complete: function() {
                $iBody.fadeIn(300);
            }
        });
    });

    //回到头部
    $(".goto").click(function() {
        $('body').animate({scrollTop: 0}, 500);
    });

    //回到头部按钮会在前300px消失
    $(window).on('scroll',function(){
        if($(window).scrollTop() < 300){
            $('.goto').hide();
        } else {
            $('.goto').fadeIn(400);
        }
    });
});
