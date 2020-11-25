<?php
get_header();
$page_id = get_page_by_path("daily-use-umbrella");
$page_id = $page_id->ID;
$du_tag_name = single_cat_title( '' , false );
 ?>
<section class="daily_use">
	<section class="du_header">
		<div class="du_header_logo"><a href="http://komiya.shinyaoritacreative.com/daily-use-umbrella/"><img src="/wp-content/themes/komiya/img/du-logo.jpg" width="117" alt="小宮商店 Daily Use Umbrella"></a></div>
		<ul class="tags">
			<?php
				$terms = get_terms('du_tag');
				foreach ( $terms as $term ) {
				echo '<a href="'.get_term_link($term).'">'.$term->name.'</a>';}
			?>
		</ul>
	</section>

<section class="bgcolor1 wrap_du_top_series_list">
	<h3 class="series_list_title"><?php single_cat_title(); ?></h3>
	<?php
	//指定タグの商品一覧
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'tax_query' =>array(array (
			'taxonomy' => 'du_tag',
			'field' => 'name',
			'terms' => $du_tag_name,
		)),
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
	<ul class="du_top_series_list">
		<?php foreach ( $posts as $post ) :setup_postdata( $post ); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div><?php the_post_thumbnail('medium'); ?></div>
					<div class="text">
						<h3><?php the_title(); ?></h3>
						<div class="tags"><?php echo get_my_term_list( $post->ID, 'du_tag', '<span> ', '</span><span>', '</span>','' ); ?></div>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</section>
<?php wp_reset_postdata(); ?>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>