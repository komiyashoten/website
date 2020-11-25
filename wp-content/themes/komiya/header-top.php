<?php get_template_part('html-head'); ?>

<script src="/wp-content/themes/komiya/js/jquery.bxslider.js"></script>
<link rel="stylesheet" href="/wp-content/themes/komiya/css/jquery.bxslider.css">
<script>
jQuery(document).ready(function(){
    jQuery('.bxslider').bxSlider({
        mode: 'fade',
		touchEnabled:false,
		auto:true
    });
});
</script>
<script type="text/javascript">
jQuery(function() {
    var navi = jQuery('.navi-pc');
    var naviHeight = navi.offset().top;
    jQuery(window).scroll(function () {
        var here = jQuery(this).scrollTop();
        if (here >= naviHeight) {
            navi.addClass('fix-navi-pc')
        } else if (here <= naviHeight) {
            navi.removeClass('fix-navi-pc')
        }
    });
});
</script>
<!-- ヘッダーラインバナー -->
<style type="text/css">
<!--
.top_sub_nav {
	padding-top: 45px;
}
.wrap-header-line-banner {
	padding: 10px;
	background: #846355;
	color: #fff;
	display: block;
}
@media screen and (max-width: 960px) {
.wrap-header-line-banner {
	margin-top: 60px;
	border: 15px #ffffff solid;
	}
}
.wrap-header-line-banner:hover {
	background: #966b5c;
}
.header-line-banner {
	text-align: center;
	font-size: 1.3rem;
}




-->
</style>
</head>
<body onload="initialize();" onclick="checkSelect();">
<header id="backtotop">
	<!-- <a href="https://www.komiyakasa.jp/clearance202007/" class="wrap-header-line-banner"><div class="header-line-banner">小宮商店 感謝セール開催  |  Thank You Sale 2020.7.10-12</div></a> -->
    <h1><a href="/"><img src="/wp-content/themes/komiya/img/logo_komiyashoten.jpg" alt="小宮商店 KOMIYA SHOTEN" class="logo_komiyashoten"></a></h1>
	<div class="navi-pc">
		<div class="fix-navi-logo"><!-- <a href="/"><img src="/wp-content/themes/komiya/img/logo_komiyashoten2.jpg" alt="小宮商店"></a> --></div>
		<?php get_template_part('navi'); ?>
	</div>
	<div class="navi-sp">
		<?php get_template_part('navi-sp'); ?>
	</div>
	<div class="top_sub_nav">
		<?php wp_nav_menu( array('menu' => 'header_munu' )); ?>
		<div class="jiten"><a href="/encyclopedia/">傘辞典</a></div>
	</div>
</header>
