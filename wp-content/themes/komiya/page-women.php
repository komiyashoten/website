<?php get_header('top');
	$sex = 'women';
	$page_id = get_page_by_path("komiyashoten-".$sex);
	$page_id = $page_id->ID;
	$item = array('long','folding','rain','sun');//おすすめ一覧に表示するタグを指定
	$tagID = array('exclude' => 12,57);//カテゴリ一覧から除外したいタグのIDを指定（天然繊維＝12）
?>
<section class="men_women_top">
<div class="men_women_top_header">
	<section>
		<h2 class="men_women_title">WOMEN</h2>
	</section>
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
		'post_parent' => $page_id
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
					<div class="arrow">&nbsp;</div>
				</div>
				<div class="black">&nbsp;</div>
				<div class="bg"><?php the_post_thumbnail('full'); ?></div>
			</a>
		</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
<section class="bgcolor1 top_section2">
	<h2 class="men_women_section_title">NEW & SEASON
	<div class="sub">新作・シーズンのおすすめ傘</div></h2>
	<?php
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => 3,
		'order'          => 'ASC',
		'tax_query' =>array(array (
			'taxonomy' => 'top_display',
			'field' => 'slug',
			'terms' => 'newseason',
		)),
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
		<ul class="series_list2">
			<?php
			foreach ( $posts as $post ) :
				setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
			</a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</section>
<section class="top_section2">
	<h2 class="men_women_section_title">POPULAR
	<div class="sub">当店の人気商品</div></h2>
	<?php
	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => 4,
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
				<div class="thumbnail"><?php the_post_thumbnail('medium'); ?></div>
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
<section class="bgcolor1 top_section2">
	<h2 class="men_women_section_title">SERIES
	<div class="sub">小宮商店 ウィメンズ・シリーズ</div></h2>
	<div class="banner2">
		<a href="/komiyashoten-women/orimono/">織物</a>
		<a href="/komiyashoten-women/somemono/">染物</a>
		<a href="/komiyashoten-women/water-repellent/">超撥水</a>
		<a href="/komiyashoten-women/shade/">一級遮光</a>
		<a href="/komiyashoten-women/kawazu/">かわず張り・二重張り</a>
	</div>
	<?php
	$arg   = array(
		'post_type' => 'page',//投稿タイプ array('post','page')なども使える
		'posts_per_page' => 3, // 表示する件数
		'order'          => 'ASC', // DESCで最新から表示、ASCで最古から表示
		'tag'            => '織物', // 表示したいタグのスラッグを指定
		'post__not_in' => array($post->ID,616,654,656,663,665,668,671,679),//表示中のページを除外（一覧ページも除外）
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
		<h2 class="men_women_series_cat_tit"><span>織物のシリーズ</span></h2>
		<ul class="series_list2">
			<?php
			foreach ( $posts as $post ) :
				setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
			</a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif;
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => 3,
		'order'          => 'ASC',
		'tag'            => '染物',
		'post__not_in' => array($post->ID,616,654,656,663,665,668,671,679),
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
		<h2 class="men_women_series_cat_tit"><span>染物のシリーズ</span></h2>
		<ul class="series_list2">
			<?php
			foreach ( $posts as $post ) :
				setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
			</a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif;
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => 3,
		'order'          => 'ASC',
		'tag'            => '超撥水',
		'post__not_in' => array($post->ID,616,654,656,663,665,668,671,679),
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
		<h2 class="men_women_series_cat_tit"><span>超撥水のシリーズ</span></h2>
		<ul class="series_list2">
			<?php
			foreach ( $posts as $post ) :
				setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
			</a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif;
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => 3,
		'order'          => 'ASC',
		'tag'            => '一級遮光',
		'post__not_in' => array($post->ID,616,654,656,663,665,668,671,679),
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
		<h2 class="men_women_series_cat_tit"><span>一級遮光のシリーズ</span></h2>
		<ul class="series_list2">
			<?php
			foreach ( $posts as $post ) :
				setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
			</a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif;
	$arg   = array(
		'post_type' => 'page',
		'posts_per_page' => 3,
		'order'          => 'ASC',
		'tag'            => 'かわず張り・二重張り',
		'post__not_in' => array($post->ID,616,654,656,663,665,668,671,679),
		'post_parent' => $page_id
	);
	$posts = get_posts( $arg );
	if ( $posts ): ?>
		<h2 class="men_women_series_cat_tit"><span>かわず張り・二重張りのシリーズ</span></h2>
		<ul class="series_list2">
			<?php
			foreach ( $posts as $post ) :
				setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
			</a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</section>
<section class="top_section2">
	<h2 class="men_women_section_title">CATEGORY
	<div class="sub">小宮商店では様々な特徴を持った傘を<br>
	取り揃えております。</div></h2>
<!-- 新規作成したシステム　-->
<?php
	$slug = array('slug' => $item);
	$terms_slug = $value->slug;
	//おすすめ一覧
	foreach ( get_terms('large_cat',$slug) as $value ) {
	$term_slug = $value->slug;
	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => 4,
		'tax_query' =>array(
			'relation' => 'AND',
			array (
				'taxonomy' => 'large_cat',
				'field' => 'slug',
				'terms' => $sex,
				'operator' => 'and'
			),
			array (
				'taxonomy' => 'product_tag',
				'field' => 'slug',
				'terms' => 'recommend',
				'operator' => 'and'
			),
			array (
				'taxonomy' => 'large_cat',
				'field' => 'slug',
				'terms' => $term_slug,
				'operator' => 'IN'
			)
		)
	);
	$myquery = new WP_Query( $args );
	if ( $myquery->have_posts()): ?>
	<div class="thumbnail_set2">
		<h2 class="men_women_series_cat_tit"><span>おすすめ<?php echo esc_html($value->name) ?></span></h2>
		<ul>
		<?php while($myquery->have_posts()): $myquery->the_post(); ?>
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
	<?php endif;
	}

	//カテゴリ一覧
	$exclude = array('exclude' => $tagID);
	foreach ( get_terms('umbrella_category',$exclude) as $value ) {
	$term_slug = $value->slug;
	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => 4,
		'tax_query' =>array(
			'relation' => 'AND',
			array (
				'taxonomy' => 'large_cat',
				'field' => 'slug',
				'terms' => $sex,
				'operator' => 'IN'
			),
			array (
				'taxonomy' => 'umbrella_category',
				'field' => 'slug',
				'terms' => $term_slug,
				'operator' => 'IN'
			)
		)
	);
	$myquery = new WP_Query( $args );
	if ( $myquery->have_posts()): ?>
	<div class="thumbnail_set2">
		<h2 class="men_women_series_cat_tit"><span><?php echo esc_html($value->name) ?>傘</span></h2>
		<ul>
		<?php while($myquery->have_posts()): $myquery->the_post(); ?>
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
	<?php endif;
	} wp_reset_postdata(); ?>
</section>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>