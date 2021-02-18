<?php get_header('top'); ?>
 
<div style="padding: 0.3em 1em 1em 1em;"><a href="https://www.komiyakasa.jp/rinji-news/" style="font-size: 1.3rem; padding: 0.8em; background: #efe8e1; width: 100%; display: block; color: #333; text-align: center;"><span style="color: #af8569;">●</span> 新型コロナ対策のため、営業日時を変更しています。 ※オンラインショップは通常営業 [12/22更新]</a></div>

<section>

<div class="top_main">
	<ul class="big_main_slide bxslider">
		<li><a href="/three/">
				<div class="text"><img src="/wp-content/themes/komiya/img/top_catch028.png" alt="" class="left_top"></div>
				<div class="black">&nbsp;</div>
				<div class="bg"><img src="/wp-content/themes/komiya/img/top_022.jpg" alt=""></div>
			</a>
		</li>
		<li><a href="/komiyashoten-men/forest/">
				<div class="text"><img src="/wp-content/themes/komiya/img/top_catch029.png" alt="" class="left_top"></div>
				<div class="black">&nbsp;</div>
				<div class="bg"><img src="/wp-content/themes/komiya/img/top_023.jpg" alt=""></div>
			</a>
		</li>
		<li><a href="/komiyashoten-men/miratoray-men/">
				<div class="text"><img src="/wp-content/themes/komiya/img/top_catch030.png" alt="" class="right_top"></div>
				<div class="black">&nbsp;</div>
				<div class="bg"><img src="/wp-content/themes/komiya/img/top_009.jpg" alt=""></div>
			</a>
		</li>
		<li><a href="/about/how-its-made/">
				<div class="text"><img src="/wp-content/themes/komiya/img/top_catch003.png" alt="職人の手作り傘ならではの奥深く細やかな仕事ぶり、クラフトマンシップをどうぞご覧ください。" class="right_top"> </div>
				<div class="black">&nbsp;</div>
				<div class="bg"><img src="/wp-content/themes/komiya/img/top_main003.jpg" alt="洋傘職人 小宮商店"></div>
			</a>
		</li>
	</ul>
</div>
</section>
<section class="bgcolor1 top_about_handmade">
	<ul class="top_about">
		<li><a href="/about/"><img src="/wp-content/themes/komiya/img/top_003-2.jpg"></a></li>
		<li>
			<div class="top_main_catch">
				<h3>愛着を持って、おしゃれとして使う、<br>
				「つくりのよさ」にこだわった日本製の傘。<br>
				そんな傘を1930年からつくり続けています。</h3>
				<div><img src="/wp-content/themes/komiya/img/top_001.jpg" alt="小宮商店"></div>
				<div class="bottom_link"><a href="/about/" class="arrow01">小宮商店のこと</a></div>
			</div>
		</li>
	</ul>
	<ul class="top_handmade">
		<li><a href="/about/#kata"><img src="/wp-content/themes/komiya/img/top_004.jpg"></a></li>
		<li>
			<div class="top_handmade_catch">
				<div><img src="/wp-content/themes/komiya/img/top_002.jpg" alt="HAND MADE（ハンドメイド） 職人（傘職人）の手作りによる日本製の傘"></div>
				<h3>型は傘の心</h3>
				<div class="text1">傘の形は生地を裁断するときに使う<br>
				三角形の木型の形で決まります。<br>
				ここには職人の魂が込められており、<br>
				小宮商店が創業当初からこだわってきた<br>
				美しい傘のフォルムを生み出します。</div>
				<div class="bottom_link"><a href="/about/#kata" class="arrow01">木型のマークに込めた想い</a></div>
			</div>
		</li>
	</ul>
</section>
<section class="clear">
	<ul class="top_men_women clear">
		<li>
			<a href="/komiyashoten-men/"><div class="top_men_women_text"><img src="/wp-content/themes/komiya/img/top_men.png" alt="MEN">
			<p>小宮商店 メンズ・シリーズ</p></div>
			<div class="black">&nbsp;</div>
			<img src="/wp-content/themes/komiya/img/top_005.jpg" class="top_men_women_bg"></a>
		</li>
		<li>
			<a href="/komiyashoten-women/"><div class="top_men_women_text"><img src="/wp-content/themes/komiya/img/top_women.png" alt="WOMEN">
			<p>小宮商店 ウィメンズ・シリーズ</p></div>
			<div class="black">&nbsp;</div>
			<img src="/wp-content/themes/komiya/img/top_008.jpg" class="top_men_women_bg"></a>
		</li>
	</ul>
</section>
<section class="bgcolor1 pickup">
	<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 2,
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'tax_query' =>array(array (
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => 'PICKUP（大）',
			))
		);
		$st_query = new WP_Query( $args );
	?>
	<?php if ( $st_query->have_posts() ): ?>
	<h2 class="blog_section_title">
		PICK UP<div class="sub">今おすすめの記事</div>
	</h2>
	<ul class="blog_list2">
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
			<li><?php if(has_post_thumbnail()): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/komiya/img/atari.jpg">
			<?php endif; ?>
			<div class="blog_date_category"><span class="date"><?php the_time('Y.m.d'); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
			<h3><?php the_title(); ?></h3></a></li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>
	<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'tax_query' =>array(array (
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => 'PICKUP（小）',
			))
		);
		$st_query = new WP_Query( $args );
	?>
	<?php if ( $st_query->have_posts() ): ?>
	<ul class="blog_list2_3">
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
			<li><?php if(has_post_thumbnail()): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/komiya/img/atari.jpg">
			<?php endif; ?>
			<div class="blog_date_category"><span class="date"><?php the_time('Y.m.d'); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
			<h3><?php the_title(); ?></h3></a></li>
		<?php endwhile; ?>
	</ul>
	<?php endif;
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 5,
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'tax_query' => array(array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => 'event2',
				'operator' => 'NOT IN',
		),),
		);
		$st_query = new WP_Query( $args );
	?>
	<?php if ( $st_query->have_posts() ): ?>
	<h2 class="blog_section_title">NEWS
	<div class="sub">最新情報</div></h2>
	<ul class="news">
	<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<div><?php the_time('Y.m.d'); ?></div>
				<div><span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
				<div><?php the_title(); ?></div>
			</a>
		</li>
	<?php endwhile; endif; ?>
	</ul>
