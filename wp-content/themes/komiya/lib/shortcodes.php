<?php
require dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-includes/class-phpass.php'; 

//ショートコードはこちらにまとめる

//囲み型ショートコードで出力(ボックスを装飾)
function inpage_links( $atts, $content = null ) {
	$return = '';
	//改行を拾ってliタグを入れる
	$content_array = explode('\n', $content);
	foreach($content_array as $val):
		$val = str_replace('<br />', '', $val);
		$return.= $val;
	endforeach;
    return '<div class="inpage_linkbox">' . $return . '</div>';
}
add_shortcode('ページ内リンク', 'inpage_links');

//スライダーの表示
function sliders( $atts, $content = null ) {
	$return = '';
	$imgTags = array();
	//imgタグごとに分離
	$pattern = '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i'; //正規表現パターン
	if ( preg_match_all( $pattern, $content, $images ) ){
		if ( is_array( $images ) && isset( $images[0] ) ) {
			//imgタグが存在した場合
			$imgTags = $images[1]; //純粋なimgタグ。1はsrc
		}else{
			$imgTags = null;
		}
	}else{
		$imgTags = null;
	}
	// var_dump($imgTags);
	$return.= '<div class="swiper-container"><div class="swiper-wrapper">';
	foreach($imgTags as $img){
		$return.= '<div class="swiper-slide"><img src="'.$img.'"></div>';
	}
	$return.= '</div>';
	$return.= '<div class="swiper-button-next swiper-button-white"></div>';
	$return.= '<div class="swiper-button-prev swiper-button-white"></div>';
	$return.= '<div class="swiper-pagination swiper-pagination-black"></div>';
	$return.= '</div>';

	$return.= '<script>jQuery(function(){ var swiper = new Swiper(".swiper-container", { loop: true, navigation: {nextEl: ".swiper-button-next",prevEl: ".swiper-button-prev",},pagination: {el: ".swiper-pagination", clickable: true,},}); });</script>';
	return $return;
}
add_shortcode('スライダー', 'sliders');

//商品の表示
function ks_showProduct( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'id' => '',
				'link' => '',
				'count' => 1,
			),
			$atts
		)
	);

	if($link){
		//URL指定の場合
		$id = url_to_postid($link);
	}

	$args = array(
		'number_posts'    => $count,
		'posts_per_page'  => $count,
		'post_type'       => 'product',
		'post_status'     => 'publish',
		'orderby'         => 'menu_order',
		'order'           => "ASC",
		'post__in'		  => array( $id ), //将来的に複数になる可能性のためarray
	);

	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$post = $the_query->post;
			$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
			$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			$src = $image[0];
			//商品URLからyahooかrakutenか判定する
			$goods_url = get_post_meta($post->ID,'商品ページURL', true);
			//ショップのURLから楽天かヤフーかを判定し、それぞれの変数に格納
			$which_shop = which_shop($goods_url);
			$$which_shop = $goods_url;

			//もし新フィールドに値がなければ旧フィールドのURLを元々フィールドにあったURLとする
			$rakuten = isset($rakuten) ? $rakuten : get_post_meta($post->ID,'楽天', true);
			$yahoo = isset($yahoo) ? $yahoo : get_post_meta($post->ID,'Yahoo', true);
			$amazon = get_post_meta($post->ID,'Amazon', true);

			$size = wp_get_object_terms($post->ID, "size");
			$ribs = wp_get_object_terms($post->ID, "ribs");
			
			$return.='<section class="product_box">';
			$return.='	<div class="product_thumbnail">'; //サムネイル
			$return.='		<img src="'.kmy_get_thumbnail($post->ID).'">';
			$return.='	</div>';
			$return.='	<div class="product_content">';
			$return.='		<div class="product_lead">'.get_post_meta($post->ID,'リード', true).'</div>';
			$return.='		<h3 class="product_title">'.get_post_meta($post->ID,'シリーズ名', true).'&nbsp;&nbsp;</h3>';
			$return.='		<p class="product_kind">'.$size[0]->name.'&nbsp;'.$ribs[0]->name.'／'.get_post_meta($post->ID,'大分類', true).'</p>';
			$return.='		<p class="product_price">¥'.get_post_meta($post->ID,'値段', true).'</p>';
			$return.='	</div>';
			//マウスオーバーの表示領域
			$return.='	<div class="links">';
			if( $rakuten != null ):
				//楽天のURLがあれば楽天のボタン表示
				$return.='<a class="product_button" href="'.$rakuten.'">楽天で詳細を見る</a>';
			endif;
			if( $yahoo != null ):
				//ヤフーのURLがあればヤフーのボタン表示
				$return.='<a class="product_button" href="'.$yahoo.'">ヤフーで詳細を見る</a>';
			endif;
			if( $amazon != null ):
				//アマゾンのURLがあればアマゾンのボタン表示
				$return.='<a class="product_button" href="'.$amazon.'">アマゾンで詳細を見る</a>';
			endif;			
			$return.='	</div>';
			$return.='</section>';
        endwhile;
	endif;
	wp_reset_postdata();
	return $return;
}
add_shortcode('商品', 'ks_showProduct');

