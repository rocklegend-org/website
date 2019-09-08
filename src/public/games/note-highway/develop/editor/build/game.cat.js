/*! rocklegend note-highway 08-09-2019 */

/*! luv 0.0.1 (2013-11-17) - https://github.com/kikito/luv.js */
/*! Minimal HTML5 game development lib */
/*! Enrique Garcia Cota */
(function(t,e){"object"==typeof exports?module.exports=e():"function"==typeof define&&define.amd?define("Luv",[],e):t.Luv=e()})(this,function(){var t=function(){var t=function(t){for(var e,n=1;arguments.length>n;n++){e=arguments[n];for(var i in e)e.hasOwnProperty(i)&&(t[i]=e[i])}return t},e=function(t,e){e=Array.isArray(e)?e:[e];for(var n=0;e.length>n;n++)delete t[e[n]];return t},n=Object.create,i={toString:function(){return"instance of "+this.getClass().getName()}},r=t(function(){return n(i)},{init:function(){},getName:function(){return"Base"},toString:function(){return"Base"},getSuper:function(){return null},methods:i,include:function(){return t.apply(this,[this.methods].concat(Array.prototype.slice.call(arguments,0)))},subclass:function(i,r){r=r||{};var o=this,s=function(){return i},u=e(t(n(o.methods),r),"init"),a=t(function(){var t=n(u);return a.init.apply(t,arguments),t},o,r,{getName:s,toString:s,getSuper:function(){return o},methods:u});return u.getClass=function(){return a},a}});i.getClass=function(){return r};var o=r.subclass("Luv",{init:function(t){t=s(t);var e=this;if(e.el=t.el,e.el.tabIndex=1,"load update draw run onResize onBlur onFocus".split(" ").forEach(function(n){t[n]&&(e[n]=t[n])}),e.media=o.Media(),e.timer=o.Timer(),e.keyboard=o.Keyboard(e.el),e.mouse=o.Mouse(e.el),e.touch=o.Touch(e.el),e.audio=o.Audio(e.media),e.graphics=o.Graphics(e.el,e.media),e.canvas=o.Graphics.Canvas(e.el),t.fullWindow){var n=function(){e.canvas.setDimensions(window.innerWidth,window.innerHeight),e.onResize(window.innerWidth,window.innerHeight)};window.addEventListener("resize",n,!1),window.addEventListener("orientationChange",n,!1),e.el.focus()}e.el.addEventListener("blur",function(){e.onBlur()}),e.el.addEventListener("focus",function(){e.onFocus()})},load:function(){},draw:function(){},update:function(){},run:function(){var t=this;t.load();var e=function(){t.timer.nativeUpdate(t.el);var n=t.timer.getDeltaTime();t.update(n),t.canvas.clear(),t.draw(),t.timer.nextFrame(e)};t.timer.nextFrame(e)},onResize:function(){},onBlur:function(){},onFocus:function(){}});o.Class=function(t,e){return r.subclass(t,e)},o.Base=r,o.extend=t;var s=function(t){t=t||{};var e=t.el,n=t.id,i=t.width,r=t.height,o=document.getElementsByTagName("body")[0],s=document.getElementsByTagName("html")[0],u="width: 100%; height: 100%; margin: 0; overflow: hidden;";return!e&&n&&(e=document.getElementById(n)),e?(!i&&e.getAttribute("width")&&(i=Number(e.getAttribute("width"))),!r&&e.getAttribute("height")&&(r=Number(e.getAttribute("height")))):(e=document.createElement("canvas"),o.appendChild(e)),t.fullWindow?(s.style.cssText=o.style.cssText=u,i=window.innerWidth,r=window.innerHeight):(i=i||800,r=r||600),e.setAttribute("width",i),e.setAttribute("height",r),t.el=e,t.width=i,t.height=r,t};return o}();return function(){t.Timer=t.Class("Luv.Timer",{init:function(){this.microTime=n.now(),this.deltaTime=0,this.deltaTimeLimit=t.Timer.DEFAULT_DELTA_TIME_LIMIT,this.events={},this.maxEventId=0},nativeUpdate:function(t){this.update((n.now()-this.microTime)/1e3,t)},update:function(t){this.deltaTime=Math.max(0,Math.min(this.deltaTimeLimit,t)),this.microTime+=1e3*t;for(var e in this.events)this.events.hasOwnProperty(e)&&this.events[e].update(t)&&delete this.events[e]},setDeltaTimeLimit:function(t){this.deltaTimeLimit=t},getDeltaTimeLimit:function(){return this.deltaTimeLimit},getDeltaTime:function(){return Math.min(this.deltaTime,this.deltaTimeLimit)},getFPS:function(){return 0===this.deltaTime?0:1/this.deltaTime},nextFrame:function(t){r(t)},after:function(n,i,r){return e(this,t.Timer.After(n,i,r))},every:function(n,i,r){return e(this,t.Timer.Every(n,i,r))},tween:function(n,i,r,o){return e(this,t.Timer.Tween(n,i,r,o))},clear:function(t){return this.events[t]?(delete this.events[t],!0):!1}}),t.Timer.DEFAULT_DELTA_TIME_LIMIT=.25;var e=function(t,e){var n=t.maxEventId++;return t.events[n]=e,n},n=window.performance||Date;n.now=n.now||n.msNow||n.mozNow||n.webkitNow||Date.now;var i=0,r=window.requestAnimationFrame||window.msRequestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.oRequestAnimationFrame||function(t){var e=n.now(),r=Math.max(0,16-(e-i)),o=setTimeout(function(){t(e+r)},r);return i=e+r,o}}(),function(){t.Timer.After=t.Class("Luv.Timer.After",{init:function(t,e,n){this.timeRunning=0,this.timeToCall=t,this.callback=e,this.context=n},update:function(t){this.timeRunning+=t;var e=this.timeRunning-this.timeToCall;return e>=0?(this.callback.call(this.context,e),!0):!1}})}(),function(){t.Timer.Every=t.Class("Luv.Timer.Every",{init:function(t,e,n){this.timeRunning=0,this.timeToCall=t,this.callback=e,this.context=n},update:function(t){if(this.timeRunning+=t,this.timeToCall>0)for(;this.timeRunning>=this.timeToCall;)this.callback.call(this.context,this.timeRunning-this.timeToCall),this.timeRunning-=this.timeToCall;else this.callback.call(this.context,t);return!1}})}(),function(){t.Timer.Tween=t.Class("Luv.Timer.Tween",{init:function(t,e,n,i){K(e,n,[]),i=i||{},this.easing=U(i.easing),this.every=i.every||this.every,this.after=i.after||this.after,this.context=i.context||this,this.runningTime=0,this.finished=!1,this.timeToFinish=t,this.subject=e,this.from=X(e,n),this.to=X(n)},update:function(t){return this.runningTime>=this.timeToFinish?void 0:(this.runningTime+=t,this.runningTime>=this.timeToFinish&&(this.runningTime=this.timeToFinish,this.after.call(this.context),this.finished=!0),this.every.call(this.context,Q(this,this.from,this.to)),this.finished)},every:function(t){this.subject=z(this.subject,t)},after:function(){},isFinished:function(){return!!this.finished}});var e=function(t,e,n,i){return n*t/i+e},n=function(t,e,n,i){return n*Math.pow(t/i,2)+e},i=function(t,e,n,i){return t/=i,-n*t*(t-2)+e},r=function(t,e,n,i){return t=2*(t/i),1>t?n/2*Math.pow(t,2)+e:-n/2*((t-1)*(t-3)-1)+e},o=function(t,e,r,o){return o/2>t?i(2*t,e,r/2,o):n(2*t-o,e+r/2,r/2,o)},u=function(t,e,n,i){return n*Math.pow(t/i,3)+e},a=function(t,e,n,i){return n*(Math.pow(t/i-1,3)+1)+e},h=function(t,e,n,i){return t=2*(t/i),1>t?n/2*t*t*t+e:(t-=2,n/2*(t*t*t+2)+e)},c=function(t,e,n,i){return i/2>t?a(2*t,e,n/2,i):u(2*t-i,e+n/2,n/2,i)},f=function(t,e,n,i){return n*Math.pow(t/i,4)+e},d=function(t,e,n,i){return-n*(Math.pow(t/i-1,4)-1)+e},l=function(t,e,n,i){return t=2*(t/i),1>t?n/2*Math.pow(t,4)+e:-n/2*(Math.pow(t-2,4)-2)+e},p=function(t,e,n,i){return i/2>t?d(2*t,e,n/2,i):f(2*t-i,e+n/2,n/2,i)},g=function(t,e,n,i){return n*Math.pow(t/i,5)+e},m=function(t,e,n,i){return n*(Math.pow(t/i-1,5)+1)+e},v=function(t,e,n,i){return t=2*(t/i),1>t?n/2*Math.pow(t,5)+e:n/2*(Math.pow(t-2,5)+2)+e},w=function(t,e,n,i){return i/2>t?m(2*t,e,n/2,i):g(2*t-i,e+n/2,n/2,i)},y=function(t,e,n,i){return-n*Math.cos(t/i*(Math.PI/2))+n+e},T=function(t,e,n,i){return n*Math.sin(t/i*(Math.PI/2))+e},b=function(t,e,n,i){return-n/2*(Math.cos(Math.PI*t/i)-1)+e},A=function(t,e,n,i){return i/2>t?T(2*t,e,n/2,i):y(2*t-i,e+n/2,n/2,i)},L=function(t,e,n,i){return 0===t?e:n*Math.pow(2,10*(t/i-1))+e-.001*n},x=function(t,e,n,i){return t==i?e+n:1.001*n*(-Math.pow(2,-10*t/i)+1)+e},E=function(t,e,n,i){return 0===t?e:t==i?e+n:(t=2*(t/i),1>t?n/2*Math.pow(2,10*(t-1))+e-5e-4*n:1.0005*(n/2)*(-Math.pow(2,-10*(t-1))+2)+e)},C=function(t,e,n,i){return i/2>t?x(2*t,e,n/2,i):L(2*t-i,e+n/2,n/2,i)},S=function(t,e,n,i){return-n*(Math.sqrt(1-Math.pow(t/i,2))-1)+e},M=function(t,e,n,i){return n*Math.sqrt(1-Math.pow(t/i-1,2))+e},I=function(t,e,n,i){return t=2*(t/i),1>t?-n/2*(Math.sqrt(1-t*t)-1)+e:(t-=2,n/2*(Math.sqrt(1-t*t)+1)+e)},k=function(t,e,n,i){return i/2>t?M(2*t,e,n/2,i):S(2*t-i,e+n/2,n/2,i)},P=function(t,e,n,i){return t=t===void 0?.3*i:t,e=e||0,Math.abs(n)>e?(e=n,s=t/4):s=t/(2*Math.PI)*Math.asin(n/e),[t,e,s]},O=function(t,e,n,i,r,o){if(0===t)return e;if(t/=i,1==t)return e+n;var s=P(o,r,n,i),u=s[2];return o=s[0],r=s[1],t-=1,-(r*Math.pow(2,10*t)*Math.sin((t*i-u)*2*Math.PI/o))+e},R=function(t,e,n,i,r,o){if(0===t)return e;if(t/=i,1==t)return e+n;var s=P(o,r,n,i),u=s[2];return o=s[0],r=s[1],r*Math.pow(2,-10*t)*Math.sin((t*i-u)*2*Math.PI/o)+n+e},F=function(t,e,n,i,r,o){if(0===t)return e;if(t/=i,1==t)return e+n;var s=P(o,r,n,i),u=s[2];return o=s[0],r=s[1],t-=1,0>t?-.5*r*Math.pow(2,10*t)*Math.sin((t*i-u)*2*Math.PI/o)+e:.5*r*Math.pow(2,-10*t)*Math.sin((t*i-u)*2*Math.PI/o)+n+e},D=function(t,e,n,i,r,o){return i/2>t?R(2*t,e,n/2,i,r,o):O(2*t-i,e+n/2,n/2,i,r,o)},N=function(t,e,n,i,r){return r=r||1.70158,t/=i,n*t*t*((r+1)*t-r)+e},B=function(t,e,n,i,r){return r=r||1.70158,t=t/i-1,n*(t*t*((r+1)*t+r)+1)+e},G=function(t,e,n,i,r){return r=1.525*(r||1.70158),t=2*(t/i),1>t?n/2*t*t*((r+1)*t-r)+e:(t-=2,n/2*(t*t*((r+1)*t+r)+2)+e)},W=function(t,e,n,i,r){return i/2>t?B(2*t,e,n/2,i,r):N(2*t-i,e+n/2,n/2,i,r)},j=function(t,e,n,i){return t/=i,1/2.75>t?n*7.5625*t*t+e:2/2.75>t?(t-=1.5/2.75,n*(7.5625*t*t+.75)+e):2.5/2.75>t?(t-=2.25/2.75,n*(7.5625*t*t+.9375)+e):(t-=2.625/2.75,n*(7.5625*t*t+.984375)+e)},_=function(t,e,n,i){return n-j(i-t,0,n,i)+e},q=function(t,e,n,i){return i/2>t?.5*_(2*t,0,n,i)+e:.5*j(2*t-i,0,n,i)+.5*n+e},H=function(t,e,n,i){return i/2>t?j(2*t,e,n/2,i):_(2*t-i,e+n/2,n/2,i)};t.Timer.Tween.easing={linear:e,inQuad:n,outQuad:i,inOutQuad:r,outInQuad:o,inCubic:u,outCubic:a,inOutCubic:h,outInCubic:c,inQuart:f,outQuart:d,inOutQuart:l,outInQuart:p,inQuint:g,outQuint:m,inOutQuint:v,outInQuint:w,inSine:y,outSine:T,inOutSine:b,outInSine:A,inExpo:L,outExpo:x,inOutExpo:E,outInExpo:C,inCirc:S,outCirc:M,inOutCirc:I,outInCirc:k,inElastic:O,outElastic:R,inOutElastic:F,outInElastic:D,inBack:N,outBack:B,inOutBack:G,outInBack:W,inBounce:_,outBounce:j,inOutBounce:q,outInBounce:H};var K=function(t,e,n){var i,r;for(var o in e)if(e.hasOwnProperty(o))if(i=typeof e[o],r=n.slice(0),r.push(o+""),"number"===i){if("number"!=typeof t[o])throw Error("Parameter '"+r.join("/")+"' is missing from 'from' or isn't a number")}else{if("object"!==i)throw Error("Parameter '"+r.join("/")+"' must be a number or string, was "+e[o]);K(t[o],e[o],r)}},Q=function(t,e,n){var i;if("object"==typeof n){i=Array.isArray(n)?[]:{};for(var r in n)n.hasOwnProperty(r)&&(i[r]=Q(t,e[r],n[r]))}else i=t.easing(t.runningTime,e,n-e,t.timeToFinish);return i},U=function(e){return e=e||"linear","string"==typeof e?t.Timer.Tween.easing[e]:e},z=function(t,e,n){if(n=n||e,"object"==typeof e){t=t||(Array.isArray(e)?[]:{});for(var i in e)e.hasOwnProperty(i)&&(t[i]=z(t[i],e[i],n[i]))}else t=e;return t},X=function(t,e){return z(null,t,e)}}(),function(){t.Keyboard=t.Class("Luv.Keyboard",{init:function(t){var e=this;return e.keysDown={},e.el=t,t.addEventListener("keydown",function(t){t.preventDefault(),t.stopPropagation();var n=r(t);e.keysDown[n]=!0,e.onPressed(n,t.which)}),t.addEventListener("keyup",function(t){t.preventDefault(),t.stopPropagation();var n=r(t);e.keysDown[n]=!1,e.onReleased(n,t.which)}),e},onPressed:function(){},onReleased:function(){},isDown:function(t){return!!this.keysDown[t]}});var e={8:"backspace",9:"tab",13:"enter",16:"shift",17:"ctrl",18:"alt",19:"pause",20:"capslock",27:"escape",33:"pageup",34:"pagedown",35:"end",36:"home",45:"insert",46:"delete",37:"left",38:"up",39:"right",40:"down",91:"lmeta",92:"rmeta",93:"mode",96:"kp0",97:"kp1",98:"kp2",99:"kp3",100:"kp4",101:"kp5",102:"kp6",103:"kp7",104:"kp8",105:"kp9",106:"kp*",107:"kp+",109:"kp-",110:"kp.",111:"kp/",112:"f1",113:"f2",114:"f3",115:"f4",116:"f5",117:"f6",118:"f7",119:"f8",120:"f9",121:"f10",122:"f11",123:"f12",144:"numlock",145:"scrolllock",186:",",187:"=",188:",",189:"-",190:".",191:"/",192:"`",219:"[",220:"\\",221:"]",222:"'"},n={192:"~",48:")",49:"!",50:"@",51:"#",52:"$",53:"%",54:"^",55:"&",56:"*",57:"(",109:"_",61:"+",219:"{",221:"}",220:"|",59:":",222:'"',188:"<",189:">",191:"?",96:"insert",97:"end",98:"down",99:"pagedown",100:"left",102:"right",103:"home",104:"up",105:"pageup"},i={16:"rshift",17:"rctrl",18:"ralt"},r=function(t){var r,o=t.which;return r=t.keyLocation&&t.keyLocation>1?i[o]:t.shiftKey?n[o]||e[o]:e[o],r===void 0&&(r=String.fromCharCode(o),t.shiftKey&&(r=r.toUpperCase())),r}}(),function(){t.Mouse=t.Class("Luv.Mouse",{init:function(e){var r=this;r.x=0,r.y=0,r.pressedButtons={},r.wheelTimeOuts={};var o=function(t){r.pressedButtons[t]=!0,r.onPressed(r.x,r.y,t)},s=function(t){r.pressedButtons[t]=!1,r.onReleased(r.x,r.y,t)},u=function(e){e.preventDefault();var n=i(e);clearTimeout(r.wheelTimeOuts[n]),r.wheelTimeOuts[n]=setTimeout(function(){s(n)},1e3*t.Mouse.WHEEL_TIMEOUT),o(n)};e.addEventListener("mousemove",function(t){var n=e.getBoundingClientRect();r.x=t.pageX-n.left,r.y=t.pageY-n.top,r.onMoved(r.x,r.y)}),e.addEventListener("mousedown",function(t){o(n(t))}),e.addEventListener("mouseup",function(t){s(n(t))}),e.addEventListener("DOMMouseScroll",u),e.addEventListener("mousewheel",u)},getX:function(){return this.x},getY:function(){return this.y},getPosition:function(){return{x:this.x,y:this.y}},onPressed:function(){},onReleased:function(){},onMoved:function(){},isPressed:function(t){return!!this.pressedButtons[t]}}),t.Mouse.WHEEL_TIMEOUT=.02;var e={1:"l",2:"m",3:"r"},n=function(t){return e[t.which]},i=function(t){var e=Math.max(-1,Math.min(1,t.wheelDelta||-t.detail));return 1===e?"wu":"wd"}}(),function(){t.Touch=t.Class("Luv.Touch",{init:function(t){var e=this;e.fingers={},e.el=t;var r=function(t){t.preventDefault(),t.stopPropagation()};t.addEventListener("gesturestart",r),t.addEventListener("gesturechange",r),t.addEventListener("gestureend",r),t.addEventListener("touchstart",function(o){r(o);for(var s,u,a=t.getBoundingClientRect(),h=0;o.targetTouches.length>h;h++)s=o.targetTouches[h],u=i(e,s.identifier),u||(u={identifier:s.identifier,position:n(e),x:s.pageX-a.left,y:s.pageY-a.top},e.fingers[u.position]=u,e.onPressed(u.position,u.x,u.y))});var o=function(n){r(n);var o,s;t.getBoundingClientRect();for(var u=0;n.changedTouches.length>u;u++)o=n.changedTouches[u],s=i(e,o.identifier),s&&(delete e.fingers[s.position],e.onReleased(s.position,s.x,s.y))};t.addEventListener("touchend",o),t.addEventListener("touchleave",o),t.addEventListener("touchcancel",o),t.addEventListener("touchmove",function(n){r(n);for(var o,s,u=t.getBoundingClientRect(),a=0;n.targetTouches.length>a;a++)o=n.targetTouches[a],s=i(e,o.identifier),s&&(s.x=o.pageX-u.left,s.y=o.pageY-u.top,e.onMoved(s.position,s.x,s.y))})},onPressed:function(){},onReleased:function(){},onMoved:function(){},isPressed:function(t){return!!this.fingers[t]},getFinger:function(t){var e=this.fingers[t];return e&&{position:e.position,identifier:e.identifier,x:e.x,y:e.y}},getFingers:function(){for(var t,e,n=[],i=Object.keys(this.fingers).sort(),r=0;i.length>r;r++)e=i[r],t=this.fingers[e],n.push({position:e,x:t.x,y:t.y});return n},isAvailable:function(){return void 0!==window.ontouchstart}});var e=function(t){var e=Object.keys(t.fingers);return 0===e.length?0:Math.max.apply(Math,e)},n=function(t){for(var n=e(t),i=1;n>i;i++)if(!t.isPressed(i))return i;return n+1},i=function(t,e){var n=t.fingers;for(var i in n)if(n.hasOwnProperty(i)&&n[i].identifier==e)return n[i]}}(),function(){t.Media=t.Class("Luv.Media",{init:function(){this.pending=0,this.loaded=!0},isLoaded:function(){return this.loaded},getPending:function(){return this.pending},onAssetLoaded:function(){},onAssetError:function(t){throw Error("Could not load "+t)},onLoaded:function(){},newAsset:function(t){this.pending++,this.loaded=!1,clearTimeout(this.onLoadedTimeout),t.status="pending"},registerLoad:function(e){if(this.pending--,e.status="loaded",this.onAssetLoaded(e),0===this.pending){var n=this;clearTimeout(this.onLoadedTimeout),this.onLoadedTimeout=setTimeout(function(){n.loaded=!0,n.onLoaded()},t.Timer.ONLOAD_TIMEOUT)}},registerError:function(t){this.pending--,t.status="error",this.onAssetError(t)}}),t.Timer.ONLOAD_TIMEOUT=200,t.Media.Asset={isPending:function(){return"pending"==this.status},isLoaded:function(){return"loaded"==this.status},isError:function(){return"error"==this.status}}}(),function(){t.Audio=t.Class("Luv.Audio",{init:function(t){this.media=t},isAvailable:function(){return t.Audio.isAvailable()},getSupportedTypes:function(){return t.Audio.getSupportedTypes()},canPlayType:function(t){return this.supportedTypes[t.toLowerCase()]},Sound:function(){if(this.isAvailable()){var e=[this.media].concat(Array.prototype.slice.call(arguments,0));return t.Audio.Sound.apply(t.Audio.Sound,e)}return t.Audio.NullSound()}}),t.Audio.isAvailable=function(){return i},t.Audio.canPlayType=function(t){return!!n[t.toLowerCase()]},t.Audio.getSupportedTypes=function(){return Object.keys(n)};var e=document.createElement("audio"),n={},i=!!e.canPlayType;i&&(n.ogg=!!e.canPlayType('audio/ogg; codecs="vorbis"'),n.mp3=!!e.canPlayType("audio/mpeg;"),n.wav=!!e.canPlayType('audio/wav; codecs="1"'),n.m4a=!!e.canPlayType("audio/x-m4a;"),n.aac=!!e.canPlayType("audio/aac;"))}(),function(){t.Audio.Sound=t.Class("Luv.Audio.Sound",{init:function(e){var n=Array.prototype.slice.call(arguments,1);if(0===n.length)throw Error("Must provide at least one path for the Sound");if(n=n.filter(o),0===n.length)throw Error("None of the provided sound types ("+n.join(", ")+") is supported by the browser: ("+t.Audio.getSupportedTypes().join(", ")+")");var i=this;i.path=n[0],e.newAsset(i);var r=i.el=document.createElement("audio");r.preload="auto",r.addEventListener("canplaythrough",function(){i.isLoaded()||e.registerLoad(i)}),r.addEventListener("error",function(){e.registerError(i)}),r.src=i.path,r.load(),i.instances=[],i.expirationTime=t.Audio.Sound.DEFAULT_EXPIRATION_TIME},toString:function(){return'Luv.Audio.Sound("'+this.path+'")'},play:function(t){if(!this.isLoaded())throw Error("Attepted to play a non loaded sound: "+this);var e=this.getReadyInstance(t);return e.play(),e},pause:function(){this.instances.forEach(function(t){t.pause()})},stop:function(){this.instances.forEach(function(t){t.stop()})},countInstances:function(){return this.instances.length},countPlayingInstances:function(){var t=0;return this.instances.forEach(function(e){t+=e.isPlaying()?1:0}),t},getReadyInstance:function(t){var i=e(this.instances);return i||(i=n(this),this.instances.push(i)),i.reset(this.el,t),i},getExpirationTime:function(){return this.expirationTime},setExpirationTime:function(t){this.expirationTime=t}}),t.Audio.Sound.DEFAULT_EXPIRATION_TIME=3,t.Audio.Sound.include(t.Media.Asset),t.Audio.SoundMethods={setVolume:function(t){t=s(t,0,1),this.el.volume=t},getVolume:function(){return this.el.volume},setLoop:function(t){this.loop=!!t,t?this.el.loop="loop":this.el.removeAttribute("loop")},getLoop:function(){return this.loop},setSpeed:function(t){this.el.playbackRate=t},getSpeed:function(){return this.el.playbackRate},setTime:function(t){try{this.el.currentTime=t}catch(e){}},getTime:function(){return this.el.currentTime},getDuration:function(){return this.el.duration}},t.Audio.Sound.include(t.Audio.SoundMethods);var e=function(t){for(var e,n=0;t.length>n;n++)if(e=t[n],e.isReady())return e},n=function(e){return t.Audio.SoundInstance(e.el.cloneNode(!0),function(){clearTimeout(this.expirationTimeOut)},function(){var t=this;t.expirationTimeOut=setTimeout(function(){i(e,t)},1e3*e.getExpirationTime())})},i=function(t,e){var n=t.instances.indexOf(e);-1!=n&&t.instances.splice(n,1)},r=function(t){var e=t.match(/.+\.([^?]+)(\?|$)/);return e?e[1].toLowerCase():""},o=function(e){return t.Audio.canPlayType(r(e))},s=function(t,e,n){return Math.max(e,Math.min(n,Number(t)))}}(),function(){t.Audio.SoundInstance=t.Class("Luv.Audio.SoundInstance",{init:function(t,e,n){var i=this;i.el=t,i.onPlay=e,i.onStop=n,i.el.addEventListener("ended",function(){i.stop()})},reset:function(t,e){e=e||{};var n=e.volume===void 0?t.volume:e.volume,i=e.loop===void 0?!!t.loop:e.loop,r=e.speed===void 0?t.playbackRate:e.speed,o=e.time===void 0?t.currentTime:e.time,s=e.status===void 0?"ready":e.status;this.setVolume(n),this.setLoop(i),this.setSpeed(r),this.setTime(o),this.status=s},play:function(){this.el.play(),this.status="playing",this.onPlay()},pause:function(){this.isPlaying()&&(this.el.pause(),this.status="paused")},stop:function(){this.el.pause(),this.setTime(0),this.status="ready",this.onStop()},isPaused:function(){return"paused"==this.status},isReady:function(){return"ready"==this.status},isPlaying:function(){return"playing"==this.status},onPlay:function(){},onStop:function(){}}),t.Audio.SoundInstance.include(t.Audio.SoundMethods)}(),function(){t.Audio.NullSound=t.Class("Luv.Audio.NullSound");var e={},n=function(){return 0};for(var i in t.Audio.Sound.methods)t.Audio.Sound.methods.hasOwnProperty(i)&&(e[i]=n);t.Audio.NullSound.include(e,{play:function(){return t.Audio.SoundInstance(r())}});var r=function(){return{volume:1,playbackRate:1,loop:void 0,currentTime:0,play:function(){},pause:function(){},addEventListener:function(t,e){e()}}}}(),function(){t.Graphics=t.Class("Luv.Graphics",{init:function(t,e){this.el=t,this.media=e},parseColor:function(e,n,i){return t.Graphics.parseColor(e,n,i)},Canvas:function(e,n){return e=e||this.el.getAttribute("width"),n=n||this.el.getAttribute("height"),t.Graphics.Canvas(e,n)},Image:function(e){return t.Graphics.Image(this.media,e)},Sprite:function(e,n,i,r,o){return t.Graphics.Sprite(e,n,i,r,o)},SpriteSheet:function(e,n,i,r,o,s){return t.Graphics.SpriteSheet(e,n,i,r,o,s)}}),t.Graphics.parseColor=function(t,e,n){var i,r=parseInt;if(Array.isArray(t))return{r:t[0],g:t[1],b:t[2]};if("object"==typeof t)return{r:t.r,g:t.g,b:t.b};if("string"==typeof t){if(t=t.replace(/#|\s+/g,""),i=/^([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})/.exec(t))return{r:r(i[1],16),g:r(i[2],16),b:r(i[3],16)};if(i=/^([\da-fA-F])([\da-fA-F])([\da-fA-F])/.exec(t))return{r:17*r(i[1],16),g:17*r(i[2],16),b:17*r(i[3],16)};if(i=/^rgb\(([\d]+),([\d]+),([\d]+)\)/.exec(t))return{r:r(i[1],10),g:r(i[2],10),b:r(i[3],10)}}return{r:t,g:e,b:n}}}(),function(){t.Graphics.Animation=t.Class("Luv.Graphics.Animation",{init:function(t,n){if(!Array.isArray(t))throw Error("Array of sprites needed. Got "+t);if(0===t.length)throw Error("No sprites where provided. Must provide at least one");this.sprites=t.slice(0),this.time=0,this.index=0,this.durations=i(t.length,n),this.intervals=e(this.durations),this.loopDuration=this.intervals[this.intervals.length-1]},update:function(t){var e;this.time+=t,e=Math.floor(this.time/this.loopDuration),this.time-=this.loopDuration*e,0!==e&&this.onLoopEnded(e),this.index=n(this.intervals,this.time)},gotoSprite:function(t){this.index=t,this.time=this.intervals[t]},getCurrentSprite:function(){return this.sprites[this.index]},onLoopEnded:function(){}}),"getWidth getHeight getDimensions getCenter drawInCanvas".split(" ").forEach(function(e){t.Graphics.Animation.methods[e]=function(){var t=this.getCurrentSprite();return t[e].apply(t,arguments)}});var e=function(t){for(var e=[0],n=0,i=0;t.length>i;i++)n+=t[i],e.push(n);return e},n=function(t,e){for(var n=t.length-2,i=0,r=0;n>=i;)if(r=Math.floor((i+n)/2),e>=t[r+1])i=r+1;else{if(!(t[r]>e))break;n=r-1}return r},i=function(t,e){var n,i,o,s,u=[];if(Array.isArray(e))u=e.slice(0);else if("object"==typeof e){u.length=t;for(n in e)if(e.hasOwnProperty(n))for(o=r(n),s=Number(e[n]),i=0;o.length>i;i++)u[o[i]]=s}else for(e=Number(e),i=0;t>i;i++)u.push(e);if(u.length!=t)throw Error("The durations table length should be "+t+", but it is "+u.length);for(i=0;u.length>i;i++){if(u[i]===void 0)throw Error("Missing delay for sprite "+i);if(isNaN(u[i]))throw Error("Could not parse the delay for sprite "+i)}return u},r=function(t){var e,n,i,r,o;if("string"!=typeof t)throw Error("Unknown range type (must be integer or string in the form 'start-end'): "+t);if(e=t.match(/^(\d+)-(\d+)$/))if(n=[],i=Number(e[1]),r=Number(e[2]),r>i)for(o=i;r>=o;o++)n.push(o);else for(o=i;o>=r;o--)n.push(o);else n=[Number(t)];return n}}(),function(){t.Graphics.Canvas=t.Class("Luv.Graphics.Canvas",{init:function(t,e){var n;t.getAttribute?(n=t,t=n.getAttribute("width"),e=n.getAttribute("height")):(n=document.createElement("canvas"),n.setAttribute("width",t),n.setAttribute("height",e)),this.el=n,this.ctx=n.getContext("2d"),this.color={},this.backgroundColor={},this.setBackgroundColor(0,0,0),this.setColor(255,255,255),this.setLineCap("butt"),this.setLineWidth(1),this.setImageSmoothing(!0),this.setAlpha(1)},clear:function(){this.ctx.save(),this.ctx.setTransform(1,0,0,1,0,0),this.ctx.globalAlpha=1,this.ctx.fillStyle=this.backgroundColorStyle,this.ctx.fillRect(0,0,this.getWidth(),this.getHeight()),this.ctx.restore()},print:function(t,e,n){this.ctx.fillStyle=this.colorStyle,this.ctx.fillText(t,e,n)},line:function(){var t=Array.isArray(arguments[0])?arguments[0]:arguments;this.ctx.beginPath(),r(this,"luv.graphics.line",4,t),u(this,d.STROKE)},strokeRectangle:function(t,e,n,i){a(this,d.STROKE,t,e,n,i)},fillRectangle:function(t,e,n,i){a(this,d.FILL,t,e,n,i)},strokePolygon:function(){h(this,d.STROKE,arguments)},fillPolygon:function(){h(this,d.FILL,arguments)},strokeCircle:function(t,e,n){f(this,d.STROKE,t,e,n)},fillCircle:function(t,e,n){f(this,d.FILL,t,e,n)},strokeArc:function(t,e,n,i,r){c(this,d.STROKE,t,e,n,i,r)},fillArc:function(t,e,n,i,r){c(this,d.FILL,t,e,n,i,r)},draw:function(t,e,n,i,r,s,u,a){var h=this.ctx;e=e||0,n=n||0,r=r||1,s=s||1,u=u||0,a=a||0,i=o(i||0),0!==i||1!==r||1!==s||0!==u||0!==a?(h.save(),h.translate(e,n),h.translate(u,a),h.rotate(i),h.scale(r,s),h.translate(-u,-a),t.drawInCanvas(this,0,0),h.restore()):t.drawInCanvas(this,e,n)},drawCentered:function(t,e,n,i,r,o){var s=t.getCenter();this.draw(t,e-s.x,n-s.y,i,r,o,s.x,s.y)},drawInCanvas:function(t,e,n){t.ctx.drawImage(this.el,e,n)},translate:function(t,e){this.ctx.translate(t,e)},scale:function(t,e){this.ctx.scale(t,e)},rotate:function(t){this.ctx.rotate(t)},push:function(){this.ctx.save()},pop:function(){this.ctx.restore()},getDimensions:function(){return{width:this.getWidth(),height:this.getHeight()}},setDimensions:function(t,e){this.el.setAttribute("width",t),this.el.setAttribute("height",e)},getWidth:function(){return Number(this.el.getAttribute("width"))},getHeight:function(){return Number(this.el.getAttribute("height"))},getCenter:function(){return{x:this.getWidth()/2,y:this.getHeight()/2}},setColor:function(t,e,i){n(this,"color",t,e,i)},getColor:function(){return i(this.color)},setBackgroundColor:function(t,e,i){n(this,"backgroundColor",t,e,i)},getBackgroundColor:function(){return i(this.backgroundColor)},setAlpha:function(t){this.alpha=l(t,0,1),this.ctx.globalAlpha=this.alpha},getAlpha:function(){return this.alpha},setLineWidth:function(t){this.lineWidth=t,this.ctx.lineWidth=t},getLineWidth:function(){return this.lineWidth},setLineCap:function(t){if("butt"!=t&&"round"!=t&&"square"!=t)throw Error("Line cap must be either 'butt', 'round' or 'square' (was: "+t+")");this.ctx.lineCap=t,this.lineCap=this.ctx.lineCap},getLineCap:function(){return this.lineCap},setImageSmoothing:function(t){this.imageSmoothing=t=!!t,s(this.ctx,t)},getImageSmoothing:function(){return this.imageSmoothing}});var e=2*Math.PI,n=function(e,n,i,r,o){var s=e[n],u=t.Graphics.parseColor(i,r,o);t.extend(s,u),e[n+"Style"]="rgb("+[s.r,s.g,s.b].join()+")"},i=function(t){return{r:t.r,g:t.g,b:t.b}},r=function(t,e,n,i){if(n>i.length)throw Error(e+" requires at least 4 parameters");if(1==i.length%2)throw Error(e+" requires an even number of parameters");t.ctx.moveTo(i[0],i[1]);for(var r=2;i.length>r;r+=2)t.ctx.lineTo(i[r],i[r+1]);t.ctx.stroke()},o=function(t){return t%=e,0>t?t+e:t},s=function(t,e){t.webkitImageSmoothingEnabled=e,t.mozImageSmoothingEnabled=e,t.imageSmoothingEnabled=e},u=function(t,e){switch(e){case d.FILL:t.ctx.fillStyle=t.colorStyle,t.ctx.fill();break;case d.STROKE:t.ctx.strokeStyle=t.colorStyle,t.ctx.stroke();break;default:throw Error("Invalid mode: ["+e+']. Should be "fill" or "line"')}},a=function(t,e,n,i,r,o){t.ctx.beginPath(),t.ctx.rect(n,i,r,o),u(t,e),t.ctx.closePath()},h=function(t,e,n){var i=Array.isArray(n[0])?n[0]:Array.prototype.slice.call(n,0);t.ctx.beginPath(),r(t,"luv.Graphics.Canvas.polygon",6,i),u(t,e),t.ctx.closePath()},c=function(t,e,n,i,r,o,s){t.ctx.beginPath(),t.ctx.arc(n,i,r,o,s,!1),u(t,e)},f=function(t,n,i,r,o){c(t,n,i,r,o,0,e),t.ctx.closePath()},d={STROKE:1,FILL:2},l=function(t,e,n){return Math.max(e,Math.min(n,Number(t)))}}(),function(){t.Graphics.Image=t.Class("Luv.Graphics.Image",{init:function(t,e){var n=this;n.path=e,t.newAsset(n);var i=new Image;n.source=i,i.addEventListener("load",function(){t.registerLoad(n)}),i.addEventListener("error",function(){t.registerError(n)}),i.src=e},toString:function(){return'instance of Luv.Graphics.Image("'+this.path+'")'},getWidth:function(){return this.source.width},getHeight:function(){return this.source.height},getDimensions:function(){return{width:this.source.width,height:this.source.height}},getCenter:function(){return{x:this.source.width/2,y:this.source.height/2}},drawInCanvas:function(t,e,n){if(!this.isLoaded())throw Error("Attepted to draw a non loaded image: "+this);t.ctx.drawImage(this.source,e,n)}}),t.Graphics.Image.include(t.Media.Asset)}(),function(){t.Graphics.Sprite=t.Class("Luv.Graphics.Sprite",{init:function(t,e,n,i,r){this.image=t,this.left=e,this.top=n,this.width=i,this.height=r},toString:function(){return["instance of Luv.Graphics.Sprite(",this.image,", ",this.left,", ",this.top,", ",this.width,", ",this.height,")"].join("")},getImage:function(){return this.image},getWidth:function(){return this.width},getHeight:function(){return this.height},getDimensions:function(){return{width:this.width,height:this.height}},getCenter:function(){return{x:this.width/2,y:this.height/2}},getBoundingBox:function(){return{left:this.left,top:this.top,width:this.width,height:this.height}},drawInCanvas:function(t,e,n){if(!this.image.isLoaded())throw Error("Attepted to draw a prite of a non loaded image: "+this);t.ctx.drawImage(this.image.source,this.left,this.top,this.width,this.height,e,n,this.width,this.height)}})}(),function(){t.Graphics.SpriteSheet=t.Class("Luv.Graphics.SpriteSheet",{init:function(t,e,n,i,r,o){this.image=t,this.width=e,this.height=n,this.left=i||0,this.top=r||0,this.border=o||0},getSprites:function(){for(var t,n,i=[],r=0;arguments.length>r;r+=2){t=e(arguments[r]),n=e(arguments[r+1]);for(var o=0;n.length>o;o++)for(var s=0;t.length>s;s++)i.push(this.Sprite(t[s],n[o]))}return i},Sprite:function(e,n){return t.Graphics.Sprite(this.image,this.left+this.width*e+this.border*(e+1),this.top+this.height*n+this.border*(n+1),this.width,this.height)},Animation:function(e,n){var i=this.getSprites.apply(this,e);return t.Graphics.Animation(i,n)}});var e=function(t){if("number"==typeof t)return[t];if("string"==typeof t){var e=t.split("-");if(2!=e.length)throw Error("Could not parse from '"+t+"'. Must be of the form 'start-end'");var n,i=[],r=Number(e[0]),o=Number(e[1]);if(o>r)for(n=r;o>=n;n++)i.push(n);else for(n=r;n>=o;n--)i.push(n);return i}throw Error("Ranges must be integers or strings of the form 'start-end'. Got "+t)}}(),t});;var RL = {
	States: {}, // holds the games states
    sounds: {},

	hittableNotes: [false,false,false,false,false,false],
    pressedButtons: [false, false, false, false, false, false],
    playAdded: false,

    init: function()
    {         

        RL.editMode = RL.isEditMode();
        RL.playerHeightOnePercent = RL.config.height/100;
      
        restart = false;
        if(game != null){
            game.destroy();
            AudioManager.stop();
            createjs.Sound.removeAllSounds();
            RL.hittableNotes = [false,false,false,false,false,false];
            RL.pressedButtons = [false,false,false,false,false,false];
            $('#main-canvas canvas').remove();
            $('.counter-overlay .count').hide().html(RL.config.countSeconds);
            $('.counter-overlay .info').fadeIn();
            game = null;
            restart = true;
        }

        RL.config.pxPerMs = RL.config.pxPerSecond / 1000;
        RL.negPxPerMs = -RL.config.pxPerMs;
        RL.msOnScreen = RL.config.height / RL.config.pxPerMs;

        EditorManager = new RL.EditorManager();
        AudioManager = new RL.AudioManager();

        HighwayManager = new RL.HighwayManager();
        HighwayManager.aNotes = aNotes;

        InteractionManager = new RL.InteractionManager();

        if(RL.editMode){
            EditorInteractionManager = new RL.InteractionManager.Editor();
        }

        ScoreManager = new RL.ScoreManager();

        //
        
        var displayMode = Phaser.AUTO;

        switch(RL.config.displayMode){
            case 'AUTO':
                displayMode = Phaser.AUTO;
                break;
            case 'WEBGL':
                displayMode = Phaser.WEBGL;
                break;
            case 'CANVAS':
                displayMode = Phaser.CANVAS;
                break;
        }

         game = new Phaser.Game( 
            this.config.width, 
            this.config.height, 
            displayMode, 
            'main-canvas',
            null,
            false, //transparent
            true, //antialias
            null
        );

        game.state.add('Boot', RL.States.Boot);
        game.state.add('Play', RL.States.Play);
        game.state.add('Editor', RL.States.Editor);

        WebFontConfig = {
            active: function() { game.time.events.add(Phaser.Timer.SECOND, RL.HighwayManager.createText, this); },
            google: {
                families: ['Roboto']
            }
        };

        game.state.start('Boot');
    },

	getPosXForLane: function(lane){
		return RL.config.width / (RL.config.lanes+1) * lane;
	},

    getLaneForX: function(x, mouse){
        for(var i = 0 ; i <= RL.config.lanes; ++i){
            var laneX= RL.config.width / (RL.config.lanes) * i - RL.config.buttonWidth/2;
            var laneX = laneX + RL.config.noteWidth;
            if(laneX >= x){
                return i;
            }
        }
        return 6;
    },

    getTimeForY: function(y){
        return (y - RL.config.noteHeightDifferenceToButton) / RL.negPxPerMs;
    },

    getPosXForLane: function(lane){
        return RL.config.width / 6 * lane;
    },

    getXForLaneButton: function(lane){
        return RL.config.width / 6 * lane - RL.config.noteWidth/2;
    },

    getYForTime: function(time){
        return time * RL.negPxPerMs + RL.config.noteHeightDifferenceToButton;
    },

    getSpriteForLane: function(lane){
        return game.cache.getImage('note_lane'+lane);
    },

    addPlay: function()
    {
        $.post('/play/add/'+track_id);
    },

/************

*************/

	sortNotesArray: function(){
		for(var i = 1; i < aNotes.length; i++){
	        lane = aNotes[i];
	        
	        for(var n = 0; n < lane.length; n++){
	            lane[n].ms = lane[n].ms;
	        }

	        lane.sort(RL.dynamicSort("ms"));
	    }
	},

	keyCodeToIndex: function(keyCode){
		var index = 0;

        switch(keyCode){
            case RL.config.buttonKeys[0]:
                index = 0;
                break;
            case RL.config.buttonKeys[1]:
                index = 1;
                break;
            case RL.config.buttonKeys[2]:
                index = 2;
                break;
            case RL.config.buttonKeys[3]:
                index = 3;
                break;
            case RL.config.buttonKeys[4]:
                index = 4;
                break;
            case RL.config.buttonKeys[5]:
                index = 5;
                break;
            case RL.config.buttonKeys[6]:
                index = 6;
                break;
            default:
                index = -1;
                break;
        }

        return index;
	},

    isEditMode: function()
    {
        return (typeof(edit_mode) != 'undefined' && edit_mode) ? true : false;
    },
    dynamicSort: function(property) {
        var sortOrder = 1;
        if(property[0] === "-") {
            sortOrder = -1;
            property = property.substr(1);
        }
        return function (a,b) {
            var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
            return result * sortOrder;
        }
    },

    str_pad: function(input, pad_length, pad_string, pad_type){
        var half = '',
            pad_to_go;

        var str_pad_repeater = function (s, len) {
            var collect = '',
                i;

            while (collect.length < len) {
                collect += s;
            }
            collect = collect.substr(0, len);

            return collect;
        };

        input += '';
        pad_string = pad_string !== undefined ? pad_string : ' ';

        if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
            pad_type = 'STR_PAD_RIGHT';
        }
        if ((pad_to_go = pad_length - input.length) > 0) {
            if (pad_type === 'STR_PAD_LEFT') {
                input = str_pad_repeater(pad_string, pad_to_go) + input;
            } else if (pad_type === 'STR_PAD_RIGHT') {
                input = input + str_pad_repeater(pad_string, pad_to_go);
            } else if (pad_type === 'STR_PAD_BOTH') {
                half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
                input = half + input + half;
                input = input.substr(0, pad_length);
            }
        }

        return input;
    }
/************

************/
};

Array.prototype.AllValuesSame = function(){

    if(this.length > 0) {
        for(var i = 1; i < this.length; i++)
        {
            if(this[i] !== this[0])
                return false;
        }
    } 
    return true;
};RL.config = {
	log: true, // enable/disable log

	mobile: false,
	editor: false,

	countSeconds: 3,

	// Canvas
	width: $('#main-canvas').width(),
	height: $('#main-canvas').height(),

	disableVisibilityChange: true,
	smoothSprites: false,
	stageBackgroundColor: 0X2C2C2C, //canvas background color

	// Loader
	loaderWidth: 40,
	loaderHeight: 40,

	// Sounds
	squeaks: 1, // amount of squeak sounds available
	musicPlaybackRate: 1.0,

	// Grid
	gridLineWidth: 2, // thickness of main grid lines
	lanes: 5, //number of note lines (move this to a difficulty config later)
	laneColors: [	// colors of the lanes
				   null, // just a filler, so the lanes numbering is correct
	               0XD12B4F,
	               0XD4C400,
	               0X88D700,
	               0X00BBE3,
	               0X8137F9
	],

	// Buttons	
	buttonWidth: 39.5,
	buttonHeight: 45,

	buttonY: $('#main-canvas').height()-80, //the vertical position of the buttons
	
	buttonKeys: [
				null,
	            49, //1
	            50, //2
	            51, //3
	            52, //4
	            53,  //5
	            13, // STRUM = ENTER
    ],

    // Notes
	noteWidth: 35,
	noteHeight: 35,
	noteButtonOffsetY: 0,
	noteHeightDifferenceToButton: 8,

    // NoteHighway
    pxPerSecond: 250, // px : the amount of pixels the note highway scrolls down per second
    longNoteThreshold: 75, // ms : minimum difference between startTap and endTap for long notes    
    hitDetectThreshold: 50, // ms : the maximum difference between note ms and hit time to be detected as a hit


    // Performance Keys
    startKey: 32,

    // Editor Keys
    seekBackwardKey: 37,
    seekForwardKey:  39,

    speedUpKey: 38,
    speedDownKey: 40,

    deleteKey: 46,

    newLineKey: 187,

    mode: 'tap', // tap or strum
                 // 
    // performance
    showBurst: true,
    animateHitLanes: true,
    drawKeys: true,
    displayMode: 'AUTO',
}

jQuery.extend(RL.config, user_config);;function keyDownHandler(e){
    if(!$('input, textarea').is(':focus')){
        var index = RL.keyCodeToIndex(e.keyCode);
        var hopoNote = e.ctrlKey;

        if(RL.editMode && RL.config.trackTaps){
            EditorManager.addTap(index, AudioManager.currentTime, hopoNote);
        }else{
            HighwayManager.startHitDetection(index);
        }

        if(index <= 5){
            HighwayManager.aButtons[index].frame = 5*index-4;
        }
    }
}

function keyHoldHandler(e){
    if(!$('input, textarea').is(':focus')){
        var index = RL.keyCodeToIndex(e.keyCode);
        var hopoNote = e.ctrlKey;

        if(RL.editMode && RL.config.trackTaps){
            EditorManager.holdTap(index, e.duration, AudioManager.currentTime, hopoNote);
        }else{
            HighwayManager.continueHitDetection(index, e.duration);
        }
    }
}

function keyUpHandler(e){
    if(!$('input, textarea').is(':focus')){
        var index = RL.keyCodeToIndex(e.keyCode);
        var hopoNote = e.ctrlKey;

        if( RL.editMode && 
            RL.config.trackTaps && 
            e.duration >= RL.config.longNoteThreshold)
        {
            EditorManager.finishTap(index, e.duration, AudioManager.currentTime, hopoNote);
        }
        else if( !RL.config.trackTaps || !RL.editMode )
        {
            HighwayManager.endHitDetection(index);
        }

        if(index <= 5){
            HighwayManager.aButtons[index].frame = 5*index-5;
        }
    }
}
/** TOUCH EVENtS
function touchDownHandler(button, e){
    RL.HighwayManager.aButtons[button.lane-1].frame = 1;

    if(typeof(edit_mode) != 'undefined' && edit_mode && RL.config.trackTaps){
    	RL.managers.EditorManager.addTap(button.lane-1, RL.AudioManager.getPosition());
    }else{
    	noteControl.startHitDetection(button.lane-1, RL.AudioManager.getPosition());
    }
}

function touchUpHandler(button, e){
    RL.HighwayManager.aButtons[button.lane-1].frame = 0;

    if(typeof(edit_mode) != 'undefined' && edit_mode && RL.config.trackTaps && e.timeUp - e.timeDown >= RL.config.longNoteThreshold){
    	RL.managers.EditorManager.finishTap(button.lane-1, e.timeUp-e.timeDown);
    }
}
**/

/**
 * Interaction manager for general rocklegend functions
 *
 * @module RL.InteractionManager
 */
RL.InteractionManager = function() {
return {
    playing: false,
    aKeyboardEvents: [],
    keyboardPresses: [0,0,0,0,0,0],
    strumDuration: [0,0,0,0,0,0],

	init: function(){
        game.input.touch.preventDefault = false;

        var startPlayKey = game.input.keyboard.addKey(32);
        startPlayKey.onDown.add(this.togglePlayback, this);
	},

	togglePlayback: function(){
		if(RL.editMode){
            if(this.playing){
                AudioManager.pause();
                jQuery('.audio-controls .toggle-playback').addClass('paused');
                this.playing = false;
             }else{
                AudioManager.play();
                jQuery('.audio-controls .toggle-playback').removeClass('paused');
                this.playing = true;
             }
		}else{
            if(!this.playing && !$('input, textarea').is(':focus')){
                this.playing = true;
                HighwayManager.countIn(true);
            }
		}
	}
}
};;/**
 * This manages audio stuff.
 * It's to be used as a wrapper for any sound framework that might be used
 *
 * @module RL.AudioManager
 */

RL.AudioManager = function(){
return {
	duration : 0,
	halfTime: 0,
	onePercent: 0,
	muted: false,

	init: function()
	{
		this.duration = this.getDuration();
		this.onePercent = this.duration/100;
		this.halfTime = this.duration/2;
	},
	setPosition : function(pos){
		if(pos <= 0){
			pos = 0;
		}else if(pos >= AudioManager.getDuration()){
			pos = AudioManager.getDuration();
		}

		RL.music.setPosition(pos);

		for(var l = 0; l < aNotes.length; l++){
			lane = aNotes[l];

			for(var i = 0; i < lane.length; i++){
				lane[i].ticked = false;
			}
		}
	},

	getPosition : function(audio){
		var position = RL.music.position;

		AudioManager.currentTime = position;
		return position;
	},

	getDuration: function(){
		return RL.music.duration;
	},

	getPlaybackRate: function()
	{
		return RL.music._playbackResource.playbackRate;
	},

	setPlaybackRate : function(speed){
		RL.music._playbackResource.playbackRate  = speed;
	    jQuery('input[name="playbackRate"]').val(speed.toFixed(2));
	},

	toggleMute: function(){
		if(this.muted){
			RL.music.muted = false;
			this.muted = false;
		}else{
			RL.music.muted = true;
			this.muted = true;
		}
	},

	pause: function()
	{
		RL.music.paused = true;
	},

	stop: function()
	{
		return RL.music.stop();
	},

	play: function()
	{
		RL.music.play();
	}
}
};;/**
 * This contains all needed functions
 * for the Rocklegend Track Editor
 *
 * @module this
 */

RL.EditorManager = function(){
return {
	aTaps: [[],[],[],[],[],[]],
	aMsTapped: [[],[],[],[],[],[]],
	aSelectedNotes: [],
	aPreviousSelection: [],
	aCopiedNotes: [],
	selectedNote: false,
	positionSlider : false,
	playbackRateSlider: false,
	pxPerSecondSlider: false,
	auto_save: RL.config.auto_save, // in seconds
	auto_save_interval: RL.config.auto_save_interval, // in seconds
	auto_save_js_interval: null,

	notesChanged: 0,

	playTicks: false,

	advancedMode: false,

	beatsInitialized: false,
	beatLineContainer: false,
	aBeatLines: 0,
	beatLinesHeight: 0,

	beatLineTextContainer: false,

	timeSignature: [4,4],
	secondsPerMeasure: 0,
	gridSecondsPerNote: 0,

	grid: 0.25,
	grid_snap: false,
	grid_snap_sustained: false,

	dragging: false,

	newLine: function(){
		newTime = AudioManager.getPosition() + this.secondsPerNote;
		
		if(newTime < 0) newTime = 0;

		AudioManager.setPosition(newTime);
	},

	init: function(){
		this.beatLineContainer = game.add.group(game, game.world, "beatLineContainer", true, false);
		this.beatLineContainer.z = 100;

		this.beatLineTextContainer = game.add.group(game, game.world, "beatLineTextContainer", true, false);
		this.beatLineTextContainer.z = 50;

		// auto_save
		if(this.auto_save){
			this.toggleAutoSave();
		}

		tval = this.auto_save_interval + ' seconds';
		if(this.auto_save_interval >= 60){
			tval = parseFloat(this.auto_save_interval/60).toFixed(1)+' minutes';
		}
		jQuery('#auto-save-interval').html(tval);

		if(typeof(RL.config.fetchNotes) != 'undefined' && RL.config.fetchNotes){
			this.getNotesForTrack();
		}

		EditorInteractionManager.init();	
	},

	deleteBeatLines: function()
	{
		this.beatLineContainer.removeAll();
		this.beatLineTextContainer.removeAll();
		this.aBeatLines = 0;
	},

	drawBeatLines: function(force){
		var grid = this.grid;
		var pxPerSecond = RL.config.pxPerSecond;
		var neededLines = AudioManager.duration/1000 / grid;

		var line = new Phaser.Graphics(game, 0, 0);

		// reset beatlines and draw them from scratch
		if(force || this.aBeatLines < neededLines){
			this.deleteBeatLines();

			for(var i = this.aBeatLines; i <= neededLines; i+=grid){
				y = -Math.round(i*pxPerSecond);

				line.lineStyle(1, 0XFFFFFF, i % 1 == 0 ? 1 : 0.35);
				line.moveTo(0, y);
				line.lineTo(RL.config.width, y);

				line.time = parseFloat(i);

				this.aBeatLines++;

				time = parseFloat(i).toFixed(3);
				timeText = time;

				if(time >= 60){
					seconds = i;
					minutes = parseInt(seconds / 60);
					seconds = parseFloat(seconds - (minutes*60)).toFixed(3);
					timeText = minutes+':'+seconds;
				}

				text = game.add.text(4, y-12, timeText, {
					fill: '#ffffff',
					fontSize: 10,
					font: 'Roboto'
				}, this.beatLineTextContainer);

				text.alpha = i % 1 == 0 ? 1 : 0.35;
				text.exists = false;
				text.time = time*1000;

				text.update = function(){
					if(this.time > AudioManager.currentTime + RL.msOnScreen ||
	                    this.time < AudioManager.currentTime - 250)
	                {
	                    this.exists = false;
	                }
	                else
	                {
	                    this.exists = true;
	                }
				}
			}			

			this.beatLineContainer.add(line);
			this.beatLinesHeight = Math.round(i*pxPerSecond);
			this.beatLinesTime = i;
		}

		

		/*this.beatLineContainer.forEach(function(e){
			if(typeof(e) != 'undefined'){
				// if y !== false, we have to move this object to y
				y = false;
				switch(e.type){
					case 3: // graphics
					 	currentY = e.currentPath.shape.points[1];
						pos = currentY + this.beatLineContainer.y;
						if(pos >= RL.config.height){
							y = currentY - this.beatLinesHeight;
						}else if(pos < RL.config.height - this.beatLinesHeight){
							y = currentY + this.beatLinesHeight;
						}

						if(y !== false){
							e.destroy();

							time = parseFloat(y / -RL.config.pxPerSecond).toFixed(1);

							var line = new Phaser.Graphics(game, 0, 0);
							line.lineStyle(1, 0XFFFFFF, time % 1 == 0 ? 1 : 0.35);
							
							line.moveTo(0,y);
							line.lineTo(RL.config.width, y);

							this.beatLineContainer.add(line);
						}
					break;
					case 4: // text
						if(e.y+12 + this.beatLineContainer.y >= RL.config.height){
							y = e.y + 12 - this.beatLinesHeight;
						}else if(e.y+12 + this.beatLineContainer.y < RL.config.height - this.beatLinesHeight){
							y = e.y + 12 + this.beatLinesHeight;
						}

						if(y !== false){	
							time = parseFloat(y/ -RL.config.pxPerSecond).toFixed(3);
							e.destroy();					    	

							text = game.add.text(4,y-12, time, {}, this.beatLineContainer);

							text.fill = '#ffffff';
							text.alpha = parseFloat(time).toFixed(1) % 1 == 0 ? 1 : 0.35;
							text.fontSize = 10;
							text.font = 'Roboto';
							text.z = 100;
						}
					break;
				}
			}
		}, this);*/
	},

	/**
	 * addTap(lane, time)
	 * This function gets called when editor is active and trackTaps is activated.
	 * It adds an Note Object (see note.js) to the aNotes array with the current time
	 *
	 * @method addTap
	 * @param {Int} lane The line on which the note should be added
	 * @param {Int} time The current time
	 * @return {RL.Note} Returns the generated note
	 */
	 addTap: function(lane, time, hopo){
		if(	this.beatsInitialized && 
			this.grid_snap){
			time = this.calculateBPMTime(time);
		}
			
		// make sure that no other note exists at this time on this lane
		if(jQuery.inArray(time, this.aMsTapped[lane]) <= -1){
			var note = new RL.Note(game, {
				time: time,
				lane: lane,
				hopo: hopo
			});

			note.exists = true;

			noteContainer.add(note);

			HighwayManager.aNotes[lane].push(note);

			note.initEditorFunctions();

			return note;
		}
	},

	calculateBPMTime: function(t){
		snap = this.secondsPerBeat * ( this.timeSignature[0] / this.grid_snap_bottom ) * 1000;
		return t.roundTo(snap);
	},

	holdTap: function(lane, duration, time, hopo){
		aNotes = HighwayManager.aNotes[lane];

		if(	this.beatsInitialized && 
			this.grid_snap){
			time = this.calculateBPMTime(time);
		}
		
		if(duration > RL.config.longNoteThreshold){
			noteIndex = aNotes.length-1;

			time = HighwayManager.aNotes[lane][noteIndex].time;
			HighwayManager.aNotes[lane][noteIndex].kill(true);
			HighwayManager.aNotes[lane].splice(noteIndex, 1);

			var note = new RL.Note(game, {
				time: time,
				lane: lane,
				duration: duration,
				hopo: hopo,
				showRect: true
			});

			note.exists = true;

			noteContainer.add(note);

			HighwayManager.aNotes[lane].push(note);

			note.initEditorFunctions();
		}
	},

	/**
	* Handles the keyUp event for the this.
	*
	* @method finishTap
	* @param {Int} lane The lane
	* @param {Int} duration
	* @param {Int} time
	*
	*/
	finishTap: function(lane, duration, time){
		aNotes = HighwayManager.aNotes[lane];
		noteIndex = aNotes.length-1;
		
		if(typeof(HighwayManager.aNotes[lane][noteIndex].rect) != 'undefined')
		{
			HighwayManager.aNotes[lane][noteIndex].rect.alpha = 0.5;
		}
	},

	/**
	* Handles note selection.
	*
	* Clicking on notes makes them selected.
	* Multiselection by pressing shift key is possible
	*
	* @method onNoteDown
	* @param {RL.Note} note The clicked note
	* @param {Event} e The event object
	*/
	onNoteDown: function(note, e, multiSelection){
		var multiSelection = typeof(multiSelection) != 'undefined' ? multiSelection : false;

		EditorManager.selectedNote = true;

		/** check if shiftkey is pressed **/
		if(game.input.keyboard.event != null){
			var shiftKey = game.input.keyboard.event.shiftKey;
		}else{
			shiftKey = false;
		}

		/** if shiftkey is not pressed we start a new selection **/
		if(!multiSelection && !shiftKey && !note.isSelected){
			EditorManager.resetSelectedNotes();
		}

		/** if the pressed note is not selected, we select it.
		 *  otherwise, we remove it from the selected notes array 
		 *  
		 *  we don't want to reset everything because this way it's possible
		 *  to easily correct a multi-selection
		 */
		if(!note.isSelected){
			note.isSelected = true;
			note.setDefaultTexture();

			EditorManager.aSelectedNotes.push(note);
		}else{

			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i] == note){
					note.isSelected = false;

					EditorManager.aSelectedNotes.splice(i,1);
				}
			}
			note.setDefaultTexture();

		}

		EditorManager.updateNoteInfo();
		EditorManager.aPreviousSelection = EditorManager.aSelectedNotes.slice();
	},

	/**
	* Resets the this.aSelectedNotes array to start a new selection
	*
	* @method resetSelectedNotes
	* @param {Event} e The event object
	*/
	resetSelectedNotes: function(e){
		for(var i = 0; i < this.aSelectedNotes.length; i++){
			this.aSelectedNotes[i].isSelected = false;
			this.aSelectedNotes[i].setDefaultTexture();
		}

		this.aSelectedNotes = [];

		EditorManager.updateNoteInfo();
	},

	activatePreviousSelection: function(e){
		EditorManager.resetSelectedNotes();

		for(var i = 0; i < EditorManager.aPreviousSelection.length; i++){
			EditorManager.onNoteDown(EditorManager.aPreviousSelection[i], null, true);
		}
	},

	/**
	* This function resets this.selectedNote to false
	* Needed for dragging of notecontainer, so we know that the user has not currently
	* selected a note für die mouseDown event
	*
	* @method onNoteUp
	* @param {RL.Note} note The note
	* @param {Event} e The event object
	**/
	onNoteUp: function(note, e){
		var duration = e.timeUp - e.timeDown;
		if(duration >= 200){
			// empty selected notes array
			EditorManager.aSelectedNotes = [];

			// populate selected notes array with notes which have the "selected" frame
			// hacky but it works
			for(var i = 0; i < HighwayManager.aNotes.length; i++){
				var laneNotes = HighwayManager.aNotes[i];
				for(var n = 0; n < laneNotes.length; n++){
					if(laneNotes[n].isSelected){
						laneNotes[n].isSelected = false;
						EditorManager.onNoteDown(laneNotes[n], e, true);
					}
				}
			}
		}
		else
		{
			note.setDefaultTexture();
		}
	},

	/** 
	* Updates the information shown next to the player about
	* the currently selected notes 
	*
	* @method updateNoteInfo
	*/
	updateNoteInfo: function()
	{
		selectedNotes = EditorManager.aSelectedNotes;

		durations = [];
		times = [];
		lanes = [];
		hopos = [];

		durationDifferent = false;
		timeDifferent = false;
		laneDifferent = false;
		hoposDifferent = false;
		nonFalse = 0;

		for(var i = 0; i < selectedNotes.length; i++){
			durations.push(selectedNotes[i].duration);
			times.push(selectedNotes[i].time);
			lanes.push(selectedNotes[i].lane);
			hopos.push(selectedNotes[i].hopo);
			if(selectedNotes[i]){
				nonFalse++;
			}
		}

		if(!durations.AllValuesSame()){
			durationDifferent = true;
		}
		
		if(!times.AllValuesSame()){
			timeDifferent = true;
		}
		
		if(!lanes.AllValuesSame()){
			laneDifferent = true;
		}
		
		if(!hopos.AllValuesSame()){
			hoposDifferent = true;
		}

		$('.var-sel-count').text(nonFalse);

		if(selectedNotes.length <= 0){

			$('#sel-note-time').attr('readonly',true).val("-");
			$('#sel-note-duration').attr('readonly',true).val("-");
			$('#sel-note-lane').attr('readonly',true).val("-");
			$('#sel-note-hopo').attr('readonly',true).prop('checked', false);

			$('#copy-selected, #paste-copied').hide();

		}else{
			$('#copy-selected').show();

			$('#sel-note-time').attr('readonly',false).val(timeDifferent ? '' : selectedNotes[0].time);
			$('#sel-note-duration').attr('readonly',false).val(durationDifferent ? '' : selectedNotes[0].duration);
			$('#sel-note-lane').attr('readonly',false).val(laneDifferent ? '' : selectedNotes[0].lane);

			if(hoposDifferent){
				$('#sel-note-hopo').attr('readonly',false).prop('checked',false);	
			}else{
				if(selectedNotes[0].hopo){
					$('#sel-note-hopo').attr('readonly',false).prop('checked', true);
				}else{
					$('#sel-note-hopo').attr('readonly',false).prop('checked', false);
				}
			}

		}
	},

	copyNotes: function(e){
		EditorManager.aCopyNotes = [];

		for(var n = 0; n < EditorManager.aSelectedNotes.length; n++)
		{
			if(EditorManager.aSelectedNotes[n]){
				EditorManager.aCopyNotes.push(
					EditorManager.aSelectedNotes[n]
				);
			}
		}

		$('#copy-info').html(EditorManager.aCopyNotes.length+' notes copied');
		$('#paste-copied').show();
	},

	pasteNotes: function(e){
		var currentPlaybackPosition = AudioManager.getPosition();

		EditorManager.resetSelectedNotes();

		minTime = false;
		for(var n = 0; n < EditorManager.aCopyNotes.length; n++)
		{
			if(minTime === false || EditorManager.aCopyNotes[n].time < minTime){
				minTime = EditorManager.aCopyNotes[n].time;
			}
		}

		for(var n = 0; n < EditorManager.aCopyNotes.length; n++)
		{

			var newTime = EditorManager.aCopyNotes[n].time - minTime + currentPlaybackPosition;

			var note = new RL.Note(game, {
				time: newTime,
				lane: EditorManager.aCopyNotes[n].lane,
				duration: EditorManager.aCopyNotes[n].duration,
				hopo: EditorManager.aCopyNotes[n].hopo
			});

			note.exists = true;

			noteContainer.add(note);

			HighwayManager.aNotes[EditorManager.aCopyNotes[n].lane].push(note);

			note.initEditorFunctions();

			EditorManager.onNoteDown(note, null, true);
		}
		
		// save previous selection
		EditorManager.aPreviousSelection = EditorManager.aSelectedNotes.slice();

		EditorManager.aCopyNotes = [];

		$('#copy-info').html('no notes copied');
	},

	/**
	* Deletes notes from this.aSelectedNotes array from the aNotes array
	* and calls their burst methods
	*
	* Sorts aNotes array after each note deletion to ensure noteIndex data is correct
	*
	* Triggers this.resetSelectedNotes afterwards to start a new selection
	*
	* @method deleteNotes
	* @param {Event} e The event object
	**/
	deleteNotes: function(e){
		if(e.event.target.sourceElement != 'input'){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				var note = EditorManager.aSelectedNotes[i];

				var lane = EditorManager.aSelectedNotes[i].lane;

				/** Delete note from used ms array 
				 *  so we can put another note here again 
				 **/
				 if(typeof(note.time) != 'undefined'){
					time = note.time;
					var index = EditorManager.aMsTapped[lane].indexOf(time);
					ele = EditorManager.aMsTapped[lane].splice(index, 1);
				 }

				 note = HighwayManager.aNotes[lane].splice(
				 			HighwayManager.aNotes[lane].indexOf(note),
				 			1
				 		);
				 note = note[0];

				 note.kill(true);
				}

				EditorManager.resetSelectedNotes();
			}
		},

	/**
	* Sets the current frame of the dragged note to 1
	*
	* @method onNoteDragStart
	* @param {RL.Note} The note
	* @param {Event} e
	**/
	onNoteDragStart: function(note, e){
		note.originalLane = note.lane;
		note.rlDrag = true;
		EditorManager.dragging = true;

		for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
			if(EditorManager.aSelectedNotes[i] && !EditorManager.aSelectedNotes[i].input.isDragged){
				EditorManager.aSelectedNotes[i].input.startDrag(game.input.activePointer);
			}
		}
	},

	/**
	* Updates the dragged note according to its new position
	*
	* @method onNoteDragStop
	* @param {RL.Note} note
	* @param {Event} e
	**/
	onNoteDragStop: function(note, e){
		var notesArray = HighwayManager.aNotes;
		var editor = this;
		EditorManager.dragging = false;
		
		// extract note from its currently set lane
		noteObject = notesArray[note.originalLane].splice(
						notesArray[note.originalLane].indexOf(note), 1
					);
		noteObject = noteObject[0];

		// get lane for the notes new x position
		lane = noteObject.setLaneForX(note.x) - 1;

		// insert the note on its new corresponding lane array
		noteIndex = notesArray[noteObject.lane].push(noteObject) - 1;
		note = noteObject;

		// calculate new time for current y position
		time = RL.getTimeForY(note.y);

		// if advanced editor is active and grid snapping is activated 
		// the notes y position should snap to the grid
		if(	EditorManager.beatsInitialized &&
			EditorManager.grid_snap)
		{
			snap = EditorManager.secondsPerNote*1000;

			time = time.roundTo(snap);
		}

		note.time = time;
		note.y = RL.getYForTime(time);

		/** MOVE CORRESPONDING SUSTAINED RECTANGLE! **/
		if(typeof note.rect !== 'undefined'){
			note.drawRect();
		}
	},

	moveAllByMs: function(ms)
	{
		for(var lane = 1; lane < HighwayManager.aNotes.length; lane++){
			laneNotes = HighwayManager.aNotes[lane];

			for(var i = 0; i < laneNotes.length; i++){
				n = laneNotes[i];
				n.time = parseFloat(n.time) + parseFloat(ms);
				n.y = RL.getYForTime(parseFloat(n.time));
				n.drawRect();

				EditorManager.notesChanged++;
			}
		}
	},

	save: function(){
		EditorManager.finish(null, true, true);
	},

	finish: function(e, auto_save, manual){
		if(typeof(auto_save) === 'undefined') auto_save = false;
		if(typeof(manual) === 'undefined') manual = false;

		var sendNotes = [];
		var noteCount = 0;

		notes = $.map(HighwayManager.aNotes, function(value, index){
			return [value];
		});

		for(var l = 0; l < notes.length; l++){
			aIndex = sendNotes.push([]) - 1;
			lane = notes[l];

			for(var i = 0; i < lane.length; i++){
				sendNotes[aIndex].push({
					time: lane[i].time,
					duration: lane[i].duration,
					//cb: lane[i].cb,
					//hitcb: lane[i].hitcb,
					hopo: lane[i].hopo
				});

				length = sendNotes[aIndex].length-1;
			}

			noteCount += sendNotes[aIndex].length;
		}
		
		if(noteCount < 5){
			if(!auto_save || manual)
				jQuery('#modal-errorMinimumNotes').foundation('reveal', 'open');
		}else{
			var notes = JSON.stringify(sendNotes);
			if($('select[name="status"] option:selected').val() == '2'){
				$('select[name="status"]').attr('disabled', true);
			}
			jQuery.post(
				'/create/editor/'+song_slug+'/'+$('select[name="difficulty"]').val()+(track_id ? '/'+track_id : ''), 
				{ 
					name: $('#track-name').val(), 
					status: $('select[name="status"]').val(),
					difficulty: $('select[name="difficulty"]').val(),
					notes: notes, 
					lanes: $('select[name="lanes"]').val(),
					song_id: song_id, 
					track_id: track_id, 
					px_per_second: RL.config.pxPerSecond, 
					auto_save: auto_save,
					_token: csrf
				},
				function(data){
					if(typeof(data.error) != 'undefined'){
						alert('An error occured! We didn\'t save the track. We added debug data to a box on the bottom of the page. Please copy and post it to a thread in the forums. We also disable autosave if it\’s currently active.');

						$('#error-debug textarea').html('Track ID: '+track_id+'\r\n'+notes);

						$('#error-debug').fadeIn();

						if(auto_save){
							EditorManager.toggleAutoSave();
						}

					}else{
						if(!auto_save){
							location.href = '/create/review/'+song_slug+'/'+data.track_id;
						}else if(!track_id){
							document.location.hash = data.track_id;
							track_id = data.track_id;
						}

						$('.stats-notecount').html(data.note_count);
						$('select[name="status"] option[value="'+data.status+'"]').attr('selected', true);
					}
				}
				);

			var date = new Date();
			var time = RL.str_pad(date.getHours(),2,'0','STR_PAD_LEFT')+':'+RL.str_pad(date.getMinutes(), 2, '0', 'STR_PAD_LEFT')+':'+RL.str_pad(date.getSeconds(),2,'0','STR_PAD_LEFT');
			
			if(auto_save && !manual){
				jQuery('#auto-save-info').html('<b>Last Auto-Save:</b> '+time).show();

				setTimeout(function(){
					jQuery('#auto-save-info').hide();
				}, 3000);
			}else if(manual){
				jQuery('#manual-save-info').html('<b>Last Manual-Save:</b> '+time).show();

				setTimeout(function(){
				jQuery('#manual-save-info').hide();
				}, 3000);
			}
		}
	},

	toggleTracking: function(){
		RL.config.trackTaps ? RL.config.trackTaps = false : RL.config.trackTaps = true;
		document.getElementById('trackingCB').checked = (RL.config.trackTaps) ? "checked" : "";
	},

	getNotesForTrack: function(){
		jQuery.post('/tools/getTrackById/'+track_id, 
			{ _token: csrf },
			function(data){
				HighwayManager.aNotes = data;
				HighwayManager.drawNotes();
			}
		);
	},

	toggleAutoSave: function(e, reset){
		if(typeof(reset) == 'undefined') reset = false;

		if(!reset){
			if(EditorManager.auto_save_js_interval != null){
				clearInterval(EditorManager.auto_save_js_interval);
				EditorManager.auto_save_js_interval = null;
				jQuery('#auto-save-container').fadeOut();
			}else{
				EditorManager.auto_save_js_interval = setInterval(function(){
					EditorManager.finish(null, true);
				}, EditorManager.auto_save_interval*1000);
				jQuery('#auto-save-container').fadeIn();
			}
		}else{
			EditorManager.auto_save_js_interval = null;
			EditorManager.auto_save_js_interval = setInterval(function(){
				EditorManager.finish(null, true);
			}, EditorManager.auto_save_interval*1000);
		}
	},

	print: function(o){
	    var str='';

	    for(var p in o){
	        if(typeof o[p] == 'string'){
	            str+= p + ': ' + o[p]+';';
	        }else{
	            str+= p + ': {' + EditorManager.print(o[p]) + '}';
	        }
	    }

	    return str;
	}
}
};;/**
 * The HighwayManager is responsible for drawing stuff on the canvas
 * It also contains methods for hit detection
 *
 * @module RL.HighwayManager
 */

