<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mywp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'QMnpPDuUKw9Y7e4A81VjM929NnWNyF81r9UVZKL5G2rzzof7FxihbBxgNVwBH15Q' );
define( 'SECURE_AUTH_KEY',  'kMApul9JaJbP6k85MPi0l5XfQfI9XpjNWcUgKnTGlu5O6TPsPSoymvtV4FNX3cot' );
define( 'LOGGED_IN_KEY',    'DE630OyukEhIck2qcDU90DX65qAz79bXmQT2wi3GZa7cwz1diYgrYBWP6fXmWMNY' );
define( 'NONCE_KEY',        'sM4OcCsCl6E8EPELOVn3kamCXMWhu7JJpg93DfhCGzsICudSLEuVburo4K4oPWnw' );
define( 'AUTH_SALT',        'dglrr0GlfcelzTORxpKbcXBrwSJPYFW3CHY2Xk9jmgM7SSFjmDqtyFyfwoTRlEbO' );
define( 'SECURE_AUTH_SALT', 't17b52pq2P77NsIWtpXgpJfWK02DItPXrU5gBq5V6FrCOv0FXdKCxDHLVWFYPUa0' );
define( 'LOGGED_IN_SALT',   '34gDGnyBj1UOJdXfUtH36fN2DN8fZio9oYcEcVWLPEjRUMndWhxvCdIPLOCYcq2M' );
define( 'NONCE_SALT',       'uN5OH9kWpz99A7g5yTekbgYGRS6wskhpH7vZdF38zc6NlZ7h0WKu4mZtDY7PO2kT' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
