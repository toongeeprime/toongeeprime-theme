function p2getEl(e){return document.querySelector(e)}function p2getAll(e){return document.querySelectorAll(e)}function prime2g_inViewport(e){let t=(el="object"==typeof e?e:p2getEl(e)).getBoundingClientRect();return t.top>=0&&t.left>=0&&t.bottom<=(window.innerHeight||document.documentElement.clientHeight)&&t.right<=(window.innerWidth||document.documentElement.clientWidth)}function prime2g_gotoThis(e){p2getEl(e).scrollIntoView(!0)}function prime2g_class_on_scroll(e,t="pop",i=200){window.addEventListener("scroll",()=>{let n=p2getEl(e);n&&(window.pageYOffset>i?n.classList.add(t):n.classList.remove(t))},!1)}function prime2g_count_to(e=100,t=".countEl"){let i=p2getAll(t);i.forEach(t=>{let i=()=>{let n=+t.getAttribute("countto"),r=+t.getAttribute("speed"),o=+t.innerText,l=r||e;o<n?(t.innerText=Math.ceil(o+n/l),setTimeout(i,l)):t.innerText=n};i()})}function prime2g_get_sibling(e,t,i=""){if("previous"===e)var n=t.previousElementSibling;if("next"===e)var n=t.nextElementSibling;if(!i)return n;for(;n;){if(n.classList.contains(i))return n;"previous"===e&&(n=n.previousElementSibling),"next"===e&&(n=n.nextElementSibling)}}function prime2g_isMobile(){return"ontouchstart"in document.documentElement}function prime2g_isTouchDevice(){try{return document.createEvent("TouchEvent"),!0}catch(e){return!1}}function prime2g_screenIsSmaller(e=481){return(window.screen.width<window.outerWidth?window.screen.width:window.outerWidth)<e}function insertAfter(e,t){t.parentNode.insertBefore(e,t.nextSibling)}function prime2g_addClass(e,t="prime",i=!0){i&&event&&event.preventDefault(),e.forEach(e=>{elmt=p2getEl(e),"array"==typeof t?t.forEach(e=>{elmt?.classList.add(e)}):elmt?.classList.add(t)})}function prime2g_remClass(e,t="prime",i=!0){i&&event&&event.preventDefault(),e.forEach(e=>{elmt=p2getEl(e),"array"==typeof t?t.forEach(e=>{elmt?.classList.remove(e)}):elmt?.classList.remove(t)})}function prime2g_toggClass(e,t="prime",i=!0){i&&event&&event.preventDefault(),e.forEach(e=>{elmt=p2getEl(e),"array"==typeof t?t.forEach(e=>{elmt?.classList.toggle(e)}):elmt?.classList.toggle(t)})}function primeSetCookie(e,t,i,n=null,r="Lax"){let o=new Date;o.setTime(o.getTime()+864e5*i);let l="expires="+o.toUTCString();document.cookie=encodeURIComponent(e)+"="+encodeURIComponent(t)+"; "+l+";Secure;SameSite="+r+"; path=/"+(n?"; domain="+n:null)}function primeHasCookie(e){return document.cookie.split(";").some(t=>t.trim().startsWith(e))}function primeGetCookieValue(e){let t;return document.cookie.split("; ").find(t=>t.startsWith(e+"="))?.split("=")[1]||"undefined"}function primeCookieIsDefined(e){return primeHasCookie(e)&&"undefined"!==primeGetCookieValue(e)}document.addEventListener("keyup",function(e){if(e.defaultPrevented)return;let t=e.key||e.keyCode;if("Escape"===t||"Esc"===t||27===t){let i=document.getElementsByClassName("prime");for(;i.length>0;)i[0].classList.remove("prime")}});