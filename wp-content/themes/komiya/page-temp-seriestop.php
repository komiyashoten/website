<?php
/*
Template Name: シリーズトップ
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

<section class="top_section2">
	<h2 class="men_women_section_title"><?php echo strtoupper($sex); ?>
	<div class="sub">傘の選び方</div></h2>
	<?php
	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => 8,
		'tax_query' =>array(
			'relation' => 'AND', //タクソノミー同士の関係を指定
			array (
				'taxonomy' => 'large_cat',
				'field' => 'slug',
				'terms' => $sex,
				'operator' => 'and'
			),
			array (
				'taxonomy' => 'product_tag',
				'field' => 'slug',
				'terms' => 'popular',
				'operator' => 'and'
			)
		)
	);
	query_posts( $args );
	if (have_posts()) : ?>
	<div class="thumbnail_set2">
		<ul>
		<?php while (have_posts()) : the_post(); /* ループ開始 */ ?>
			<li><a href="<?php echo post_custom('商品ページURL'); ?>">
				<div class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="brand"><?php echo post_custom('ブランド'); ?></div>
				<h3><?php echo post_custom('シリーズ名'); ?>&nbsp;&nbsp;<span><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?>&nbsp;<?php $terms = get_the_terms($post->ID, 'ribs'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></span></h3>
				<div class="spec">
					<?php echo post_custom('大分類'); ?>
				</div>
				<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
			</a></li>
		<?php endwhile; ?>
		</ul>
	</div>
	<?php endif; ?>
</section>
<section class="top_section2">
	<h2 class="men_women_section_title">POPULAR
	<div class="sub">人気商品</div></h2>
	<div class="banner2">
		<a href="/komiyashoten-men/orimono/">織物</a>
		<a href="/komiyashoten-men/water-repellent/">超撥水</a>
		<a href="/komiyashoten-men/shade/">日傘・晴雨兼用傘</a>
	</div>
</section>
<section class="top_section2">
<h2 class="men_women_section_title">SERIES
	<div class="sub">シリーズ</div></h2>
</section>

<section class="bgcolor1 top_section2">
	<h2 class="men_women_section_title">CATEGORY
	<div class="sub">カテゴリ</div></h2>
	<div class="banner2">
		<a href="/komiyashoten-men/orimono/">織物</a>
		<a href="/komiyashoten-men/water-repellent/">超撥水</a>
		<a href="/komiyashoten-men/shade/">日傘・晴雨兼用傘</a>
	</div>
</section>

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>