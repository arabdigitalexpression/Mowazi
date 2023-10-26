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
define( 'DB_NAME', 'db52atupvdt5oh' );

/** MySQL database username */
define( 'DB_USER', 'uksnz70my2flk' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wxifszmulncy' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define('AUTH_KEY',         'Qzi|j;-f#UXzK/-.=|^tG|P6(#nd2y8r<A`Z,F}Evj!#F,j<J vo||DR1rOiAn?n');
define('SECURE_AUTH_KEY',  'X;{hLS<%%HOeu5;!b~3?vH[D@:;Nm-VpUuR^[:BFd,y|6ToRcfVB}z;KVByz8=V#');
define('LOGGED_IN_KEY',    'i9`]vl4 ha7`:&8MCr+TESm{/0X^T/f[[2M`qP,pCdB+$@*:{p*rdD7,[4bTL<QX');
define('NONCE_KEY',        'vE+m#qVTB+cjwkYliQ9jnx`p|NNM*P_@Ca$F|UTCi?[=MZU|1%2p%-hd<}9 FG/ ');
define('AUTH_SALT',        '>kD`Jgi!MB}ZYo?6Hz3g{^|}gn^V|A]]ru$MDOALse#P)gXtW-,|}jL4>}>=kV1E');
define('SECURE_AUTH_SALT', 'tVpp|GKsJJpt>Da7:;6b9_<v?+o&. RKBj&3qAc]>Uk#cZ2Ar~,,a3u~Tc9I_Q6V');
define('LOGGED_IN_SALT',   'wtL6uF]OUs]d*iC3=KN l`TTMs,OjLk%_q5A8ICwd]2ChtW9fGuxhk=JegsA-}nQ');
define('NONCE_SALT',       'g[T+OGMAekPsuZ9A%sE=|dL2ObNN,gP+.mA@&G[-2s@s8aqi)xt^oER`$|s;P3SD');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_mowazi_';


define('WP_DEBUG', false);
/* That's all, stop editing! Happy blogging. */
define('FORCE_SSL_ADMIN', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
define( 'WP_ENVIRONMENT_TYPE', 'staging' ); // Added by SiteGround WordPress Staging system
require_once ABSPATH . 'wp-settings.php';
@require_once ABSPATH . 'disable_wp_cron.php'; // Added by SiteGround WordPress Staging system
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
