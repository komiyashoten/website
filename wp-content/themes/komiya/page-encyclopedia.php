<?php get_header(); ?>

<section class="page_default">
    <section class="site_width_inner">
		<h2>傘辞典</h2>
		<?php 
		$page_id = get_page_by_path("encyclopedia");
		$page_id = $page_id->ID;
		?>
		<ul class="encyclopedia_list1">
			<?php 
			$page_list = new WP_Query([ 'post_type' =>'page', 'post_parent' => $page_id, 'posts_per_page' => 100, 'order' => 'ASC' ]);
			if ( $page_list->have_posts() ):
				 while ( $page_list->have_posts() ) : $page_list->the_post(); ?>
				<li>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				</li>
				 <?php
				endwhile;
			endif;
			?>
		</ul>
    </section>
</section>
<section class="bgcolor1" style=" font-size: 1vw; padding: 5em 5em 0 5em;">
	<h2 class="blog_section_title">COLUMN
	<div class="sub">傘にまつわる<br>
	様々なお話</div></h2>
	<ul class="blog_list2_3">
		<?php
			$args = array(
				'post_type' => 'post',
				'category_name' => 'column',
				'posts_per_page' => 100
			);
			$st_query = new WP_Query( $args );
		?>
		<?php if ( $st_query->have_posts() ): ?>
			<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
				<li><?php if(has_post_thumbnail()): ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<?php else: ?>
					<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/komiya/img/atari.jpg">
				<?php endif; ?>
				<div class="blog_date_category"><span class="date"><?php the_date(); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
				<h3><?php the_title(); ?></h3></a></li>
			<?php endwhile; ?>
		<?php else: ?>
			<p>新しい記事はありません。</p>
		<?php endif; ?>
	</ul>
</section>

<?php get_footer(); ?>