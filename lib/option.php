<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// 設定ページ追加!

add_action(
	'admin_menu',
	function () {
		add_options_page( 'byakurai template filter', 'byakurai template filter option', 'manage_options', 'byakurai_template-filter', 'byakuraitmp_option_page' );
	}
);

add_action(
	'init',
	function () {
		if ( isset( $_POST['Template_regeneration_name'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['Template_regeneration_name'] ) ), 'Template_regeneration_action' ) && isset( $_POST['Template_regeneration'] ) ) {
			byakuraitmp_insert_template();
		}

		if ( isset( $_POST['speedup_name'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['speedup_name'] ) ), 'speedup_action' ) && isset( $_POST['speedup_submit'] ) ) {
			if ( isset( $_POST['speedoption'] ) ) {
				$byakuraitmp_option                = get_option( 'byakuraitmp_option' );
				$byakuraitmp_option['speedoption'] = $_POST['speedoption'];
				update_option( 'byakuraitmp_option', $byakuraitmp_option );
			} else {
				$byakuraitmp_option                            = get_option( 'byakuraitmp_option' );
				$byakuraitmp_option['speedoption']['css']      = '';
				$byakuraitmp_option['speedoption']['emoji']    = '';
				$byakuraitmp_option['speedoption']['dashicon'] = '';
				update_option( 'byakuraitmp_option', $byakuraitmp_option );
			}
		}
	}
);

/**
 * オプションページ生成
 *
 * @return void
 */
function byakuraitmp_option_page() {
	?>
	<style>
	.option-form{
		display:block;
		border:1px solid whitesmoke;
		margin:1.3vw;
		background-color:white;
		padding:1em;
	}
	</style>
	<div class="wrap">
		<form class="option-form" id="regeneration-form" method="post">
		<?php
			wp_nonce_field( 'Template_regeneration_action', 'Template_regeneration_name' );  // nonceフィールド設置!
		?>
			<p class="submit">
				<input type="submit" class="button button-primary" name="Template_regeneration" value="<?php esc_attr_e( 'Template regeneration', 'byakurai-template-filter' ); ?>">
			</p>
		</form>

		<form class="option-form" id="regeneration-form" method="post">
			<?php
			wp_nonce_field( 'speedup_action', 'speedup_name' );  // nonceフィールド設置!
			?>
			<div>
				<p>
					<h2><?php esc_html_e( 'Speeding up settings', 'byakurai-template-filter' ); ?></h2><br>
					<?php esc_html_e( '*Do not use with other acceleration plug-ins at the same time.', 'byakurai-template-filter' ); ?><br>
					<?php esc_html_e( '*If the display is corrupted after use, uncheck the box and save the file again.', 'byakurai-template-filter' ); ?>
				</p>
				<?php
					$byakuraitmp_option = get_option( 'byakuraitmp_option' );
					// var_dump( $byakuraitmp_option['speedoption'] );!
					$checkboxs = array(
						'css'      => __( 'Compress theme css for inline output', 'byakurai-template-filter' ),
						'emoji'    => __( 'Cancel loading of emoji set in WordPress', 'byakurai-template-filter' ),
						'dashicon' => __( 'WordPress icon fonts (dash icons) not loaded on front end', 'byakurai-template-filter' ),
					);
					foreach ( $checkboxs as $key => $message ) {
						$optionvalue = '';
						if ( isset( $byakuraitmp_option['speedoption'][ $key ] ) ) {
							$optionvalue = $byakuraitmp_option['speedoption'][ $key ];
						}
						echo '<p><input class="checkbox" type="checkbox" name="speedoption[' . esc_attr( $key ) . ']" value="checked" ' . esc_attr( $optionvalue ) . '>';
						echo esc_html( $message );
					}
					?>
			</div>
			<p class="submit">
				<input type="submit" class="button button-primary" name="speedup_submit" value="<?php esc_attr_e( 'Submit', 'byakurai-template-filter' ); ?>">
			</p>
		</form>
	</div>
	<?php
}