RL.HighwayManager = function() {
return {
    aButtons: [false],
    aLanes  : [false],
    emitter : [false],
    progressBar: false,
    secondsOnScreen : RL.config.height / RL.config.pxPerSecond,
    topSecondsDistance : RL.config.buttonY / RL.config.pxPerSecond,
    containerDragStart: 0,
    containerDragEnd: 0,

    animateNoteDistanceInterval: false,

    drawNotes: function(){
    	noteContainer.removeAll(true);

        for(var lane = 1; lane <= RL.config.lanes; lane++){
            notes = this.aNotes[lane];

            for(var i = 0; i < notes.length; i++){
                duration = notes[i].duration;

                if(typeof(notes[i].time) !== 'undefined'){
                    t = notes[i].time;
                }else if(typeof(notes[i].start) !== 'undefined'){
                    t = notes[i].start*1000;
                    duration = notes[i].duration * 1000;
                }else{
                    t = notes[i].ms;
                }

                if(t === null){
                    this.aNotes[lane].splice(i,1);
                    continue;
                }

                notes[i] = new RL.Note(game, {
                    time: t,
                    lane: lane,
                    duration: duration,
                    cb: typeof(notes[i].cb) != 'undefined' ? notes[i].cb : false,
                    hitcb: typeof(notes[i].hitcb) != 'undefined' ? notes[i].hitcb : false,
                    hopo: notes[i].hopo      
                })

                notes[i].exists = true;

                noteContainer.add(notes[i]);

                if(RL.editMode)
                	notes[i].initEditorFunctions();
            }
        }

        this.drawHitArea();
    },

    updateNotes: function(notes){
        notes = $.map(notes, function(value, index){
            return [value];
        });

        for(var lane = 1; lane < notes.length; lane++){
            laneNotes = notes[lane];
            for(var n = 0; n < laneNotes.length; n++){
                currNote = laneNotes[n].updateY();
            }
        }
    },

    animateNoteDistance: function(to)
    {
        if(HighwayManager.animateNoteDistanceInterval){
            clearInterval(HighwayManager.animateNoteDistanceInterval);
        }

        HighwayManager.animateNoteDistanceFrom = RL.config.pxPerSecond;

        /*HighwayManager.animateNoteDistanceInterval = setInterval(function(){
            if(HighwayManager.animateNoteDistanceFrom > to && RL.config.pxPerSecond > to){
                RL.config.pxPerSecond-=2;
            }else if(RL.config.pxPerSecond < to){
                RL.config.pxPerSecond+=2;
            }else{
                clearInterval(HighwayManager.animateNoteDistanceInterval);
            }

            HighwayManager.updateNotes(HighwayManager.aNotes);

            if(RL.editMode){
                $('#slider-pxPerSecond').slider('value',RL.config.pxPerSecond);
                $('span#pxPerSecond').html(RL.config.pxPerSecond);
            }
        }, 50);*/

        RL.config.pxPerSecond = to;

        HighwayManager.updateNotes(HighwayManager.aNotes);

        if(RL.editMode){
            $('#slider-pxPerSecond').slider('value',RL.config.pxPerSecond);
            $('span#pxPerSecond').html(RL.config.pxPerSecond);
        }
    },

    countIn: function(play)
    {
        RL.HighwayManager.counterOverlay = $('.counter-overlay');
        RL.HighwayManager.counterOverlay.transition({ opacity: 0.5 });
        RL.HighwayManager.counterOverlay.find('.info').hide();
        RL.HighwayManager.counterOverlay.find('.count').show();

        this.counter = { start: (new Date()).getTime(), count: RL.config.countSeconds };

        $('.counter-overlay .count').html(this.counter.count);

        this.counterInterval = setInterval(function(){
            HighwayManager.counter.count --;
              RL.sounds.drumstick.play();

            if(HighwayManager.counter.count <= 0){
                RL.sounds.drumstick.stop();
                $('.counter-overlay').hide();
                clearInterval(HighwayManager.counterInterval);
                AudioManager.play();
            }else{
              $('.counter-overlay .count').html(HighwayManager.counter.count);
            }

        }, 1000);
    },

    drawGrid: function(){
        grid = game.add.image(0, 0, 'spritesheet', 35);
        grid.alpha = 0.5;
    },

    createButtons: function(){
        for(var i = 1; i <= 5; i++){
            var button = game.add.sprite(RL.getPosXForLane(i)-RL.config.buttonWidth/2, 
                                            RL.config.buttonY, 
                                            "spritesheet", 
                                            5*i-5
                                        );

            if(i > RL.config.lanes){
                button.alpha = 0.25;
            }
            
            this.aButtons.push(button);
            button.inputEnabled = true;
            button.lane = i;
            button.z = 5;

            var key = game.input.keyboard.addKey(RL.config.buttonKeys[i]);
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);
        }

        if(RL.config.mode == 'strum'){
            var key = game.input.keyboard.addKey(RL.config.buttonKeys[6]);
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);
        }

        game.input.keyboard.clearCaptures();
    },

    showLoadingScreen: function()
    {
        $('.large-player-loading-overlay').fadeOut();
        $('.loading-overlay').show();
        RL.loadingStep = '-=360deg';
        RL.loadingAnimation = setInterval(function(){
            $('.loading-overlay img').css({ 
                transformOrigin: '11px 10px'
            }).transition({
                rotate:RL.loadingStep,
                duration: 850
            });

            RL.loadingStep = (RL.loadingStep == '-=360deg') ? '+=360deg' : '-=360deg'; 
        }, 1010);
    },

    hideLoadingScreen: function()
    {
        $('.loading-overlay').fadeOut();

        clearInterval(RL.loadingAnimation);
    },

    showInfoScreen: function()
    {
        $('.counter-overlay').fadeIn();
    },

    hideInfoScreen: function()
    {
        $('.counter-overlay').fadeOut();
    },
    
    drawHitArea: function()
    {
        max = RL.config.buttonY+RL.config.noteHeight+10;
        min = RL.config.buttonY-2;

        grid = game.add.graphics(0, 0);
        grid.lineStyle(RL.config.gridLineWidth, RL.config.laneColors[1]);
        grid.moveTo(0, max);
        grid.alpha = 0.5;
        grid.lineTo(RL.config.width, max);

        grid = game.add.graphics(0, 0);
        grid.lineStyle(RL.config.gridLineWidth, RL.config.laneColors[1]);
        grid.moveTo(0, min);
        grid.alpha = 0.5;
        grid.lineTo(RL.config.width, min);
    },

	particleBurst: function(lane)
    {
        if(RL.config.showBurst)
        {
    	    //  The first parameter sets the effect to "explode" which means all particles are emitted at once
    	    //  The second gives each particle a ms lifespan
    	    //  The third is ignored when using burst/explode mode
    	    //  The final parameter (10) is how many particles will be emitted in this single burst
    	    this.emitter[lane].start(true, 700, null, 5);
        }
	},

    /**
    * This function starts hit detection
    *
    * (int) lane - The string to be tested for a hittable note
    * returns (boolean) true|false
    */
    startHitDetection: function(lane)
    {        
        if(RL.config.mode == 'strum'){
            if(lane === 6){
                // strum held notes
                // check each string if a note is being held down
                var count_hit = 0;

                for(var i = 1; i <= 5; i++){
                    if(RL.hittableNotes[i] && RL.pressedButtons[i]){
                        InteractionManager.strumDuration[i] = { start: (new Date()).getTime(), duration: 0 };

                        InteractionManager.keyboardPresses[i] = RL.hittableNotes[i];
                        InteractionManager.keyboardPresses[i].burst();

                        ScoreManager.sustainedCache[i] = 0;
                        ScoreManager.notes_hit++;

                        count_hit++;
                    }else if(RL.hittableNotes[i]){
                        ScoreManager.reset();
                        count_hit = -1;
                    }
                }

                if(count_hit <= 0){
                    ScoreManager.reset();
                }
            }else{
                RL.pressedButtons[lane] = true;
            }
        }else if(RL.config.mode == 'tap'){
            if(RL.hittableNotes[lane]){
                InteractionManager.keyboardPresses[lane] = RL.hittableNotes[lane];
                InteractionManager.keyboardPresses[lane].burst();
                ScoreManager.notes_hit++;
            }else{
                ScoreManager.reset();
            }
        }
    },

    /**
    * This function continues hit detection
    *
    * (int) lane - The string to be tested for a hittable note
    * returns (boolean) true|false
    */
    continueHitDetection: function(lane, duration)
    {
        if(RL.config.mode == 'strum'){
            if(lane != 6){              
                if(InteractionManager.keyboardPresses[lane] != 0){
                    if(!InteractionManager.keyboardPresses[lane].alive){
                        /*if(RL.hittableNotes[lane]){
                            InteractionManager.keyboardPresses[lane] = RL.hittableNotes[lane];
                            InteractionManager.keyboardPresses[lane].burst();
                        }*/
                        InteractionManager.keyboardPresses[lane] = 0;
                    }else{

                        duration = (new Date()).getTime() - InteractionManager.strumDuration[lane].start;
                        InteractionManager.keyboardPresses[lane].burstLong(duration, AudioManager.getPosition());
                    }
                }
            }
        }else if(RL.config.mode == 'tap'){
            if(InteractionManager.keyboardPresses[lane] !== 0){
                InteractionManager.keyboardPresses[lane].burstLong(duration, AudioManager.getPosition());
            }
        }
    },

    /**
    * This function ends hit detection
    *
    * (int) lane - The string where hitdetection ends
    * returns (boolean) true|false
    */
    endHitDetection: function(lane)
    {
        if(RL.config.mode == 'strum'){
            if(lane === 6){
                // strum holded notes
            }else{
                RL.pressedButtons[lane] = false;

                if(InteractionManager.keyboardPresses[lane] !== 0){
                    InteractionManager.keyboardPresses[lane].endTap();
                }

                InteractionManager.keyboardPresses[lane] = 0;
            }
        }else if(RL.config.mode == 'tap'){
            if(InteractionManager.keyboardPresses[lane] !== 0){
                InteractionManager.keyboardPresses[lane].endTap();
                InteractionManager.keyboardPresses[lane] = 0;
            }
            ScoreManager.resetSustainedCache(lane);
        }
    }
}
};;/**
 * Interaction manager for editor functions
 *
 * @module RL.InteractionManager.Editor
 */

