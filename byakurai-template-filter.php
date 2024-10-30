<?php
/**
 * Plugin Name: byakurai template filter
 * Plugin URI: https://wordpress.org/plugins/byakurai-template-filter
 * Description: byakurai template filter is an add-on for the theme byakurai. This plugin automatically creates a page for editing each template. When you edit the body of the page for this template, the edited body is inserted instead of the original template parts of the theme.
 * Version:      1.0.4
 * Requires at least: 5.6
 * Requires PHP: 7.0
 * Author:      yukimichi
 * Author URI:
 * License:     GPL v2 or later
 * Text Domain: byakurai-template-filter
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Donate link: https://ci-en.dlsite.com/creator/13120
 */

/*
  Copyright 2023 yukimichi

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
defined( 'ABSPATH' ) || exit;

// 翻訳読み込み!
load_plugin_textdomain( 'byakurai-template-filter', false, basename( dirname( __FILE__ ) ) . '/languages' );

if ( ! defined( 'BYAKURAI_ADON_TEMPLATEFILTER' ) ) {
	define( 'BYAKURAI_ADON_TEMPLATEFILTER', plugin_dir_path( __FILE__ ) );
}

// ファイルの読み込み!
require BYAKURAI_ADON_TEMPLATEFILTER . 'lib/constant.php';
require BYAKURAI_ADON_TEMPLATEFILTER . 'lib/hook.php';
require BYAKURAI_ADON_TEMPLATEFILTER . 'lib/template-tags.php';
require BYAKURAI_ADON_TEMPLATEFILTER . 'lib/filter-functions.php';
require BYAKURAI_ADON_TEMPLATEFILTER . 'lib/option.php';
// css高速化設定がある場合読み込む!
$byakuraitmp_option = get_option( 'byakuraitmp_option' );
if ( ! is_admin() && isset( $byakuraitmp_option['speedoption']['css'] ) ) {
	if ( 'checked' === $byakuraitmp_option['speedoption']['css'] ) {
		require BYAKURAI_ADON_TEMPLATEFILTER . 'lib/minify.php';
	}
}
// 有効化時に実行する関数!
register_activation_hook( __FILE__, 'byakuraitmp_insert_template' );
