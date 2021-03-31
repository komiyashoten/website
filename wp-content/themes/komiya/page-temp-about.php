<?php
/*
Template Name: ABOUT
Template Post Type: post, page
*/
?>
<?php get_header(); ?>

<ul class="local_menu">
	<li><a href="/about/">小宮商店のこと</a></li>
	<li><a href="/about/history/">小宮商店の歴史</a></li>
	<li><a href="/about/how-its-made/">小宮商店の洋傘づくり</a></li>
	<li><a href="/about/koshu-weave/">甲州織のこと</a></li>
	<li><a href="/about/traditional-craft/">伝統工芸品のこと</a></li>
	<li><a href="/about/company/">会社概要</a></li>
	<li><a href="/about/jyokatsutaishou/">女性活躍推進大賞</a></li>
</ul>
<section class="about">
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
	<div class="page_header">
		<h2><?php the_title(); ?></h2>
		<div class="black">&nbsp;</div>
		<img src="/wp-content/themes/komiya/img/zzz.jpg">
	</div>
    <section class="site_width_inner">
		<?php remove_filter ('the_content', 'wpautop'); ?><?php the_content(); ?>
    </section>
	<?php endwhile; endif; ?>
</section>
<section class="bgcolor1" style=" font-size: 1vw; padding: 5em 5em 0 5em;">
	<h2 class="blog_section_title">BLOG
	<div class="sub">小宮商店の傘づくり</div></h2>
	<ul class="blog_list2_3">
		<?php
			$args = array(
				'post_type' => 'post',
				'category_name' => 'making',
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_status' => 'publish'
			);
			$st_query = new WP_Query( $args );
		?>
	<?php if ( $st_query->have_posts() ): ?>
	<ul class="blog_list2_3">
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
			<li><?php if(has_post_thumbnail()): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/komiya/img/atari.jpg">
			<?php endif; ?>
			<div class="blog_date_category"><span class="date"><?php the_time('Y.m.d'); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
			<h3><?php the_title(); ?></h3></a></li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>

</section>
<?php get_footer(); ?>