<?php
/*
Template Name: 小宮商店デフォルト
Template Post Type: post, page
*/
?>
<?php get_header(); ?>
<section class="page_default">
    <section class="site_width_inner">
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<p><?php the_content(); ?></p>
	<?php endwhile; endif; ?>
    </section>
</section>

<?php get_footer(); ?>