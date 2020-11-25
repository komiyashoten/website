<?php

class XO_Widget_Event_Calendar extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'xo_event_calendar',
			apply_filters( 'xo_event_calendar_widget_name', __( 'Event Calendar (XO Event Calendar)', 'xo-event-calendar' ) ),
			array( 'classname' => 'widget_xo_event_calendar', 'description' => __( 'Display Event Calendar', 'xo-event-calendar' ) )
		);
	}

	public function widget( $args, $instance ) {
		global $xo_event_calendar;

		if ( empty( $instance ) ) {
			$instance = array(
				'title' => '',
				'cats' => array(),
				'holidays' => array(),
				'prev' => -1,
				'next' => -1,
				'start_of_week' => 0,
				'months' => 1
			);
		}

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$categories = is_array( $instance['cats'] ) ? implode( ',', $instance['cats'] ) : '';
		$holidays = is_array( $instance['holidays'] ) ? implode( ',', $instance['holidays'] ) : '';
		$show_event = ! empty( $categories );
		$prev = intval( $instance['prev'] );
		$next = intval( $instance['next'] );
		$start_of_week = isset( $instance['start_of_week'] ) ? intval( $instance['start_of_week'] ) : 0;
		$months = isset( $instance['months'] ) ? intval( $instance['months'] ) : 1;

		echo $xo_event_calendar->get_calendar( array(
			'id' => "{$args['widget_id']}-calendar",
			//'year' => date_i18n( 'Y' ),
			//'month' => date_i18n( 'n' ),
			'show_event' => $show_event,
			'categories_string' => $categories,
			'holidays_string' => $holidays,
			'prev_month_feed' => $prev,
			'next_month_feed' => $next,
			'start_of_week' => ( $start_of_week == -1 ) ? get_option( 'start_of_week' ) : $start_of_week,
			'months' => $months,
			'navigation' => true,
			'multiple_holiday_classs' => false,
		) );

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$cats = isset( $instance['cats'] ) ? $instance['cats'] : array();
		$holidays = isset( $instance['holidays'] ) ? $instance['holidays'] : array();
		$prev = isset( $instance['prev'] ) ? esc_attr( $instance['prev'] ) : '-1';
		$next = isset( $instance['next'] ) ? esc_attr( $instance['next'] ) : '-1';
		$start_of_week = isset( $instance['start_of_week'] ) ? esc_attr( $instance['start_of_week'] ) : '0';
		$months = isset( $instance['months'] ) ? esc_attr( $instance['months'] ) : '1';
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
  $('#xo_event_holiday ul').sortable({handle: 'span', stop: function(e, ui) {
	$('#xo_event_holiday ul input').change();
  }});
});
</script>
<?php
		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'xo-event-calendar' ) . '</label>';
		echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>' . "\n";
		
		$terms = get_terms( XO_Event_Calendar::get_taxonomy_type(), array( 'hide_empty' => false ) );
		echo '<span>' . __( 'Categories:', 'xo-event-calendar' ) . '</span>';
		echo '<div id="' . XO_Event_Calendar::get_taxonomy_type() . '" class="xo-event-cat-checklist">';
		echo '<ul>';
		foreach ( $terms as $term ) {
			echo '<li><label class="selectit">';
			echo '<input type="checkbox" value="' . $term->slug . '" id="cats-' . $term->slug . '" name="' . $this->get_field_name( 'cats[]' ) . '" ' . checked( in_array( $term->slug, $cats ), true, false ) . '/>' . $term->name;
			echo '</label></li>';
		}
		echo '</ul>';
		echo "</div>\n";

		$holiday_settings = get_option( 'xo_event_calendar_holiday_settings' );
		if ( !is_array( $holiday_settings ) )
			$holidays = array();
		$full_holidays = $holidays;
		if ( $holiday_settings ) {
			foreach ( $holiday_settings as $key => $value ) {
				if ( array_search( $key, $holidays ) === false ) {
					$full_holidays[] = $key;
				}
			}
		}
		echo '<span>' . __( 'Holiday:', 'xo-event-calendar' ) . '</span>';
		echo '<div id="xo_event_holiday" class="xo-event-cat-checklist">';
		echo '<ul>';
		foreach ( $full_holidays as $holiday ) {
			if ( isset ( $holiday_settings[$holiday] ) ) {
				$title = $holiday_settings[$holiday]['title'];
				echo '<li><span class="dashicons dashicons-menu"></span><label class="selectit"> ';
				echo '<input type="checkbox" value="' . $holiday . '" id="holidays-' . $holiday . '" name="' . $this->get_field_name( 'holidays[]' ) . '" ' . checked( in_array( $holiday, $holidays ), true, false ) . '/>' . $title;
				echo '</label></li>';
			}
		}
		echo '</ul>';
		echo "</div>\n";

		echo '<p>';
		echo '<span>' . __( 'Feed month:', 'xo-event-calendar' ) . '</span><br />';
		echo '<label for="' . $this->get_field_id( 'prev' ) . '">' . __( 'Previous month:', 'xo-event-calendar' ) . '</label> ';
		echo '<select id="' . $this->get_field_id( 'prev' ) . '" name="' . $this->get_field_name( 'prev' ) . '">';
		echo '<option value="-1"' . ( $prev === '-1' ? ' selected="selected"' : '' ) . '>' . __( 'No limit', 'xo-event-calendar' ) . '</option>';
		echo '<option value="0"' . ( $prev === '0' ? ' selected="selected"' : '' ) . '>0</option>';
		echo '<option value="1"' . ( $prev === '1' ? ' selected="selected"' : '' ) . '>1</option>';
		echo '<option value="2"' . ( $prev === '2' ? ' selected="selected"' : '' ) . '>2</option>';
		echo '<option value="3"' . ( $prev === '3' ? ' selected="selected"' : '' ) . '>3</option>';
		echo '<option value="4"' . ( $prev === '4' ? ' selected="selected"' : '' ) . '>4</option>';
		echo '<option value="5"' . ( $prev === '5' ? ' selected="selected"' : '' ) . '>5</option>';
		echo '<option value="6"' . ( $prev === '6' ? ' selected="selected"' : '' ) . '>6</option>';
		echo '<option value="7"' . ( $prev === '7' ? ' selected="selected"' : '' ) . '>7</option>';
		echo '<option value="8"' . ( $prev === '8' ? ' selected="selected"' : '' ) . '>8</option>';
		echo '<option value="9"' . ( $prev === '9' ? ' selected="selected"' : '' ) . '>9</option>';
		echo '<option value="10"' . ( $prev === '10' ? ' selected="selected"' : '' ) . '>10</option>';
		echo '<option value="11"' . ( $prev === '11' ? ' selected="selected"' : '' ) . '>11</option>';
		echo '<option value="12"' . ( $prev === '12' ? ' selected="selected"' : '' ) . '>12</option>';
		echo '</select> ' . __( '(month(s))', 'xo-event-calendar' );
		echo '<br />';
		echo '<label for="' . $this->get_field_id( 'next' ) . '">' . __( 'Next month:', 'xo-event-calendar' ) . '</label> ';
		echo '<select id="' . $this->get_field_id( 'next' ) . '" name="' . $this->get_field_name( 'next' ) . '">';
		echo '<option value="-1"' . ( $next === '-1' ? ' selected="selected"' : '' ) . '>' . __( 'No limit', 'xo-event-calendar' ) . '</option>';
		echo '<option value="0"' . ( $next === '0' ? ' selected="selected"' : '' ) . '>0</option>';
		echo '<option value="1"' . ( $next === '1' ? ' selected="selected"' : '' ) . '>1</option>';
		echo '<option value="2"' . ( $next === '2' ? ' selected="selected"' : '' ) . '>2</option>';
		echo '<option value="3"' . ( $next === '3' ? ' selected="selected"' : '' ) . '>3</option>';
		echo '<option value="4"' . ( $next === '4' ? ' selected="selected"' : '' ) . '>4</option>';
		echo '<option value="5"' . ( $next === '5' ? ' selected="selected"' : '' ) . '>5</option>';
		echo '<option value="6"' . ( $next === '6' ? ' selected="selected"' : '' ) . '>6</option>';
		echo '<option value="7"' . ( $next === '7' ? ' selected="selected"' : '' ) . '>7</option>';
		echo '<option value="8"' . ( $next === '8' ? ' selected="selected"' : '' ) . '>8</option>';
		echo '<option value="9"' . ( $next === '9' ? ' selected="selected"' : '' ) . '>9</option>';
		echo '<option value="10"' . ( $next === '10' ? ' selected="selected"' : '' ) . '>10</option>';
		echo '<option value="11"' . ( $next === '11' ? ' selected="selected"' : '' ) . '>11</option>';
		echo '<option value="12"' . ( $next === '12' ? ' selected="selected"' : '' ) . '>12</option>';
		echo '</select> ' . __( '(month(s))', 'xo-event-calendar' );
		echo '</p>' . "\n";

		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'months' ) . '">' . __( 'Months to display:', 'xo-event-calendar' ) . '</label> ';
		echo '<select id="' . $this->get_field_id( 'months' ) . '" name="' . $this->get_field_name( 'months' ) . '">';
		echo '<option value="1"' . ( $months === '1' ? ' selected="selected"' : '' ) . '>1</option>';
		echo '<option value="2"' . ( $months === '2' ? ' selected="selected"' : '' ) . '>2</option>';
		echo '<option value="3"' . ( $months === '3' ? ' selected="selected"' : '' ) . '>3</option>';
		echo '<option value="4"' . ( $months === '4' ? ' selected="selected"' : '' ) . '>4</option>';
		echo '<option value="5"' . ( $months === '5' ? ' selected="selected"' : '' ) . '>5</option>';
		echo '<option value="6"' . ( $months === '6' ? ' selected="selected"' : '' ) . '>6</option>';
		echo '<option value="7"' . ( $months === '7' ? ' selected="selected"' : '' ) . '>7</option>';
		echo '<option value="8"' . ( $months === '8' ? ' selected="selected"' : '' ) . '>8</option>';
		echo '<option value="9"' . ( $months === '9' ? ' selected="selected"' : '' ) . '>9</option>';
		echo '<option value="10"' . ( $months === '10' ? ' selected="selected"' : '' ) . '>10</option>';
		echo '<option value="11"' . ( $months === '11' ? ' selected="selected"' : '' ) . '>11</option>';
		echo '<option value="12"' . ( $months === '12' ? ' selected="selected"' : '' ) . '>12</option>';
		echo '</select> ' . __( '(month(s))', 'xo-event-calendar' );
		echo '</p>' . "\n";

		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'start_of_week' ) . '">' . __( 'Week Starts On:', 'xo-event-calendar' ) . '</label> ';
		echo '<select id="' . $this->get_field_id( 'start_of_week' ) . '" name="' . $this->get_field_name( 'start_of_week' ) . '">';
		echo '<option value="-1"' . ( $start_of_week === '-1' ? ' selected="selected"' : '' ) . '>' . __( 'General Settings', 'xo-event-calendar' ) . '</option>';
		echo '<option value="0"' . ( $start_of_week === '0' ? ' selected="selected"' : '' ) . '>' . __( 'Sunday', 'xo-event-calendar' ) . '</option>';
		echo '<option value="1"' . ( $start_of_week === '1' ? ' selected="selected"' : '' ) . '>' . __( 'Monday', 'xo-event-calendar' ) . '</option>';
		echo '<option value="2"' . ( $start_of_week === '2' ? ' selected="selected"' : '' ) . '>' . __( 'Tuesday', 'xo-event-calendar' ) . '</option>';
		echo '<option value="3"' . ( $start_of_week === '3' ? ' selected="selected"' : '' ) . '>' . __( 'Wednesday', 'xo-event-calendar' ) . '</option>';
		echo '<option value="4"' . ( $start_of_week === '4' ? ' selected="selected"' : '' ) . '>' . __( 'Thursday', 'xo-event-calendar' ) . '</option>';
		echo '<option value="5"' . ( $start_of_week === '5' ? ' selected="selected"' : '' ) . '>' . __( 'Friday', 'xo-event-calendar' ) . '</option>';
		echo '<option value="6"' . ( $start_of_week === '6' ? ' selected="selected"' : '' ) . '>' . __( 'Saturday', 'xo-event-calendar' ) . '</option>';
		echo '</select>';
		echo '</p>' . "\n";
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cats'] = $new_instance['cats'];
		$instance['holidays'] = $new_instance['holidays'];
		$instance['prev'] = $new_instance['prev'];
		$instance['next'] = $new_instance['next'];
		$instance['start_of_week'] = $new_instance['start_of_week'];
		$instance['months'] = $new_instance['months'];
		return $instance;
	}
}
