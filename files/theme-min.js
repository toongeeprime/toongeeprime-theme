function p2getEl(e){return document.querySelector(e)}function p2getAll(e){return document.querySelectorAll(e)}function prime2g_inViewport(e){let t=("object"==typeof elmt?elmt:p2getEl(elmt)).getBoundingClientRect();return t.top>=0&&t.left>=0&&t.bottom<=(window.innerHeight||document.documentElement.clientHeight)&&t.right<=(window.innerWidth||document.documentElement.clientWidth)}function prime2g_inViewport_get(e){el="object"==typeof e?e:p2getEl(e);let t=el.getBoundingClientRect();return t.top>=0&&t.left>=0&&t.bottom<=(window.innerHeight||document.documentElement.clientHeight)&&t.right<=(window.innerWidth||document.documentElement.clientWidth)}function prime2g_gotoThis(e){p2getEl(e).scrollIntoView(!0)}function prime2g_class_on_scroll(e,t="pop",n=200){window.addEventListener("scroll",(()=>{let i=p2getEl(e);i&&(window.pageYOffset>n?i.classList.add(t):i.classList.remove(t))}),!1)}function prime2g_count_to(e=100,t=".countEl"){p2getAll(t).forEach((t=>{const n=()=>{const i=+t.getAttribute("countto"),o=+t.getAttribute("speed"),r=+t.innerText,l=o||e,c=i/l;r<i?(t.innerText=Math.ceil(r+c),setTimeout(n,l)):t.innerText=i};n()}))}function prime2g_get_sibling(e,t,n=""){if("previous"===e)var i=t.previousElementSibling;if("next"===e)i=t.nextElementSibling;if(!n)return i;for(;i;){if(i.classList.contains(n))return i;"previous"===e&&(i=i.previousElementSibling),"next"===e&&(i=i.nextElementSibling)}}function prime2g_isMobile(){return"ontouchstart"in document.documentElement}function prime2g_isTouchDevice(){try{return document.createEvent("TouchEvent"),!0}catch(e){return!1}}function prime2g_screenIsSmaller(e=481){return(window.screen.width<window.outerWidth?window.screen.width:window.outerWidth)<e}function insertAfter(e,t){t.parentNode.insertBefore(e,t.nextSibling)}function prime2g_addClass(e,t="prime",n=!0){n&&event.preventDefault(),e.forEach((e=>{elmt=p2getEl(e),elmt&&elmt.classList.add(t)}))}function prime2g_remClass(e,t="prime",n=!0){n&&event.preventDefault(),e.forEach((e=>{elmt=p2getEl(e),elmt&&elmt.classList.remove(t)}))}function prime2g_toggClass(e,t="prime",n=!0){n&&event.preventDefault(),e.forEach((e=>{elmt=p2getEl(e),elmt&&elmt.classList.toggle(t)}))}function primeSetCookie(e,t,n,i=null,o="Lax"){let r=new Date;r.setTime(r.getTime()+24*n*60*60*1e3);let l="expires="+r.toUTCString(),c=i?"; domain="+i:null;document.cookie=encodeURIComponent(e)+"="+encodeURIComponent(t)+"; "+l+";Secure;SameSite="+o+"; path=/"+c}function primeHasCookie(e){return document.cookie.split(";").some((t=>t.trim().startsWith(e)))}function primeGetCookieValue(e){let t=document.cookie.split("; ").find((t=>t.startsWith(e+"=")))?.split("=")[1];return t||"undefined"}function primeCookieIsDefined(e){return primeHasCookie(e)&&"undefined"!==primeGetCookieValue(e)}document.addEventListener("keyup",(function(e){if(e.defaultPrevented)return;let t=e.key||e.keyCode;if("Escape"===t||"Esc"===t||27===t){let e=document.getElementsByClassName("prime");for(;e.length>0;)e[0].classList.remove("prime")}}));