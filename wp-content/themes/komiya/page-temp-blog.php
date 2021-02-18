<?php
/*
Template Name: BLOG
Template Post Type: post, page
*/
?>
<?php get_header(); ?>
<section class="bgcolor1" style=" font-size: 1vw; padding: 5em 5em 0 5em;">
	<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 2,
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'tax_query' =>array(array (
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => 'PICKUP（大）',
			))
		);
		$st_query = new WP_Query( $args );
	?>
	<?php if ( $st_query->have_posts() ): ?>
	<h2 class="blog_section_title">
		PICK UP<div class="sub">今おすすめの記事</div>
	</h2>
	<ul class="blog_list2">
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
	<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'tax_query' =>array(array (
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => 'PICKUP（小）',
			))
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
<section class="bgcolor1" style=" font-size: 1vw; padding: 6em 5em 0 5em;">
	<h2 class="blog_section_title">BLOG
	<div class="sub">お店や工房から、<br>
	傘づくりにまつわる情報を<br>
	お届けしています</div></h2>
	<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 18,
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'tax_query' => array(array(
				'taxonomy' => 'category',
				'field'    => 'name',
				'terms'    => 'イベント','・スタッフだより','・商品日記','・傘作りの修行',
				'operator' => 'NOT IN',
		),),
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
		<?php else: ?>
			<p>新しい記事はありません。</p>
		<?php endif; ?>
	</ul>
	<div class="pager">
		<?php global $wp_rewrite;
			$paginate_base = get_pagenum_link(1);
			if (strpos($paginate_base, '?') || !$wp_rewrite->using_permalinks()) {
				$paginate_format = '';
				$paginate_base = add_query_arg('paged', '%#%');
				} else {
				$paginate_format = (substr($paginate_base, -1, 1) == '/' ? '' : '/').
				user_trailingslashit('page/%#%/', 'paged');
				$paginate_base .= '%_%';
				}
				echo paginate_links(array(
					'base' => $paginate_base,
					'format' => $paginate_format,
					'total' => $wp_query->max_num_pages,
					'mid_size' => 4,
					'current' => ($paged ? $paged : 1),
					'prev_text' => '«',
					'next_text' => '»',
			));
		 ?>
	</div>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>