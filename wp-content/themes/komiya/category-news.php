<?php get_header(); ?>

<section style=" font-size: 1vw; padding: 4em 5em 2em 5em; margin-bottom: 5em;">
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
				'field'    => 'slug',
				'terms'    => 'event2',
				'operator' => 'NOT IN',
		),),
		);
		$st_query = new WP_Query( $args );
	?>
	<?php if ( $st_query->have_posts() ): ?>
	<h2>NEWS</h2>
	<ul class="news">
	<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<div><?php the_time('Y.m.d'); ?></div>
				<div><span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
				<div><?php the_title(); ?></div>
			</a>
		</li>
	<?php endwhile; endif; ?>
	</ul>
</section>

<section>
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