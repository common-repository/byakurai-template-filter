<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * テンプレート用のページを作成
 *
 * @return void
 */
function byakuraitmp_insert_template() {
	// delete_option( 'byakuraitmp_template_ids' );// debug!
	$ids = get_option( 'byakuraitmp_template_ids' );

	if ( false !== $ids ) {
		foreach ( $ids as $key => $value ) {

			if ( false === get_post_status( $value ) ) {
				// 記録されているはずのページが存在しなかったら作り直す!
				$post = array(
					'post_title' => $key,
					'post_type'  => 'page',
				);
				$pid  = wp_insert_post( $post );

				$ids[ $key ] = $pid;
			}
		}

		// 更新でテンプレートが追加された際のために差分を取得!
		$diff = array_diff_key( BYAKURAI_PAGETMP_LIST, $ids );
		if ( false !== $diff && count( BYAKURAI_PAGETMP_LIST ) > count( $ids ) ) {
			foreach ( $diff as $key => $value ) {
				$post = array(
					'post_title' => $key,
					'post_type'  => 'page',
				);
				$pid  = wp_insert_post( $post );

				$ids[ $key ] = $pid;
			}
		}

		update_option( 'byakuraitmp_template_ids', $ids );

	} else {
		$ids = BYAKURAI_PAGETMP_LIST;

		foreach ( $ids as $key => $value ) {
			$post = array(
				'post_title' => $key,
				'post_type'  => 'page',
			);
			$pid  = wp_insert_post( $post );

			$ids[ $key ] = $pid;
		}
		update_option( 'byakuraitmp_template_ids', $ids );
	}
}

if ( ! function_exists( 'byakuraitmp_add_reusable_block_menu' ) ) {
	add_action( 'admin_menu', 'byakuraitmp_add_reusable_block_menu' );
	/**
	 * 管理画面にブロックメニューを追加する
	 *
	 * @return void
	 */
	function byakuraitmp_add_reusable_block_menu() {
		add_menu_page(
			__( 'Reusable Block', 'byakurai-template-filter' ),
			__( 'Reusable Block', 'byakurai-template-filter' ),
			'edit_posts',
			'edit.php?post_type=wp_block',
			'',
			'dashicons-admin-post',
			21
		);
	}
}

/** 高速化 **/
/**
 * 絵文字の読み込みキャンセル
 *
 * @return void
 */
function byakuraitmp_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
// dns-prefetchを非表示にする 絵文字を早く読み込みする効果!
function byakuraitmp_remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}
if ( ! is_admin() ) {
	$byakuraitmp_option = get_option( 'byakuraitmp_option' );
	if ( isset( $byakuraitmp_option['speedoption']['emoji'] ) ) {
		if ( 'checked' === $byakuraitmp_option['speedoption']['emoji'] ) {
			add_action( 'init', 'byakuraitmp_disable_emoji' );
			add_filter( 'wp_resource_hints', 'byakuraitmp_remove_dns_prefetch', 10, 2 );
		}
	}

	if ( isset( $byakuraitmp_option['speedoption']['dashicon'] ) ) {
		if ( 'checked' === $byakuraitmp_option['speedoption']['dashicon'] ) {
			add_action( 'wp_enqueue_scripts', 'byakuraitmp_deregister_styles', 11 );
		}
	}
}
/**
 * ワードプレス用アイコンをフロントエンドで非表示
 *
 * @return void
 */
function byakuraitmp_deregister_styles() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
