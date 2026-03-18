<?php
/**
 * LocalWP runtime wp-config after Duplicator import.
 * Keep this as standard WP bootstrap to avoid custom-path boot failures.
 */

define( 'DB_NAME', 'local' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', '127.0.0.1:10005' );
define( 'DB_CHARSET', 'utf8mb3' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY',         '7^-YPO-^z.ZevOu9nyJrcn6#A{|6T)bSGA}M`S1M[SL)L6r`{=E>QvHSc[%(5,y4' );
define( 'SECURE_AUTH_KEY',  's7Q`g80^;A:s?HqoaoM<ToqLuUnHyI_~%kp&M6Y5LJ!Y&&7SB]P=:zzj0msnPbrr' );
define( 'LOGGED_IN_KEY',    'xx~&s=<3q6*8E-C+%=kC`q8M>q$Mka?ltBTPRK*{U2yr=@_r~vK2Bn7`=Xj{}7h-' );
define( 'NONCE_KEY',        '}aJMQx(TcGc9N(5&c{2T{H9h1vE8M@2LR77jz8;0TuQx<~W?9^+=6+l#u6Q^-N?#' );
define( 'AUTH_SALT',        '?*Qz(Vx9KChsM#r#+yyL9A!YifxNtYB=jq]ffQm=4i=p#T<>S8jRHCm[qXyd6rW!' );
define( 'SECURE_AUTH_SALT', '8.RGf8G6fJ2gh|KmfNCZ-7x8@26S`myvG=pK;Q<U#;8L6!]cRJ9#O$!mI*=h+4sS' );
define( 'LOGGED_IN_SALT',   'i$[QK4@R5Nf{QApKrS0n]JxjVY_nAXnYk}4V(qf:-6Yj1C:0Hn%TRo;1I^T4x8Du' );
define( 'NONCE_SALT',       'LR@zv&|X6[p2vW6;43BT7r{GIk4jB3e+?9b*EJfP[a}P[%sh8dE.!^,Xx9}vaY8N' );

$table_prefix = 'wp_';

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_ENVIRONMENT_TYPE', 'local' );

if ( ! defined( 'WP_ENV' ) ) {
	if ( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE ) {
		define( 'WP_ENV', WP_ENVIRONMENT_TYPE );
	} else {
		define( 'WP_ENV', 'production' );
	}
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', __DIR__ . '/app' );
}

if ( ! defined( 'WP_CONTENT_URL' ) ) {
	$scheme = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? 'https' : 'http';
	$host   = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : 'localhost';
	define( 'WP_CONTENT_URL', $scheme . '://' . $host . '/app' );
}

if ( ! defined( 'WP_SITEURL' ) ) {
	$scheme = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? 'https' : 'http';
	$host   = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : 'localhost';
	define( 'WP_SITEURL', $scheme . '://' . $host . '/wp' );
}

$root_vendor_autoload = dirname( __DIR__ ) . '/vendor/autoload.php';
if ( file_exists( $root_vendor_autoload ) ) {
	require_once $root_vendor_autoload;
}

require_once ABSPATH . 'wp-settings.php';