RL.InteractionManager.Editor = function(){
return {
	init: function(){
		$('body').on('copy', function(e)
		{
			EditorManager.copyNotes(e);
		});
		$('body').on('paste', function(e)
		{
			EditorManager.pasteNotes(e);
		});
		$('#grid').on('change', function(){
			EditorManager.grid = parseFloat($(this).find('option:selected').val());
			EditorManager.drawBeatLines(true);
		});

		$('#ticksCB').on('change', function(){
			EditorManager.playTicks = $('#ticksCB:checked').length > 0 ? true : false;
		});

		$('#toggleLines').on('change', function(){
			if($('#toggleLines:checked').length > 0){
				EditorManager.advancedMode = true;
			}else{
				EditorManager.advancedMode = false;
				EditorManager.deleteBeatLines();
			}
		});

		$('#move_notes').on('click', function(e){
			e.preventDefault();

			var ms = $('input[name="move_notes_ms"]').val();
			if(confirm('Are you sure you want to move all notes of this track by '+ms+'ms?')){
				EditorManager.notesChanged = 0;
				EditorManager.moveAllByMs(ms);
			}
		});

		$('#sel-note-time').on('change', function(){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].time = parseFloat($(this).val());
					EditorManager.aSelectedNotes[i].updateY();
				}
			}
		});

		$('#sel-note-lane').on('change', function(){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].updateLane($(this).val());
				}
			}
		});

		$('#sel-note-duration').on('change', function(){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].updateDuration($(this).val());
				}
			}
		});

		$('#sel-note-distance').on('change', function(){
			var num = $(this).val();
			if(!isNaN(num)){
				EditorManager.aSelectedNotes[0].cb = 'HighwayManager.animateNoteDistance('+num+')';
			}else{
				$(this).val('-');
				EditorManager.aSelectedNotes[0].cb = '';
			}
		});

		$('#sel-note-hopo').on('change', function(){
			var state = $('#sel-note-hopo:checked').length;

			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].setHOPO(state);
				}
			}
		});

		$('#deselect-all').on('click', function(e){
			e.preventDefault();

			EditorManager.resetSelectedNotes();
		});

		$('#copy-selected a').on('click', function(e){
			e.preventDefault();

			EditorManager.copyNotes(e);
		});

		$('#paste-copied a').on('click', function(e){
			e.preventDefault();

			EditorManager.pasteNotes(e);
		});

		$('#previous-selection a').on('click', function(e){
			e.preventDefault();

			EditorManager.activatePreviousSelection(e);
		});

		jQuery('#autoSaveCB').on('change', EditorManager.toggleAutoSave);

		jQuery('.toggle-playback').on('click', InteractionManager.togglePlayback);

		var seekForwardKey = game.input.keyboard.addKey(RL.config.seekForwardKey);
		seekForwardKey.onHoldCallback = EditorInteractionManager.seekForward;

		var seekBackwardKey = game.input.keyboard.addKey(RL.config.seekBackwardKey);
		seekBackwardKey.onHoldCallback = EditorInteractionManager.seekBackward;

		var speedUpKey = game.input.keyboard.addKey(RL.config.speedUpKey);
		speedUpKey.onHoldCallback = EditorInteractionManager.speedUp;

		var speedDownKey = game.input.keyboard.addKey(RL.config.speedDownKey);
		speedDownKey.onHoldCallback = EditorInteractionManager.speedDown;

		var deleteKey = game.input.keyboard.addKey(RL.config.deleteKey);
		deleteKey.onDown.add(EditorManager.deleteNotes, this);

		var newLineKey = game.input.keyboard.addKey(RL.config.newLineKey);
		newLineKey.onDown.add(EditorManager.newLine, this);

		jQuery('.mute').on('click', EditorInteractionManager.toggleMute);

		jQuery('#btn-finish').on('click', EditorManager.finish);
		jQuery('#btn-save').on('click', EditorManager.save);

		/** config values **/

		jQuery('input[name="destroyNotes"]').on('change', function(){
			jQuery(this).is(':checked') ? RL.config.destroyNotes = true : RL.config.destroyNotes = false;
		});

		EditorManager.autoSaveSlider = jQuery('#slider-autoSave').slider({
			value: EditorManager.auto_save_interval,
			range: "min",
			min: 5,
			max: 1800,
			step: 5,
			slide: function(event, ui){
				tval = ui.value+' seconds';
				if(ui.value >= 60){
					tval = parseFloat(ui.value/60).toFixed(1)+' minutes';
				}
				jQuery('#auto-save-interval').html(tval);
				EditorManager.auto_save_interval = ui.value;
				EditorManager.toggleAutoSave(null, true);
			}
		});

		EditorManager.pxPerSecondSlider = jQuery('#slider-pxPerSecond').slider({
			value: RL.config.pxPerSecond,
			range: "min",
			min: 30,
			max: 1000,
			step: 1,
			slide: function(event, ui){
				jQuery('#pxPerSecond').html(ui.value);
				RL.config.pxPerSecond = ui.value;
		        RL.config.pxPerMs = RL.config.pxPerSecond / 1000;
		        RL.negPxPerMs = -RL.config.pxPerMs;
        		RL.msOnScreen = RL.config.height / RL.config.pxPerMs;

				if(EditorManager.advancedMode){
					EditorManager.drawBeatLines(true);
				}
				
				HighwayManager.updateNotes(HighwayManager.aNotes);
			}
		});

		setTimeout(function(){
			jQuery('#slider-position').html('');
			EditorManager.positionSlider = jQuery('#slider-position').slider({
				value: 0,
				range: "min",
				min: 0,
				max: AudioManager.getDuration(),
				step: 1,
				slide: function(event, ui){
					AudioManager.setPosition(ui.value);
				}
			});
		}, 500)

		EditorManager.playbackRateSlider = jQuery('#slider-playbackRate').slider({
			value: RL.config.playbackRate,
			range: "min",
			min: 0.5,
			max: 4,
			step: 0.1,
			slide: function(event, ui){
				jQuery('#playbackRate').html(ui.value);
				RL.config.playbackRate = ui.value;
				AudioManager.setPlaybackRate(ui.value);
			}
		});

		jQuery('input[name="tracking"]').on('click', function(){
			EditorManager.toggleTracking();
		});

		jQuery('input[type="text"]').on('focus', function(){
			if(RL.config.trackTaps){
				EditorManager.toggleTracking();
				jQuery(this).data('trackTaps', true);
			}else{
				jQuery(this).data('trackTaps', false);
			}
		});

		jQuery('input[type="text"]').on('focusout', function(){
			if(jQuery(this).data('trackTaps')){
				EditorManager.toggleTracking();
			}
		})
	},
	seekForward: function(e, time){
		if(typeof(time) == 'undefined') time = typeof(e.duration) != 'undefined' ? e.duration/10 : 1;
		AudioManager.setPosition(AudioManager.getPosition()+time);
	},

	seekBackward: function(e, time){
		if(typeof(time) == 'undefined') time = typeof(e.duration) != 'undefined' ? e.duration/10 : 1;
		AudioManager.setPosition(AudioManager.getPosition()-time);
	},

	speedUp: function(e, speed){
		if(typeof(speed) == 'undefined') speed = AudioManager.getPlaybackRate() + 0.005;
		if(speed > 4) speed = 4;
		AudioManager.setPlaybackRate(speed);
		EditorManager.playbackRateSlider.slider('value', speed);
		jQuery('#playbackRate').html(speed.toFixed(2));
	},

	speedDown: function(e, speed){
		if(typeof(speed) == 'undefined') speed = AudioManager.getPlaybackRate() - 0.005;
		if(speed < 0.5) speed = 0.5;
		AudioManager.setPlaybackRate(speed);
		EditorManager.playbackRateSlider.slider('value', speed);
		jQuery('#playbackRate').html(speed.toFixed(2));
	},

	// TODO: change for soundjs -- add mute function to audiomanager
	toggleMute: function(){
		if(typeof(AudioManager.muted) != 'undefined'){
			AudioManager.toggleMute();
			AudioManager.muted ? jQuery('.audio-controls .mute').removeClass('unmute') : jQuery('.audio-controls .mute').addClass('unmute');
		}
	},

	resetSpeed: function(e, speed){
		AudioManager.setPlaybackRate(1);
	},
	handleCanvasUp: function(e)
	{
	    HighwayManager.containerDragStart = 0;
	},
	handleCanvasDown: function(e)
	{
	    if(e.button == 0){
	        HighwayManager.containerDragStart = e.positionDown.y;
	    }else if(e.button == 2){
	        dist = (( RL.config.buttonY - e.positionDown.y) / RL.config.pxPerSecond);
	        time = AudioManager.getPosition() + dist + 0.1;
	        /*if(time > 0)
	            RL.managers.EditorManager.addTap(RL.Note.prototype.setLaneForX(e.positionDown.x, true)-1, time);*/
	    }
	}
}
};;RL.ScoreManager = function(){
return {
	score: 0,
	multiplier: 1,
	streak: 0,
	max_streak: 0,
	max_multiplier: 0,
	notes_hit: 0,
	notes_missed: 0,
	percent: 0,

	sustainedCache: [0,0,0,0,0,0],

	cheeringStreak: [25, 50, 100, 150, 200, 300, 400, 500],

	singleNotePoints: 50,

	$score: $('.score-display .score'),
	$streak: $('.score-display .streak'),
	$multiplier: $('.score-display .multiplier'),

	init: function(){
		this.$score.html('0');
		this.$streak.html('0');
		this.$multiplier.html('x1');

		$('.repeat-song').unbind().on('click', function(e){
			e.preventDefault();

			$('.score-overlay').fadeOut();
			
			ScoreManager.animateFinishBack('.score-points-wrap', 0);
			ScoreManager.animateFinishBack('.score-streak-wrap', 1);
			ScoreManager.animateFinishBack('.score-multiplier-wrap', 0);

			RL.init();
		});

		$('.share-score').unbind().on('click', function(e){
			FB.ui({
				method: 'feed',
				caption: 'Can you beat my score?',
				name: share_title,
				description: 'I just scored '+numberWithDots(ScoreManager.score)+' points on "'+song_name+'" by '+artist_name+'! A max streak of '+numberWithDots(ScoreManager.max_streak)+', '+
								numberWithDots(ScoreManager.notes_hit)+' notes hit and a completion of '+ScoreManager.percent+'%. #thisisrocklegend',
				link: share_url,
				picture: thumbnail_url
			});
		});
	},

	ended: function(){
		if(!RL.editMode && !testMode){
			// here we should switch to the next state -> "ENDED"
			$.post('/play/score/'+track_id+'/save',
			{
				score: ScoreManager.score,
				max_streak: ScoreManager.max_streak,
				max_multiplier: ScoreManager.max_multiplier,
				notes_missed: ScoreManager.notes_missed,
				notes_hit: ScoreManager.notes_hit
			}, function(data){
				// data should be an object with score related information
				if(rl.focusMode){
					rl.darkenPage();
				}

				$('.score-overlay').fadeIn();
				
				var total_notes = notes_count;
				var percent_hit = (ScoreManager.notes_hit / total_notes * 100).toFixed(2);

				ScoreManager.percent = percent_hit;

				ScoreManager.animateFinish('.score-points-wrap', 2, function(){});

				setTimeout(function(){
					ScoreManager.animateFinish('.score-streak-wrap',1.5, function(){
						$('.score-streak-wrap h1').eq(2).not('.streak').html('Max Streak');
						$('.score-streak-wrap h1.streak').eq(1).html(ScoreManager.max_streak);
					});
				}, 270);

				setTimeout(function(){
					ScoreManager.animateFinish('.score-multiplier-wrap',3.5, function(){
						$('.score-multiplier-wrap h1').eq(2).not('.multiplier').html('Percent');
						$('.score-multiplier-wrap h1.multiplier').eq(1).html(percent_hit+'%');
					});
				}, 540);

				setTimeout(function(){
					$('.score-button-wrap').fadeIn();
				}, 1010);

				RL.sounds.crowds[0].play();
			});
		}
	},

	animateFinish: function(selector, indent, cb)
	{
		var indent = typeof(indent) != 'undefined' ? indent : 0;

		var $scoreWrap = $(selector);
		var $scoreClone = $scoreWrap.clone();

		$scoreClone
			.css({
				position: 'absolute',
				top: $scoreWrap.offset().top-1,
				left: $scoreWrap.offset().left
			})
			.appendTo('body')
			.transition({
				left: $('.score-overlay').offset().left + $('.score-overlay').width()/2 - $scoreClone.width() + indent * 20,
				duration: 500
			}, 500, 'ease-in-out');

		$scoreWrap.fadeOut(0).css({ display: 'inline-block', visibility : 'hidden'});

		cb();
	},

	animateFinishBack: function(selector, indent)
	{
		var $scoreWrap = $(selector).eq(0);
		var $scoreClone = $(selector).eq(1);

		$scoreClone
			.transition({
				left: $scoreWrap.offset().left - indent*20,
				duration: 500
			}, 500, 'ease-in-out');

		setTimeout(function(){
			$scoreClone.fadeOut(200,function(){ $scoreClone.remove(); });
			$scoreWrap.css('visibility', 'visible').fadeOut(0).fadeIn(200);
		}, 500);
	},

	adjustScoreBox: function(){
		$('.scoreBox').css({
			position: 'absolute',
			left: $('#main-canvas canvas').offset().left + RL.config.width,
			top: $('#main-canvas canvas').offset().top + 60,
		});
	},

	scoreSingleNote: function(){
		this.score += this.singleNotePoints * this.multiplier;
		this.increaseStreak();

		if(this.streak % 10 == 0){
			this.increaseMultiplier();
		}

		this.$score.html(numberWithDots(this.score));
	},

	scoreSustainedNote: function(duration, currentDuration, lane)
	{
		perc = Math.ceil((currentDuration / (duration/100))/1000 * duration * this.multiplier);
		this.score -= this.sustainedCache[lane];

		if(this.sustainedCache[lane] <= 0){
			this.increaseStreak();

			if(this.streak % 10 == 0){
				this.increaseMultiplier();
			}
		}

		this.sustainedCache[lane] = perc;
		this.score += perc;

		this.$score.html(numberWithDots(this.score));
	},

	resetSustainedCache: function(lane)
	{
		this.sustainedCache[lane] = 0;
	},

	increaseMultiplier: function(){
		// maximum multiplier: 4
		if(this.multiplier <= 3){
			this.multiplier++;
			this.$multiplier.html('x'+this.multiplier);

			if(this.max_multiplier < this.multiplier){
				this.max_multiplier = this.multiplier;
			}
		}
	},

	increaseStreak: function(){
		this.streak++;
		this.$streak.html(this.streak);

		if(this.max_streak < this.streak){
			this.max_streak = this.streak;
		}

		if(this.cheeringStreak.indexOf(this.streak) > -1){
			rand = Math.floor(Math.random() * RL.sounds.crowds.length);
			RL.sounds.crowds[rand].play();
		}
	},

	reset: function(){
		this.multiplier = 1;
		this.streak = 0;

		this.$streak.html('0');
		this.$multiplier.html('x1');
	}
}
};

