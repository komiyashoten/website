<?php
include('lib/custom-functions.php');
include('lib/shortcodes.php');
include('lib/custom-fields.php');

// ウィジェットエリア
// サイドバーのウィジェット
register_sidebar( array(
	'name' => __( 'Side Widget' ),
	'id' => 'side-widget',
	'before_widget' => '<li class="widget-container">',
	'after_widget' => '</li>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
) );

// フッターエリアのウィジェット
register_sidebar( array(
	'name' => __( 'Footer Widget' ),
	'id' => 'footer-widget',
	'before_widget' => '<div class="widget-area"><ul><li class="widget-container">',
	'after_widget' => '</li></ul></div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
) );

// アイキャッチ画像
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(220, 165, true ); // 幅 220px、高さ 165px、切り抜きモード

// カスタムナビゲーションメニュー
add_theme_support('menus');


// 特定タームを除外できるようにする
function get_my_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '', $excludes = '', $includes= '' ) {
  $terms = get_the_terms( $id, $taxonomy );
  
  if ( is_wp_error( $terms ) )
    return $terms;
 
  if ( empty( $terms ) )
    return false;
    
  foreach ( $terms as $term ) {
 $terms = get_the_terms( $id, $taxonomy ); 
    
    if($excludes) {  //$excludes（除外） が指定されていれば
      //カンマを「|」に置換
      $excludes = str_replace(',', '|', $excludes); 
      //パターンを作成
      $pattern = '/' . $excludes . '/i';  //念のため大文字小文字を区別しないように指定
      //パターンがマッチしなければターム名を出力
      if(!preg_match($pattern, $term->slug)) {  //$term->name にすれば、名前で比較できる。
      $term_names[] = $term->name ;
      }
    }elseif($includes) {
      $includes = str_replace(',', '|', $includes); 
      $pattern = '/' . $includes . '/i';
      //パターンがマッチしたらリンクを出力
      if(preg_match($pattern, $term->slug)) { 
      $term_names[] = $term->name ;
      }
    }else{
      $term_names[] = $term->name ;
    }    
  }
  return $before . join( $sep, $term_names ) . $after;
}


//固定ページでタグ設定欄を表示
function add_tag_to_page() {
 register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'add_tag_to_page');


//固定ページのみ自動<br><p>を無効化
function disable_page_wpautop() {
	if ( is_page() ) remove_filter( 'the_content', 'wpautop' );
}
add_action( 'wp', 'disable_page_wpautop' );


