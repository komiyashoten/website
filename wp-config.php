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
define('AUTH_KEY',         '0mTVmbZyoJ1G/U43XqCyTlSTXUqzPke8k6aN9JZtKhR+i9knd/rE0TCH0PJrK8R7Hji0FUHnYL5/HCGwKhIgeg==');
define('SECURE_AUTH_KEY',  'tuz9kE+gQv3HUfKPHNu5rLZPSUdcq7xH3YPTu5+l0A8hVEK2FYuvAiweSjLLbOHp3PC0yq1TW+NOQyRpuCWSsQ==');
define('LOGGED_IN_KEY',    '1d3f9Ozvbkdgf9aPXzwx8sgi9qh66xXpuzJdrvJieL8hg0Q9AggpDDORwO4NtFndGvOxzTmC6zOl3YAXCpXoZw==');
define('NONCE_KEY',        '+MGQjZhhThIUlrHbZ7mHEC59nJK7B4BiTQLDviVC05bAJepwHpLPaC1YTQtFOV73lB2z1ViXbaPbNuS6SLJwZw==');
define('AUTH_SALT',        'OZi926OaxHETPfuHkWaW04NUKAEBGM6zdAaZxZsZ6xEP7INKnuENg1AOlUuVmQnqe3fz6U8Kg6E1aXI+nqejEA==');
define('SECURE_AUTH_SALT', 'YF29GbBH2hlSJWjMaEgL5qRPsow7Nq4PUN5O4vTQ27xVWf0MfJtfS9b5na85J/5EcM+nnkj8YU9udhhKyF7EFg==');
define('LOGGED_IN_SALT',   'ZvXBOfNuSvdpPyPLOT/EC2R7a/IXmDhkzFsKt/wWcOncyAcMlwL7OepSVLalxPS7hNXSXQK8DQAr1mD4SnfpFQ==');
define('NONCE_SALT',       'UneUdntJ6WRFWcdlCYvSR03DuN30vYHbl9q+uWkwQC9M1q3HDLIMKMdJmFBGx3viefTReWeg2Yk1eUNUAv+/DQ==');

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
