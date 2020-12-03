<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'DCAaD4ihhn8OlecmzKNUOmMAiCsJnc8FCUqlwZiNFIjd/l5IBCC7h0GNL28Qo/4v1RLZgeoHkGf+vxEzYlxpbA==');
define('SECURE_AUTH_KEY',  '1ta58My89z+4tmMhwJCoeKyn67jUJJCZNZTHUyY6tjSoIsjKCkp4HVJfzoj3mfPG2QKqCioGCzDenMYV0H0vxw==');
define('LOGGED_IN_KEY',    'K0BO4vXo/mgi+YsrTmf5l4VC97i03sUL+wPOMlnxak+H5FvcuUTr2IxgPhniqrIHY28KMM+WL6Fpphd1HfsqCg==');
define('NONCE_KEY',        'aidiirhiXRDq+Uq/6xGOFHKp51RNRj43xXRrcwja6zGYjyLqFxQ4th9w1/bFHc9WIvJGShkPCmMh+hiNJSugyA==');
define('AUTH_SALT',        '8gMIgXVt6TnS6bGILdjKjavjYlw73e7vQ+f5uR0RCh6NgcnOFs1++yKAATMfZ1s7ysCR7fDvp+2sI4Um+gqJ0Q==');
define('SECURE_AUTH_SALT', 'u7x6edtoqYperCAoeSR7lDqUc3w/JeL2OSfFHtgH33myeTzPZ196zSPejVrbG8xBd0L6G1Kuu8VwX4v8kZL3uQ==');
define('LOGGED_IN_SALT',   'WZhrgBqxOYDGhHiI4PXVnUBDpnQTnQJ7x2IKrULfDpOJXd9pg/VlsAH/hC3WZlD2pRvpB2tbC2zMlhI5ZpvKzw==');
define('NONCE_SALT',       'YUsxfkkRskY8r/KQHesWnMTfmok3HwWTRgZOw5pdQ1CIx/xcfV0qfV2olWOQj+6/dvrul6DlDHiONcASp9Ksew==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
