<?php

// カスタムフィールドの追加
add_action( 'admin_menu', 'add_custom_field' );
function add_custom_field() {
    add_meta_box( 'summary', 'まとめタイトル（英語／日本語）', 'create_summary', 'post', 'normal' );
    add_meta_box( 'summary', 'まとめタイトル（英語／日本語）', 'create_summary', 'page', 'normal' );
    add_meta_box( 'is_summary', 'まとめ記事オプション', 'create_is_summary', 'post', 'normal' );
    add_meta_box( 'is_summary', 'まとめ記事オプション', 'create_is_summary', 'page', 'normal' );
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

function create_is_summary() {
    $key = 'is_summary_gender';
    $get_value = get_post_meta( $post->ID, $key, true );
    if($get_value == "men"){
        $men_is_selected = 'selected';
    }else if($get_value == "women"){
        $women_is_selected = 'selected';
    }
        wp_nonce_field( 'action-' . $key, 'nonce-' . $key );
    echo '<div><strong>まとめ一覧テンプレートの場合、表示する商品性別：</strong><select name="' . $key . '">';
    echo '<option value="men" '.$men_is_selected.'>MEN</option>';
    echo '<option value="women"'.$women_is_selected.'>WOMEN</option>';
    echo '</select></div><br>';

    $key = 'is_summary';
    $placeholder = 'まとめ記事に属するページの場合はチェック';
    global $post;
    // 保存されているカスタムフィールドの値を取得
    $get_value = get_post_meta( $post->ID, $key, true );
    // nonceの追加
    wp_nonce_field( 'action-' . $key, 'nonce-' . $key );
    // HTMLの出力
    if($get_value){
        $is_checked = 'checked';
    }
    echo '<input type="checkbox" name="' . $key . '" '.$is_checked.' value="1" style=""> <strong>まとめ一覧に属する記事の場合はチェック</strong><br>';

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
    $custom_fields = ['まとめ英語タイトル','まとめ日本語タイトル','楽天', 'Yahoo', 'Amazon','is_summary','is_summary_gender'];
 
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


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_604ac1888d8e9',
        'title' => 'TOPスライダーオプション',
        'fields' => array(
            array(
                'key' => 'field_604ac5a780cc2',
                'label' => 'リンク',
                'name' => 'link',
                'type' => 'page_link',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => '',
                'taxonomy' => '',
                'allow_null' => 0,
                'allow_archives' => 1,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_604ac1e9cfa54',
                'label' => 'オーバーフロー表示位置',
                'name' => 'overflow_position',
                'type' => 'radio',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'static' => '中央',
                    'left_top' => '左',
                    'right_top' => '右',
                ),
                'allow_null' => 1,
                'other_choice' => 0,
                'default_value' => 'static',
                'layout' => 'horizontal',
                'return_format' => 'value',
                'save_other_choice' => 0,
            ),
            array(
                'key' => 'field_604ad60c0bddc',
                'label' => 'HTML/画像表示選択',
                'name' => 'overflow_or_html',
                'type' => 'radio',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'html' => 'HTML（エディタのものを反映）',
                    'overflow' => 'オーバーフロー画像（下のオーバーフロー画像を反映）',
                ),
                'allow_null' => 0,
                'other_choice' => 0,
                'default_value' => 'overflow',
                'layout' => 'horizontal',
                'return_format' => 'value',
                'save_other_choice' => 0,
            ),
            array(
                'key' => 'field_604ac297cfa55',
                'label' => 'オーバーフロー画像',
                'name' => 'overflow_img',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_604ad60c0bddc',
                            'operator' => '==',
                            'value' => 'overflow',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'full',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_604ac2fef636b',
                'label' => 'スライダー画像',
                'name' => 'slider_img',
                'type' => 'image',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'full',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'topfeature',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;