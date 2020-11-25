<?php
/*
Template Name: シリーズのカテゴリー
*/
?>
<?php get_header(); ?>

<div class="handmade_logo"><img src="/wp-content/themes/komiya/img/handmade.jpg" alt="HAND MADE（ハンドメイド） 職人（傘職人）の手作りによる日本製の傘"></div>
<?php if(is_page(265)|| 265 == $post->post_parent ): ?>
<ul class="series_category_list">
	<li><a href="/komiyashoten-men/orimono/">織物</a></li>
	<li><a href="/komiyashoten-men/water-repellent/">超撥水</a></li>
	<li><a href="/komiyashoten-men/shade/">日傘・晴雨兼用</a></li>
</ul>
<?php elseif(is_page(276)|| 276 == $post->post_parent): ?> 
<ul class="series_category_list">
	<li><a href="/komiyashoten-women/orimono/">織物</a></li>
	<li><a href="/komiyashoten-women/somemono/">染物</a></li>
	<li><a href="/komiyashoten-women/water-repellent/">超撥水</a></li>
	<li><a href="/komiyashoten-women/shade/">一級遮光</a></li>
	<li><a href="/komiyashoten-women/kawazu/">かわず張り・二重張り</a></li>
</ul>
<?php endif; ?>


<section class="wrap_big_banner">
<?php
$parent_id = $post->post_parent;
$page_id = $parent_id->ID;

$original_post = $post;
$tags = wp_get_post_tags($post->ID);
$tagIDs = array();
if ($tags) {
$tagcount = count($tags);
for ($i = 0; $i < $tagcount; $i++) {
	$tagIDs[$i] = $tags[$i]->term_id;
}
$args=array(
	'tag__in' => $tagIDs,//指定した複数のタグ(表示するページのタグ) のいずれかを含む投稿のみを表示
	'post__not_in' => array($post->ID,616,654,656,663,665,668,671,679),//表示中のページを除外（一覧ページも除外）
	'posts_per_page'=>'100',//投稿表示数
	'post_type' => 'page',//投稿タイプ array('post','page')なども使える
	'orderby'    => 'menu_order',//並び順
	'order'      => 'ASC',//降順か昇順か
	'post_parent' => $parent_id//同じ親固定ページ
);
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {  ?>
<h2 class="series_cat_title"><?php $tags = get_the_tags(); foreach ( $tags as $tag ) { echo $tag->name; } ?>のシリーズ</h2>
<ul class="big_banner">
<?php while ($my_query->have_posts()) : $my_query->the_post();//ループのスタート ?>
	<li>
		<a href="<?php the_permalink(); ?>">
			<div class="text">
				<h3><?php the_title(); ?></h3>
				<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
				<div class="catch"><?php echo post_custom('リード'); ?></div>
				<div class="arrow">&nbsp;</div>
			</div>
			<div class="black">&nbsp;</div>
			<div class="bg"><?php the_post_thumbnail('full'); ?></div>
			<!-- <div class="bg"><img src="<?php // the_post_thumbnail_url('full'); ?>"></div> -->
		</a>
	</li>
<?php endwhile; wp_reset_query(); ?>
</ul>
<?php } else { ?>
<?php } }?>
</section>

<?php if(is_page(265)|| 265 == $post->post_parent ): ?>
<h3 class="banner_title">小宮商店 メンズ・シリーズ</h3>
<div class="h2-sub">職人がつくる日本製の雨傘・日傘ブランド『小宮商店』の男性用（メンズ）シリーズ<br>
お好みのカテゴリーからご覧ください。</div>
<div class="banner2gray">
	<a href="/komiyashoten-men/orimono/">織物</a>
	<a href="/komiyashoten-men/water-repellent/">超撥水</a>
	<a href="/komiyashoten-men/shade/">日傘・晴雨兼用</a>
</div>
<?php elseif(is_page(276)|| 276 == $post->post_parent): ?> 
<h3 class="banner_title">小宮商店 ウィメンズ・シリーズ</h3>
<div class="h2-sub">職人がつくる日本製の雨傘・日傘ブランド『小宮商店』のレディース・シリーズ<br>
お好みのカテゴリーからご覧ください。</div>
<div class="banner2gray">
	<a href="/komiyashoten-women/orimono/">織物</a>
	<a href="/komiyashoten-women/somemono/">染物</a>
	<a href="/komiyashoten-women/water-repellent/">超撥水</a>
	<a href="/komiyashoten-women/shade/">一級遮光</a>
	<a href="/komiyashoten-women/kawazu/">かわず張り・二重張り</a>
</div>
<?php endif; ?>

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