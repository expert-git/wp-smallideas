<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', false); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/smallid4/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('MMAFF', 'hostgator' ); //Added by QuickInstall

define('DB_NAME', 'smallid4_jjj');

/** MySQL database username */
define('DB_USER', 'smallid4_usr');

/** MySQL database password */
define('DB_PASSWORD', 'DFTH88%gg22');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_HOME', 'https://smallideas.com.au');
define('WP_SITEURL', 'https://smallideas.com.au');

/* SMALLIDEAS APP paths */
define('EP_PATH', '/home/smallid4/app.smallideas.com.au/ep_library');  //LIVE
//define('EP_PATH', '/home/demo4ep/app.smallideas.com.au/ep_library');  //STAGING
//define('EP_PATH', '/home/demo4ep/app.smallideas.com.au/ep_library');  //LOCAL

define('WP_MEMORY_LIMIT', '256M');

//define( 'WP_DEBUG', true );
 //   @ini_set( 'display_errors', 1 );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'lMSt-ig:xuve$tu|)<BAwV*HcJHoA<heEjPhO0w-!C|$7tiAu_=~1T>/UNo');
define('SECURE_AUTH_KEY',  '');
define('LOGGED_IN_KEY',    'J1bOhOP^6s4d4U;WSAaA;Ad^|d$#z@J*?;Zal_Dw-sA9qwMSfxo=R-:9Kgxt!L*J*_BUI7UuW3y/J;ZO/');
define('NONCE_KEY',        'FeS>bZXO\`cXTV_46^^;RO~>\`i^B;$:f#dwsxT7<9<K:ZV<uk^TEF6=hS;l');
define('AUTH_SALT',        '-NtEoUQ7JONrBO/2\`TTEdovLt_AihR4-GZD-smf\`P@\`09tFSQR=DM#lq8A0Qz');
define('SECURE_AUTH_SALT', '#x3<vk8^obyT6E\`)f)1suZ~A1vUDkMF?MiYna;H2t\`t#r<x-c*pJqI;Bxob@jEDqbJg_k^YX:gYs');
define('LOGGED_IN_SALT',   '<T<ZzMRX0o|RxiePZrTlUji5lfHKOFdMu~53*6vLEER9#6bj/Ay*XxVaJzd6/~7BtPI(Z4y4@UY#hvxbl');
define('NONCE_SALT',       'Q9cjg$@*7>rV0\`EecY\`WV~AoTx<gV|@M!b3A:WN~^b;SAyS|hhZI1_V3CKfu(X<G|OX*Dtn2');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
