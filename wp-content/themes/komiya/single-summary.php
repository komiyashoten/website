<?php
/*
Template Name: まとめページ
Template Post Type: post
*/
?>
<?php get_header('blog'); ?>
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
	<section class="blog clear">
		<div class="content summary">
			<h1><?php the_title(); ?></h1>
			<p><?php the_content(); ?></p>			
			<div class="prev_next clear">
				<div class="prev">
					<?php previous_post_link('<div class="title">前の記事</div>%link', '%title'); ?>
				</div>
				<div class="next">
					<?php next_post_link('<div class="title">次の記事</div>%link', '%title'); ?>
				</div>
			</div>
		</div>
	</section>
<?php endwhile; endif; ?>

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>