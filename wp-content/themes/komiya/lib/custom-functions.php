<?php

//該当記事のサムネイル画像を取得する
function kmy_get_thumbnail( $post_id = '', $opt = '', $replace = '' ){
    //もしpost_id指定が文字列だった場合、スラッグからidを取得する
    if( is_string($post_id) ){
        $get_post_id = get_page_by_path($post_id);
        $post_id = $get_post_id->ID;
    }
	if( !isset($post_id) ) $post_id = get_the_ID();
	if( !isset($opt) ) $opt = 'full';
	$thumbnail_id = get_post_thumbnail_id($post_id);
	$image = wp_get_attachment_image_src( $thumbnail_id, $opt );
	$src = $image[0];
	$width = $image[1]*0.3;
	$height = $image[2]*0.3;
	
	if(!isset($src)){
        if( !$replace ){
            $src = null;
        }else{
            $src = $replace;
        }
		
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

function get_ks_class(){
    global $post;
    $is_logged_in = is_user_logged_in();
    if( $is_logged_in ) $is_logged_in = "logged_in";
    if(basename( get_page_template() ) == "single-summary.php"){
        $add_class = "summary";
    }
	$slug = $post->post_name;
    if($slug == "men" || $slug == "women"){
        return "series ".$is_logged_in." ".$add_class;
    }else{
        return $is_logged_in." ".$add_class;
    }
}

function ks_logo(){
    global $post;
	$slug = $post->post_name;
    if($slug == "men" || $slug == "women" || basename( get_page_template() ) == "single-summary.php"){
        echo "logo_komiyashoten_white.png";
    }else{
        echo "logo_komiyashoten.jpg";
    }
}
