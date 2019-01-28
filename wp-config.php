<?php
define('WP_CACHE', false);
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
define('DB_NAME', 'metasita');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'PNcj*aJ!KLP_ekLbSJY[7{T`PRVt>Xj|vQ*wbyVRWd~Z^oub6,OWH)uuD+57-sS.');
define('SECURE_AUTH_KEY',  '`)&`%OkHZm0iER3K.PBiszl;r 0kho|gn|$I-0F E]1GqA2+58g66Dgjb@d]W-)I');
define('LOGGED_IN_KEY',    'F%Hhvj$1wR00x!ach*D6hy*Db&j^4Tx,2m  L1EFK7TddPo[Kj(V7bmit;?|#&xa');
define('NONCE_KEY',        '8u=fPC,?Vfad{k9l&*Fb]h>BA5J])(Wr/O b#QaN LL:m9*PhrLh#69~8Rd(F0et');
define('AUTH_SALT',        '3[qFH:R@oIe&]U|aUz]?}.GiR>F?a`_eG`75]K4b%ofYH~+:Klt0f,tO|dtqie(g');
define('SECURE_AUTH_SALT', '3/duqzed3a$tAeB?Vzk$#PV @qfJ*r${SJlw`7Dy*b*/5Z?#648P.L(|1,19KJZ0');
define('LOGGED_IN_SALT',   '~eF/nF{RB}kPjYcxQ%qU %5~B|gfi5,Wg0Ev(Gv1v|DIeoLK,mx#ha:ZLttEw0I,');
define('NONCE_SALT',       '[pn3zl3{,QZ5Dq~@HwOX$7txZQ6C3p#)@?K7z-31*C&mEK,Us1T4qS>5knzgiXV.');



define('AUTOMATIC_UPDATER_DISABLED', true);

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
