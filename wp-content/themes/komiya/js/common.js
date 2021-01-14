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

    makeHeightSame(".products_box .product_box");
    $(window).resize(function(){
        makeHeightSame(".products_box .product_box")
    });
});

function makeHeightSame( element ){
    if( $(window).width() > 500 ){
        var maxHeight = 0;
        $(element).each(function(){
            if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
        });
        $(element).height(maxHeight);    
    }

}