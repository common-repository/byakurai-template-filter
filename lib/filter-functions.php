<?php
/**
 * テーマの表示用関数を上書き
 */

function byakuraitmp_print_home() {
	$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_HOME_INDEX );
	return $tmpcon;
}

function byakuraitmp_print_search() {
	$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_SEARCH );
	return $tmpcon;
}

/**
 *
 */
function byakuraitmp_print_archive() {
	$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_ARCHIVE );
	return $tmpcon;
}

// singlepost!
/**
 *
 */
function byakuraitmp_print_single() {

	$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_SINGLE );
	return $tmpcon;
}

// singlepage!
/**
 *
 */
function byakuraitmp_print_page() {
	$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_PAGE );
	return $tmpcon;
}

// 404!
/**
 *
 */
function byakuraitmp_print_404() {
	$tmpcon = byakuraitmp_the_content( BYAKURAI_PAGETMP_404 );
	return $tmpcon;
}

// header!
/**
 *
 */
function byakuraitmp_print_header() {
	$tmpcon = byakuraitmp_header_content();
	return $tmpcon;
}

/**
 *
 */
function byakuraitmp_print_header_un() {
	$tmpcon = byakuraitmp_headerun_content();
	return $tmpcon;
}

// footer!
/**
 *
 */
function byakuraitmp_print_footer() {
	$tmpcon = byakuraitmp_footer_content();
	return $tmpcon;
}

// sidebar!
/**
 *
 */
function byakuraitmp_print_side_three() {
	$tmpcon = byakuraitmp_leftsidebar_content();
	return $tmpcon;
}
/**
 *
 */
function byakuraitmp_print_side_four() {
	$tmpcon = byakuraitmp_rightsidebar_content();
	return $tmpcon;
}
