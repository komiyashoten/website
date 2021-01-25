<?php
/*
Template Name: シリーズ（Daily Use）
Template Post Type: post, page
*/
?>
<?php get_header(); ?>
<section class="daily_use">
	<section class="du_header">
		<div class="du_header_logo"><a href="/daily-use-umbrella/"><img src="/wp-content/themes/komiya/img/du-logo.jpg" width="117" alt="小宮商店 Daily Use Umbrella"></a></div>
		<h1><?php the_title(); ?></h1>
		<div class="tags"><?php echo get_the_term_list( $post->ID, 'du_tag'); ?></div>
	</section>
	<section class="series">
		<section class="site_width_inner">
			<?php if(have_posts()): while(have_posts()):the_post(); ?>
				<?php remove_filter('the_content', 'wpautop'); ?>
				<?php remove_filter ('the_content', 'wpautop'); ?><?php the_content(); ?>
			<?php endwhile; endif; ?>

			<section class="margin1 center">
				<h3 class="section_title1"><?php the_title(); ?>シリーズ</h3>
				<ul class="product_list">
					<?php $slug = get_post( get_the_ID() ); //記事データ取得
					$args = array(
						'post_type' => 'product',
						'order' => 'ASC',
						'meta_key' => 'シリーズのスラッグ', //カスタムフィールドのキー
						'meta_value' => $slug->post_name //カスタムフィールドにスラッグを反映
					);
					$my_query = new WP_Query($args);
					if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
					?>
					<li class="clear"><a href="<?php echo post_custom('商品ページURL'); ?>" class="clear">
						<div class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
						<div class="text">
							<div class="lead"><?php echo post_custom('リード'); ?></div>			
							<h3><?php echo post_custom('シリーズ名'); ?></h3>
							<div class="size"><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></div>
							<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
						</div>
					</a></li>
					<?php endwhile; endif; wp_reset_postdata(); ?>
				</ul>
			</section>
		</section>
	</section>
</section>
<?php 
$page_id = get_page_by_path("daily-use-umbrella");
$page_id = $page_id->ID;
?>
<section class="bgcolor1 wrap_du_top_series_list">
	<h3 class="series_list_title">Daily Use Umbrella シリーズ</h3>
	<ul class="du_top_series_list_s">
		<?php 
		$page_list = new WP_Query([ 'post_type' =>'page', 'post_parent' => $page_id, 'posts_per_page' => 100, 'order' => 'ASC' ]);
		if ( $page_list->have_posts() ):
			 while ( $page_list->have_posts() ) : $page_list->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div><?php the_post_thumbnail('medium'); ?></div>
					<div class="text">
						<h3><?php the_title(); ?></h3>
						<div class="tags"><?php echo get_my_term_list( $post->ID, 'du_tag', '<span> ', '</span><span>', '</span>','' ); ?></div>
					</div>
				</a>
			</li>
			 <?php
			endwhile;
		endif;
		?>
	</ul>
</section>
<section class="du_header">
		<ul class="tags">
			<?php
				$terms = get_terms('du_tag');
				foreach ( $terms as $term ) {
				echo '<a href="'.get_term_link($term).'">'.$term->name.'</a>';}
			?>
		</ul>
</section>
<section class="brand_big_banner">
	<h2 class="blog_section_title" style="font-size: 2.4rem;">BRANDS
	<div class="sub" style="font-size: 1.1rem; line-height: 1;">ブランド紹介</div></h2>
	<ul>
		<li>
		<a href="https://www.komiyakasa.jp/" class="clear">
			<div class="img_pc"><img src="/wp-content/themes/komiya/img/brand_banner_komiyashoten_pc.jpg"></div>
			<div class="logo_catch"><img src="/wp-content/themes/komiya/img/komiyashoten_handmade.jpg" width="173px;" class="logo">
			<p class="catch">愛着を持って、おしゃれとして使う、<br>
			「つくりのよさ」にこだわった日本製の傘。<br>
			そんな傘を1930年からつくり続けています。</p>
			</div>
			<div class="img_sp"><img src="/wp-content/themes/komiya/img/brand_banner_komiyashoten_sp.jpg"></div>
		</a></li>
		<li>
		<a href="https://www.komiyakasa.jp/daily-use-umbrella/" class="clear">
		<div class="img_pc"><img src="/wp-content/themes/komiya/img/brand_banner_du_pc.jpg"></div>
		<div class="logo_catch"><img src="/wp-content/themes/komiya/img/du-logo.jpg" width="145px" class="logo">
		<p class="catch">まいにちを、もっと快適にする<br>
		小宮商店企画の海外製の傘</p>
		</div>
		<div class="img_sp"><img src="/wp-content/themes/komiya/img/brand_banner_du_sp.jpg"></div>
		</a></li>
	</ul>
</section>
<?php get_footer(); ?>