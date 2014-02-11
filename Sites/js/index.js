$(document).ready(function() {
    var $wrapBg = $(".wrapBg"),
        $wrapTit = $(".wrapTit"),
        $iWrap = $("#iWrap");

    //设置背景图片宽高
    $wrapBg.css("width", document.documentElement.clientWidth);
    $wrapBg.css("height", document.documentElement.clientHeight);

    //设置用户头像位置
    $wrapTit.css("top", ($iWrap.height() - $wrapTit.height()) / 2 - 95);
    $wrapTit.css("left", ($iWrap.width() - $wrapTit.width()) / 2);
});
