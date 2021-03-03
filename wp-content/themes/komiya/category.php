<?php get_header(); ?>
<section class="blog_category">
<section class="bgcolor1" style=" font-size: 1vw; padding: 0 5em 0 5em;">
	<h2 class="blog_category_title"><?php $cat = get_category( get_query_var("cat") ); echo $cat->name; ?></h2>
	<ul class="blog_list2_3">
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
		<li><?php if(has_post_thumbnail()): ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
			<?php else: ?>
			<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/komiya/img/atari.jpg">
			<?php endif; ?>
			<div class="blog_date_category">
				<span class="date"><?php the_time('Y.m.d'); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span>
			</div>
			<h3><?php the_title(); ?></h3></a>
		</li>
	<?php endwhile; endif; ?>
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
	<div class="blog_category_list_title">CATEGORY</div>
		<ul class="category_list">
			<?php
			$args = array(
				'orderby' => 'count',
				'order' => 'DSC'
			);
			$categories = get_categories( $args );
			foreach( $categories as $category){
				if($category->name == 'イベント'){
					continue;
				}
				echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
			}
			?>
		</ul>
</section>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>