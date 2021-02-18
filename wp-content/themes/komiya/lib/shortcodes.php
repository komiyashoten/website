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
function ks_showProductsByCategory( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count' => 8,
				'cat1' => "men",
				'cat2' => "popular",
				'col'  => '4',
			),
			$atts
		)
	);

	$return = "";

	$args = array(
		'post_type' =>array(
			'product'
		),
		'posts_per_page' => $count,
		'tax_query' =>array(
			'relation' => 'AND', //タクソノミー同士の関係を指定
			array (
				'taxonomy' => 'large_cat',
				'field' => 'slug',
				'terms' => $cat1,
				'operator' => 'and'
			),
			array (
				'taxonomy' => 'product_tag',
				'field' => 'slug',
				'terms' => $cat2,
				'operator' => 'and'
			)
		)
	);
	$return = "<section class='products_box product_col".$col."'>";
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
add_shortcode('カテゴリ指定商品', 'ks_showProductsByCategory');


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
