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

	$return.= '<script>jQuery(function(){ var swiper = new Swiper(".swiper-container", { loop: true, navigation: {nextEl: ".swiper-button-next",prevEl: ".swiper-button-prev",},pagination: {el: ".swiper-pagination",},}); });</script>';
	return $return;
}
add_shortcode('スライダー', 'sliders');


