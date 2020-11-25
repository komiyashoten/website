<?php get_header();?>

<section class="body1 clear">
	<?php if ( has_term('men', 'large_cat')): ?>
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
    <?php elseif ( has_term('women', 'large_cat')): ?>
	<div class="side_area">
		<div class="side_category_menu">
			<h3><a href="/women/">WOMEN</a></h3>
			<ul class="col2 clear">
				<li><a href="/large_cat/long+women/"><strong>長傘</strong></a></li>
				<li><a href="/large_cat/folding+women/"><strong>折りたたみ傘</strong></a></li>
				<li><a href="/large_cat/rain+long+women/">雨傘・雨晴兼用</a></li>
				<li><a href="/large_cat/rain+folding+women/">雨傘・雨晴兼用</a></li>
				<li><a href="/large_cat/sun+long+women/">日傘・晴雨兼用</a></li>
				<li><a href="/large_cat/sun+folding+women/">日傘・晴雨兼用</a></li>
			</ul>
			<ul class="col2 clear">
				<li class="side_taxonomy_title">CATEGORY</li>
				<li><a href="/large_cat/women/?umbrella_category=woven_fabric">織物</a></li>
				<li><a href="/large_cat/women/?umbrella_category=water_repellent">超撥水</a></li>
				<li><a href="/large_cat/women/?umbrella_category=natural">天然繊維</a></li>
				<li><a href="/large_cat/women/?umbrella_category=many-bones">骨が多い</a></li>
				<li><a href="/large_cat/women/?umbrella_category=light">軽い</a></li>
				<li><a href="/large_cat/women/?umbrella_category=wind-proof">風に強い</a></li>
				<li><a href="/large_cat/women/?umbrella_category=shade">一級遮光</a></li>
				<li><a href="/large_cat/women/?umbrella_category=automatic">ワンタッチ</a></li>
				<li><a href="/large_cat/women/?umbrella_category=easy-open">ラクラク開閉</a></li>
			</ul>
			<ul class="col3 clear">
				<li class="side_taxonomy_title">SIZE</li>
				<li><a href="/large_cat/women/?size=47cm">47cm</a></li>
				<li><a href="/large_cat/women/?size=50cm">50cm</a></li>
				<li><a href="/large_cat/women/?size=55cm">55cm</a></li>
				<li><a href="/large_cat/women/?size=58cm">58cm</a></li>
				<li><a href="/large_cat/women/?size=60cm">60cm</a></li>
			</ul>
			<ul class="col3 clear">
				<li class="side_taxonomy_title">PRICE</li>
				<li><a href="/large_cat/women/?price=3000y">3,000円〜</a></li>
				<li><a href="/large_cat/women/?price=5000y">5,000円〜</a></li>
				<li><a href="/large_cat/women/?price=10000y">10,000円〜</a></li>
				<li><a href="/large_cat/women/?price=20000y">20,000円〜</a></li>
				<li><a href="/large_cat/women/?price=30000y">30,000円〜</a></li>
			</ul>
        </div>
    <?php endif; ?>
	<?php if ( has_term('men', 'large_cat') || has_term('women', 'large_cat') ): ?>
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
					<?php if ( has_term('men', 'large_cat') ) : ?>
					<li><a href="/komiyashoten-men/"><img src="/wp-content/themes/komiya/img/dropdown_brand2.png"></a></li>
					<?php elseif ( has_term('women', 'large_cat')): ?>
					<li><a href="/komiyashoten-women/"><img src="/wp-content/themes/komiya/img/dropdown_brand2.png"></a></li>
					<?php endif; ?>
					<li><a href="/daily-use-umbrella/"><img src="/wp-content/themes/komiya/img/dropdown_brand1.png"></a></li>
				</ul>
			</div>
		</div>
    </div>
    <?php endif; ?>	
