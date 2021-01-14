$(window).on('load',function(){
    //スムーススクロール
    $('a[href^="#"]').click(function(){
        var speed = 500;
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $("html, body").animate({scrollTop:position}, speed, "swing");
        return false;
    });

    var maxHeight = 0;
    $(".product_box").each(function(){
        if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
    });
    $(".product_box").height(maxHeight);
});