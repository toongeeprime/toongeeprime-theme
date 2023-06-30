<?php defined( 'ABSPATH' ) || exit;

/**
 *	WOOCOMMERCE JS SCRIPTS
 *
 *	@package WordPress
 *	@package WooCommerce
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Run if WooCommerce is active
 */
if ( class_exists( 'WooCommerce' ) ) :


/**
 *		Add to WP FOOTER
 */
add_action( 'wp_footer', 'prime2g_woocommerceJS' );
if ( ! function_exists( 'prime2g_woocommerceJS' ) ) {

function prime2g_woocommerceJS() { ?>

<script id="prime2g_woocommerce_js">
jQuery( document ).ready( function() {

<?php
/**
 *	On Woo checkout page:
 */
if ( is_checkout() ) { ?>

jQuery( document.body ).on( 'updated_checkout', function() {

let pay_meths	=	document.querySelectorAll( '.wc_payment_method .input-radio' );
if ( pay_meths ) {
	pay_meths[0].parentElement.classList.add( 'prime_active' );
	pay_meths.forEach( ( method )=>{
		method.addEventListener( 'change', ()=>{
			pay_meths.forEach( ( li )=>{
				li.parentElement.classList.remove( 'prime_active' );
			} );
			method.parentElement.classList.add( 'prime_active' );
		} );
	} );
}

} );

<?php } ?>

});
</script>
<?php

}
}



endif;

