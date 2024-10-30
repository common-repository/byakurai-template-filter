<?php
defined( 'ABSPATH' ) || exit;

/**
 * テンプレート本文が存在するか確認
 *
 * @param [type] $tmpkey
 * @return false or content
 */
function byakuraitmp_get_content( $tmpkey = '' ) {
	$ids = get_option( 'byakuraitmp_template_ids' );

	if ( isset( $ids[ $tmpkey ] ) ) {

		$content = get_post( $ids[ $tmpkey ], 'OBJECT', 'display' )->post_content;

		if ( null === $content || '' === $content ) {
			return false;
		} else {
			if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
				$content;
			}
			return $content;
		}
	} else {
		return false;
	}
}

/**
 * テンプレート本文出力
 *
 * @param string $tmpkey
 * @param string $side
 * @return bool
 */
function byakuraitmp_the_content( $tmpkey = '', $side = '' ) {
	$ids = get_option( 'byakuraitmp_template_ids' );

	if ( isset( $ids[ $tmpkey ] ) ) {

		$content = get_post( $ids[ $tmpkey ], 'OBJECT', 'display' )->post_content;

		if ( null !== $content && '' !== $content ) {
			if ( 'sidebar-left' === $side ) {
				?>
				<aside id="secondary-three" class="widget-area sidebar">
					<div id="aside-child">
					<?php
					echo apply_shortcodes( do_blocks( $content ) );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
					edit_post_link( __( 'Edit template left sidbar', 'byakurai-template-filter' ), '', '', $ids[ $tmpkey ] );
					?>
					</div>
				</aside>
				<?php
			} elseif ( 'sidebar-right' === $side ) {
				?>
				<aside id="secondary-four" class="widget-area sidebar">
					<div id="aside-child">
					<?php
					echo apply_shortcodes( do_blocks( $content ) );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
					edit_post_link( __( 'Edit template right sidbar', 'byakurai-template-filter' ), '', '', $ids[ $tmpkey ] );
					?>
					</div>
				</aside>
				<?php
			} else {
				echo apply_shortcodes( do_blocks( $content ) );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
			}

			return $ids[ $tmpkey ];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/**
 * ヘッダーの出力制御
 */
function byakuraitmp_header_content() {
	if ( is_tax() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_TAXONOMY_HEADER );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HEADER );
		}
	} elseif ( is_front_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FRONT_HEADER );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HEADER );
		}
	} elseif ( is_singular() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_SINGULAR_HEADER );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HEADER );
		}
	} else {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HEADER );
	}
	return $tmpcon;
}

/**
 * ヘッダー下の出力制御
 */
function byakuraitmp_headerun_content() {
	if ( is_front_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FRONT_HEADER_UN );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HEADER_UN );
		}
	} else {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HEADER_UN );
	}
	return $tmpcon;
}

/**
 * フッターーの出力制御
 */
function byakuraitmp_footer_content() {
	if ( is_front_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FRONT_FOOTER );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FOOTER );
		}
	} elseif ( is_singular() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_SINGULAR_FOOTER );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FOOTER );
		}
	} else {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FOOTER );
	}
	return $tmpcon;
}

/**
 * 左サイドバーの出力制御
 */
function byakuraitmp_leftsidebar_content() {
	if ( is_front_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FRONT_L, 'sidebar-left' );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_L, 'sidebar-left' );
		}
	} elseif ( is_single() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_SINGLE_L, 'sidebar-left' );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_L, 'sidebar-left' );
		}
	} elseif ( is_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_PAGE_L, 'sidebar-left' );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_L, 'sidebar-left' );
		}
	} else {
		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_L, 'sidebar-left' );
	}
	return $tmpcon;
}

/**
 * 右サイドバーの出力制御
 */
function byakuraitmp_rightsidebar_content() {
	if ( is_front_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_FRONT_R, 'sidebar-right' );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_R, 'sidebar-right' );
		}
	} elseif ( is_single() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_SINGLE_R, 'sidebar-right' );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_R, 'sidebar-right' );
		}
	} elseif ( is_page() ) {

		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_PAGE_R, 'sidebar-right' );
		if ( false === $tmpcon ) {
			$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_R, 'sidebar-right' );
		}
	} else {
		$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_R, 'sidebar-right' );
	}
	return $tmpcon;
}
