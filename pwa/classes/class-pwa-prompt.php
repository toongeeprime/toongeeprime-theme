<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Create PWA Prompt
 *	@ https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps/How_to/Trigger_install_prompt
 */

class Prime2g_PWA_Prompt {

	/**
	 *	Instantiate
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance	=	new self();
		}
		return self::$instance;
	}


	public function __construct() {
		add_action( 'wp_footer', array( $this, 'button' ), 5, 0 );
	}


	public function button() {
		$urls	=	wp_cache_get( 'pwa_urls', PRIME2G_APPCACHE );
		$src	=	$urls[ 'appicon' ];
		$siteName	=	str_replace( [ ' ', '\'', '.' ], '', PRIME2G_PWA_SITENAME );

echo '<style id="p2g_pwaBtnCss">
#p2g_pwaBtnWrap.prime{transform:translate(0);visibility:visible;opacity:1;}
#p2g_pwaBtnWrap{transform:translateX(150%);position:fixed;bottom:0;right:0;transition:0.5s;visibility:hidden;opacity:0;
background-color:#fff;background:var(--content-background);box-shadow:0 0 15px 3px rgba(0,0,0,0.2);}
#p2g_pwaBtnWrap .bi{top:-20px;left:-15px;font-size:1.75em;}
</style>
<div id="p2g_pwaBtnWrap" class="prel">
<i id="xpwaPrompt" class="bi bi-x-circle-fill p-abso" title="Close"></i>
<div id="'. PRIME2G_PWA_BTNID .'" class="grid pointer" title="Install Web App" 
style="grid-template-columns:50px 1fr;padding:5px;gap:5px;">
<img src="'. $src .'" alt width="50px" height="50px" />
<button>Install App</button>
</div>
</div>';

$js	=	'<script id="p2g_pwaPromptJS">
let p2g_pwaPrompt	=	null,
	stopCookie		=	"'. $siteName .'_stopPrompt";
const	p2g_pwabtnWrap=	p2getEl( "#p2g_pwaBtnWrap" ),
		xpwaPrompt	=	p2getEl( "#xpwaPrompt" ),
		p2g_pwaBtn	=	p2getEl( "#'. PRIME2G_PWA_BTNID .'" );

window.addEventListener( "appinstalled", ()=>{ stopPWAinstallPrompt(); } );
xpwaPrompt.addEventListener( "click", ()=>{
	stopPWAinstallPrompt();
	primeSetCookie( stopCookie, "stop", 1 );
	p2getEl( "body" ).classList.add( "prompt_hidden" );
} );

window.addEventListener( "beforeinstallprompt", ( event )=>{
	event.preventDefault();
	if ( primeHasCookie( stopCookie ) ) {
		p2getEl( "body" ).classList.add( "prompt_hidden" )
		return;
	}
	p2g_pwaPrompt	=	event;
	p2g_pwabtnWrap.classList.add( "prime" );
} );

p2g_pwaBtn.addEventListener( "click", async ()=>{
if ( ! p2g_pwaPrompt ) { return; }

	const result	=	await p2g_pwaPrompt.prompt();
	console.log(`Install prompt was: ${result.outcome}`);
	stopPWAinstallPrompt();
} );

function stopPWAinstallPrompt() {
	p2g_pwaPrompt	=	null;
	p2g_pwabtnWrap.classList.remove( "prime" );
}
</script>';

echo $js;
	}

}