// 複数商品の場合の囲いショートコード 
function ks_showProducts( $atts, $content = null ) {
	// ショートコードを内部で出力
	$content = do_shortcode( shortcode_unautop( $content ) );
	$cnt = mb_substr_count($content, '<section class="product_box">');
	if( $cnt > 5 ) $cnt = 5;
	return '<div class="products_box product_col'.$cnt.'">'.$content.'</div>';
}
add_shortcode('複数商品', 'ks_showProducts');


//カテゴリによる商品の表示
function ks_showProductsByCategory_old( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count'        => 8,
				'large_cat'    => "men",
				'size'         => "",
				'category'     => "",
				'product_tag'  => "popular",
				'price'        => "",
				'ribs'         => "",
				'column'       => "4",
			),
			$atts
		)
	);

	if( $whichcat == "category" ){
		$whichcat = "umbrella_category";
	}
	//複数あるかどうか（カンマ区切りで判別）
	if( strstr($large_cat, ",") ){
		//複数指定があった場合arrayにする
		$large_cat = explode(",",$large_cat);
	}
	if( strstr($size, ",") ){
		$size = explode(",",$size);
	}
	if( strstr($category, ",") ){
		$category = explode(",",$category);
	}
	if( strstr($product_tag, ",") ){
		$product_tag = explode(",",$product_tag);
	}
	if( strstr($price, ",") ){
		$price = explode(",",$price);
	}
	if( strstr($ribs, ",") ){
		$ribs = explode(",",$ribs);
	}
	$tax_names = array();

	//パラメーターの調整
	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => $count,
	);

	$args['tax_query']['relation'] = "AND";

	if($large_cat){
		$tax_names["large_cat"] = "large_cat";
		$args['tax_query'][] = array (
			'taxonomy' => 'large_cat',
			'field' => 'slug',
			'terms' => $large_cat,
			'operator' => 'and'
		);
	}
	if($size){
		$tax_names["size"] = "size";
		$args['tax_query'][] = array (
			'taxonomy' => 'size',
			'field' => 'slug',
			'terms' => $size,
			'operator' => 'and'
		);
	}
	if($category){
		$tax_names["category"] = "umbrella_category";
		$args['tax_query'][] = array (
			'taxonomy' => 'umbrella_category',
			'field' => 'slug',
			'terms' => $category,
			'operator' => 'and'
		);
	}
	if($product_tag){
		$tax_names["product_tag"] = "product_tag";
		$args['tax_query'][] = array (
			'taxonomy' => 'product_tag',
			'field' => 'slug',
			'terms' => $product_tag,
			'operator' => 'and'
		);
	}
	if($price){
		$tax_names["price"] = "price";
		$args['tax_query'][] = array (
			'taxonomy' => 'price',
			'field' => 'slug',
			'terms' => $price,
			'operator' => 'and'
		);
	}
	if($ribs){
		$tax_names["ribs"] = "ribs";
		$args['tax_query'][] = array (
			'taxonomy' => 'ribs',
			'field' => 'slug',
			'terms' => $ribs,
			'operator' => 'and'
		);
	}
	$return = "";

	$return.= "<section class='products_box product_col".$column."'>";
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$post = $the_query->post;
			$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
			$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			$src = $image[0];
			//商品URLからyahooかrakutenか判定する
			$goods_url = get_post_meta($post->ID,'商品ページURL', true);
			//ショップのURLから楽天かヤフーかを判定し、それぞれの変数に格納
			$which_shop = which_shop($goods_url);
			$$which_shop = $goods_url;

			//もし新フィールドに値がなければ旧フィールドのURLを元々フィールドにあったURLとする
			$rakuten = isset($rakuten) ? $rakuten : get_post_meta($post->ID,'楽天', true);
			$yahoo = isset($yahoo) ? $yahoo : get_post_meta($post->ID,'Yahoo', true);
			$amazon = get_post_meta($post->ID,'Amazon', true);

			$size = wp_get_object_terms($post->ID, "size");
			$ribs = wp_get_object_terms($post->ID, "ribs");
			
			$return.='<section class="product_box">';
			$return.='	<div class="product_thumbnail">'; //サムネイル
			$return.='		<img src="'.kmy_get_thumbnail($post->ID).'">';
			$return.='	</div>';
			$return.='	<div class="product_content">';
			$return.='		<div class="product_lead">'.get_post_meta($post->ID,'リード', true).'</div>';
			$return.='		<h3 class="product_title">'.get_post_meta($post->ID,'シリーズ名', true).'&nbsp;&nbsp;</h3>';
			$return.='		<p class="product_kind">'.$size[0]->name.'&nbsp;'.$ribs[0]->name.'／'.get_post_meta($post->ID,'大分類', true).'</p>';
			$return.='		<p class="product_price">¥'.get_post_meta($post->ID,'値段', true).'</p>';
			$return.='	</div>';
			//マウスオーバーの表示領域
			$return.='	<div class="links">';
			if( $rakuten != null ):
				//楽天のURLがあれば楽天のボタン表示
				$return.='<a class="product_button" href="'.$rakuten.'">楽天で詳細を見る</a>';
			endif;
			if( $yahoo != null ):
				//ヤフーのURLがあればヤフーのボタン表示
				$return.='<a class="product_button" href="'.$yahoo.'">ヤフーで詳細を見る</a>';
			endif;
			if( $amazon != null ):
				//アマゾンのURLがあればアマゾンのボタン表示
				$return.='<a class="product_button" href="'.$amazon.'">アマゾンで詳細を見る</a>';
			endif;			
			$return.='	</div>';
			$return.='</section>';
        endwhile;
	endif;
	wp_reset_postdata();
	$return.="</section>";
	$return.="<p class='more'><a href='#'>MORE</a></p>";
	return $return;
}


