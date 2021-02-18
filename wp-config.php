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
define('AUTH_KEY',         'Hh3wXB9apdIRO/uaZPZylbx7P8vxRW5RwnUMa7wFkque2uthpV7dN0768W+bT9TG1Ry86rPUr9NdyXEh4uYMIA==');
define('SECURE_AUTH_KEY',  'UukBen+LofNTRlQ23hwLUc0a8Q/Dl2bAL7iDcuPUj/u+lNbwmTfppjEl++g5bPv6qwHfX6Ly6JGadMjYWkocPQ==');
define('LOGGED_IN_KEY',    'N6bsJltmz7+9ggXLDNpXssfi9EPs8TzlW0BugjWU4VR+RHOKwiROyBBr1g/K4cuM7xYDlsf6VP7n97CN3SQpYg==');
define('NONCE_KEY',        'sIznBxwP3p3Lv820ha56nvQ9eH/TJVAtf8etNGwtP+uykqBkX8JUm1NR7al925vS97GvVo67ePDQpzC9idwXuA==');
define('AUTH_SALT',        '8ZVfS7XZOA9IVt8y5XAVgD+dXViDQkBX9hGrelSxE/rc9djYaUdj8ZbJbbZCr9e+tWeT9CD5VTTzwB/UZIx1FQ==');
define('SECURE_AUTH_SALT', 'hhMoYGkjL4spkFhMEeUkjxQCLXUIO5MegqJy9ltqMXf3X6sKfcdv5ijFh7aGg8k5mp8c8HUTHBgkwb6fT+K6vw==');
define('LOGGED_IN_SALT',   'jB1bAncyspu6/Xb7Ogr9po8JGIMmB+VG9Lz8f8YgWpaaTIBuavtc1rR0DW8jrGY+hpst9FcRUNVn118ZEZWuXQ==');
define('NONCE_SALT',       'xRm/CFrpPuCav55ZknB5wqIFgVubGCLgyoG7UJ3ROzM4TOUu0NMzBW8JIzq88Hn9KCDb15LY3SDrMO+zvmqF1A==');

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