<?php if ( have_posts() ) : ?>
	<script type="text/javascript">

    	//全ての選択を外す
    	jQuery('select option').attr("selected", false);

		var ofsize_collection = document.getElementsByName("ofsize");
		var ofsize_collection_length = ofsize_collection.length;
		for (var i=0; i < ofsize_collection_length; i++ ) {
			ofsize_collection[i].selectedIndex = 0;
		}
		var ofprice_collection = document.getElementsByName("ofprice");
		var ofprice_collection_length = ofprice_collection.length;
		for (var i=0; i < ofprice_collection_length; i++ ) {
			ofprice_collection[i].selectedIndex = 0;
		}
		
		//未選択の項目を選択状態にする
    	jQuery('select option[value="0"]').attr("selected", "selected");
		
	</script>
  <section class="right_area">
		<div class="right_area_inner taxonomy_page">
			<h2><?php custom_wp_title(); ?></h2>
			<!--<h3><?php echo term_description(); ?></h3>-->
			<div class="thumbnail_set">
				<ul>
				<?php while ( have_posts() ) : the_post(); ?>
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
<script type="text/javascript">
	var setRetry = function() {
		var searchArry = { 
			"men": "34",
			"women": "35",
			"folding": "40",
			"long": "36",
			"rain": "43",
			"sun": "47",
			"woven_fabric": "10",
			"%e6%9f%93%e7%89%a9": "56",
			"%E6%9F%93%E7%89%A9": "56",
			"natural": "12",
			"water_repellent": "11",
			"many-bones": "13",
			"light": "14",
			"wind-proof": "15",
			"shade": "16",
			"automatic": "17",
			"easy-open": "18",
			"%e5%a4%a7%e3%81%8d%e3%81%84": "71",
			"%E5%A4%A7%E3%81%8D%E3%81%84": "71",
			"%e7%89%b9%e6%ae%8a%e3%82%bf%e3%82%a4%e3%83%97": "57",
			"%E7%89%B9%E6%AE%8A%E3%82%BF%E3%82%A4%E3%83%97": "57",
			"47cm": "8",
			"50cm": "9",
			"54cm": "72",
			"55cm": "19",
			"58cm": "20",
			"60cm": "21",
			"63-5cm": "55",
			"65cm": "22",
			"70cm": "23",
			"2000%e5%86%86%ef%bd%9e": "70",
			"2000%E5%86%86%EF%BD%9E": "70",
			"3000y": "28",
			"5000y": "30",
			"10000y": "31",
			"20000y": "32",
			"30000y": "33"
		};
		var url = new URL(window.location.href);
		//alert(url.pathname);
		var pathArray = url.pathname.split("/");
		var large_cat_index = pathArray.indexOf('large_cat');
		var large_cat_array;
		if ( large_cat_index >= 0 ) {
			large_cat_array = pathArray[large_cat_index + 1].split("+");
			var large_cat_array_length = large_cat_array.length;
			for (var i = 0; i < large_cat_array_length; i++ ) {
				var targetValue = searchArry[large_cat_array[i]];
				jQuery('li.cat-item input:checkbox[value='+targetValue+']').prop('checked',true);
			}								   
		}

        var umbrella_cat_index = pathArray.indexOf('umbrella_category');
        var umbrella_cat_array;
        if ( umbrella_cat_index >= 0 ) {
            umbrella_cat_array = pathArray[umbrella_cat_index + 1].split("+");
            var umbrella_cat_array_length = umbrella_cat_array.length;
            for (var i = 0; i < umbrella_cat_array_length; i++ ) {
                var targetValue = searchArry[umbrella_cat_array[i]];
                jQuery('li.cat-item input:checkbox[value='+targetValue+']').prop('checked',true);
            }                                  
        }		
		
    	//optionの全ての選択を外す
    	jQuery('select option').attr("selected", false);
		
        var size_cat_index = pathArray.indexOf('size');
        var size_cat_array;
        if ( size_cat_index >= 0 ) {
            size_cat_array = pathArray[size_cat_index + 1].split("+");
            var size_cat_array_length = size_cat_array.length;
            for (var i = 0; i < size_cat_array_length; i++ ) {
                var targetValue = searchArry[size_cat_array[i]];
				var ofsize_collection = document.getElementsByName("ofsize");
				var ofsize_collection_length = ofsize_collection.length;
				for (var j=0; j < ofsize_collection_length; j++ ) {
					ofsize_collection[j].selectedIndex = 0;
				}
				jQuery('select option[value='+targetValue+']').attr("selected", "selected");
            }
        }

        var price_cat_index = pathArray.indexOf('price');
        var price_cat_array;
        if ( price_cat_index >= 0 ) {
            price_cat_array = pathArray[price_cat_index + 1].split("+");
            var price_cat_array_length = price_cat_array.length;
            for (var i = 0; i < price_cat_array_length; i++ ) {
                var targetValue = searchArry[price_cat_array[i]];
				var ofprice_collection = document.getElementsByName("ofprice");
				var ofprice_collection_length = ofprice_collection.length;
				for (var j=0; j < ofprice_collection_length; j++ ) {
					ofprice_collection[j].selectedIndex = 0;
				}
				jQuery('select option[value='+targetValue+']').attr("selected", "selected");
            }
        }
		
		var queryString = url.search.slice(1);
		var queryArray = queryString.split("&");
		var queryArray2 = new Array;
		var queryArray_length = queryArray.length;
		for (var i = 0; i < queryArray_length; i++) {
			queryArray2[i] = queryArray[i].split("=");
		}
		
		var queryArray2_length = queryArray2.length;
		for (var i =0; i < queryArray2_length; i++) {
			var umbrella_cat_index = queryArray2[i].indexOf('umbrella_category');
			if (umbrella_cat_index >= 0) {
				var umbrella_cat_array = queryArray2[i][umbrella_cat_index + 1].split("+");
            	var umbrella_cat_array_length = umbrella_cat_array.length;
            	for (var j = 0; j < umbrella_cat_array_length; j++ ) {
                	var targetValue = searchArry[umbrella_cat_array[j]];
                	jQuery('li.cat-item input:checkbox[value='+targetValue+']').prop('checked',true);
            	}                                  
        	}
        	var size_cat_index = queryArray2[i].indexOf('size');
        	if ( size_cat_index >= 0 ) {
				var targetValue = searchArry[queryArray2[i][size_cat_index + 1]];
				jQuery('select option[value='+targetValue+']').attr("selected", "selected");
			}
        	var price_cat_index = queryArray2[i].indexOf('price');
        	if ( price_cat_index >= 0 ) {
				var targetValue = searchArry[queryArray2[i][price_cat_index + 1]];
				jQuery('select option[value='+targetValue+']').attr("selected", "selected");
			}
		}
		jQuery('li.cat-item input[type="checkbox"]:checked').parent('label').css("background","#ddd");
		checkAll();
	};
	
	setRetry();
</script>
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