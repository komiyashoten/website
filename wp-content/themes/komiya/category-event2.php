<?php get_header(); ?>
<?php
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 18,
	'paged' => $paged,
	'orderby' => 'post_date',
	'order' => 'DESC',
	'post_status' => 'publish',
	'tax_query' =>array(array (
		'taxonomy' => 'category',
		'field' => 'name',
		'terms' => 'イベント',
	))
);
$st_query = new WP_Query( $args );
if ( $st_query->have_posts() ): ?>
<section class="bgcolor1 event_info">
	<div>
		<h2 class="blog_section_title">EVENT
		<div class="sub">実店舗や催事、<br>
オンラインショップの<br>
イベント情報</div></h2>
	</div>
	<div>
		<ul class="event_info_table">
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div><?php echo post_custom('開始'); ?> ~ <?php echo post_custom('終了'); ?></div>
					<div><?php echo post_custom('場所'); ?></div>
					<div><?php the_title(); ?></div>
				</a>
			</li>
		<?php endwhile; ?>
		<li><div>現在開催予定のイベントはありません。</div></li>
		</ul>
	</div>
</section>
<?php endif ?>
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