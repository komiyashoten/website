<?php
/*
Template Name: MEN/WOMENトップ
Template Post Type: post, page
*/
?>
<?php get_header('top');
	global $post;
	$sex = $post->post_name;
	$page_id = $post->ID;
	$item = array('long','folding','rain','sun');//おすすめ一覧に表示するタグを指定
	$tagID = array('exclude' => 12,57);//カテゴリ一覧から除外したいタグのIDを指定（天然繊維＝12）
?>
<section class="men_women_top">
<div class="men_women_top_header">
	<!-- <section>
		<h2 class="men_women_title"><?php echo strtoupper($sex); ?></h2>
	</section> -->
	<?php
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => 4,
		'order'          => 'ASC',
		'tax_query' =>array(array (
			'taxonomy' => 'top_display',
			'field' => 'slug',
			'terms' => $sex.'トップ',
		)),
		// 'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
	<ul class="big_banner_top bxslider">
		<?php
		foreach ( $posts as $post ) :
			setup_postdata( $post ); ?>
		<li><a href="<?php the_permalink(); ?>">
				<div class="text">
					<h3><?php the_title(); ?></h3>
					<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
					<div class="catch"><?php echo post_custom('リード'); ?></div>
					<div class="read">READ</div>
				</div>
				<div class="black">&nbsp;</div>
				<div class="bg"><?php the_post_thumbnail('full'); ?></div>
			</a>
		</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; wp_reset_postdata(); ?>
</div>

<?php the_content(get_the_ID()); ?>

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>