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
define('DB_NAME', 'avdukec1_ratemenew');
//define('DB_NAME', 'avdukec1_rateme');

/** MySQL database username */
define('DB_USER', 'avdukec1_rateme1');

/** MySQL database password */
define('DB_PASSWORD', 'rateme');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'TLlNDndVr)*M>2l`.]fhK &9imThIS#=r+(,o6Z$}[[?)oP+8f@uFOV#3rI3<kbX');
define('SECURE_AUTH_KEY',  '}W(!5syo!MX,Q/:@`]7ljj#u)ishecQ0B-3+R429AL,/C5W~t} :e+4mw44xvoC`');
define('LOGGED_IN_KEY',    'zv{YWt70oQ{6v<%hK7Kzg]!6i@72n93l e%kLq&85z44oyodz%ZOs(kA4m2hz_V:');
define('NONCE_KEY',        'HZ7wp))WWRt*A4-]UINsl.nmmzFY6*8M:pbF@_0N`jM5[m~wD5;lV[&VyS&,v=~J');
define('AUTH_SALT',        'djIcN2bP{v=R}6dMQE-W?~e;7Uid.0,x?l9MCn~5wJS]UK!P;_ Veig^)F<h0P%0');
define('SECURE_AUTH_SALT', 'j3~k4b>|w[6e3O(a5ZA@Zm=F4@t4yiiGcz;_FcYY!szf1gw.0dnVN2$c{%rL#Vxo');
define('LOGGED_IN_SALT',   ',6N/*{zu(/(p5glc7g_D3;VO>+Mea)X:i,_Tg9Fmd,CUGzAgC9j,4z.5p3-zd /i');
define('NONCE_SALT',       'v;^hQ.1g+1om/Z|2=07Jt!}f2@H|*%oV?OdVnz+[I{+.h6ps1<fX08bs}.4#<NFY');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

