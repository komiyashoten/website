<?php

class XO_Event_Calendar_Admin {
	private $parent;

	function __construct( $parent ) {
		$this->parent = $parent;
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	function plugins_loaded() {
		$post_type_name = XO_Event_Calendar::get_post_type();
		$taxonomy_name = XO_Event_Calendar::get_taxonomy_type();

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );

		add_filter( "manage_edit-{$taxonomy_name}_columns", array( $this, 'category_columns' ) );
		add_filter( "manage_{$taxonomy_name}_custom_column", array ( $this, 'category_custom_column' ), 10, 3 );
		add_action( "{$taxonomy_name}_add_form_fields", array( $this, 'category_add_form_fields' ) );
		add_action( "{$taxonomy_name}_edit_form_fields", array( $this, 'category_edit_form_fields' ) );
		add_action( "edited_{$taxonomy_name}", array( $this, 'save_category' ) );
		add_action( "created_{$taxonomy_name}", array( $this, 'save_category' ) );
		add_action( "delete_{$taxonomy_name}", array( $this, 'delete_category' ) );

		add_filter( "manage_edit-{$post_type_name}_columns", array( $this, 'event_columns' ) );
		add_action( "manage_{$post_type_name}_posts_custom_column", array( $this, 'event_custom_column' ), 10, 2 );

		add_action( "add_meta_boxes_{$post_type_name}", array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_option_settings' ) );
	}

	/**
	 * 管理画面のスタイルおよびスクリプトをロードします。
	 */
	function admin_enqueue_scripts() {
		global $is_safari, $is_IE;

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'xo-event-calendar-admin', XO_EVENT_CALENDAR_URL . 'css/admin.css', array(), XO_EVENT_CALENDAR_VERSION);

		wp_enqueue_script( 'xo-event-calendar-admin',  XO_EVENT_CALENDAR_URL . 'js/admin.js', array( 'wp-color-picker' ), XO_EVENT_CALENDAR_VERSION, true );

		if ( ! isset( $this->parent->options['disable_datepicker'] ) || ! $this->parent->options['disable_datepicker']  ) {
			if ( ( !wp_is_mobile() && $is_safari ) || $is_IE ) {
				// Safari および IE はブラウザが日付のカレンダー入力に対応していないので、jQuery UI datepicker を使用する。
				wp_enqueue_style( 'jquery-ui', XO_EVENT_CALENDAR_URL . 'jquery-ui/jquery-ui.min.css' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'jquery-ui-datepicker-ja', XO_EVENT_CALENDAR_URL . 'jquery-ui/datepicker-ja.js', array( 'jquery-ui-datepicker' ), false, true );
				wp_enqueue_script( 'xo-event-calendar-editor-datepicker', XO_EVENT_CALENDAR_URL . 'js/editor-datepicker.js', array( 'jquery-ui-datepicker' ), XO_EVENT_CALENDAR_VERSION, true );
			}
		}
	}

	/**
	 * イベント カスタム投稿タイプのメッセージを変更します。
	 */
	function post_updated_messages( $messages ) {
		$post = get_post();
		$post_type = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		$post_type_name = XO_Event_Calendar::get_post_type();

		$messages[$post_type_name] = array(
			0 => '',
			1 => __( 'Event updated.', 'xo-event-calendar' ),
			2 => __( 'Custom field updated.', 'xo-event-calendar' ),
			3 => __( 'Custom field deleted.', 'xo-event-calendar' ),
			4 => __( 'Event updated.', 'xo-event-calendar' ),
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s.', 'xo-event-calendar' ), wp_post_revision_title( (int)$_GET['revision'], false ) ) : false,
			6 => __( 'Event published.', 'xo-event-calendar' ),
			7 => __( 'Event saved.', 'xo-event-calendar' ),
			8 => __( 'Event submitted.', 'xo-event-calendar' ),
			9 => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>.', 'xo-event-calendar' ), date_i18n( __( 'M j, Y @ G:i', 'xo-event-calendar' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Event draft updated.', 'xo-event-calendar' ),
		);