//カテゴリによる商品の表示
function ks_showProductsByCategory( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count'        => 4,
				'column'	   => 4,
				'large_cat'    => "men",
				'category'     => "",
				'product_tag'  => "",
			),
			$atts
		)
	);
	//複数あるかどうか（カンマ区切りで判別）
	if( strstr($large_cat, ",") ){
		//複数指定があった場合arrayにする
		$large_cat = explode(",",$large_cat);
	}
	if( strstr($category, ",") ){
		//複数カテゴリの場合
		$category = explode(",",$category);
		$cat_name = "";
		foreach($category as $cat){
			$cat_info = get_term_by('slug', $cat, 'umbrella_category');
			$cat_name.=$cat_name." | ".$cat_info->name;
		}
	}else{
		//単体カテゴリの場合
		$cat_name = "";
		$cat_info = get_term_by('slug', $category, 'umbrella_category');
		$cat_name = $cat_info->name;
	}
	if($product_tag){
		$tax_names["product_tag"] = "product_tag";
		$args['tax_query'][] = array (
			'taxonomy' => 'product_tag',
			'field' => 'slug',
			'terms' => $product_tag,
			'operator' => 'and'
		);
	}
	$tax_names = array();

	//パラメーターの調整
	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => $count,
	);
	
	$args['tax_query']['relation'] = "AND";
	if($large_cat){
		$tax_names["large_cat"] = "large_cat";
		$args['tax_query'][] = array (
			'taxonomy' => 'large_cat',
			'field' => 'slug',
			'terms' => $large_cat,
			'operator' => 'and'
		);
	}
	if($category){
		$tax_names["category"] = "umbrella_category";
		$args['tax_query'][] = array (
			'taxonomy' => 'umbrella_category',
			'field' => 'slug',
			'terms' => $category,
			'operator' => 'and'
		);
	}
	if($product_tag){
		$tax_names["product_tag"] = "product_tag";
		$args['tax_query'][] = array (
			'taxonomy' => 'product_tag',
			'field' => 'slug',
			'terms' => $product_tag,
			'operator' => 'and'
		);
	}
	$return = "";

	if($cat_name){
		$return.= "<h2 class='men_women_series_cat_tit'><span>".$cat_name."</span></h2>";
	}
	$return.= "<section class='products_box product_col".$column."'>";
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$post = $the_query->post;
			$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
			$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			$src = $image[0];
			//商品URLからyahooかrakutenか判定する
			$goods_url = get_post_meta($post->ID,'商品ページURL', true);
			//ショップのURLから楽天かヤフーかを判定し、それぞれの変数に格納
			$which_shop = which_shop($goods_url);
			$$which_shop = $goods_url;

			//もし新フィールドに値がなければ旧フィールドのURLを元々フィールドにあったURLとする
			$rakuten = isset($rakuten) ? $rakuten : get_post_meta($post->ID,'楽天', true);
			$yahoo = isset($yahoo) ? $yahoo : get_post_meta($post->ID,'Yahoo', true);
			$amazon = get_post_meta($post->ID,'Amazon', true);

			$size = wp_get_object_terms($post->ID, "size");
			$ribs = wp_get_object_terms($post->ID, "ribs");
			
			$return.='<section class="product_box">';
			$return.='	<div class="product_thumbnail">'; //サムネイル
			$return.='		<img src="'.kmy_get_thumbnail($post->ID).'">';
			$return.='	</div>';
			$return.='	<div class="product_content">';
			$return.='		<div class="product_lead">'.get_post_meta($post->ID,'リード', true).'</div>';
			$return.='		<h3 class="product_title">'.get_post_meta($post->ID,'シリーズ名', true).'&nbsp;&nbsp;</h3>';
			$return.='		<p class="product_kind">'.$size[0]->name.'&nbsp;'.$ribs[0]->name.'／'.get_post_meta($post->ID,'大分類', true).'</p>';
			$return.='		<p class="product_price">¥'.get_post_meta($post->ID,'値段', true).'</p>';
			$return.='	</div>';
			//マウスオーバーの表示領域
			$return.='	<div class="links">';
			if( $rakuten != null ):
				//楽天のURLがあれば楽天のボタン表示
				$return.='<a class="product_button" href="'.$rakuten.'">楽天で詳細を見る</a>';
			endif;
			if( $yahoo != null ):
				//ヤフーのURLがあればヤフーのボタン表示
				$return.='<a class="product_button" href="'.$yahoo.'">ヤフーで詳細を見る</a>';
			endif;
			if( $amazon != null ):
				//アマゾンのURLがあればアマゾンのボタン表示
				$return.='<a class="product_button" href="'.$amazon.'">アマゾンで詳細を見る</a>';
			endif;			
			$return.='	</div>';
			$return.='</section>';
        endwhile;
	endif;
	wp_reset_postdata();
	$return.="</section>";
	$return.="<p class='more'><a href='".get_bloginfo("url")."/large_cat/".$large_cat."/?umbrella_category=".$category."'>MORE</a></p>";
	return $return;
}
add_shortcode('カテゴリ指定商品', 'ks_showProductsByCategory');


