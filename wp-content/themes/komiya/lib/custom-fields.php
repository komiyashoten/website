<?php

// カスタムフィールドの追加
add_action( 'admin_menu', 'add_custom_field' );
function add_custom_field() {
    add_meta_box( 'summary', 'まとめタイトル（英語／日本語）', 'create_summary', 'post', 'normal' );
}
 

function create_summary() {
    $keyname = array('summary_en', 'summary_ja');
    global $post;
    foreach($keyname as $key):
        if($key == 'summary_en'):
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

// カスタムフィールドの保存
add_action( 'save_post', 'save_custom_field' );
function save_custom_field( $post_id ) {
    $custom_fields = ['summary_en','summary_ja'];
 
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