// auter Isamu Takata
// $sep セパレータ文字列　規定値は全角スペース
// $display タイトルを表示する（true）か、PHP 文字列として使えるようにタイトルの値を返す（false）か。規定値はtrue
// $suffix タイトルの末尾に追加する文字列　規定値はNULLで追加文字列無し
// $startFromGender trueは文字列を性別、長傘・折りたたみ傘、種別順に並び変える。falseは逆順にする。規定値はtrue
function custom_wp_title($sep="　", $display=true, $suffix="", $startFromGender=true ) {
		$category_array = [
		["men"=>"メンズ", "weight"=>"1"],
		["women"=>"レディース", "weight"=>"2"],
		["long"=>"長傘", "weight"=>"3"],
		["folding"=>"折りたたみ傘", "weight"=>"4"],
		["rain"=>"雨傘・雨晴兼用", "weight"=>"5"],
		["sun"=>"日傘・晴雨兼用", "weight"=>"5"],
		["woven_fabric"=>"織物", "weight"=>"6"],
		["%e6%9f%93%e7%89%a9"=>"染物", "weight"=>"6"],
		["%E6%9F%93%E7%89%A9"=>"染物", "weight"=>"6"],
		["natural"=>"天然繊維", "weight"=>"6"],
		["water_repellent"=>"超撥水", "weight"=>"6"],
		["many-bones"=>"骨が多い", "weight"=>"6"],
		["light"=>"軽量", "weight"=>"6"],
		["wind-proof"=>"風に強い", "weight"=>"6"],
		["shade"=>"一級遮光", "weight"=>"6"],
		["automatic"=>"自動開閉", "weight"=>"6"],
		["easy-open"=>"ラクラク開閉", "weight"=>"6"],
		["%e5%a4%a7%e3%81%8d%e3%81%84"=>"大きい", "weight"=>"6"],
		["%E5%A4%A7%E3%81%8D%E3%81%84"=>"大きい", "weight"=>"6"],
		["%e7%89%b9%e6%ae%8a%e3%82%bf%e3%82%a4%e3%83%97"=>"特殊タイプ", "weight"=>"6"],
		["%E7%89%B9%E6%AE%8A%E3%82%BF%E3%82%A4%E3%83%97"=>"特殊タイプ", "weight"=>"6"],
		["47cm"=>"47cm", "weight"=>"7"],
		["50cm"=>"50cm", "weight"=>"7"],
		["54cm"=>"54cm", "weight"=>"7"],
		["55cm"=>"55cm", "weight"=>"7"],
		["58cm"=>"58cm", "weight"=>"7"],
		["60cm"=>"60cm", "weight"=>"7"],
		["63-5cm"=>"63.5cm", "weight"=>"7"],
		["65cm"=>"65cm", "weight"=>"7"],
		["70cm"=>"70cm", "weight"=>"7"],
		["2000%e5%86%86%ef%bd%9e"=>"2000円～", "weight"=>"8"],
		["2000%E5%86%86%EF%BD%9E"=>"2000円～", "weight"=>"8"],
		["3000y"=>"3000円〜", "weight"=>"8"],
		["5000y"=>"5000円〜", "weight"=>"8"],	
		["10000y"=>"10000円〜", "weight"=>"8"],	
		["20000y"=>"20000円〜", "weight"=>"8"],	
		["30000y"=>"30000円〜", "weight"=>"8"]
		];

	global $template;
	if( basename($template) == "search.php" ) { 
		echo "小宮商店の傘一覧 | 傘専門店 小宮商店";
		return;
	} elseif( basename($template) != "taxonomy.php" ) {
		wp_title( '|', true, 'right' );bloginfo( 'name' );
		return;
	}
	
//	echo (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//	echo $_SERVER['REQUEST_URI'];
	$uri_array = explode('/', $_SERVER['REQUEST_URI']);

	if ( !( in_array('large_cat', $uri_array) || in_array('umbrella_category', $uri_array) || in_array('size', $uri_array) || in_array('price', $uri_array) ) ) {
		wp_title( '|', true, 'right' );bloginfo( 'name' );
		return;
	}
	
	if (in_array('large_cat', $uri_array)) {
		$array_index = array_search('large_cat', $uri_array);
		$large_categories = explode('+', $uri_array[$array_index+1]);
		foreach ($large_categories as $value1) {
			foreach ($category_array as $value2) {
				if ( !empty($value2[$value1]) ) {
					$echo_string_array[$value2[$value1]] = $value2["weight"];
				}
			}
		}
	} elseif (in_array('umbrella_category', $uri_array)) {
		$array_index = array_search('umbrella_category', $uri_array);
		$large_categories = explode('/', $uri_array[$array_index+1]);
		foreach ($large_categories as $value1) {
			foreach ($category_array as $value2) {
				if ( !empty($value2[$value1]) ) {
					$echo_string_array[$value2[$value1]] = $value2["weight"];
				}
			}
		}
	} elseif (in_array('size', $uri_array)) {
		$array_index = array_search('size', $uri_array);
		$large_categories = explode('/', $uri_array[$array_index+1]);
		foreach ($large_categories as $value1) {
			foreach ($category_array as $value2) {
				if ( !empty($value2[$value1]) ) {
					$echo_string_array[$value2[$value1]] = $value2["weight"];
				}
			}
		}
	} elseif (in_array('price', $uri_array)) {
		$array_index = array_search('price', $uri_array);
		$large_categories = explode('/', $uri_array[$array_index+1]);
		foreach ($large_categories as $value1) {
			foreach ($category_array as $value2) {
				if ( !empty($value2[$value1]) ) {
					$echo_string_array[$value2[$value1]] = $value2["weight"];
				}
			}
		}
	}

	if (!empty( $_SERVER['QUERY_STRING']) ) {
		$query_array = explode('&', $_SERVER['QUERY_STRING']);
		foreach ($query_array as $array1) {
			$query_param_array[] = explode('=', $array1);
		}
		foreach ($query_param_array as $value3) {
			if (in_array("umbrella_category",$value3)) {
				$array_index = array_search('umbrella_category', $value3);
				$umbrella_categories = explode('+', $value3[$array_index+1]);
				foreach ($umbrella_categories as $value1) {
					foreach ($category_array as $value2) {
						if ( !empty($value2[$value1]) ) {
							$echo_string_array[$value2[$value1]] = $value2["weight"];
						}
					}
				}
			}
		}
		foreach ($query_param_array as $value1) {
			foreach ($category_array as $value2) {
				if ( !empty($value2[$value1[1]]) ) {
					$echo_string_array[$value2[$value1[1]]] = $value2["weight"];
				}
			}
		}
	}

	if ($startFromGender) {
		asort($echo_string_array);
	} else {
		arsort($echo_string_array);
	}
	
	$echo_string = "";
	foreach ($echo_string_array as $key => $value) {
		$echo_string .= $key . $sep;
	}
	
	if( !empty($suffix) ) {
		$echo_string .= $suffix;
	} else {
		$echo_string = mb_substr($echo_string, 0, -1, "UTF-8");
		if ( !(mb_substr($echo_string, -1, 1, "UTF-8") == "傘") ) {
			$echo_string .= "傘";
		}
	}

	if ($display) {
		echo $echo_string;
	} else {
		return $echo_string;
	}
}

