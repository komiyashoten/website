<?php
/*
Template Name: 佐久間作成のテンプレート
Template Post Type: post, page
*/
?>
<?php
get_header();
$page_id = get_page_by_path("daily-use-umbrella");
$page_id = $page_id->ID;
$du_tag_name = single_cat_title( '' , false );
 ?>
<section class="daily_use">
	<section class="du_header">
		<div class="du_header_logo"><img src="/wp-content/themes/komiya/img/du-logo.jpg" width="117" alt="小宮商店 Daily Use Umbrella"></div>
		<ul class="tags">
			<?php
				$terms = get_terms('du_tag');
				foreach ( $terms as $term ) {
				echo '<a href="'.get_term_link($term).'">'.$term->name.'</a>';}
			?>
		</ul>
	</section>
<?php
foreach ( get_terms('du_tag') as $value ) {
$term_slug = $value->slug;
$arg   = array(
	'post_type' => 'page',
	'posts_per_page' => -1,
	'order'          => 'ASC',
	'tax_query' =>array(array (
		'taxonomy' => 'du_tag',
		'field' => 'slug',
		'terms' => $term_slug,
	)),
	'post_parent' => $page_id
);
$posts = get_posts( $arg );
if ( $posts ): ?>
<section class="bgcolor1 wrap_du_top_series_list">
	<h3 class="series_list_title">Daily Use Umbrella <?php echo esc_html($value->name) ?>シリーズ</h3>
	<ul class="du_top_series_list">
		<?php foreach ( $posts as $post ) :setup_postdata( $post ); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div><?php the_post_thumbnail('medium'); ?></div>
					<div class="text">
						<h3><?php the_title(); ?></h3>
						<div class="tags"><?php echo get_my_term_list( $post->ID, 'du_tag', ' ', '／', '','' ); ?></div>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
<?php endif;
} wp_reset_postdata(); ?>

<section>
	<div class="four_cubes">
		<ul>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/crew-56835.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/eduard-militaru-196832.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/jonathan-velasquez-1187.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/kari-shea-272383.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/khai-sze-ong-308080.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/pineapple-supply-co-142104.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/william-iven-5893.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/crew-56835.jpg"></a></li>
		</ul>
	</div>
</section>
<section>
	<section class="site_width_inner">
		<div class="backtotop"><a href="#backtotop">Back to top</a></div>
	</section>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>