<?php defined( 'ABSPATH' ) || exit;
/**
 *	Title: Theme Login Page
 *	Slug: prime2g/login-page
 *	Categories: featured, prime2g/page-patterns
 *	Description: The basic template for theme's custom login page set in Customizer
 *	Inserter: false
 *	Post Types: page
 *	Keywords: login, page, custom
 */
?>
<!-- wp:html -->
<style id="customLoginCSS">
body.login{display:grid;gap:var(--med-pad);}
#login h1{display:none;}
#login_page_content{padding:var(--med-pad);}

@media(min-width:821px){
body.login{grid-template-columns:1fr 1fr;}
}
</style>
<!-- /wp:html -->

<!-- wp:html -->
<div id="login_page_content">
<?php echo do_shortcode( '[prime_site_logo]' ); ?>
</div>
<!-- /wp:html -->