function numberWithDots(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};/**
* Defines the Boot State (initial state) of rocklegends play
* This state loads the assets and then switches to the Run state
*/
RL.States.Boot = {
    soundsToLoad: 1, // the amount of sounds loaded by soundjs
    soundsLoaded: 0, // holds the current amount of loaded sounds by soundjs

    preload: function()
    {
        HighwayManager.showLoadingScreen();

        game.load.crossOrigin = 'anonymous';
        game.load.baseURL = ASSETS_BASE_URL;

        game.load.atlasJSONHash('spritesheet', '/assets/images/game/spritesheet-player.png?t='+(new Date()).getTime(), '/assets/images/game/spritesheet-hash.json?t='+(new Date()).getTime());

        game.load.audio('squeak', ['/assets/sounds/game/squeak1.mp3', '/assets/sounds/game/squeak1.ogg']);
        game.load.audio('tick', ['/assets/sounds/game/tick.mp3', '/assets/sounds/game/tick.ogg']);
        
        game.load.script('webfont', '/assets/js/plugins/webfont.js');

        createjs.Sound.registerPlugins([createjs.HTMLAudioPlugin, createjs.WebAudioPlugin, createjs.FlashPlugin]);
        createjs.Sound.registerSound(game.load.baseURL+soundFiles[0], "music");
        createjs.Sound.addEventListener("fileload", createjs.proxy(this.loadedSound, this));
    },

    // this function waits for the createjs sounds to be loaded and then switches to the next state
    update: function()
    {
        if(this.soundsToLoad <= this.soundsLoaded)
        {
            $('#main-canvas canvas').css('visibility', 'visible');
            
            if(typeof(RL.music) == 'undefined'){
                RL.music = createjs.Sound.createInstance('music');
            }else{
                AudioManager.stop();
            }
            
            RL.music.addEventListener("complete", createjs.proxy(ScoreManager.ended, this));

            RL.sounds.squeaks = [game.add.sound('squeak1')];

            $(document).on("keydown", function (e) {
              {
                if(e.which == 32 && !$('input,textarea').is(':focus')){ e.preventDefault(); }
              }
            });

            RL.sounds.ticks = [ false, game.add.sound('tick'), game.add.sound('tick'), game.add.sound('tick'), game.add.sound('tick'), game.add.sound('tick') ];
            
            game.state.start("Editor");
        }
    },

    /* soundjs loadcheck*/
    loadedSound: function()
    {
        this.soundsLoaded ++;
    }
};/**
* Defines the Boot State (initial state) of rocklegends play
* This state loads the assets and then switches to the Run state
*/
RL.States.Editor = {
    dragBoxNoteContainerStartY: 0,
    dragStartX: false,
    dragStartY: false,
    dragBoxWidth: false,
    dragBoxHeight: false,
    $timer: $('#debug-container input[name="current-time"]'),

    preload: function(){

    },

    /**
     * Creates the basic canvas for the note highway
     * triggers function calls for drawing the grid
     * drawing the hit buttons
     * drawing the note container
     * and initializing the interaction handler
     *
     * it also starts the song and adds emitters and squeak sounds
     *
     * @author lst
     * @author pne
     */
    create: function()
    {
        game.stage.disableVisibilityChange = true;
        game.stage.backgroundColor = 0X2C2C2C;

        InteractionManager.init();

        HighwayManager.drawGrid();
        HighwayManager.createButtons();

        noteContainer = game.add.group(game, game.world, "noteContainer", false);
        //noteContainer.enableBody = true;
        noteContainer.inputEnabled = true;

        HighwayManager.drawNotes();

        EditorManager.init();

        // mouseevent listener
        game.input.onDown.add(EditorInteractionManager.handleCanvasDown);
        game.input.onUp.add(EditorInteractionManager.handleCanvasUp);

        squeak = game.add.sound('squeak');
        tick = game.add.sound('tick');

        _emitters = HighwayManager.emitter;
        _emitterY = RL.config.buttonY + RL.config.buttonHeight/2;

        for(var i = 1; i <= 5; ++i){
            _emitters.push(game.add.emitter(0, 0, 50));
            _emitters[i].makeParticles(['spritesheet'], 24+i);
            _emitters[i].gravity = 400;
            _emitters[i].x = RL.getPosXForLane(i);
            _emitters[i].y = _emitterY;
        }

        AudioManager.init();

        $('canvas').on("contextmenu", function(evt) {evt.preventDefault();});
            
        HighwayManager.hideLoadingScreen();

        dragSelectionBox = game.add.graphics(0,0);
        dragSelectionBox.z = 100;
        dragSelectionBox.renderable = false;
        dragSelectionPhysicsBox = game.add.sprite(0,0,null);
        dragSelectionPhysicsBox.renderable = false;

        game.physics.enable(dragSelectionPhysicsBox, Phaser.Physics.ARCADE);
        dragSelectionPhysicsBox.body.setSize(0,0,0,0);
    },

    update: function()
    {
        currentPlaybackTime = AudioManager.getPosition();

        noteContainer.y = RL.config.buttonY + (currentPlaybackTime/1000 * RL.config.pxPerSecond);;

        if(game.time.now % 2 == 0)
        {
            this.$timer.val(currentPlaybackTime.toFixed(3));
        }

        if(EditorManager.positionSlider){
            EditorManager.positionSlider.slider('value', currentPlaybackTime.toFixed(3));
        }

        if(game.input.activePointer.isDown && !EditorManager.dragging){
            if(game.input.activePointer.y <= 25){
                AudioManager.setPosition(currentPlaybackTime+game.input.activePointer.duration/75);
            }else if(game.input.activePointer.y >= RL.config.height-25){
                AudioManager.setPosition(currentPlaybackTime-game.input.activePointer.duration/75);
            }

            if(!EditorManager.dragging){
                if(this.dragStartX === false){
                    this.dragStartX = game.input.activePointer.x;
                    this.dragStartY = game.input.activePointer.y;
                    this.dragBoxNoteContainerStartY = noteContainer.y;
                }
        
                dragSelectionBox.endFill();
                dragSelectionBox.clear();
                dragSelectionBox.beginFill(0XCCCCCC,0.5);
                dragSelectionBox.lineStyle(1,0XFFFFFF,0.8);

                // calculate new selection width
                this.dragBoxWidth = game.input.activePointer.x - this.dragStartX;

                // calculate offset of repositioned noteContainer
                noteContainerDiff = noteContainer.y - this.dragBoxNoteContainerStartY;

                startY = this.dragStartY + noteContainerDiff;

                this.dragBoxHeight = game.input.activePointer.y - startY;

                dragSelectionBox.drawRect(this.dragStartX, startY, this.dragBoxWidth, this.dragBoxHeight);
            }
        }else{
            if(this.dragStartX !== false){
                dragSelectionBox.endFill();

                if((this.dragBoxWidth > 40 || this.dragBoxWidth < -40) && (this.dragBoxHeight > 20 || this.dragBoxHeight < -20)){
                    // calculate offset of repositioned noteContainer
                    noteContainerDiff = noteContainer.y - this.dragBoxNoteContainerStartY;

                    startY = this.dragStartY + noteContainerDiff;
                   
                    // set collision box
                    dragSelectionPhysicsBox.body.setSize(Math.abs(this.dragBoxWidth), Math.abs(this.dragBoxHeight), this.dragBoxWidth < 0 ? this.dragStartX + this.dragBoxWidth : this.dragStartX, this.dragBoxHeight < 0 ? startY + this.dragBoxHeight : startY);

                    if(game.input.keyboard.event != null){
                        var shiftKey = game.input.keyboard.event.shiftKey;
                    }else{
                        shiftKey = false;
                    }

                    /** if shiftkey is not pressed we start a new selection **/
                    if(!shiftKey){
                        EditorManager.resetSelectedNotes();
                    }

                    setTimeout(function(){
                        dragSelectionBox.clear(); // we want the selection to disappear after the notes are selected
                        noteContainer.forEach(function(note){
                            game.physics.arcade.overlap(note, dragSelectionPhysicsBox, 
                                function(note, box){ 
                                    EditorManager.onNoteDown(note, null, true);
                                }
                            );
                        });                        
                    }, 50);

                }else{
                    dragSelectionBox.clear();
                }

                this.dragStartX = false;
                this.dragStartY = false;
            }       
        }

        if(EditorManager.advancedMode){
            EditorManager.beatLineContainer.y = noteContainer.y;
            EditorManager.beatLineTextContainer.y = noteContainer.y;

            EditorManager.drawBeatLines();
        }
    },

    render: function(){
        //game.debug.body(dragSelectionPhysicsBox);
    }
};/**
* Represents a note object
* Contains all data for the note, e.g. time, duration, lane etc.
*
* @class RL.Note
* @constructor
*/

