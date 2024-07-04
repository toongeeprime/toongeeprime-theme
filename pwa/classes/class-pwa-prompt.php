<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: Create PWA Prompt
 *	@https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps/How_to/Trigger_install_prompt
 */

class Prime2g_PWA_Prompt {
	/**
	 *	Instantiate
	 */
	private static $instance;

	static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance	=	new self();
		}
	return self::$instance;
	}


	public function __construct() {
		add_action( 'wp_footer', array( $this, 'button' ), 5, 0 );
	}


	function button() {
		$urls	=	wp_cache_get( 'pwa_urls', PRIME2G_APPCACHE );
		$src	=	$urls[ 'appicon' ];
		$siteName	=	str_replace( [ ' ', '\'', '.' ], '', PRIME2G_PWA_SITENAME );

echo '<style id="p2g_pwaBtnCss">
#pwa_install{background:var(--content-background);}
.p2g_pwaBtnWrap{position:fixed;bottom:0;right:0;overflow:hidden;padding:20px 0 0 20px;}
.p2g_pwaBtnWrap.prime .in_pwaBtnWrap{transform:translate(0);visibility:visible;opacity:1;}
.in_pwaBtnWrap{transform:translateX(150%);transition:0.5s;visibility:hidden;opacity:0;
color:var(--content-text);box-shadow:0 0 15px 3px rgba(0,0,0,0.2);}
.p2g_pwaBtnWrap .bi{top:-20px;left:-15px;font-size:1.4em;}
</style>
<div id="p2g_pwaBtnWrap" class="p2g_pwaBtnWrap">
<div id="in_pwaBtnWrap" class="in_pwaBtnWrap prel">
<i id="xpwaPrompt" class="bi bi-x-circle-fill p-abso" title="Close"></i>
<div id="'. PRIME2G_PWA_BTNID .'" class="grid pointer" title="Install Web App" 
style="grid-template-columns:50px 1fr;padding:5px;gap:5px;">
<img src="'. $src .'" alt width="50px" height="50px" />
<button>Install App</button>
</div>
</div>
</div>';

$js	=	'<script id="p2g_pwaPromptJS" async defer>
let p2g_pwaPrompt	=	null,
	stopCookie		=	"'. $siteName .'_stopPrompt";
const	p2g_pwabtnWrap=	p2getEl( "#p2g_pwaBtnWrap" ),
		xpwaPrompt	=	p2getEl( "#xpwaPrompt" ),
		installPWA	=	p2getAll( ".install_pwa_app" ),
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

p2g_pwaBtn.addEventListener( "click", prime_install_app );
if ( installPWA ) {
	installPWA.forEach( ii => { ii.addEventListener( "click", prime_install_app ); } );
}

async function prime_install_app( event ) {
event.preventDefault();
if ( ! p2g_pwaPrompt ) return;
	const result	=	await p2g_pwaPrompt.prompt();
	console.log(`Install prompt was: ${result.outcome}`);
	stopPWAinstallPrompt();
}


function stopPWAinstallPrompt() {
	p2g_pwaPrompt	=	null;
	p2g_pwabtnWrap.classList.remove( "prime" );
}
</script>';

echo $js;
	}
}

