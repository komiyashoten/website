<?php get_header(); ?>

<div class="handmade_logo"><img src="/wp-content/themes/komiya/img/handmade.jpg" alt="HAND MADE（ハンドメイド） 職人（傘職人）の手作りによる日本製の傘"></div>
<ul class="series_category_list">
	<li><a href="/komiyashoten-men/orimono/">織物</a></li>
	<li><a href="/komiyashoten-men/water-repellent/">超撥水</a></li>
	<li><a href="/komiyashoten-men/shade/">日傘・晴雨兼用</a></li>
</ul>
<section class="wrap_big_banner">
	<?php 
	$page_id = get_page_by_path("komiyashoten-men");
	$page_id = $page_id->ID;
	?>
	<ul class="big_banner">
		<?php 
		$page_list = new WP_Query([ 'post_type' =>'page', 'post_parent' => $page_id, 'posts_per_page' => 100, 'order' => 'ASC', 'post__not_in' => array(616,654,656) ]);
		if ( $page_list->have_posts() ):
			 while ( $page_list->have_posts() ) : $page_list->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div class="text">
						<h3><?php the_title(); ?></h3>
						<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
						<div class="catch"><?php echo post_custom('リード'); ?></div>
						<div class="arrow">&nbsp;</div>
					</div>
					<div class="black">&nbsp;</div>
					<div class="bg">
					<?php the_post_thumbnail('full'); ?></div>
				</a>
			</li>
			 <?php
			endwhile;
		endif;
		?>
	</ul>
</section>
<h3 class="banner_title">小宮商店 メンズ・シリーズ</h3>
<div class="h2-sub">職人がつくる日本製の雨傘・日傘ブランド『小宮商店』の男性用（メンズ）シリーズ<br>
お好みのカテゴリーからご覧ください。</div>
<div class="banner2gray">
	<a href="/komiyashoten-men/orimono/">織物</a>
	<a href="/komiyashoten-men/water-repellent/">超撥水</a>
	<a href="/komiyashoten-men/shade/">日傘・晴雨兼用</a>
</div>
<section class="top_section2">
	<ul class="banner3">
		<li><a href="/about/" class="clear"><img src="/wp-content/themes/komiya/img/top_003-1.jpg">
			<div class="text">
				<div class="catch">愛着を持って、おしゃれとして使う、<br>
				「つくりのよさ」にこだわった日本製の傘。<br>
				そんな傘を1930年からつくり続けています。</div>
				<div class="link">小宮商店のこと</div>
			</div>
		</a></li>
		<li><a href="/about/" class="clear"><img src="/wp-content/themes/komiya/img/handmade2.jpg" alt="HAND MADE（ハンドメイド） 職人（傘職人）の手作りによる日本製の傘">
			<div class="text">
				<div class="catch">「型は傘の心」<br>
				職人の魂が込められた木型は、<br>
				美しい傘のフォルムを生み出します。</div>
				<div class="link">木型のマークに込めた想い</div>
			</div>
		</a></li>
		<li><a href="/about/how-its-made/" class="clear"><img src="/wp-content/themes/komiya/img/okunugi.jpg">
			<div class="text">
				<div class="catch">洋傘はどのようにしてつくられるのか、<br>
				動画で詳しくご紹介します。</div>
				<div class="link">洋傘のつくり方</div>
			</div>
		</a></li>
		<li><a href="/repair/" class="clear"><img src="/wp-content/themes/komiya/img/shuuri.jpg">
			<div class="text">
				<div class="catch">末永くお使いいただくために、<br>
				メンテナンスや修理等のアフターケアを<br>
				行なっております。</div>
				<div class="link">傘の修理</div>
			</div>
		</a></li>
	</ul>
</section>

<?php get_footer(); ?>