RL.Note = function(game, opts){
	this.className = 'RL.Note';
 	this.game = game;

 	if(typeof(opts.y) == 'undefined' || opts.y == null){
 		var y = RL.getYForTime(opts.time);
 	}else{
 		var y = opts.y;
 	}	

	var x = RL.getXForLaneButton(opts.lane);
	var lane = opts.lane;
	var time = opts.time;
	var duration = opts.duration;
	var frame = opts.hopo ? 2 : 0;
	var self = this;

	var cb = typeof(opts.cb) != 'undefined' ? opts.cb:false;
	var hitcb = typeof(opts.hitcb) != 'undefined' ? opts.hitcb:false;

	Phaser.Sprite.call(this, this.game, x, y, 'spritesheet', 0);

	this.showRect = typeof(opts.showRect) !== 'undefined' ? opts.showRect : false;
	this.hopo = typeof(opts.hopo) != 'undefined' ? opts.hopo : false;
	this.hit = false;
	this.lane = lane;
	this.time = parseFloat(time);
	this.removed = false;
	this.originalTime = parseFloat(time);
	this.duration = typeof(duration) != 'undefined' ? parseFloat(duration) : 0;
	this.originalDuration = parseFloat(this.duration);
	this.endTime = this.time + this.duration;

	this.cb_fired = false;
	this.hitcb_fired = false;
	this.cb = cb;
	this.hitcb = hitcb;

	this.maxHitY = RL.config.buttonY+RL.config.buttonHeight;
	this.minHitY = RL.config.buttonY-RL.config.noteHeight/1.5;
	this.shortMaxHitY = this.maxHitY;

	if(this.duration >= RL.config.longNoteThreshold){
		this.drawRect(this.showRect);
	}

	this.exists = false;

	this.setDefaultTexture();

	this.game.add.existing(this);
}

