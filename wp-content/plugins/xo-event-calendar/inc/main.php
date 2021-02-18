<?php

class XO_Event_Calendar {
	public $options;

	/**
	 * Construction.
	 */
	function __construct() {
		$this->options = get_option( 'xo_event_calendar_options', array(
			'disable_datepicker' => false,
			'disable_dashicons' => false,
			'disable_event_link' => false,
		) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	static function get_post_type() {
		return XO_EVENT_CALENDAR_EVENT_POST_TYPE;
	}

	static function get_taxonomy_type() {
		return XO_EVENT_CALENDAR_EVENT_TAXONOMY;
	}

	/**
	 * Plugin deactivation.
	 */
	static function deactivation() {
		$uninstall = array(
			self::get_post_type(),
			self::get_taxonomy_type()
		);
		set_site_transient( 'xo_event_calendar_uninstall_options', $uninstall, MINUTE_IN_SECONDS );
	}

	/**
	 * Plugin activation.
	 */
	public function activation( $network_wide ) {
		if ( is_multisite() && $network_wide  ) {
			$sites = wp_get_sites( array( 'limit' => false ) );
			foreach ( $sites as $site ) {
				switch_to_blog( $site['blog_id'] );
				$this->activation_site();
				restore_current_blog();
			}
		} else {
			$this->activation_site();
		}
	}

	function activation_site() {
		$holiday_settings = get_option( 'xo_event_calendar_holiday_settings' );
		if ( $holiday_settings === false ) {
			$holiday_settings['all'] = array(
				'title' => __( 'Regular holiday', 'xo-event-calendar' ),
				'dayofweek' => array( 'sun' => true, 'mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => true ),
				'special_holiday' => null,
				'non_holiday' => null,
				'color' => '#fddde6'
			);
			$holiday_settings['am'] = array(
				'title' => __( 'Morning Off', 'xo-event-calendar' ),
				'dayofweek' => array( 'sun' => false, 'mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false ),
				'special_holiday' => null,
				'non_holiday' => null,
				'color' => '#dbf6cc'
			);
			$holiday_settings['pm'] = array(
				'title' => __( 'Afternoon Off', 'xo-event-calendar' ),
				'dayofweek' => array( 'sun' => false, 'mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false ),
				'special_holiday' => null,
				'non_holiday' => null,
				'color' => '#def0fc'
			);
			update_option( 'xo_event_calendar_holiday_settings', $holiday_settings );
		}

		$this->register_post_type();
		flush_rewrite_rules();
	}

	function plugins_loaded() {
		$ajax = 'xo_event_calendar_month';

		add_action( 'init',  array( $this, 'register_post_type' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( "wp_ajax_{$ajax}", array( $this, 'ajax' ) );
		add_action( "wp_ajax_nopriv_{$ajax}", array( $this, 'ajax' ) );
		add_shortcode( 'xo_event_calendar', array( $this, 'event_calendar_shortcode' ) );
        add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_filter( 'template_include', array( $this, 'template_include' ) );
	}

	function enqueue_scripts() {
		if ( ! isset( $this->options['disable_dashicons'] ) || ! $this->options['disable_dashicons'] ) {
			wp_enqueue_style( 'dashicons' );
		}
		wp_enqueue_style( 'xo-event-calendar', XO_EVENT_CALENDAR_URL . 'css/xo-event-calendar.css', array(), XO_EVENT_CALENDAR_VERSION );

		wp_enqueue_script( 'xo-event-calendar-ajax', XO_EVENT_CALENDAR_URL . 'js/ajax.js', array(), XO_EVENT_CALENDAR_VERSION );
		wp_localize_script( 'xo-event-calendar-ajax', 'xo_event_calendar_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'action' => 'xo_event_calendar_month'
		) );
	}

	/**
	 * Retrieve the date in localized format, based on timestamp.
	 *
	 * @since 1.7.1
	 *
	 * @param string $dateformatstring Format to display the date.
	 * @param bool|int $unixtimestamp Optional. Unix timestamp. Default false.
	 * @param bool $gmt Optional. Whether to use GMT timezone. Default false.
	 *
	 * @return string The date, translated if locale specifies it.
	 */
	function date( $dateformatstring, $unixtimestamp = false, $gmt = false ) {
		$default_timezone = date_default_timezone_get();
		if ( $default_timezone == 'UTC' ) {
			$result = date_i18n( $dateformatstring, $unixtimestamp, $gmt );
		} else {
			date_default_timezone_set( 'UTC' );
			$result = date_i18n( $dateformatstring, $unixtimestamp, $gmt );
			date_default_timezone_set( $default_timezone );
		}
		return $result;
	}

	/**
	 * Ajax handler for updating the event calendar.
	 */
	function ajax() {
		$id = isset( $_POST['id'] ) ? $_POST['id'] : '';
		$month = isset( $_POST['month'] ) ? $_POST['month'] : '';
		$show_event = isset( $_POST['event'] ) ? (bool)$_POST['event'] : false;
		$categories = isset( $_POST['categories'] ) ? $_POST['categories'] : '';
		$holidays = isset( $_POST['holidays'] ) ? $_POST['holidays'] : '';
		$prev = isset( $_POST['prev'] ) ? intval( $_POST['prev'] ) : -1;
		$next = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : -1;
		$start_of_week = isset( $_POST['start_of_week'] ) ? intval( $_POST['start_of_week'] ) : 0;
		$months = isset( $_POST['months'] ) ? intval( $_POST['months'] ) : 1;
		$navigation = isset( $_POST['navigation'] ) ? (bool)$_POST['navigation'] : false;
		$mhc = isset( $_POST['mhc'] ) ? (bool)$_POST['mhc'] : false;

		preg_match( '/^([0-9]{4})-([0-9]{1,2})/', $month, $matches );
		if ( count( $matches ) === 3 ) {
			$y = $matches[1];
			$m = $matches[2];
			for ( $i = 1; $i <= $months; $i++ ) {
				echo $this->get_month_calendar( array(
					'id' => $id,
					'year' => $y,
					'month' => $m,
					'show_event' => $show_event,
					'categories_string' => $categories,
					'holidays_string' => $holidays,
					'prev_month_feed' => $prev,
					'next_month_feed' => $next,
					'start_of_week' => $start_of_week,
					'months' => $months,
					'navigation' => $navigation,
					'multiple_holiday_classs' => $mhc,
				), $i );
				$next_time = strtotime( '+1 month', strtotime( "{$y}-{$m}-1" ) );
				$y = date( 'Y', $next_time );
				$m = date( 'n', $next_time );
			}
		}
		die();
	}

	function register_post_type() {
		$post_type = $this->get_post_type();
		$args = array(
			'labels' => array(
				'name' => _x( 'Events', 'post type general name', 'xo-event-calendar' ),
				'singular_name' => _x( 'Event', 'post type singular name', 'xo-event-calendar' ),
				'menu_name' => _x( 'Events', 'admin menu', 'xo-event-calendar' ),
				'name_admin_bar' => _x( 'Event', 'add new on admin bar', 'xo-event-calendar' ),
				'add_new' => _x( 'Add New', 'Event', 'xo-event-calendar' ),
				'add_new_item' => __( 'Add New Event', 'xo-event-calendar' ),
				'new_item' => __( 'New Event', 'xo-event-calendar' ),
				'edit_item' => __( 'Edit Event', 'xo-event-calendar' ),
				'view_item' => __( 'View Event', 'xo-event-calendar' ),
				'all_items' => __( 'All Events', 'xo-event-calendar' ),
				'search_items' => __( 'Search Events', 'xo-event-calendar' ),
				'parent_item_colon'  => __( 'Parent Events:', 'xo-event-calendar' ),
				'not_found' => __( 'No Events found.', 'xo-event-calendar' ),
				'not_found_in_trash' => __( 'No Events found in Trash.', 'xo-event-calendar' )
			),
			'public' => true,
			'menu_position' => 4,
			'menu_icon' => 'dashicons-calendar-alt',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'has_archive' => true,
			'show_in_rest' => true,
		);
		$args = apply_filters( 'xo_event_calendar_register_post_args', $args );
		register_post_type( $post_type, $args );

		$taxonomy_type = $this->get_taxonomy_type();
		$args = array(
			'labels' => array(
				'name' => _x( 'Categories', 'taxonomy general name', 'xo-event-calendar' ),
				'singular_name' => _x( 'Category', 'taxonomy singular name', 'xo-event-calendar' ),
				'search_items' => __( 'Search Categories', 'xo-event-calendar' ),
				'all_items' => __( 'All Categories', 'xo-event-calendar' ),
				'parent_item' => __( 'Parent Category', 'xo-event-calendar' ),
				'parent_item_colon' => __( 'Parent Category:', 'xo-event-calendar' ),
				'edit_item' => __( 'Edit Category', 'xo-event-calendar' ),
				'update_item' => __( 'Update Category', 'xo-event-calendar' ),
				'add_new_item' => __( 'Add New Category', 'xo-event-calendar' ),
				'new_item_name' => __( 'New Category Name', 'xo-event-calendar' ),
				'menu_name' => __( 'Category', 'xo-event-calendar' )
			),
			'hierarchical' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $taxonomy_type ),
			'show_in_rest' => true,
		);
		$args = apply_filters( 'xo_event_calendar_register_taxonomy_args', $args );
		register_taxonomy( $taxonomy_type, $post_type, $args );
	}

	private function get_events( $start_date, $end_date, $terms = null ) {
		$post_type = $this->get_post_type();
		$taxonomy_type = $this->get_taxonomy_type();

		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'orderby' => array( 'event_start_date' => 'ASC', 'event_end_date' => 'DESC', 'event_start_hour' => 'ASC', 'event_start_minute' => 'ASC' ),
			'meta_query' => array(
				'event_start_date' => array( 'key' => 'event_start_date', 'value' => date( 'Y-m-d', $end_date ), 'compare' => '<=', 'type' => 'DATE' ),
				'event_end_date' => array( 'key' => 'event_end_date', 'value' => date( 'Y-m-d', $start_date ), 'compare' => '>=', 'type' => 'DATE' ),
				'event_start_hour' => array( 'key' => 'event_start_hour', 'type' => 'NUMERIC' ),
				'event_start_minute' => array( 'key' => 'event_start_minute', 'type' => 'NUMERIC' ), 
			),
			'posts_per_page' => -1
		);

		if ( !empty( $terms ) ) {
			$args['tax_query'] = array( array( 'taxonomy' => $taxonomy_type, 'field' => 'slug', 'terms' => $terms ) );
		}
		$query = new WP_Query( $args );

		$events = array();
		while ( $query->have_posts() ) {
			global $post;
			$query->the_post();

			// Get category color
			$bg_color = '#ccc';
			$terms = get_the_terms( $post->ID, $taxonomy_type );
			if ( is_array( $terms ) ) {
				foreach ( $terms as $cate ) {
					$cat_data = get_option( 'xo_event_calendar_cat_' . intval( $cate->term_id ) );
					$cat_color = esc_html( $cat_data['category_color'] );
					if ( $cat_color ) {
						$bg_color = $cat_color;
						break;
					}
				}
			}

			$events[] = array(
				'post' => $post,
				'title' => get_the_title(),
				'start_date' => get_post_meta( $post->ID, 'event_start_date', true ),
				'end_date' => get_post_meta( $post->ID, 'event_end_date', true ),
				'bg_color' => $bg_color,
				'permalink' => get_permalink( $post->ID ),
				'short_title' => get_post_meta( $post->ID, 'short_title', true ),
			);
		}
		wp_reset_postdata();

		return $events;
	}

	private function get_holiday_slug( $holidays, $holiday_settings, $date ) {
		$weeks = array( 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat' );
		$slugs = array();

		foreach ( $holidays as $holiday ) {
			if ( array_key_exists( $holiday, $holiday_settings ) ) {
				if ( ( $holiday_settings[$holiday]['dayofweek'][$weeks[date( 'w', $date )]] ||
					strpos( $holiday_settings[$holiday]['special_holiday'], date( 'Y-m-d', $date ) ) !== false ) &&
					strpos( $holiday_settings[$holiday]['non_holiday'], date( 'Y-m-d', $date ) ) === false
				) {
					$slugs[] = $holiday;
				}
			}
		}

		return $slugs;
	}

	/**
	 * Render the monthly calendar.
	 *
	 * @param array $args An array of arguments used to retrieve monthly calendar.
	 * @param int $month_index Calendar number.
	 * @return string HTML
	 */
	private function get_month_calendar( $args, $month_index = 1 ) {
		global $wp_locale;

		if ( $args['month'] < 1 ) $args['month'] = 1; else if ( $args['month'] > 12 ) $args['month'] = 12;

		// 月末の取得
		$last_day = date( 'j', mktime( 0, 0, 0, $args['month'] + 1, 0, $args['year'] ) );
		// 曜日の取得（0:日 ～ 6:土）
		$week = date( 'w', mktime( 0, 0, 0, $args['month'], 1, $args['year'] ) );
		// 週数を取得
		$week_count = ceil( ( ( ( 7 + $week - $args['start_of_week'] ) % 7 ) + $last_day ) / 7 );
		// 日数を取得
		$day_count = $week_count * 7;
		// 開始日を取得
		$start_time = strtotime( "{$args['year']}-{$args['month']}-1" );
		if ( $args['start_of_week'] != $week ) {
			$d = ( 7 + $week - $args['start_of_week'] ) % 7;
			$start_time = strtotime( "-{$d} day", $start_time );
		}
		// 終了日を取得
		$end_time = strtotime( "+{$day_count} day", $start_time );
		// イベントを取得
		if ( $args['show_event'] ) {
			if ( empty( $args['categories_string'] ) ) {
				$events = $this->get_events( $start_time, $end_time );
			} else {
				$categories = explode( ',', $args['categories_string'] );
				$events = $this->get_events( $start_time, $end_time, $categories );
			}

			/**
			 * Filters Event calendar events' data.
			 *
			 * @since 2.2.1
			 *
			 * @param array An array of events' data.
			 * @param array $args An array of arguments used to retrieve monthly calendar.
			 * @param int $month_index Calendar number.
			 */
			$events = apply_filters( 'xo_event_calendar_events', $events, $args, $month_index );

			$args['show_event'] = 1;
		} else {
			$events = array();
			$args['show_event'] = 0;
		}

		$today = $this->date( 'Y-m-d' );

		$holidays = explode( ',', $args['holidays_string'] );
		$holiday_settings = get_option( 'xo_event_calendar_holiday_settings' );

		// 月間カレンダー
		$month_html = '';
		$line_count = 0;
		for ( $week_index = 0; $week_index < $week_count; $week_index++ ) {
			$month_html .= '<tr><td colspan="7" class="month-week">';

			$month_html .= '<table class="month-dayname">';
			$month_html .= '<tbody>';
			$month_html .= '<tr class="dayname">';
			for ( $day_index = 0; $day_index < 7; $day_index++ ) {
				$d = $week_index * 7 + $day_index;
				$date = strtotime( "+{$d} days", $start_time );
				$class = '';
				if ( date( 'n', $date ) != $args['month'] ) $class .= 'other-month ';
				if ( date( 'Y-m-d', $date ) === $today ) $class .= 'today ';
				$style = '';
				if ( $holiday_settings ) {
					$holiday_slugs = $this->get_holiday_slug( $holidays, $holiday_settings, $date );
					if ( count( $holiday_slugs ) ) {
						$holiday_slug = end( $holiday_slugs );
						$style = 'style="background-color: ' . $holiday_settings[$holiday_slug]['color'] . ';"';

						if ( empty( $args['multiple_holiday_classs'] ) ) {
							$class .= "holiday-{$holiday_slug} ";
						} else {
							$class .= implode( ' ', array_map( function( $s ) { return "holiday-{$s}"; }, $holiday_slugs ) );
						}
					}
				}
				if ( !empty( $class ) ) $class = 'class="' . trim( $class ) . '" ';
				$month_html .= "<td><div {$class}{$style}>" . date( 'j', $date ) . '</div></td>';
			}
			$month_html .= '</tr>';
			$month_html .= '</tbody>';
			$month_html .= '</table>';

			$month_html .= '<div class="month-dayname-space"></div>';

			if ( count( $events ) > 0 ) {
				$days_week =  array_fill( 0, 7, array() );
				for ( $day_index = 0; $day_index < 7; $day_index++ ) {
					$d = $week_index * 7 + $day_index;
					$day = date( 'Y-m-d', strtotime( "+{$d} day", $start_time ) );
					for ( $i = 0; $i < count( $events ); $i++ ) {
						$event = $events[$i];
						if ( empty( $event['end_date'] ) ) {
							if ( $event['start_date'] == $day ) {
								$days_week[$day_index][] = $i;
							}
						} else {
							if ( $event['start_date'] <= $day && $day <= $event['end_date'] ) {
								$days_week[$day_index][] = $i;
							}
						}
					}
				}

				for ( $day_index = 0; $day_index < 7; $day_index++ ) {
					for ( $line_index = 0; $line_index < count( $days_week[$day_index] ); $line_index++ ) {
						if ( isset( $days_week[$day_index][$line_index] ) && $days_week[$day_index][$line_index] != null ) {
							$max_line = -1;
							for ( $i = 0; $i < 7; $i++ ) {
								for ( $j = 0; $j < count( $days_week[$i] ); $j++ ) {
									if ( isset( $days_week[$i][$j] ) && $days_week[$i][$j] == $days_week[$day_index][$line_index] ) {
										if ( $max_line < $j ) $max_line = $j;
									}
								}
							}
							if ( $max_line > $line_index ) {
								array_splice( $days_week[$day_index], $line_index, 0, -1 );
								$days_week[$day_index][$line_index] = -1;
							}
						}
					}
				}

				$line_count = max(
					count( $days_week[0] ), count( $days_week[1] ), count( $days_week[2] ),
					count( $days_week[3] ),	count( $days_week[4] ), count( $days_week[5] ),
					count( $days_week[6] )
				);

				for ( $line_index = 0; $line_index < $line_count; $line_index++ ) {
					$month_html .= '<table class="month-event">';
					$month_html .= '<tbody>';
					$month_html .= '<tr>';
					for ( $day_index = 0; $day_index < 7; $day_index++ ) {
						if ( !isset( $days_week[$day_index][$line_index] ) ) {
							$month_html .= '<td></td>';
						} else if ( $days_week[$day_index][$line_index] === -1 ) {
							$month_html .= '<td></td>';
						} else {
							$colspan = 1;
							if ( $day_index < 7 ) {
								for ( $i = $day_index + 1; $i < 7; $i++ ) {
									if ( isset( $days_week[$i][$line_index] ) && $days_week[$day_index][$line_index] == $days_week[$i][$line_index] ) {
										$colspan++;
									} else {
										break;
									}
								}
							}
							if ( $colspan > 0 ) {
								$event = $events[$days_week[$day_index][$line_index]];

								$short_title = ( $event['short_title'] ) ? $event['short_title'] : $event['title'];

								$hsv = XO_Color::getHsv( XO_Color::getRgb( $event['bg_color'] ) );
								$font_color = $hsv['v'] > 0.8 ? '#333' : '#eee';

								$event_html = "<span class=\"month-event-title\" style=\"color: {$font_color}; background-color: {$event['bg_color']};\">{$short_title}</span>";
								if ( ! isset( $this->options['disable_event_link'] ) || ! $this->options['disable_event_link'] ) {
									$event_html = "<a href=\"{$event['permalink']}\" title=\"{$event['title']}\">{$event_html}</a>";
								}

								/**
								 * Filters Event calendar event title HTML.
								 *
								 * @since 1.9.0
								 *
								 * @param string $event_html Event calendar event title HTML.
								 * @param array $event_post Event calendar event post object.
								 * @param array $options Option datas.
								 */
								$event_html = apply_filters( 'xo_event_calendar_event_title', $event_html, $event, $this->options );

								$month_html .= "<td colspan=\"{$colspan}\">{$event_html}</td>";

								$day_index += $colspan - 1;
							}
						}
					}
					$month_html .= '</tr>';
					$month_html .= '</tbody>';
					$month_html .= '</table>';
				}
			}

			if ( $line_count === 0 ) {
				$month_html .= '<table class="month-event-space">';
				$month_html .= '<tbody><tr><td><div></div></td><td><div></div></td><td><div></div></td><td><div></div></td><td><div></div></td><td><div></div></td><td><div></div></td></tr></tbody>';
				$month_html .= '</table>';
			}

			$month_html .= '</td></tr>';
		}

		$m = strtotime( "{$args['year']}-{$args['month']}-1" );
		$prev_month = date( 'Y-n', strtotime( '-1 month', $m ) );
		$next_month = date( 'Y-n', strtotime( '+1 month', $m ) );
		if ( isset( $this->options['disable_dashicons'] ) && $this->options['disable_dashicons'] ) {
			$prev_text = '<span class="nav-prev">PREV</span>';
			$next_text = '<span class="nav-next">NEXT</span>';
		} else {
			$prev_text = '<span class="dashicons dashicons-arrow-left-alt2"></span>';
			$next_text = '<span class="dashicons dashicons-arrow-right-alt2"></span>';
		}

		$calendar_caption = sprintf( _x( '%1$s %2$s', 'calendar caption', 'xo-event-calendar' ), $wp_locale->get_month( $args['month'] ), $args['year'] );

		/**
		 * Filters Event calendar month caption.
		 *
		 * @since 2.1.0
		 *
		 * @param string $calendar_caption Calendar month caption.
		 * @param array $args An array of arguments used to retrieve monthly calendar.
		 * @param int $month_index Calendar number.
		 */
		$calendar_caption = apply_filters( 'xo_event_calendar_month_caption', $calendar_caption, $args, $month_index );

		$html = '<div class="xo-month-wrap">';
		$html .= '<table class="xo-month">';
		$html .= '<caption>';
		$html .= '<div class="month-header">';
		if ( $args['navigation'] && $month_index == 1 ) {
			if ( $args['prev_month_feed'] === -1 || $m > strtotime( "-{$args['prev_month_feed']} month", strtotime( $this->date( 'Y-m-1' ) ) ) ) {
				$html .= "<button type=\"button\" class=\"month-prev\" onclick=\"this.disabled = true; xo_event_calendar_month(this,'{$prev_month}',{$args['show_event']},'{$args['categories_string']}','{$args['holidays_string']}',{$args['prev_month_feed']},{$args['next_month_feed']},{$args['start_of_week']},{$args['months']}," . (int)$args['navigation'] . "," . (int)$args['multiple_holiday_classs'] . "); return false;\">{$prev_text}</button>";
			} else {
				$html .= "<button type=\"button\" class=\"month-prev\" disabled=\"disabled\">{$prev_text}</button>";
			}
		}
		$html .= "<span class=\"calendar-caption\">{$calendar_caption}</span>";
		if ( $args['navigation'] && $month_index == 1 ) {
			if ( $args['next_month_feed'] === -1 || $m < strtotime( "+{$args['next_month_feed']} month", strtotime( $this->date( 'Y-m-1' ) ) ) ) {
				$html .= "<button type=\"button\" class=\"month-next\" onclick=\"this.disabled = true; xo_event_calendar_month(this,'{$next_month}',{$args['show_event']},'{$args['categories_string']}','{$args['holidays_string']}',{$args['prev_month_feed']},{$args['next_month_feed']},{$args['start_of_week']},{$args['months']}," . (int)$args['navigation'] . "," . (int)$args['multiple_holiday_classs'] . "); return false;\">{$next_text}</button>";
			} else {
				$html .= "<button type=\"button\" class=\"month-next\" disabled=\"disabled\" >{$next_text}</button>";
			}
		}
		$html .= '</div>';
		$html .= '</caption>';

		$day_classs = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
		$day_names = array(
			__( 'Sun', 'xo-event-calendar' ),
			__( 'Mon', 'xo-event-calendar' ),
			__( 'Tue', 'xo-event-calendar' ),
			__( 'Wed', 'xo-event-calendar' ),
			__( 'Thu', 'xo-event-calendar' ),
			__( 'Fri', 'xo-event-calendar' ),
			__( 'Sat', 'xo-event-calendar' ),
		);

		$html .= '<thead>';
		$html .= '<tr>';
		for ( $day_index = 0; $day_index < 7; $day_index++ ) {
			$index = ( $day_index + $args['start_of_week'] ) % 7;
			$html .= "<th class=\"{$day_classs[$index]}\">{$day_names[$index]}</th>";
		}
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= $month_html;
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>' . "\n";

		/**
		 * Filters Event calendar month HTML.
		 *
		 * @since 1.9.0
		 *
		 * @param string $html Event calendar event title HTML.
		 * @param array $args An array of arguments used to retrieve monthly calendar.
		 * @param int $month_index Calendar number.
		 * @param array $event_posts Event calendar event posts.
		 */
		$html = apply_filters( 'xo_event_calendar_month', $html, $args, $month_index, $events );

		return $html;
	}

	/**
	 * Render the monthly calendar.
	 *
	 * @since 1.0.0
	 * @deprecated 1.7.0 Use get_calendar()
	 */
	function get_event_calendar( $id, $show_event, $categories_string, $holidays_string, $prev_month_feed, $next_month_feed, $start_of_week = 0 ) {
		/**
		 * Filters Event calendar arguments.
		 *
		 * @since 1.5.0
		 *
		 * @param array $args Event calendar arguments.
		 */
		$args = apply_filters( 'xo_event_calendar_args', array(
			'id' => $id,
			'year' => $this->date( 'Y' ),
			'month' => $this->date( 'n' ),
			'show_event' => $show_event,
			'categories_string' => $categories_string,
			'holidays_string' => $holidays_string,
			'prev_month_feed' => $prev_month_feed,
			'next_month_feed' => $next_month_feed,
			'start_of_week' => ( $start_of_week == -1 ) ? get_option( 'start_of_week' ) : $start_of_week,
		) );

		$retour = "<div id=\"{$id}\" class=\"xo-event-calendar\" >";
		$retour .= '<div class="xo-months" >';
		$retour .= $this->get_month_calendar( $args );
		$retour .= '</div>';

		$retour .= '<div class="holiday-titles" >';
		$holiday_settings = get_option( 'xo_event_calendar_holiday_settings' );
		if ( $holiday_settings ) {
			$holidays = explode( ',', $args['holidays_string'] );
			foreach ( $holidays as $holiday ) {
				if ( array_key_exists( $holiday, $holiday_settings ) ) {
					$retour .= "<p class=\"holiday-title\"><span style=\"background-color: {$holiday_settings[$holiday]['color']};\"></span>{$holiday_settings[$holiday]['title']}</p>";
				}
			}
		}
		$retour .= '</div>';

		$retour .= '<div class="loading-animation"></div>';
		$retour .= "</div>\n";
		return $retour;
	}

	/**
	 * Render the monthly calendar.
	 *
	 * @since 1.7.0
	 *
	 * @param array $args An array of arguments used to retrieve monthly calendar.
	 * @return string HTML
	 */
	function get_calendar( $args ) {
		/**
		 * Filters Event calendar arguments.
		 *
		 * @since 1.5.0
		 *
		 * @param array $args Event calendar arguments.
		 */
		$args = apply_filters( 'xo_event_calendar_args', $args );

		if ( ! isset( $args['year'] ) ) $args['year'] = $this->date( 'Y' );
		if ( ! isset( $args['month'] ) ) $args['month'] = $this->date( 'n' );

		if ( $args['month'] < 1 ) $args['month'] = 1; else if ( $args['month'] > 12 ) $args['month'] = 12;

		$retour = "<div id=\"{$args['id']}\" class=\"xo-event-calendar\" >";
		$retour .= '<div class="xo-months" >';
		$retour .= $this->get_month_calendar( $args );
		$count = isset( $args['months'] ) ? $args['months'] : 1;
		for ( $i = 2; $i <= $count; $i++ ) {
			$next_time = strtotime( '+1 month', strtotime( "{$args['year']}-{$args['month']}-1" ) );
			$args['year'] = date( 'Y', $next_time );
			$args['month'] = date( 'n', $next_time );
			$retour .= $this->get_month_calendar( $args, $i );
		}
		$retour .= '</div>';

		$html = '<div class="holiday-titles" >';
		$holiday_settings = get_option( 'xo_event_calendar_holiday_settings' );
		if ( $holiday_settings ) {
			$holidays = explode( ',', $args['holidays_string'] );
			foreach ( $holidays as $holiday ) {
				if ( array_key_exists( $holiday, $holiday_settings ) ) {
					$html .= "<p class=\"holiday-title\"><span style=\"background-color: {$holiday_settings[$holiday]['color']};\"></span>{$holiday_settings[$holiday]['title']}</p>";
				}
			}
		}
		$html .= '</div>';

		/**
		 * Filters Calendar footer HTML.
		 *
		 * @since 2.0.0
		 *
		 * @param array $html Calendar footer HTML.
		 * @param array $args Event calendar arguments.
		 */
		$retour .= apply_filters( 'xo_event_calendar_footer', $html, $args );

		$retour .= '<div class="loading-animation"></div>';
		$retour .= "</div>\n";

		return $retour;
	}

	/**
	 * Builds the Event Calendar shortcode output.
	 */
	function event_calendar_shortcode( $args ) {
		$args = shortcode_atts( array(
			'id' => 'xo-event-calendar-1',
			'year' => $this->date( 'Y' ),
			'month' => $this->date( 'n' ),
			'event' => 'true',
			'categories' => null,
			'holidays' => null,
			'previous' => -1,
			'next' => -1,
			'start_of_week' => 0,
			'months' => 1,
			'navigation' => 'true',
			'multiple_holiday_classs' => 'false',
		), $args );

		return $this->get_calendar( array(
			'id' => esc_attr( $args['id'] ),
			'year' => $args['year'],
			'month' => $args['month'],
			'show_event' => (bool)( strtolower( $args['event'] ) == 'true' ),
			'categories_string' => $args['categories'],
			'holidays_string' => $args['holidays'],
			'prev_month_feed' => intval( $args['previous'] ),
			'next_month_feed' => intval( $args['next'] ),
			'start_of_week' => ( $args['start_of_week'] == -1 ) ? get_option( 'start_of_week' ) : $args['start_of_week'],
			'months' => intval( $args['months'] ),
			'navigation' => (bool)( strtolower( $args['navigation'] ) == 'true' ),
			'multiple_holiday_classs' => (bool)( strtolower( $args['multiple_holiday_classs'] ) == 'true' ),
		) );
	}

	function register_widget() {
		register_widget( 'XO_Widget_Event_Calendar' );
	}

	function template_include( $template ) {
		$post_type = $this->get_post_type();
		if ( is_singular( $post_type ) ) {
			$file_name = "single-{$post_type}.php";
		}
		if ( isset( $file_name ) ) {
			$theme_file = locate_template( $file_name );
		}
		if ( isset( $theme_file ) && $theme_file ) {
			// With template.
		} elseif ( isset( $file_name ) && $file_name ) {
			// No template.
			add_filter( 'next_post_link', '__return_false' );
			add_filter( 'previous_post_link', '__return_false' );
			add_filter( 'the_content', array( $this, 'single_content' ) );
		}
		return $template;
	}

	function get_event_date( $post_id ) {
		$custom = get_post_custom( $post_id );

		$all_day = (bool)$custom['event_all_day'][0];
		$start_date = $custom['event_start_date'][0];
		$start_hour = $custom['event_start_hour'][0];
		$start_minute = $custom['event_start_minute'][0];
		$end_date = !empty( $custom['event_end_date'][0] ) ? $custom['event_end_date'][0] : $start_date;
		$end_hour = $custom['event_end_hour'][0];
		$end_minute = $custom['event_end_minute'][0];

		$date_format = get_option( 'date_format' );	// _x( 'Y/n/j', 'event meta', 'xo-event-calendar' );
		$time_format = get_option( 'time_format' );

		$date = date( $date_format, strtotime( $start_date ) );
		if ( ! $all_day ) {
			$date .= ' ' . date( $time_format, strtotime( $start_hour . ':' . $start_minute  ) );
		}
		if ( $start_date !== $end_date ) {
			//if ( date( 'Y', strtotime( $start_date ) ) == date( 'Y', strtotime( $end_date ) ) ) {
			//	$date_format = _x( 'n/j', 'event meta', 'xo-event-calendar' );
			//}
			$date .= ' - ' . date( $date_format, strtotime( $end_date ) );
			if ( ! $all_day ) {
				$date .= ' ' . date( $time_format, strtotime( $end_hour . ':' . $end_minute  ) );
			}
		} else {
			if ( ! $all_day && ( $start_hour * 60 + $start_minute ) < ( $end_hour * 60 + $end_minute ) ) {
				$date .= ' - ' . date( $time_format, strtotime( $end_hour . ':' . $end_minute  ) );
			}
		}

		return $date;
	}

	function single_content( $content ) {
		$post_id = get_the_ID();
		$taxonomy = $this->get_taxonomy_type();

		$details  = '<div class="xo-event-meta-details">';
		$details .= '<div class="xo-event-meta">';
		$details .= '<span class="xo-event-date">' . esc_html__( 'Event date:', 'xo-event-calendar' ) . ' ' . $this->get_event_date( $post_id ) . '</span>';
		if ( get_the_terms( $post_id, $taxonomy ) ) {
			$details .= '<span class="xo-event-category">' . esc_html__( 'Categories:', 'xo-event-calendar' ) . ' ' . get_the_term_list( $post_id, $taxonomy, '', ', ', '' ) . '</span>';
		}
		$details .= '</div>';
		$details .= '</div>' . "\n";

		return $details . $content;
	}
}
