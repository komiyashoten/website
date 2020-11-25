<?php
/*
Template Name: シリーズ
*/
?>
<?php get_header(); ?>

<div class="handmade_logo"><img src="/wp-content/themes/komiya/img/handmade.jpg" alt="HAND MADE（ハンドメイド） 職人（傘職人）の手作りによる日本製の傘"></div>

<section>
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
	<div class="series_header">
		<div class="text">
			<h3><?php the_title(); ?></h3>
			<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
			<div class="catch"><?php echo post_custom('リード'); ?></div>
		</div>
		<div class="black">&nbsp;</div>
		<div class="bg"><?php the_post_thumbnail('full'); ?></div>
	</div>
	<?php endwhile; endif; ?>
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
					<div class="thumbnail"><?php the_post_thumbnail('medium'); ?></div>
					<div class="text">
						<div class="lead"><?php echo post_custom('リード'); ?></div>			
						<h3><?php echo post_custom('シリーズ名'); ?>&nbsp;&nbsp;<span><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?>&nbsp;<?php $terms = get_the_terms($post->ID, 'ribs'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></span></h3>
						<div class="spec">
							<?php echo get_my_term_list( $post->ID, 'large_cat', ' ', '／', '','men, women' ); ?>
						</div>
						<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
					</div>
				</a></li>
				<?php endwhile; endif; wp_reset_postdata(); ?>
			</ul>
		</section>
</section>
</section>


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
<section class="bgcolor1 wrap_series_list">
	<h3 class="series_list_title"><?php $tags = get_the_tags(); foreach ( $tags as $tag ) { echo $tag->name; } ?>のシリーズ</h3>
	<ul class="series_list">
	<?php while ($my_query->have_posts()) : $my_query->the_post();//ループのスタート ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
			<h3><?php the_title(); ?></h3>
			<div class="ruby"><?php echo post_custom('ルビ'); ?></div>
			<div class="catch"><?php echo post_custom('キャッチコピー'); ?></div>
		</a></li>
	<?php endwhile; wp_reset_query(); ?>
	</ul>
</section>
<?php } else { ?>
<?php } }?>



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