</section>

<section class="bgcolor1 top_gift_shop">
	<ul class="top_gift">
		<li><a href="/gift/"><img src="/wp-content/themes/komiya/img/gift-blog.jpg"></a></li>
		<li>
			<div class="top_gift_catch">
				<h3>傘は、末広がりの縁起物</h3>
				<p class="center">もらってうれしい、縁起もいい。<br>
				そんな傘を大切な方への贈り物にいかがですか？<br>
プレゼント用に小宮商店の傘をお求めいただきましたら、<br>
専用のギフトボックスにて、丁寧にお包みいたします。</p>
				<div class="bottom_link"><a href="/gift/" class="arrow01">ギフトにおすすめの傘</a></div>
			</div>
		</li>
	</ul>
	<ul class="top_shop">
		<li><a href="/shop/"><img src="/wp-content/themes/komiya/img/shop002.jpg"></a></li>
		<li>
			<div class="top_shop_catch">
				<h3>いまでは日本にごくわずかとなった<br>
				洋傘の専門店</h3>
				<p>創業当時からなじみのある<br>
				東京都東日本橋に実店舗を構えています。<br>
お客様のライフスタイルに合わせて様々な洋傘をご用意しております。<br>
お似合いの１本を必ず見つけていただけるはずです。 <br>
				お近くにお越しの際は是非お立ち寄りください。</p>
				<div class="bottom_link"><a href="/shop/" class="arrow01">実店舗でお得な情報はこちら</a></div>
			</div>
		</li>
	</ul>
</section>

<section class="bgcolor1 shop_info">
	<div>
		<h2 class="blog_section_title">SHOP
		<div class="sub">お近くにお越しの際は<br>
		是非お立ち寄りください。</div></h2>
		<span class="pc_calender"><?php echo do_shortcode('[xo_event_calendar holidays="day-off,20pm"]'); ?></span>
	</div>
	<div>
		<h4>東日本橋ショップ</h4>
		<p>〒103-0004 東京都中央区東日本橋3-9-7<br>
		TEL 03-6206-2970</p>
		<p>[営業時間]<br>
		平日&nbsp;&nbsp;10:00～18:00<br>
		土&nbsp;&nbsp;10:00～17:00<br>
		※土曜日は月2回営業<br>
		営業日はカレンダーにてご確認ください。<br>
		<span style="color: #FF0004;">※新型コロナウイルス感染拡大防止のため<br>
営業日時を変更しています。</span><br>
<a href="https://www.komiyakasa.jp/rinji-news/">詳しくはこちらのページ</a>でご確認ください。</p>
		<p>[定休日]<br>
		日・祝<br>
		※日曜は大江戸問屋祭りの日のみ<br>
		年2回／営業時間 9:00～16:00</p>
		<span class="sp_calender"><?php echo do_shortcode('[xo_event_calendar ID="xo-event-calendar-2" holidays="day-off,20pm"]'); ?></span>
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
<?php
$today = new DateTime();
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 10,
	'paged' => $paged,
	'orderby' => 'post_date',
	'order' => 'DESC',
	'post_status' => 'publish',
	'tax_query' =>array(array (
		'taxonomy' => 'category',
		'field' => 'name',
		'terms' => 'イベント',
	))
);
$st_query = new WP_Query( $args );
?>
<?php if ( $st_query->have_posts() ): ?>
<section class="bgcolor1 event_info">
	<div>
		<h2 class="blog_section_title">EVENT
		<div class="sub">開催中のイベント</div></h2>
	</div>
	<div>
		<ul class="event_info_table">
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
		<?php
		$each_event_date = new DateTime(post_custom('開始'));
		$each_event_end = new DateTime(post_custom('終了'));
		if($today < $each_event_end && $today > $each_event_date){
		?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div><?php echo post_custom('開始'); ?> ~ <?php echo post_custom('終了'); ?></div>
					<div><?php echo post_custom('場所'); ?></div>
					<div><?php the_title(); ?></div>
				</a>
			</li>
		<?php } endwhile; ?>
		<li><div>現在開催中のイベントはありません。</div></li>
		</ul>
		<p class="bottom_link"><a href="/category/event2/" class="arrow01">開催予定のイベントはこちら</a></p>
	</div>
</section>
<?php endif ?>
<section style="padding: 0.5em 0 2.5em 0;" class="bgcolor1">
<div class="du_banner clear">
	<a href="/daily-use-umbrella/" class="clear" style="background: #fff;"><div class="logo"><img src="/wp-content/themes/komiya/img/du-logo.jpg" width="142" alt="小宮商店　Daily Use Umbrella"><div class="catch">まいにちを、もっと快適にする<br>
	小宮商店企画の海外製の傘</div></div>
	<div class="photo"><img src="/wp-content/themes/komiya/img/du-banner.jpg" alt="小宮商店　Daily Use Umbrella"></div></a>
</div>
</section>
<?php get_footer(); ?>