//傘の選び方投稿の表示
function ks_showHowToPosts( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count'        => 3,
				'gender'       => "men",
			),
			$atts
		)
	);

	//パラメーターの調整
	$args = array(
		'post_type' =>array(
			'post'
		),
		'posts_per_page' => $count,
		'category_name'  => "how-to-select-".$gender,
	);

	$return = "";
	$return.= "<ul class='blog_list2_3 gender_top'>";
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$post = $the_query->post;
			$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
			$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			$src = $image[0];
			$permalink = get_permalink($the_query->post->ID);
			$cat = get_the_category(); $cat = $cat[0];
			
			$return.='<li>';
			$return.='	<a href="'.$permalink.'"><img src="'.kmy_get_thumbnail($post->ID).'">';
			$return.='	<div class="blog_date_category"><span class="date">'.get_the_time('Y.m.d').'</span> ｜ <span class="category">'.$cat->cat_name.'</span></div>';
			$return.='	<h3>'.get_the_title().'</h3>';
			$return.='</a></li>';
        endwhile;
	endif;
	wp_reset_postdata();
	$return.="</ul>";
	$return.="<p class='more'><a href='".get_bloginfo("url")."/category/how-to-select-".$gender."/'>MORE</a></p>";
	return $return;
}
add_shortcode('傘の選び方', 'ks_showHowToPosts');

