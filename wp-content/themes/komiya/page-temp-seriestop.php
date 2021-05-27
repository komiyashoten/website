<?php
/*
Template Name: MEN/WOMENトップ
Template Post Type: post, page
*/
?>
<?php get_header('top');
	global $post;
?>
<section class="men_women_top">

<?php the_content(get_the_ID()); ?>

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>