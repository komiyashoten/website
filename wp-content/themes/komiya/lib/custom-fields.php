<?php

// カスタムフィールドの追加
add_action( 'admin_menu', 'add_custom_field' );
function add_custom_field() {
    add_meta_box( 'summary', 'まとめタイトル（英語／日本語）', 'create_summary', 'post', 'normal' );
    add_meta_box( 'summary', 'まとめタイトル（英語／日本語）', 'create_summary', 'page', 'normal' );
    add_meta_box( 'goodsURLs', '商品URL', 'create_goodsurls', 'product', 'normal' );
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

    acf_add_local_field_group(array(
        'key' => 'group_60626f59ddebb',
        'title' => 'まとめ記事一覧に表示する',
        'fields' => array(
            array(
                'key' => 'field_60626f6b3c2bb',
                'label' => 'まとめ一覧ページに表示するか',
                'name' => 'is_summary',
                'type' => 'checkbox',
                'instructions' => 'まとめ一覧ページに表示する場合はチェック',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    '表示する' => '表示する',
                ),
                'allow_custom' => 0,
                'default_value' => array(
                ),
                'layout' => 'vertical',
                'toggle' => 0,
                'return_format' => 'value',
                'save_custom' => 0,
            ),
            array(
                'key' => 'field_606270b9177ba',
                'label' => '一覧表示する商品性別（まとめ一覧テンプレート使用時のみ有効）',
                'name' => 'summary_gender',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_60626f6b3c2bb',
                            'operator' => '==empty',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'men' => 'メンズ',
                    'women' => 'ウィメンズ',
                ),
                'allow_null' => 0,
                'other_choice' => 0,
                'default_value' => 'men : メンズ',
                'layout' => 'horizontal',
                'return_format' => 'value',
                'save_other_choice' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
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