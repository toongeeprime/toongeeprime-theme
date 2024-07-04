<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: PWA Push Notifications
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.98
 */

class Prime2g_Push_Notifications {

	private static $instance;
	private $vapidKey;
	public $appName;

	public function __construct( string $appName ) {
	if ( ! isset( self::$instance ) ) {
	if ( ! prime2g_run_pwa_push_notifs() ) return;

	$auth			=	new Prime2gCredentials;
	$this->vapidKey	=	$auth->vapid();

	// new Prime2g_Push_Database;

	$this->appName	=	$appName;	# provided @ manifest class

	// add_filter( 'prime2g_filter_cached_pwa_scripts', [ $this, 'script' ] );
	add_filter( 'prime2g_filter_pwa_scripts', [ $this, 'script' ] );	// WIP
	// add_filter( 'prime2g_filter_cached_service_worker', [ $this, 'service_worker' ] );
	}

	return self::$instance;
	}



	function script() {
	return	'
/*	Notif Permissions	*/
const permitBtn	=	p2getEl( "#'. PWA_PUSHPERMIT_BTN_ID .'" );

if ( ("Notification" in window) && Notification.permission === "granted" ) {
	permitBtn ? permitBtn.style.display	=	"none" : "";
	p2getEl( "body" ).classList.add( "app_notif_granted" );
}


primeAppNotifPermit();
function primeAppNotifPermit( permitBtn ) {
permitBtn?.addEventListener( "click", ()=>{
if ( !("Notification" in window) ) {
	return alert( "Notifications not supported in this browser!" );
}

if ( Notification.permission === "granted" ) {
	const notification	=	new Notification( "Hi there! '. $this->appName .' notifications are active already, thanks." );
	return console.log("User has already accepted notifications");
}

Notification.requestPermission().then( permission => {
if ( permission === "granted" ) {
	permitBtn.style.display	=	"none";
	const notification	=	new Notification( "Hi there! Thanks for activating '. $this->appName .' notifications." );
}
} );
} );
}


function urlBase64ToUint8Array( base64String ) {
var padding	=	"=".repeat((4 - base64String.length % 4) % 4),
	base64	=	(base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");

var rawData	=	window.atob(base64),
	outputArray	=	new Uint8Array(rawData.length);

for (var i = 0; i < rawData.length; ++i) {
	outputArray[i] = rawData.charCodeAt(i);
}
return outputArray;
}


// p2getEl( "#stickySidebarToggler" ).addEventListener( "click", primeSubscribeToPushNotes );

async function prime_subscribe_to_notif_server() {
formData	=	{
	action : "prime2g_doing_ajax_nopriv",
	"prime_do_ajax" : "subscribe_pwa_notifications",
	"_prime-nonce" : "'. wp_create_nonce( 'prime_nonce_action' ) .'"
};
ajaxSuccess	=	function( response ) {
	if ( response && ! response.hasOwnProperty( "error" ) ) {
		console.log( response );
	}
	else {
		console.log( "Search Response Failed: " + JSON.stringify( response ) );
	}
}
ajaxError	=	function( response ) {
	console.log( "Server Error: " + response.statusText + " status: " + response.status + " - Error Info: " + JSON.stringify( response ) );
}

return prime2g_run_ajax( formData, ajaxSuccess, ajaxError );
}



async function primeSubscribeToPushNotes() {
const serviceWorkerRegn	=	await navigator.serviceWorker.ready;

/*
let pushSubscription	=	serviceWorkerRegn.pushManager.getSubscription();
if ( pushSubscription )
	return console.log( "Push already subscribed" );
*/

try {
pushSubscription	=	await serviceWorkerRegn.pushManager.subscribe( {
	userVisibleOnly: true,
	applicationServerKey: urlBase64ToUint8Array( "'. $this->vapidKey .'" )
} );

if ( pushSubscription ) {
	console.log( "ENDPOINT: " + pushSubscription.endpoint );	// Push services URL. To trigger a push message, make a POST request to this URL
	const notification	=	new Notification( "Great! '. $this->appName .' subscription is successful!" );
}

} catch (err) {
	console.log( "Push Subcription Error", err );
}
}';
	}



	function service_worker() {
return	'

//	PUSH NOTES
async function primeReSubscribeToPushNotes() {
return self.registration.pushManager.getSubscription()
.then( (subscription)=>{
if (subscription) {
	return subscription.unsubscribe();
}
})
.then( ()=>{
return self.registration.pushManager.subscribe({
	userVisibleOnly: true,
	applicationServerKey: urlBase64ToUint8Array(  "'. $this->vapidKey .'"  )
});
})
.then( (subscription)=>{
	console.log( "Resubscribed to push notifications:", subscription);
	// Optionally, send new subscription details to your server
})
.catch( (error)=>{
	console.error( "Failed to resubscribe:", error );
});
}



//	Display Them
self.addEventListener( "push", event => {	// event ?? response?
if ( Notification.permission === "granted" ) {
// Get the notification data from the server.
const notif_Data		=	event.data;
const notificationText	=	notif_Data.text();

const showNotificationPromise	=	self.registration.showNotification( notif_Data.title, {
body: notificationText,
icon: "images/icon512.png"
} );

// Keep the service worker running until the notification is displayed.
event.waitUntil( showNotificationPromise );

// Attempt to resubscribe after receiving a notification
event.waitUntil(primeReSubscribeToPushNotes());
}
} );';
	}

}


/*	STUDY
notificationclick event
notificationclose
ServiceWorkerRegistration.getNotifications()
ServiceWorkerRegistration.showNotification()
*/