RL.Note.prototype = Object.create(Phaser.Sprite.prototype);
RL.Note.prototype.constructor = RL.Note;

RL.Note.prototype.create = function(){}

RL.Note.prototype.drawRect = function(shorter){
	if(typeof shorter === 'undefined') shorter = false;

	var rectangleHeight = this.duration/1000 * RL.config.pxPerSecond + RL.config.noteHeight/2;

	rectangleY =  this.y - rectangleHeight + RL.config.noteHeight/2;

	if(typeof(this.rect) === 'undefined')
	{
		var rectangle = game.add.image(RL.getPosXForLane(this.lane) - 11,rectangleY,'spritesheet',29+this.lane);

		rectangle.scale.setTo(1, rectangleHeight/30); // divide through rect height

		if(shorter === false)
		{
			rectangle.exists = false;
			rectangle.alpha = 0.5;
		}

		noteContainer.add(rectangle);
		noteContainer.sendToBack(rectangle);

		this.rect = rectangle;
	}
	else
	{
		if (this.rect.y !== rectangleY) {
			this.rect.scale.setTo(1, 1);
			this.rect.y = rectangleY;
			this.rect.scale.setTo(1, rectangleHeight/30);
		}

		if(shorter)
		{
			this.rect.alpha = 1;
			this.rect.scale.setTo(1, rectangleHeight/30);
		}
	}

	this.rectHeight = rectangleHeight;
	this.maxHitY = RL.config.buttonY+RL.config.noteHeight+10+rectangleHeight;
	this.killMaxY = this.maxHitY + 50;
}