function custom_overwrite_title($title){
	global $template;
	if( basename($template) == "search.php" ) { 
		$title = "小宮商店の傘一覧 | 傘専門店 小宮商店";
		return $title;
	} elseif( basename($template) != "taxonomy.php" ) {
		return $title;
	}

	$title = custom_wp_title( ' | ', false, '傘専門店 小宮商店', false );

	return $title;
}
add_filter('aioseop_title', 'custom_overwrite_title');

// auter Isamu Takata
// $key 値を取得したいカスタムフィールド名
function custom_post_custom($key = '') {
	global $post;

	if ($key != "値段") {
		return post_custom($key);
	}

	if ( empty(post_custom("新規値段")) || empty(post_custom("変更日時")) ) {
		return post_custom('値段');
	}

	date_default_timezone_set('Asia/Tokyo');
	$now_date_time = new DateTime();
	$update_date_time = new DateTime();
	$update_date_time = DateTime::createFromFormat("Y/n/j G:i", post_custom("変更日時"));

	if ($now_date_time >= $update_date_time) {
		$bool = update_post_meta( $post->ID, '値段', post_custom("新規値段") );
		$bool = update_post_meta( $post->ID, '新規値段', '' );
		$bool = update_post_meta( $post->ID, '変更日時', '' );
		
	}
	return post_custom('値段');
}