		return $messages;
	}

	/**
	 * カテゴリー リストの項目を設定します。
	 */
	function category_columns( $columns ) {
		$offset = array_search( 'posts', array_keys( $columns ) );
		return array_merge(
			array_slice( $columns, 0, $offset ),
			array( 'color' => __( 'Color', 'xo-event-calendar' ) ),
			array_slice( $columns, $offset, null )
		);
	}

	/**
	 * カテゴリー リストの項目を表示します。
	 */
	function category_custom_column( $html, $column, $term_id ) {
		if ( $column == 'color' ) {
			$cat_options = get_option( 'xo_event_calendar_cat_' . $term_id );
			$color = !empty( $cat_options['category_color'] ) ? esc_html( $cat_options['category_color'] ) : '#ffffff';
			$hsv = XO_Color::getHsv( XO_Color::getRgb( $color ) );
			$html = sprintf( '<p><div style="width: 4.0rem; color: %s; border: 1px solid #ddd; background-color: %s; text-align: center; padding: 2px;"><span>%s</span></div></p>',
						( $hsv['v'] > 0.9 ? '#333' : '#eee'), esc_attr( $color ), $color );
		}
		return $html;
	}

	function category_add_form_fields( $taxonomy ) {
		$color_table = array( '#33a02c', '#4573b3', '#cccc00', '#9e49a1', '#0099ca', '#cc0000', '#fe9f34' );
		$color = $color_table[0];
		$terms = get_terms( $taxonomy, array( 'hide_empty' => false ) );
		if ( $terms ) {
			$color_table_index = count( $terms ) % count( $color_table );
			$color = $color_table[$color_table_index];
		}
		echo '<div class="form-field term-category-color-wrap">';
		echo '<label for="tag-category-color">' . __( 'Color', 'xo-event-calendar' ) . '</label>';
		echo '<input id="category_color" class="c-picker" type="text" name="cat_meta[category_color]" value="' . $color . '" />';
		echo '</div>' . "\n";
	}

	function category_edit_form_fields( $term ) {
		$term_id = $term->term_id;
		$cat_options = get_option( 'xo_event_calendar_cat_' . $term_id );
		echo '<tr class="form-field term-category-color-wrap">';
		echo '<th scope="row"><label for="category_color">' . __( 'Color', 'xo-event-calendar' ) . '</label></th>';
		echo '<td><input id="category_color" class="c-picker" type="text" name="cat_meta[category_color]" value="' . $cat_options['category_color'] . '" />';
		echo '</tr>' . "\n";
	}

	function save_category( $term_id ) {
		if ( isset( $_POST['cat_meta'] ) ) {
			$cat_keys = array_keys( $_POST['cat_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset( $_POST['cat_meta'][$key] ) ) {
					$cat_meta[$key] = $_POST['cat_meta'][$key];
				}
			}
			update_option( 'xo_event_calendar_cat_' .$term_id, $cat_meta );
		}
	}

	function delete_category( $term_id ) {
		delete_option( 'xo_event_calendar_cat_' . $term_id );
	}

	/**
	 * イベント リストの項目を設定します
	 */
	function event_columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => _x( 'Title', 'column name', 'xo-event-calendar' ),
			'datestart' => __( 'Start Date', 'xo-event-calendar' ),
			'dateend' => __( 'End Date', 'xo-event-calendar' ),
			'category' => __( 'Category', 'xo-event-calendar' ),
			'author' => __( 'Author', 'xo-event-calendar' ),
			'date' => __( 'Date', 'xo-event-calendar' )
		);
		return $columns;
	}

	/**
	 * イベント リストの項目を表示します。
	 */
	function event_custom_column( $column_name, $post_id ) {
		if( $column_name == 'datestart' ) {
			$d = get_post_meta( $post_id, 'event_start_date', true );
			if ( !empty( $d ) ) {
				$d = date( 'Y/m/d', strtotime( $d ) );
				$allday = (bool)get_post_meta( $post_id, 'event_all_day', true );
				if ( !$allday ) {
					$h = get_post_meta( $post_id, 'event_start_hour', true );
					$m = get_post_meta( $post_id, 'event_start_minute', true );
					echo esc_attr( sprintf( '%s %d:%02d', $d, $h, $m ) );
				} else {
					echo esc_attr( $d );
				}
			}
		} elseif( $column_name == 'dateend' ) {
			$d = get_post_meta( $post_id, 'event_end_date', true );
			if ( !empty( $d ) ) {
				$d = date( 'Y/m/d', strtotime( $d ) );
				$allday = (bool)get_post_meta( $post_id, 'event_all_day', true );
				if ( !$allday ) {
					$h = get_post_meta( $post_id, 'event_end_hour', true );
					$m = get_post_meta( $post_id, 'event_end_minute', true );
					echo esc_attr( sprintf( '%s %d:%02d', $d, $h, $m ) );
				} else {
					echo esc_attr( $d );
				}
			}
		} elseif ( $column_name == 'category' ) {
			$cats = get_the_terms( $post_id, XO_Event_Calendar::get_taxonomy_type() );
			if ( $cats && count( $cats ) > 0 )
				echo $cats[0]->name;
		}
	}

	/**
	 * イベント メタボックスを追加します。
	 */
	function add_meta_boxes() {
		add_meta_box( 'xo-event-meta-box', __( 'Event Details', 'xo-event-calendar' ), array( $this, 'event_meta_box' ), XO_Event_Calendar::get_post_type(), 'advanced' );
	}

	private function get_select_hour( $id, $name, $selected ) {
		$html = "<select id=\"{$id}\" name=\"{$name}\">";
		for ( $i = 0; $i < 24; $i++ ) {
			$html .= sprintf( '<option %s value="%d">%d</option>', ($i == $selected ? 'selected' : ''), $i, $i);
		}
		$html .= "</select>\n";
		return $html;
	}

	private function get_select_minute( $id, $name, $selected ) {
		$html = "<select id=\"{$id}\" name=\"{$name}\">";
		for ( $i = 0; $i < 60; $i += 5 ) {
			$html .= sprintf( '<option %s value="%d">%02d</option>', ($i == $selected ? 'selected' : ''), $i, $i);
		}
		$html .= "</select>\n";
		return $html;
	}

	/**
	 * イベント メタ ボックスを表示します。
	 */
	function event_meta_box() {
		global $post;

		$custom = get_post_custom( $post->ID );
		if ( empty( $custom ) ) {
			$start_date = ''; //date_i18n( 'Y-m-d' );
			$start_hour = '';
			$start_minute = '';
			$end_date = '';
			$end_hour = '';
			$end_minute = '';
			$all_day = true;
			$short_title = '';
		} else {
			$start_date = isset( $custom["event_start_date"][0] ) ? date( 'Y-m-d', strtotime( $custom["event_start_date"][0] ) ) : date_i18n( 'Y-m-d' );
			$start_hour = isset( $custom["event_start_hour"][0] ) ? $custom["event_start_hour"][0] : '';
			$start_minute = isset( $custom["event_start_minute"][0] ) ? $custom["event_start_minute"][0] : '';
			$end_date = isset( $custom["event_end_date"][0] ) ? date( 'Y-m-d', strtotime( $custom["event_end_date"][0] ) ) : '';
			$end_hour = isset( $custom["event_end_hour"][0] ) ? $custom["event_end_hour"][0] : '';
			$end_minute = isset( $custom["event_end_minute"][0] ) ? $custom["event_end_minute"][0] : '';
			$all_day = isset( $custom["event_all_day"][0] ) ? $custom["event_all_day"][0] : true;
			$short_title = isset( $custom["short_title"][0] ) ? $custom["short_title"][0] : '';
		}

		wp_nonce_field( 'xo_event_calendar_meta_box_data', 'xo_event_calendar_meta_box_nonce' );
		?>
		<table class="xo-event-calendar-meta-box-table">
			<tr>
				<th nowrap><?php _e( 'Start Date/Time', 'xo-event-calendar' ); ?></th>
				<td>
					<input id="event_start_date" name="event_start_date" class="datepicker" type="date" value="<?php echo $start_date; ?>" /> @ 
					<?php echo $this->get_select_hour( 'event_start_hour', 'event_start_hour', $start_hour ); ?>:
					<?php echo $this->get_select_minute( 'event_start_minute', 'event_start_minute', $start_minute ); ?> 
					<input id="event_all_day" name="event_all_day" type="checkbox" value="1"<?php echo ( $all_day ? ' checked' : '' ); ?> /><label for="event_all_day"><?php _e( 'All Day', 'xo-event-calendar' ); ?></label>
				</td>
			</tr>
			<tr>
				<th nowrap><?php _e( 'End Date/Time', 'xo-event-calendar' ); ?></th>
				<td>
					<input id="event_end_date" name="event_end_date" class="datepicker" type="date" value="<?php echo $end_date; ?>" /> @ 
					<?php echo $this->get_select_hour( 'event_end_hour', 'event_end_hour', $end_hour ); ?>:
					<?php echo $this->get_select_minute( 'event_end_minute', 'event_end_minute', $end_minute ); ?>
				</td>
			</tr>
			<tr>
				<th nowrap><?php _e( 'Short Title', 'xo-event-calendar' ); ?></th>
				<td><input id="short_title" name="short_title" type="text" size="20" value="<?php echo $short_title; ?>" /></td>
			</tr>
		</table>
		<?php

		// 日付セレクト コントロールの幅が狭くなる不具合(?)対策
		echo '<style type="text/css">.media-frame select.attachment-filters { min-width: 102px; }</style>';
	}

	/**
	 * イベント メタ ボックスの値を保存します。
	 */
	function save_post( $post_id ) {
		// 対象のフォームのから送られてきたかどうかチェックする
		if ( ! isset( $_POST['xo_event_calendar_meta_box_nonce'] ) ) {
			return;
		}
		if ( !wp_verify_nonce( $_POST['xo_event_calendar_meta_box_nonce'], 'xo_event_calendar_meta_box_data' ) ) {
			return $post_id;
		}
		// 自動保存ルーチンかどうかチェック。そうだった場合はフォームを送信しない（何もしない）
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$start_date = isset( $_POST['event_start_date'] ) ? sanitize_text_field( $_POST['event_start_date'] ) : null;
		$start_hour = isset( $_POST['event_start_hour'] ) ? sanitize_text_field( $_POST['event_start_hour'] ) : null;
		$start_minute = isset( $_POST['event_start_minute'] ) ? sanitize_text_field( $_POST['event_start_minute'] ) : null;
		$end_date = isset( $_POST['event_end_date'] ) ? sanitize_text_field( $_POST['event_end_date'] ) : $start_date;
		$end_hour = isset( $_POST['event_end_hour'] ) ? sanitize_text_field( $_POST['event_end_hour'] ) : null;
		$end_minute = isset( $_POST['event_end_minute'] ) ? sanitize_text_field( $_POST['event_end_minute'] ) : null;
		$all_day = isset( $_POST['event_all_day'] );
		$short_title = isset( $_POST['short_title'] ) ? sanitize_text_field( $_POST['short_title'] ) : null;
		
		if ( empty( $end_date ) ) $end_date = $start_date;

		update_post_meta( $post_id, 'event_start_date', $start_date );
		update_post_meta( $post_id, 'event_start_hour', $start_hour );
		update_post_meta( $post_id, 'event_start_minute', $start_minute );
		update_post_meta( $post_id, 'event_end_date', $end_date );
		update_post_meta( $post_id, 'event_end_hour', $end_hour );
		update_post_meta( $post_id, 'event_end_minute', $end_minute );
		update_post_meta( $post_id, 'event_all_day', $all_day );
		update_post_meta( $post_id, 'short_title', $short_title );
	}

	/**
	 * メニューを追加します。
	 */
	function add_menu() {
		$post_type_name = XO_Event_Calendar::get_post_type();

		$holiday_settings_page = add_submenu_page( "edit.php?post_type={$post_type_name}", 'Holiday Settings', __( 'Holiday Settings', 'xo-event-calendar' ), XO_EVENT_CALENDAR_HOLIDAY_SETTING_CAPABILITY, 'xo-event-holiday-settings', array( $this, 'holiday_settings_page' ) );
		add_action( "load-{$holiday_settings_page}", array( $this, 'add_holiday_settings_page_tabs' ) );

		$option_settings_page = add_submenu_page( "edit.php?post_type={$post_type_name}", 'Option Settings', __( 'Option', 'xo-event-calendar' ), 'manage_options', 'xo-event-option-settings', array( $this, 'option_settings_page' ) );
		add_action( "load-{$option_settings_page}", array( $this, 'add_option_settings_page_tabs' ) );
	}

	/**
	 * 休日設定ページにタブを追加します。
	 */
	function add_holiday_settings_page_tabs() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
			'id' => 'holiday-settings-help',
			'title' => __( 'Overview', 'xo-event-calendar' ),
			'content' =>
				'<p>' . __( 'This screen is used to manage the holiday.', 'xo-event-calendar' ). '</p>'
		) );
	}

	/**
	 * オプション設定ページにタブを追加します。
	 */
	function add_option_settings_page_tabs() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
			'id' => 'option-settings-help',
			'title' => __( 'Overview', 'xo-event-calendar' ),
			'content' =>
				'<p>' . __( 'This screen is used to set options.', 'xo-event-calendar' ). '</p>'
		) );
	}

	function sanitize_date_list( $date_list ) {
		$datas = explode( "\n", $date_list );
		$result = '';
		foreach ( $datas as $data ) {
			if ( ( $time = strtotime( $data ) ) ) {
				$result .= date( 'Y-m-d', $time ) . "\n";
			}
		}
		return $result;
	}

	function sanitize_color( $color ) {
		if ( '' === $color )
			return '';
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
			return $color;
		return null;
	}

	/**
	 * Display holiday setting page.
	 *
	 * @since 1.0.0
	 */
	function holiday_settings_page() {
		$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'select';
		$selected_name = isset( $_REQUEST['selected-name'] ) ? $_REQUEST['selected-name'] : null;

		$holiday_settings = get_option( 'xo_event_calendar_holiday_settings' );
		if ( !is_array( $holiday_settings ) )
			$holiday_settings = array();

		$messages = array();

		switch ( $action ) {
			case 'new':
				$selected_name = null;
				break;
			case 'select':
				if ( empty( $selected_name ) ) {
					$selected_name = key( array_slice( $holiday_settings, 0, 1 ) );
				}
				break;
			case 'delete':
				unset( $holiday_settings[$selected_name] );
				check_admin_referer( 'delete-history' );
				update_option( 'xo_event_calendar_holiday_settings', $holiday_settings );
				$messages[] = '<div id="message" class="updated notice is-dismissible"><p>' . __( 'The holiday item has been successfully deleted.', 'xo-event-calendar' ) . '</p></div>';
				if ( count( $holiday_settings ) >= 1 ) {
					reset( $holiday_settings );
					$selected_name = key( $holiday_settings );
				} else {
					$selected_name = null;
				}
				break;
			case 'append':
				$name = isset( $_REQUEST['name'] ) ? preg_replace( "/[^a-z0-9\-]/", "", strtolower( $_REQUEST['name'] ) ) : null;
				if ( empty( $name ) ) {
					$messages[] = '<div id="message" class="error notice is-dismissible"><p>' . __( 'Please enter a valid holiday name.', 'xo-event-calendar' ) . '</p></div>';
				} else {
					$holiday_settings[$name] = array(
						'title' => __( 'Regular holiday', 'xo-event-calendar' ),
						'dayofweek' => array( 'sun' => false, 'mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false ),
						'special_holiday' => null,
						'non_holiday' => null,
						'color' => '#fddde6'
					);
					$selected_name = $name;
					check_admin_referer( 'xo_event_calendar_holiday_settings' );
					update_option( 'xo_event_calendar_holiday_settings', $holiday_settings );
				}
				break;
			case 'update':
				$name = isset( $_REQUEST['name'] ) ? preg_replace( "/[^a-z0-9\-]/", "", strtolower( $_REQUEST['name'] ) ) : null;
				$title = isset( $_REQUEST['title'] ) ? sanitize_text_field( $_REQUEST['title'] ) : null;
				$dayofweek = isset( $_REQUEST['dayofweek'] ) ? $_REQUEST['dayofweek'] : array();
				$non_holiday = isset( $_REQUEST['non-holiday'] ) ? $this->sanitize_date_list( $_REQUEST['non-holiday'] ) : null;
				$special_holiday = isset( $_REQUEST['special-holiday'] ) ? $this->sanitize_date_list( $_REQUEST['special-holiday'] ) : null;
				$color = isset( $_REQUEST['color'] ) ? $this->sanitize_color( $_REQUEST['color'] ) : null;
				
				if ( empty( $name ) ) {
					$messages[] = '<div id="message" class="error notice is-dismissible"><p>' . __( 'Please enter a valid holiday name.', 'xo-event-calendar' ) . '</p></div>';
				} else {
					if ( $selected_name !== $name ) {
						unset( $holiday_settings[$selected_name] );
						$selected_name = $name;
					}
					$holiday_settings[$name] = array(
						'title' => $title,
						'dayofweek' => array(
							'sun' => isset( $dayofweek['sun'] ),
							'mon' => isset( $dayofweek['mon'] ),
							'tue' => isset( $dayofweek['tue'] ),
							'wed' => isset( $dayofweek['wed'] ),
							'thu' => isset( $dayofweek['thu'] ),
							'fri' => isset( $dayofweek['fri'] ),
							'sat' => isset( $dayofweek['sat'] )
						),
						'non_holiday' => $non_holiday,
						'special_holiday' => $special_holiday,
						'color' => $color
					);
					check_admin_referer( 'xo_event_calendar_holiday_settings' );
					update_option( 'xo_event_calendar_holiday_settings', $holiday_settings );
					$messages[] = '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Save Holiday', 'xo-event-calendar' ) . '</p></div>';
				}
				break;
		}

		if ( !empty( $selected_name ) ) {
			$title = isset( $holiday_settings[$selected_name]['title'] ) ? $holiday_settings[$selected_name]['title'] : null;
			$dayofweek = isset( $holiday_settings[$selected_name]['dayofweek'] ) ? $holiday_settings[$selected_name]['dayofweek'] : array();
			$non_holiday = isset( $holiday_settings[$selected_name]['non_holiday'] ) ? $holiday_settings[$selected_name]['non_holiday'] : null;
			$special_holiday = isset( $holiday_settings[$selected_name]['special_holiday'] ) ? $holiday_settings[$selected_name]['special_holiday'] : null;
			$color = isset( $holiday_settings[$selected_name]['color'] ) ? $holiday_settings[$selected_name]['color'] : null;
		}
		$add_new = empty( $selected_name ) ? true : false;

		echo '<div class="wrap">';
		echo '<h1>' . __( 'Holiday Settings', 'xo-event-calendar' ) . '</h1>';
		foreach ( $messages as $_message ) {
			echo $_message . "\n";
		}
		?>
			<div id="xo-event-name">
				<?php if ( count( $holiday_settings ) < 2 ) : ?>
					<span class="add-edit-action">
					<?php printf( __( 'Edit your holiday below, or <a href="%s">create a new holiday</a>.', 'xo-event-calendar' ), esc_url( add_query_arg( array( 'action' => 'new' ) ) ) ); ?>
					</span>
				<?php else : ?>
					<form method="get">
						<input type="hidden" name="post_type" value="<?php echo XO_Event_Calendar::get_post_type(); ?>" />
						<input type="hidden" name="page" value="xo-event-holiday-settings" />
						<input type="hidden" name="action" value="select" >
						<label for="select-name-to-edit" class="select-name-label"><?php _e( 'Select a holiday to edit:', 'xo-event-calendar' ); ?></label>
						<select name="selected-name" id="select-name-to-edit">
						<?php if ( $add_new ) : ?>
							<option value="0" selected="selected"><?php _e( '&mdash; Select &mdash;', 'xo-event-calendar' ) ?></option>
						<?php endif; ?>
						<?php foreach ( (array)$holiday_settings as $key => $val ): ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $selected_name ); ?>>
								<?php echo esc_html( !empty( $val['label'] ) ? $val['label'] : $key ); ?>
							</option>
						<?php endforeach; ?>
						</select>
						<span class="submit-btn"><input type="submit" class="button-secondary" value="<?php esc_attr_e( 'Select', 'xo-event-calendar' ); ?>"></span>
						<span class="add-new-name-action">
						<?php printf( __( 'or <a href="%s">create a new holiday</a>.', 'xo-event-calendar' ), esc_url( add_query_arg( array( 'action' => 'new' ) ) ) ); ?>
						</span>
					</form>
				<?php endif; ?>
			</div>
			<div id="xo-event-holiday-setting">
				<form id="update-holiday" method="post" enctype="multipart/form-data">
					<?php wp_nonce_field( 'xo_event_calendar_holiday_settings' ); ?>
					<input type="hidden" name="selected-name" value="<?php echo $selected_name; ?>" />
					<input type="hidden" name="action" value="<?php echo $add_new ? 'append' : 'update'; ?>" />
					<div class="holiday-edit">
						<div id="xo-event-holiday-setting-header">
							<div class="major-publishing-actions">
								<label class="name-label" for="name">
									<span><?php _e( 'Holiday Name', 'xo-event-calendar' ); ?></span>
									<input name="name" id="name" type="text" class="regular-text name-input" title="<?php esc_attr_e( 'Enter holiday name here', 'xo-event-calendar' ); ?>" value="<?php echo esc_attr( $selected_name ); ?>" maxlength="20" />
								</label>
								<span class="name-description"><?php _e( '&#8251; Lower case letters, digits, and hyphens only', 'xo-event-calendar' ); ?></span>
								<div class="publishing-action">
								<?php submit_button( empty( $selected_name ) ? __( 'Create Holiday', 'xo-event-calendar' ) : __( 'Save Holiday', 'xo-event-calendar' ), 'button-primary', 'submit', false, array( 'id' => 'submit-holiday' ) ); ?>
								</div>
							</div>
						</div>
						<div id="xo-event-holiday-setting-body">
						<?php if ( $add_new ) : ?>
							<p class="holiday-body-plain"><?php _e( 'Give your holiday a name above, then click Create Holiday.', 'xo-event-calendar' ); ?></p>
						<?php else: ?>
							<h3><?php _e( 'Holiday item', 'xo-event-calendar' ); ?></h3>
							<dl>
								<dt><?php _e( 'Title', 'xo-event-calendar' ); ?></dt>
								<dd>
									<input name="title" id="title" class="regular-text" value="<?php echo $title; ?>" type="text">
								</dd>
							</dl>
							<dl>
								<dt><?php _e( 'Regular weekly', 'xo-event-calendar' ); ?></dt>
								<dd>
									<label for="dayofweek[sun]"><input type="checkbox" id="dayofweek[sun]" name="dayofweek[sun]" value="1"<?php checked( $dayofweek['sun'] ); ?>><?php _e( 'Sunday', 'xo-event-calendar' ); ?></label>
									<label for="dayofweek[mon]"><input type="checkbox" id="dayofweek[mon]" name="dayofweek[mon]" value="1"<?php checked( $dayofweek['mon'] ); ?>><?php _e( 'Monday', 'xo-event-calendar' ); ?></label>
									<label for="dayofweek[tue]"><input type="checkbox" id="dayofweek[tue]" name="dayofweek[tue]" value="1"<?php checked( $dayofweek['tue'] ); ?>><?php _e( 'Tuesday', 'xo-event-calendar' ); ?></label>
									<label for="dayofweek[wed]"><input type="checkbox" id="dayofweek[wed]" name="dayofweek[wed]" value="1"<?php checked( $dayofweek['wed'] ); ?>><?php _e( 'Wednesday', 'xo-event-calendar' ); ?></label>
									<label for="dayofweek[thu]"><input type="checkbox" id="dayofweek[thu]" name="dayofweek[thu]" value="1"<?php checked( $dayofweek['thu'] ); ?>><?php _e( 'Thursday', 'xo-event-calendar' ); ?></label>
									<label for="dayofweek[fri]"><input type="checkbox" id="dayofweek[fri]" name="dayofweek[fri]" value="1"<?php checked( $dayofweek['fri'] ); ?>><?php _e( 'Friday', 'xo-event-calendar' ); ?></label>
									<label for="dayofweek[sat]"><input type="checkbox" id="dayofweek[sat]" name="dayofweek[sat]" value="1"<?php checked( $dayofweek['sat'] ); ?>><?php _e( 'Saturday', 'xo-event-calendar' ); ?></label>
								</dd>
							</dl>
							<dl>
								<dt><?php _e( 'Extraordinary dates', 'xo-event-calendar' ); ?></dt>
								<dd>
									<textarea name="special-holiday" id="special-holiday" rows="6" cols="20"><?php echo esc_textarea( $special_holiday ); ?></textarea>
									<p class="description"><?php _e( 'One date on one line.', 'xo-event-calendar' ); ?></p>
								</dd>
							</dl>
							<dl>
								<dt><?php _e( 'Cancel dates', 'xo-event-calendar' ); ?></dt>
								<dd>
									<textarea name="non-holiday" id="non-holiday" rows="6" cols="20"><?php echo esc_textarea( $non_holiday ); ?></textarea>
									<p class="description"><?php _e( 'One date on one line.', 'xo-event-calendar' ); ?></p>
								</dd>
							</dl>
							<dl>
								<dt><?php _e( 'Color', 'xo-event-calendar' ); ?></dt>
								<dd>
									<input id="color" class="c-picker" type="text" name="color" value="<?php echo esc_html( $color ) ?>" />
								</dd>
							</dl>
						<?php endif; ?>
						</div>
						<div id="xo-event-holiday-setting-footer">
							<div class="major-publishing-actions">
							<?php if ( 0 != count( $holiday_settings ) && !$add_new ) : ?>
								<span class="delete-action">
								<?php
									$href = esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'selected-name' => $selected_name, 'page' => 'xo-event-holiday-settings', 'post_type' => XO_Event_Calendar::get_post_type() ) ), 'delete-history' ) );
									$onclick = "if(confirm('" . __( "You are about to permanently delete this holiday.\\n \'Cancel\' to stop, \'OK\' to delete.", 'xo-event-calendar' ) . "')){ return true; } return false;";
								?>
									<a class="submitdelete deletion" href="<?php echo $href; ?>" onclick="<?php echo $onclick; ?>"><?php _e( 'Delete Holiday', 'xo-event-calendar' ); ?></a>
								</span>
							<?php endif; ?>
								<div class="publishing-action">
								<?php submit_button( empty( $selected_name ) ? __( 'Create Holiday', 'xo-event-calendar' ) : __( 'Save Holiday', 'xo-event-calendar' ), 'button-primary', 'submit', false, array( 'id' => 'submit-holiday' ) ); ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		<?php
	}

	/**
	 * Display option setting page.
	 *
	 * @since 1.8.0
	 */
	function option_settings_page() {
		echo '<div class="wrap">';
		echo '<h1>' . __( 'Option Settings', 'xo-event-calendar' ) . '</h1>';
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {
			echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">';
			echo '<p><strong>' . __( 'Settings saved.', 'xo-event-calendar' ) . '</strong></p>';
			echo '</div>';
		}
		echo '<div id="xo-event-option-settings">';
		echo '<form method="post" action="options.php">';
		settings_fields( 'xo_event_calendar_option_group' );
		do_settings_sections( 'xo_event_calendar_option_group' );
		submit_button();
		echo '</form>';
		echo "</div>\n";
	}

	/**
	 * Register option settings.
	 *
	 * @since 1.8.0
	 */
	function register_option_settings() {
		register_setting( 'xo_event_calendar_option_group', 'xo_event_calendar_options', array( $this, 'sanitize_option_settings' ) );
		add_settings_section( 'xo_event_calendar_option_generic_section', '', '__return_empty_string', 'xo_event_calendar_option_group' );
		add_settings_field( 'disable_datepicker', __( 'jQuery UI Datepicker', 'xo-event-calendar' ), array( $this, 'field_disable_datepicker' ), 'xo_event_calendar_option_group', 'xo_event_calendar_option_generic_section' );
		add_settings_field( 'disable_calendar', __( 'Calendar', 'xo-event-calendar' ), array( $this, 'field_calendar' ), 'xo_event_calendar_option_group', 'xo_event_calendar_option_generic_section' );
	}

	/**
	 * Register disable datepicker field.
	 *
	 * @since 1.8.0
	 */
	function field_disable_datepicker() {
		$check = isset( $this->parent->options['disable_datepicker'] ) ? $this->parent->options['disable_datepicker'] : false;
		echo '<fieldset>';
		echo '<label for="disable_datepicker"><input id="disable_datepicker" name="xo_event_calendar_options[disable_datepicker]" type="checkbox" value="1" class="code" ' . checked( 1, $check, false ) . ' /> ' . __( 'Do not use jQuery UI Datepicker', 'xo-event-calendar' ) . '</label>';
		echo '</fieldset>';
	}

	/**
	 * Register calendar field.
	 *
	 * @since 1.8.0
	 */
	function field_calendar() {
		$disable_dashicons = isset( $this->parent->options['disable_dashicons'] ) ? $this->parent->options['disable_dashicons'] : false;
		$disable_event_link = isset( $this->parent->options['disable_event_link'] ) ? $this->parent->options['disable_event_link'] : false;
		echo '<fieldset>';
		echo '<label for="disable_dashicons"><input id="disable_dashicons" name="xo_event_calendar_options[disable_dashicons]" type="checkbox" value="1" class="code" ' . checked( 1, $disable_dashicons, false ) . ' /> ' . __( 'Do not use Dashicons font', 'xo-event-calendar' ) . '</label>';
		echo '<br />';
		echo '<label for="disable_event_link"><input id="disable_event_link" name="xo_event_calendar_options[disable_event_link]" type="checkbox" value="1" class="code" ' . checked( 1, $disable_event_link, false ) . ' /> ' . __( 'Disable event link', 'xo-event-calendar' ) . '</label>';
		echo '</fieldset>';
	}

	/**
	 * Sanitize option settings.
	 *
	 * @since 1.8.0
	 */
	function sanitize_option_settings( $input ) {
		$input['disable_datepicker'] = isset( $input['disable_datepicker'] ) ? $input['disable_datepicker'] : false;
		$input['disable_dashicons'] = isset( $input['disable_dashicons'] ) ? $input['disable_dashicons'] : false;
		$input['disable_event_link'] = isset( $input['disable_event_link'] ) ? $input['disable_event_link'] : false;
		return $input;
	}
}
