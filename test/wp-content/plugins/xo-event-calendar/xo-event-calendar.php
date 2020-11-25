<?php
/*
Plugin Name: XO Event Calendar
Plugin URI: https://xakuro.com/wordpress/xo-event-calendar/
Description: XO Event Calendar is a simple event calendar plugin.
Author: Xakuro
Author URI: https://xakuro.com/
License: GPLv2
Version: 2.2.5
Text Domain: xo-event-calendar
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XO_EVENT_CALENDAR_VERSION', '2.2.5' );
if ( !defined( 'XO_EVENT_CALENDAR_EVENT_POST_TYPE' ) ) {
	define( 'XO_EVENT_CALENDAR_EVENT_POST_TYPE', 'xo_event' );
}
if ( !defined( 'XO_EVENT_CALENDAR_EVENT_TAXONOMY' ) ) {
	define( 'XO_EVENT_CALENDAR_EVENT_TAXONOMY', 'xo_event_cat' );
}
if ( !defined( 'XO_EVENT_CALENDAR_HOLIDAY_SETTING_CAPABILITY' ) ) {
	define( 'XO_EVENT_CALENDAR_HOLIDAY_SETTING_CAPABILITY', 'edit_pages' );
}
define( 'XO_EVENT_CALENDAR_PLUGIN_FILE', __FILE__ );
define( 'XO_EVENT_CALENDAR_DIR', plugin_dir_path( __FILE__ ) );
define( 'XO_EVENT_CALENDAR_URL', plugin_dir_url( __FILE__ ) );

load_plugin_textdomain( 'xo-event-calendar' );

require_once( XO_EVENT_CALENDAR_DIR . 'inc/class-xo-color.php' );
require_once( XO_EVENT_CALENDAR_DIR . 'inc/event-calendar-widget.php' );
require_once( XO_EVENT_CALENDAR_DIR . 'inc/main.php' );

global $xo_event_calendar;
$xo_event_calendar = new XO_Event_Calendar;

if ( is_admin() ) {
	require_once( XO_EVENT_CALENDAR_DIR . 'inc/admin.php' );
	new XO_Event_Calendar_Admin( $xo_event_calendar );
}

register_activation_hook( __FILE__, array( $xo_event_calendar, 'activation' ) );
register_deactivation_hook( __FILE__, 'XO_Event_Calendar::deactivation' );
