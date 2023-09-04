/**
 *	PWA JS
 */

// https://stackoverflow.com/questions/44756154/progressive-web-app-how-to-detect-and-handle-when-connection-is-up-again

window.addEventListener( 'online', connectionMonitor );
window.addEventListener( 'offline', connectionMonitor );

function connectionMonitor() {
const ooID	=	'#prime2g_offOnline_notif',
	ooClass		=	'.oo_notif',
	onClass		=	'.online.oo_notif',
	connClass	=	'.connected.oo_notif',
	offClass	=	'.offline.oo_notif';

if ( navigator.onLine ) {
	reachToUrl( getServerUrl() ).then( function( online ) {
	if ( online ) {
	console.log( 'online' );
	prime2g_addClass( [ connClass, offClass ], 'off' );
	prime2g_remClass( [ ooID, onClass ], 'off' );
	}
	else {
	console.log( 'no connectivity' );
	prime2g_addClass( [ onClass, offClass ], 'off' );
	prime2g_remClass( [ ooID, connClass ], 'off' );
	}
	} );
}
else {
	console.log( 'offline' );
	prime2g_addClass( [ onClass, connClass ], 'off' );
	prime2g_remClass( [ ooID, offClass ], 'off' );
}

setTimeout( ()=>{ prime2g_addClass( [ '#prime2g_offOnline_notif' ], 'off' ); }, 10000 );
}


function reachToUrl( url ) {
return fetch( url, { method: 'HEAD', mode: 'no-cors' } )
.then( function( resp ) {
	return resp && ( resp.ok || resp.type === 'opaque' );
} )
.catch( function( err ) {
	console.warn( '[conn test failure]:', err );
} );
}

function getServerUrl() { return window.location.origin; }


p2getEl( '#prime2g_offOnline_notif' ).onclick = ( event )=>{
	prime2g_addClass( [ '#prime2g_offOnline_notif' ], 'off' );
}

