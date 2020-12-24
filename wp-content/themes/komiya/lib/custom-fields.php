<?php

// カスタムフィールドの追加
add_action( 'admin_menu', 'add_custom_field' );
function add_custom_field() {
    add_meta_box( 'summary', 'まとめタイトル（英語／日本語）', 'create_summary', 'post', 'normal' );
    add_meta_box( 'goodsURLs', '商品URL', 'create_goodsurls', 'product', 'normal' );
}
 

function create_summary() {
    $keyname = array('まとめ英語タイトル', 'まとめ日本語タイトル');
    global $post;
    foreach($keyname as $key):
        if($key == 'まとめ英語タイトル'):
            $placeholder = 'まとめタイトル（英語）';
        else:
            $placeholder = 'まとめタイトル（日本語）';
        endif;
        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta( $post->ID, $key, true );
        // nonceの追加
        wp_nonce_field( 'action-' . $key, 'nonce-' . $key );
        // HTMLの出力
        echo '<input name="' . $key . '" value="' . $get_value . '" style="width:99%; border-radius: 3px; border: solid 1px #DEDEDE; padding: 5px; margin-bottom: 10px;" placeholder="'.$placeholder.'">';
    endforeach;
}

function create_goodsurls() {
    $keyname = array('楽天', 'Yahoo', 'Amazon');
    global $post;
    foreach($keyname as $key):
        $placeholder = $key.' URL';
        // 保存されているカスタムフィールドの値を取得
        $get_value = get_post_meta( $post->ID, $key, true );
        // nonceの追加
        wp_nonce_field( 'action-' . $key, 'nonce-' . $key );
        // HTMLの出力
        echo '<p>&nbsp;'.$key.'<br>';
        echo '<input name="' . $key . '" value="' . $get_value . '" style="width:99%; border-radius: 3px; border: solid 1px #DEDEDE; padding: 5px; margin-bottom: 10px;" placeholder="'.$placeholder.'"></p>';
    endforeach;
}

// カスタムフィールドの保存
add_action( 'save_post', 'save_custom_field' );
function save_custom_field( $post_id ) {
    $custom_fields = ['まとめ英語タイトル','まとめ日本語タイトル','楽天', 'Yahoo', 'Amazon'];
 
    foreach( $custom_fields as $d ) {
        if ( isset( $_POST['nonce-' . $d] ) && $_POST['nonce-' . $d] ) {
            if( check_admin_referer( 'action-' . $d, 'nonce-' . $d ) ) {
 
                if( isset( $_POST[$d] ) && $_POST[$d] ) {
                    update_post_meta( $post_id, $d, $_POST[$d] );
                } else {
                    delete_post_meta( $post_id, $d, get_post_meta( $post_id, $d, true ) );
                }
            }
        }
    }    
}

