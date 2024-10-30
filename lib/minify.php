<?php

defined( 'ABSPATH' ) || exit;

// WP_Filesystemを使用するためにWPのコアにあるファイルを読み込み!
require_once ABSPATH . 'wp-admin/includes/file.php';

// minifyして結合した後のcss!
define( 'BYAKURAITMP_MINIFY_PATH', BYAKURAI_ADON_TEMPLATEFILTER . 'css/minify.css' );
define( 'BYAKURAITMP_MINIFY_SIZE', filesize( BYAKURAITMP_MINIFY_PATH ) );// ファイルサイズ!
define( 'BYAKURAITMP_MINIFY_DATE', filemtime( BYAKURAITMP_MINIFY_PATH ) );// 日付!

use MatthiasMullie\Minify;

/**
 * CSSを読み込んで圧縮・結合する
 *
 * @return bool
 */
function byakuraitmp_minify_css() {

	$block_style_path = ABSPATH . 'wp-includes/css/dist/block-library/style.min.css';
	$block_theme_path = ABSPATH . 'wp-includes/css/dist/block-library/theme.min.css';
	if ( is_child_theme() ) {
		$minifycss_paths = array(
			$block_style_path,
			$block_theme_path,
			get_template_directory() . '/style.css',
			get_stylesheet_directory() . '/style.css', // 子テーマのスタイル 優先したい順番に気をつける!
		);
	} else {
		$minifycss_paths = array(
			$block_style_path,
			$block_theme_path,
			get_template_directory() . '/style.css',
		);
	}
	$block_style_path = get_template_directory() . '/block-style.css';
	if ( @is_file( $block_style_path ) ) {
		$minifycss_paths[] = $block_style_path;
	}

	$flag = false;

	// 日付を比較して、結合後のcssが古かったらフラグを立てる!
	foreach ( $minifycss_paths as $path ) {
		if ( BYAKURAITMP_MINIFY_DATE < filemtime( $path ) ) {
			$flag = true;
		}
	}
	// まだ一度も結合したことがなかったらフラグを立てる!
	if ( 0 === BYAKURAITMP_MINIFY_SIZE ) {
		$flag = true;
	}

	if ( $flag ) {
		// 縮小化ライブラリの読み込み!
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/Minify.php';
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/CSS.php';
		// require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/JS.php';!
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/Exception.php';
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/Exceptions/BasicException.php';
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/Exceptions/FileImportException.php';
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/minify/src/Exceptions/IOException.php';
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/path-converter/src/ConverterInterface.php';
		require_once BYAKURAI_ADON_TEMPLATEFILTER . 'assets/path-converter/src/Converter.php';
		// CSSの中身を読み込んだライブラリでminifyする!
		$minifier = new Minify\CSS();
		foreach ( $minifycss_paths as $path ) {
			$minifier->add( $path );
		}
		// minifyした状態でファイルに保存。!
		$minifier->minify( BYAKURAITMP_MINIFY_PATH );

		global $wp_filesystem;

		if ( WP_Filesystem() ) {
			// minifyしたcssの中身を取得!
			$minify_css = $wp_filesystem->get_contents( BYAKURAITMP_MINIFY_PATH );
			$minify_css = str_replace( '@charset "UTF-8";', '', $minify_css );

			$wp_filesystem->put_contents( BYAKURAITMP_MINIFY_PATH, $minify_css );
		}
	}
	return $flag;
}

// ページや投稿画面が表示されるたびに実行する!
// 他の処理より早く実行した方が良い可能性があるため優先度は高めに設定!
add_action( 'after_setup_theme', 'byakuraitmp_minify_css', 5 );

// styleのデキュー!
function byakuraitmp_remove_css() {
	wp_dequeue_style( 'wp-block-library' ); // WordPress core!
	wp_dequeue_style( 'wp-block-library-theme' ); // WordPress core!
	wp_dequeue_style( 'byakurai-style' );
	if ( is_child_theme() ) {
		wp_dequeue_style( 'child-style' );
	}
	wp_dequeue_style( 'byakurai-block-style' );
}

function byakuraitmp_inline_css() {
	// $wp_filesystemオブジェクトの呼び出し!
	global $wp_filesystem;

	if ( WP_Filesystem() ) {
		// 結合したファイルの中身を取得!
		$out = $wp_filesystem->get_contents( BYAKURAITMP_MINIFY_PATH );
		// インラインで出力!
		echo '<style type="text/css" class="minify">' . wp_strip_all_tags( $out ) . '</style>';
	}
}

// 結合したcssの中身が存在したらデキューとインライン読み込みを実行!
if ( 0 < BYAKURAITMP_MINIFY_SIZE ) {
	add_action( 'wp_enqueue_scripts', 'byakuraitmp_remove_css', 100 );
	add_action( 'wp_head', 'byakuraitmp_inline_css', 11 );
}

// function debug_style_queues() {S

// global $wp_styles;
// global $wp_styles_array;

// foreach ( $wp_styles->queue as $handle ) {

// var_dump( $handle );

// }
// }
// add_action( 'wp_print_styles', 'debug_style_queues', 999 );
