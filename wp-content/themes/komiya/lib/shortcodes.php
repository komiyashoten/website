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