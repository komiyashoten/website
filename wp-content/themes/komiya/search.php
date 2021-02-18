<?php get_header(); ?>

<section class="body1 clear">
	<div class="side_area">
		<div class="side_category_menu">
			<h3><a href="/men/">MEN</a></h3>
			<ul class="col2 clear">
				<li><a href="/large_cat/long+men/"><strong>長傘</strong></a></li>
				<li><a href="/large_cat/folding+men/"><strong>折りたたみ傘</strong></a></li>
				<li><a href="/large_cat/rain+long+men/">雨傘・雨晴兼用</a></li>
				<li><a href="/large_cat/rain+folding+men/">雨傘・雨晴兼用</a></li>
				<li><a href="/large_cat/sun+long+men/">日傘・晴雨兼用</a></li>
				<li><a href="/large_cat/sun+folding+men/">日傘・晴雨兼用</a></li>
			</ul>
			<ul class="col2 clear">
				<li class="side_taxonomy_title">CATEGORY</li>
				<li><a href="/large_cat/men/?umbrella_category=woven_fabric">織物</a></li>
				<li><a href="/large_cat/men/?umbrella_category=water_repellent">超撥水</a></li>
				<li><a href="/large_cat/men/?umbrella_category=natural">天然繊維</a></li>
				<li><a href="/large_cat/men/?umbrella_category=many-bones">骨が多い</a></li>
				<li><a href="/large_cat/men/?umbrella_category=light">軽い</a></li>
				<li><a href="/large_cat/men/?umbrella_category=wind-proof">風に強い</a></li>
				<li><a href="/large_cat/men/?umbrella_category=shade">一級遮光</a></li>
				<li><a href="/large_cat/men/?umbrella_category=automatic">ワンタッチ</a></li>
				<li><a href="/large_cat/men/?umbrella_category=easy-open">ラクラク開閉</a></li>
			</ul>
			<ul class="col3 clear">
				<li class="side_taxonomy_title">SIZE</li>
				<li><a href="/large_cat/men/?size=50cm">50cm</a></li>
				<li><a href="/large_cat/men/?size=55cm">55cm</a></li>
				<li><a href="/large_cat/men/?size=58cm">58cm</a></li>
				<li><a href="/large_cat/men/?size=60cm">60cm</a></li>
				<li><a href="/large_cat/men/?size=65cm">65cm</a></li>
				<li><a href="/large_cat/men/?size=70cm">70cm</a></li>
			</ul>
			<ul class="col3 clear">
				<li class="side_taxonomy_title">PRICE</li>
				<li><a href="/large_cat/men/?price=3000y">3,000円〜</a></li>
				<li><a href="/large_cat/men/?price=5000y">5,000円〜</a></li>
				<li><a href="/large_cat/men/?price=10000y">10,000円〜</a></li>
				<li><a href="/large_cat/men/?price=20000y">20,000円〜</a></li>
				<li><a href="/large_cat/men/?price=30000y">30,000円〜</a></li>
			</ul>
		</div>
		<div class="search_nav">
			<div id="accordion1" class="accordionbox">
				<dl class="accordionlist">
					<dt class="clearfix">
						<div class="title">
							<p>便利な組み合わせ検索</p>
						</div>
						<p class="accordion_icon"><span></span><span></span></p>
					</dt>
					<dd>
					<?php echo do_shortcode( '[searchandfilter fields="large_cat,umbrella_category,size,price" types="checkbox,checkbox,select,select" headings=",CATEGORY,SIZE,PRICE" order_by="term_group,term_group,term_group,term_group" hierarchical="1" submit_label="この条件で検索"]' ); ?>
					</dd>
				</dl>
			</div>
            <div class="left_brands">
                <h4>BRANDS</h4>
                <ul>
                    <li><a href="/komiyashoten-men/"><img src="/wp-content/themes/komiya/img/dropdown_brand2.png"></a></li>
                    <li><a href="/daily-use-umbrella/"><img src="/wp-content/themes/komiya/img/dropdown_brand1.png"></a></li>
                </ul>
            </div>
        </div>
	</div>
    <section class="right_area">
		<div class="right_area_inner taxonomy_page">
			<h2>小宮商店の傘一覧</h2>
		<?php
			
			//global $wpdb;
			//global $wp_query;
			//$columns = $wpdb->get_results("SHOW COLUMNS FROM wp_postmeta");
			//var_dump($columns);
			
			$args = array(
				'post_type' => 'product', // 取得する投稿タイプのスラッグ,
				'posts_per_page' => 18,
				'paged' => $paged,
				'orderby' => 'meta_value_num',
				'order' => 'DESC',
				'meta_key' => '値段',
				'post_status' => 'publish',
			);
			$wp_query = new WP_Query( $args );
			
			//echo "<br>Last SQL-Query: {$wp_query->request}<br>";
			
		?>
			<?php if ( $wp_query->have_posts() ) : ?>
			<div class="thumbnail_set">
				<ul>
				<?php while ( $wp_query->have_posts() ) :?>
					<?php $wp_query->the_post();?>
					<li><a href="<?php echo post_custom('商品ページURL'); ?>">
						<div class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
						<div class="brand"><?php echo post_custom('ブランド'); ?></div>
						<h3><?php echo post_custom('シリーズ名'); ?>&nbsp;&nbsp;<span><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?>&nbsp;<?php $terms = get_the_terms($post->ID, 'ribs'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></span></h3>
						<div class="spec">
							<?php echo post_custom('大分類'); ?>
						</div>
						<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
					</a></li>
				<?php endwhile;?>
				</ul>
			</div>
	<div class="pager">
		<?php global $wp_rewrite;
			$paginate_base = get_pagenum_link(1);
			if (strpos($paginate_base, '?') || !$wp_rewrite->using_permalinks()) {
				$paginate_format = '';
				$paginate_base = add_query_arg('paged', '%#%');
				} else {
				$paginate_format = (substr($paginate_base, -1, 1) == '/' ? '' : '/').
				user_trailingslashit('page/%#%/', 'paged');
				$paginate_base .= '%_%';
				}
				echo paginate_links(array(
					'base' => $paginate_base,
					'format' => $paginate_format,
					'total' => $wp_query->max_num_pages,
					'mid_size' => 4,
					'current' => ($paged ? $paged : 1),
					'prev_text' => '«',
					'next_text' => '»',
			));
		 ?>
	</div>
			<?php else : ?> 
    <section class="right_area">
		<div class="right_area_inner taxonomy_page">
				<p>ご希望の傘は見つかりませんでした。<br>
				ホームページに掲載していない店舗限定商品もございますので、<br>
				お近くにお越しの際は是非お立ち寄りください。<br>
				<a href="/shop">東日本橋ショップ</a></p>
			<?php endif; ?>
		</div>
	</section>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>