RL.Note.prototype.update = function(){
	if(this.time > AudioManager.currentTime + RL.msOnScreen || 
		this.time < AudioManager.currentTime - this.duration - 250 ||
		!this.alive){
		this.exists = false;

		if(typeof this.rect !== 'undefined')
		{
			this.rect.exists = false;
		}		
	}else{
		this.exists = true;

		if(typeof this.rect !== 'undefined')
		{
			this.rect.exists = true;
		}
	}

	if(this.input != null && this.input.isDragged){
		var pointerDiff = game.input.activePointer.y;

		this.input.updateDrag(game.input.activePointer);

		lane = this.setLaneForX(this.x) - 1;

		time = RL.getTimeForY(this.y);

		// if advanced editor is active and grid snapping is activated 
		// the notes y position should snap to the grid
		if(	EditorManager.beatsInitialized &&
			EditorManager.grid_snap)
		{
			snap = EditorManager.secondsPerNote*1000;

			time = time.roundTo(snap);
		}

		this.isSelected = true;
		this.setDefaultTexture();

		this.time = time;
		this.y = RL.getYForTime(time);

		/** MOVE CORRESPONDING SUSTAINED RECTANGLE! **/
		if(typeof this.rect !== 'undefined'){
			this.rect.destroy();
			this.rect = undefined;
			this.drawRect(true);
		}
	}
}

