<?php get_template_part('html-head'); ?>
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
<?php wp_head(); ?>
<script src="<?php assets('js','jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php assets('js','common.js'); ?>"></script>
</head>
<body onclick="checkSelect();">
<header id="backtotop">
    <h1><a href="/"><img src="/wp-content/themes/komiya/img/logo_komiyashoten.jpg" alt="小宮商店 KOMIYA SHOTEN" class="logo_komiyashoten"></a></h1>
	<div class="navi-pc">
		<div class="fix-navi-logo"><!-- <a href="/"><img src="/wp-content/themes/komiya/img/logo_komiyashoten2.jpg" alt="小宮商店"></a> --></div>
		<?php get_template_part('navi'); ?>
	</div>
	<div class="navi-sp">
		<?php get_template_part('navi-sp'); ?>
	</div>
	<div class="top_sub_nav">
		<?php wp_nav_menu( array('menu' => 'header_munu', )); ?>
		<div class="jiten"><a href="/encyclopedia/">傘辞典</a></div>
	</div>
</header>