// auter Isamu Takata
// $atts ユーザーがショートコードに指定したパラメータが配列になって格納されている
//　　　　取り出すには、extractでshortcode_attsを指定して取り出す。
function custom_get_taxonomy($atts = array()) {
	extract(shortcode_atts(array(
		'product_id' => NULL,
		'div_class' => 'custom_get_taxonomy',
		'thumbnail_class' => 'thumbnail',
		'img_style' => NULL ,
		'brand_class' => 'brand',
		'spec_class' => 'spec',
		'price_class' => 'price'		
	), $atts));
	
	if (empty($product_id)) {return 'product_idは必須パラメータです。';}

	//echo $product_id;
	$post_id = url_to_postid( home_url() . "/product/$product_id/" );
	//echo '$post_id=' . $post_id;
	
	$link = get_post_custom_values( '商品ページURL', $post_id )[0];
	$thumbnail = get_the_post_thumbnail( $post_id );
	$thumbnail = preg_replace('/[-][0-9]+[x][0-9]+[.]/', '.', $thumbnail);
	$thumbnail = preg_replace('/width="[0-9]+"[ ]+height="[0-9]+"[ ]+/', ' ', $thumbnail);

	//echo '$img_style=' . $img_style;
	if (!empty($img_style)) {
		$thumbnail = mb_substr($thumbnail, 0, -1, "UTF-8");
		$thumbnail .= ' style="' . $img_style . '">';
	}
		
	$brand = get_post_custom_values('ブランド', $post_id )[0];
	$series = get_post_custom_values('シリーズ名', $post_id )[0];

	$terms = get_the_terms($post_id, 'size');
	global $size;
	$size ="";
	foreach ($terms as $term) {
		$size .= $term->name;
	}

	$terms = get_the_terms($post_id, 'ribs');
	global $ribs;
	$ribs = "";
	foreach ($terms as $term) {
		$ribs .= $term->name;
	}
	
	$spec = get_post_custom_values('大分類', $post_id )[0];
	$price = get_post_custom_values('値段', $post_id )[0];
	
	$return_string = "";
	$return_string .= '<div class="' . $div_class . '">';
	$return_string .=  '<a href="' . $link . '"' . ">\n";
	$return_string .=  '<div class="' . $thumbnail_class . '">' . $thumbnail . "</div>\n";
	$return_string .=  '<div class="' . $brand_class . '">' . $brand . "</div>\n";
	$return_string .=  '<h3>' . '<span class=' . '"series-bold">' . $series . '&nbsp;&nbsp;' . '</span><span>' . $size . '&nbsp;' . $ribs . "</span></h3>\n";
	$return_string .=  '<div class="' . $spec_class . '">' . $spec . "</div>\n";
	$return_string .=  '<div class="' . $price_class . '">' . "\\" . $price . "</div>\n";
	$return_string .=  "</a>\n";
	$return_string .=  "</div>\n";
	
	return $return_string;
}
add_shortcode( 'custom_get_taxonomy' , 'custom_get_taxonomy' );

add_filter('posts_request', function ($query) {
	global $template;

	if( basename($template) != "search.php" ) {
		return $query;
	}
	
	//echo "<br>" . $query . "<br>";

	$pos3 = mb_strrpos( $query, "L" );	
	$queryLimit = mb_substr( $query, $pos3 );
	
	//echo "<br>" . $queryLimit . "<br>";	
	
	//echo "<br>" . "enter overwite query" . "<br>";
	$query = 
		"
		SELECT SQL_CALC_FOUND_ROWS wp_posts.* 
		FROM wp_posts 
		INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id ) 
		INNER JOIN (
			SELECT meta_id, post_id, meta_key, CAST(REPLACE(meta_value,',','') AS DECIMAL) AS meta_value_no_comma  
			FROM wp_postmeta 
			WHERE  wp_postmeta.meta_key = '値段' 
			ORDER BY `meta_value_no_comma` DESC ) AS wp_postmeta2 ON ( wp_posts.ID = wp_postmeta2.post_id) 
		WHERE 1=1 AND ( wp_postmeta.meta_key = '値段' ) AND wp_posts.post_type = 'product' AND ((wp_posts.post_status = 'publish'))
		GROUP BY wp_posts.ID 
		ORDER BY `meta_value_no_comma` DESC " . $queryLimit;
	
	//echo "<br>" . $query . "<br>";	
	
	return $query;
});


//ショートコードボタンの追加
add_filter( 'mce_external_plugins', 'add_add_shortcode_button_plugin' );
function add_add_shortcode_button_plugin( $plugin_array ) {
  $plugin_array[ 'slider_shortcode_button_plugin' ] = get_template_directory_uri() . '/js/editor-button.js';
  $plugin_array[ 'inPageLink_shortcode_button_plugin' ] = get_template_directory_uri() . '/js/editor-button.js';
  return $plugin_array;
}
add_filter( 'mce_buttons', 'add_shortcode_button' );
function add_shortcode_button( $buttons ) {
  $buttons[] = 'slider';
  $buttons[] = 'inPageLink';
  return $buttons;
}
add_action( 'admin_print_footer_scripts', 'add_shortcode_quicktags' );
function add_shortcode_quicktags() {
  if ( wp_script_is('quicktags') ) {
?>
  <script>
    QTags.addButton( 'slider_shortcode', '[スライダー]', '[スライダー]', '[/スライダー]' );
    QTags.addButton( 'inPageLink_shortcode', '[ページ内リンク]', '[ページ内リンク]', '[/ページ内リンク]' );
  </script>
<?php
  }
}
?>