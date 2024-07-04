<?php defined( 'ABSPATH' ) || exit;
/**
 *	WOOCOMMERCE JS SCRIPTS
 *	@package WordPress
 *	@package WooCommerce
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Run if WooCommerce is active
 */
if ( class_exists( 'WooCommerce' ) ) :

add_action( 'wp_footer', 'prime2g_woocommerceJS' );
if ( ! function_exists( 'prime2g_woocommerceJS' ) ) {
function prime2g_woocommerceJS() { ?>

<script id="prime2g_woocommerce_js">
( ($)=>{
$( document ).ready( ()=>{

$( 'body' ).on( 'added_to_cart', ()=>{ $( 'body' ).addClass( 'added_to_cart' ); } );
// review jQ hooks: removed_from_cart, wc_cart_emptied
<?php
/**
 *	@ Woo checkout page
 */
if ( is_checkout() ) { ?>

$( document.body ).on( 'updated_checkout', ()=>{

let pay_meths	=	p2getAll( '.wc_payment_method .input-radio' );
if ( pay_meths ) {
	pay_meths[0]?.parentElement.classList.add( 'prime_active' );
	pay_meths.forEach( method => {
		method?.addEventListener( 'change', ()=>{
			pay_meths.forEach( li => { li?.parentElement.classList.remove( 'prime_active' ); } );
			method.parentElement.classList.add( 'prime_active' );
		} );
	} );
}

} );

<?php } ?>

} );
} )( jQuery );
</script>
<?php

}
}


endif;