RL.Note.prototype.kill = function(force){
	force = typeof(force) != 'undefined' ? force : false;

	RL.hittableNotes[this.lane] = false;

	if(force){
		if(force && typeof this.rect !== 'undefined') this.rect.destroy(true);
	}

	noteContainer.remove(this, true, true);
}

RL.Note.prototype.updateY = function(){
	this.y = RL.getYForTime(this.time);

	if(typeof this.rect != 'undefined') this.drawRect();
}

/**
 * getTimeForY(y)
 *
 * (int) y = the y position in pixels
 *
 * @return (float) time = the time in ms
 */
RL.Note.prototype.updateTime = function(){
	var time = RL.getTimeForY(this.y);
	this.time = time;
	return time;
}

RL.Note.prototype.updateDuration = function(duration){
	this.duration = parseFloat(duration);
	this.originalDuration = this.duration;
	this.endTime = this.time + this.duration;

	this.maxHitY = RL.config.buttonY+RL.config.noteHeight;
	this.minHitY = RL.config.buttonY-RL.config.noteHeight+20;
	this.shortMaxHitY = this.maxHitY;

	if(this.duration >= RL.config.longNoteThreshold){
		this.drawRect();
	}else if(typeof this.rect != 'undefined'){
		this.rect.destroy();
	}
}

/**
 * getLaneForX(y)
 *
 * (int) x = the x position in pixels
 *
 * @return (int) lane = the lane number
 */
RL.Note.prototype.setLaneForX = function(x, mouse){
   	if(typeof(mouse) == 'undefined') mouse = false;
	//x += RL.config.noteWidth / 2;
	for(var i = 0 ; i <= RL.config.lanes; ++i){
		var laneX= RL.config.width / (RL.config.lanes) * i - RL.config.buttonWidth/2;
		if(!mouse){
			if(laneX >= x){
				this.lane = i;
				return i;
			}
		}else{
			var laneX = laneX + RL.config.noteWidth;
			if(laneX >= x){
				this.lane = i;
				return i;
			}
		}
	}

	this.lane = 5;

	return 6;
}

RL.Note.prototype.updateLane = function(lane){
	for(var l = 0; l < HighwayManager.aNotes.length; l++){
		laneNotes = HighwayManager.aNotes[l];
		for(var n = 0; n < laneNotes.length; n++){
			if(laneNotes[n] == this){
				laneNotes.splice(n,1);
			}
		}
	}

	this.x = RL.getXForLaneButton(lane);
	this.lane = lane;
	this.loadTexture('spritesheet',5*this.lane-3);

	if(typeof(this.rect) !== 'undefined'){
		this.drawRect();
	}
	HighwayManager.aNotes[this.lane].push(this);

	return this;
}

RL.Note.prototype.setHOPO = function(on){
	this.hopo = on ? true : false;

	this.setDefaultTexture();
}

RL.Note.prototype.setDefaultTexture = function(){
	if(!this.isSelected){
		if(this.hopo){
			this.loadTexture('spritesheet',5*this.lane-1);
		}else{
			this.loadTexture('spritesheet',5*this.lane-3);
		}
	}else{
		this.loadTexture('spritesheet',5*this.lane-2);
	}
}

RL.Note.prototype.initEditorFunctions = function(){
	this.isSelected = false;
	this.ticked = false;
	
	this.inputEnabled = true;
	this.input.enabled = true;
	this.input.enableDrag(	
		false, 
		true, 
		true, 
		255, 
		0, 
		new Phaser.Rectangle(
			RL.config.noteWidth/2,
			-900719925474,
			RL.config.width-RL.config.noteWidth,
			900719925474
		)
	);

	this.input.useHandCursor = true;
    this.input.allowHorizontalDrag = true;

    this.input.enableSnap(	
    	RL.config.width / (RL.config.lanes+1), 
		0.1, 
		true, 
		false, 
		-RL.config.noteHeight/2, 
		0
    );

    this.input.pixelPerfectAlpha = 1;

    game.physics.enable(this, Phaser.Physics.ARCADE);

    this.events.onInputDown.add( EditorManager.onNoteDown );
    this.events.onInputUp.add( EditorManager.onNoteUp );

    this.events.onDragStart.add(EditorManager.onNoteDragStart);
    this.events.onDragStop.add(EditorManager.onNoteDragStop);
    this.onHold = EditorManager.onDragging;
};var game = null;

jQuery(function($) {
    RL.init();
});

/***/

Number.prototype.roundTo = function(num) {
    var resto = this%num;
    if (resto <= (num/2)) { 
        return this-resto;
    } else {
        return this+num-resto;
    }
}

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();