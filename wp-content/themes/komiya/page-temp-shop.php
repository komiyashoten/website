<?php
/*
Template Name: SHOP
Template Post Type: post, page
*/
?>
<?php get_header(); ?>

<section class="about">
	<div class="page_header">
		<h2><?php the_title(); ?></h2>
		<div class="black">&nbsp;</div>
		<img src="/wp-content/themes/komiya/img/shop001.jpg">
	</div>
    <section class="site_width_inner">
		<section class="margin2 center">
		<h3 class="catch1">いまでは日本にごくわずかとなった洋傘の専門店</h3>
		<p>創業当時からなじみのある東京都東日本橋に実店舗を構えています。<br>
		ナチュラルな雰囲気が漂う昔ながらのショップには、<br>
		職人たちの想いのこもった日本製の手づくり洋傘「小宮商店」の商品から、<br>
		アイデアの詰まった機能的な海外製洋傘「小宮商店 Daily Use Umbrella」の商品まで、<br>
		お客様のライフスタイルに合わせて様々な洋傘をご用意しております。<br>
		お似合いの１本を必ず見つけていただけるはずです。
		<br>
		オンラインショップに掲載していない店舗限定商品もございますので、<br>
		お近くにお越しの際は是非お立ち寄りください。</p>
		</section>
		<section class="center">
			<div class=""><img src="/wp-content/themes/komiya/img/shop002.jpg" width="770"></div>
		</section>
    </section>
</section>
<section class="bgcolor1" style=" font-size: 1vw; padding: 5em 5em 0 5em;">
	<h2 class="blog_section_title">SHOP BLOG
	<div class="sub">東日本橋ショップから、<br>
	イベントやお得な情報のお知らせ</div></h2>
	<ul class="blog_list2_3">
		<?php
			$args = array(
				'post_type' => 'post',
				'category_name' => 'shop-blog',
				'posts_per_page' => 3
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
				<div class="blog_date_category"><span class="date"><?php the_time('Y.m.d'); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
				<h3><?php the_title(); ?></h3></a></li>
			<?php endwhile; ?>
		<?php else: ?>
			<p>新しい記事はありません。</p>
		<?php endif; ?>
	</ul>
</section>

<section class="bgcolor1 shop_info" id="shop_info">
	<div>
		<h2 class="blog_section_title">SHOP
		<div class="sub">お近くにお越しの際は<br>
		是非お立ち寄りください。</div></h2>
		<?php echo do_shortcode('[xo_event_calendar holidays="day-off,20pm"]'); ?>
	</div>
	<div>
		<h4>東日本橋ショップ</h4>
		<p>〒103-0004 東京都中央区東日本橋3-9-7<br>
		TEL 03-6206-2970</p>
		<p>[営業時間]<br>
		10:00～18:00<br>
		（水曜日のみ10:00～20:00）</p>
		<p>[定休日]<br>
		日・祝<br>
		※日曜は大江戸問屋祭りの日のみ<br>
		年2回／営業時間 9:00～16:00</p>
	</div>
	<div>
		<div id="map_custmomize" style="width:100%;height:370px;"></div>
		<div class="shop_direction">
			<span><a href="/shop/higashi-nihombashi/">東日本橋駅からのアクセス</a></span>
			<span><a href="/shop/bakuro-yokoyama/">馬喰横山からのアクセス</a></span>
			<span><a href="/shop/bakurocho/">馬喰町からのアクセス</a></span>
		</div>
	</div>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>