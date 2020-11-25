<?php get_header('blog'); ?>
<section class="blog clear">
	<div class="content">
		<?php if(have_posts()): while(have_posts()):the_post(); ?>
			<div class="date"><?php the_date(); ?><span class="category"><?php the_category(', ');?></span></div>
			<h1><?php the_title(); ?></h1>
			<p><?php the_content(); ?></p>
		<?php endwhile; endif; ?>
		
		<div class="prev_next clear">
			<div class="prev">
				<?php previous_post_link('<div class="title">前の記事</div>%link', '%title'); ?>
			</div>
			<div class="next">
				<?php next_post_link('<div class="title">次の記事</div>%link', '%title'); ?>
			</div>
		</div>
	</div>
	<div class="menu">
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
	</div>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>