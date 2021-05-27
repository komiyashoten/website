<?php
/*
Template Name: まとめページ
Template Post Type: post, page
*/
?>
<?php get_header('top'); ?>
<?php if(have_posts()): while(have_posts()):the_post(); ?>
	<section id="summary_header">
		<img src="<?php echo kmy_get_thumbnail(get_the_ID()); ?>">
		<div class="summary_titles">
			<div class="category"><?php the_category(', ');?></div>
			<h1><?php echo get_post_meta(get_the_ID(),'まとめ英語タイトル',true); ?>
				<span><?php echo get_post_meta(get_the_ID(),'まとめ日本語タイトル',true); ?></span>
			</h1>
		</div>
	</section>
	<section class="blog clear summary">
		<div class="content summary">
			<h1><?php the_title(); ?></h1>
			<p><?php the_content(); ?></p>			
		</div>
	</section>
<?php endwhile; endif; ?>

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>