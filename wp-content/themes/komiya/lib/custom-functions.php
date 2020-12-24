<?php

//該当記事のサムネイル画像を取得する
function kmy_get_thumbnail( $post_id = '', $opt = '' ){
	if( !isset($post_id) ) $post_id = get_the_ID();
	if( !isset($opt) ) $opt = 'full';
	$thumbnail_id = get_post_thumbnail_id($post_id);
	$image = wp_get_attachment_image_src( $thumbnail_id, $opt );
	$src = $image[0];
	$width = $image[1]*0.3;
	$height = $image[2]*0.3;
	
	if(!isset($src)){
		$src = null;
	}
	
	return $src;
}

//アセット内ファイル表示
function assets($path="",$key="",$return=""){
    if($key){
        if($return!=null){
            return get_bloginfo("template_url").'/'.$path.'/'.$key;
        }else{
            echo get_bloginfo("template_url").'/'.$path.'/'.$key;
        }
    }else{
        if($return!=null){
            return get_bloginfo("template_url").'/'.$path;
        }else{
            echo get_bloginfo("template_url").'/'.$path;
        }
    }
    
}

//URLから楽天かヤフーかを調べる関数
function which_shop($val){
    if(strpos($val,"rakuten") != false){
        return "rakuten";
    }else if(strpos($val,"yahoo")){
        return "yahoo";
    }
}