//タグによるシリーズの表示
function ks_showSeriesPosts( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count'        => 3,
				'gender'       => "men",
				'tag'          => "織物",
				'more_slug'    => "orimono",
				'ids'          => "",
			),
			$atts
		)
	);

	$parent_page = get_page_by_path("komiyashoten-".$gender);

	//パラメーターの調整
	$args = array(
		'post_type' =>array(
			'page'
		),
		'posts_per_page' => $count,
		'order'			 => "ASC",
	);

	if($ids){
		$ids = explode(",",$ids);
		$args['post__in'] = $ids;
	}else{
		$args['post__not_in'] = array(616,654,656,663,665,668,671,679);
		$args['tag'] = $tag;
		$args['post_parent'] = $parent_page->ID;
	}

	$tag_slug = "";
	//moreのリンク用にtermのslugを取得する
	$terms = get_terms('post_tag'); 
	foreach($terms as $term){
		if( $term->name == $tag ){
			$tag_slug = $term->slug;
		}
	}

	$return = "";
	$return = "<h2 class='men_women_series_cat_tit'><span>".$tag."のシリーズ</span></h2>";
	$return.= "<ul class='series_list2 gender_top'>";
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$post = $the_query->post;
			$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
			$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			$src = $image[0];
			$permalink = get_permalink($the_query->post->ID);
			$cat = get_the_category(); $cat = $cat[0];
			
			$return.='<li>';
			$return.='	<a href="'.$permalink.'"><img src="'.kmy_get_thumbnail($post->ID).'">';
			$return.='	<h3>'.get_the_title().'</h3>';
			$return.='	<div class="ruby">'.post_custom('ルビ').'</div>';
			$return.='	<div class="catch">'.post_custom('キャッチコピー').'</div>';
			$return.='</a></li>';
        endwhile;
	endif;
	wp_reset_postdata();
	$return.="</ul>";
	$return.="<p class='more'><a href='".get_bloginfo("url")."/komiyashoten-".$gender."/".$more_slug."'>MORE</a></p>";
	return $return;
}
add_shortcode('シリーズ', 'ks_showSeriesPosts');

//メン・ウィメントップのスライダーの表示
function ks_showHeroSlider( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count'        => -1,
				'ids'          => "",
			),
			$atts
		)
	);
	$ids = explode(",",$ids);
	//パラメーターの調整
	$args = array(
		'post_type' =>array('page','post'),
		'posts_per_page' => $count,
		'orderby'		 => "post__in",
		'post__in'		 => $ids
	);

	$return = "";
	$return = "<div class='men_women_top_header'>";
	$return.= "<ul class='big_banner_top bxslider'>";
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ):
		while ( $the_query->have_posts() ): $the_query->the_post();
			$post = $the_query->post;
			$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
			$image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			$src = $image[0];
			$permalink = get_permalink($the_query->post->ID);
			$cat = get_the_category(); $cat = $cat[0];
			
			$return.='<li>';
			$return.='	<a href="'.$permalink.'">';
			$return.='	<div class="text">';
			$return.='		<h3>'.get_the_title().'</h3>';
			$return.='		<div class="ruby">'.post_custom('ルビ').'</div>';
			$return.='		<div class="catch">'.post_custom('リード').'</div>';
			$return.='		<div class="read">READ</div>';
			$return.='	</div>';
			$return.='	<div class="black">&nbsp;</div>';
			$return.='	<div class="bg"><img src="'.kmy_get_thumbnail($post->ID).'"></div>';
			$return.='</a></li>';
        endwhile;
	endif;
	wp_reset_postdata();
	$return.="</ul>";
	$return.="</div>";
	return $return;
}
add_shortcode('ヒーロースライダー', 'ks_showHeroSlider');

// シリーズのタグ一覧
function ks_showSeriesTags( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'gender'       => "men",
				'color'        => "",
			),
			$atts
		)
	);

	$return = '<div class="banner2'.$color.'">';
	if($gender == "men"){
		$return.='<a href="/komiyashoten-men/orimono/">織物</a>';
		$return.='<a href="/komiyashoten-men/water-repellent/">超撥水</a>';
		$return.='<a href="/komiyashoten-men/shade/">日傘・晴雨兼用傘</a>';
	}else{
		$return.='<a href="/komiyashoten-women/orimono/">織物</a>';
		$return.='<a href="/komiyashoten-women/somemono/">染物</a>';
		$return.='<a href="/komiyashoten-women/water-repellent/">超撥水</a>';
		$return.='<a href="/komiyashoten-women/shade/">一級遮光</a>';
		$return.='<a href="/komiyashoten-women/kawazu/">かわず張り・二重張り</a>';
	}

	$return.= '</div>';

	return $return;
}
add_shortcode('タグ一覧', 'ks_showSeriesTags');


// 囲いショートコード - 見出し
function ks_showTopHeadding( $atts, $content = null ) {
	// ショートコードを内部で出力
	$content = do_shortcode( shortcode_unautop( $content ) );
	return '<h2 class="men_women_section_title">'.$content.'</h2>';
}
add_shortcode('見出し', 'ks_showTopHeadding');

// 囲いショートコード - 小見出し
function ks_showTopSubHeadding( $atts, $content = null ) {
	return '<div class="sub">'.$content.'</div>';
}
add_shortcode('小見出し', 'ks_showTopSubHeadding');
