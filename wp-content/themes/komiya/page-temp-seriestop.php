<?php
/*
Template Name: MEN/WOMENトップ
Template Post Type: post, page
*/
?>
<?php get_header('top');
	global $post;
	$sex = $post->post_name;
	$page_id = $post->ID;
	$item = array('long','folding','rain','sun');//おすすめ一覧に表示するタグを指定
	$tagID = array('exclude' => 12,57);//カテゴリ一覧から除外したいタグのIDを指定（天然繊維＝12）
?>
<section class="men_women_top">

<?php the_content(get_the_ID()); ?>

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>