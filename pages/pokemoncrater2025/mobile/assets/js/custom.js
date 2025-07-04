jQuery(document).ready(function () {
		// Touch Slider START
		jQuery('.owl-active').owlCarousel({items : 3});
		// Touch Slider END
		
		// Validation START
		jQuery("#admin_page form").validate({
			rules: {
				storage_ttl: {
					minlength: 0
				}
			}
		});
		// Validation END
		
		// Video START
		jQuery( 'body' ).on('popupbeforeposition', '.ui-page-active .video-popup', function(){
			var size = scale( 640, 480, 15, 1 ),
				w = size.width,
				h = size.height;
			jQuery(this).find('iframe').attr( "width", w ).attr( "height", h );
		});
		jQuery( 'body' ).on('popupafterclose', '.ui-page-active .video-popup', function(){
			var videoSrc = jQuery(this).find('iframe').attr('src');
			jQuery(this).find('iframe').attr('src', videoSrc);
		});
		jQuery('.ui-content').on('click', '.alert', function(){
			jQuery(this).fadeOut();
		});
		function scale( width, height, padding, border ) {
			var scrWidth = jQuery( window ).width() - 30,
				scrHeight = jQuery( window ).height() - 30,
				ifrPadding = 2 * padding,
				ifrBorder = 2 * border,
				ifrWidth = width + ifrPadding + ifrBorder,
				ifrHeight = height + ifrPadding + ifrBorder,
				h, w;

			if ( ifrWidth < scrWidth && ifrHeight < scrHeight ) {
				w = ifrWidth;
				h = ifrHeight;
			} else if ( ( ifrWidth / scrWidth ) > ( ifrHeight / scrHeight ) ) {
				w = scrWidth;
				h = ( scrWidth / ifrWidth ) * ifrHeight;
			} else {
				h = scrHeight;
				w = ( scrHeight / ifrHeight ) * ifrWidth;
			}

			return {
				'width': w - ( ifrPadding + ifrBorder ),
				'height': h - ( ifrPadding + ifrBorder )
			};
		};
		// Video END
		
		// Touch Gallery START
		if ( jQuery('.gallery').hasClass('gallery-active') ) {
			var myPhotoSwipe = jQuery(".gallery-active a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false });
		}
		// Touch Gallery END
		
		jQuery( 'body' ).on( "pagebeforeload", function( event ) {
			jQuery('#disqus_thread').empty().removeClass('disqus-active').addClass('disqus-inactive').removeAttr('id');
			jQuery('.owl-carousel').removeClass('owl-active');
			jQuery('.gallery').removeClass('gallery-active');
		});
		jQuery( 'body' ).on( "pagechange", function( event, ui ) {
			// Activate Retina Images START
			if (RetinaImage !== undefined) {
				jQuery('.ui-page-active img:not([src*="@2x"])').each(function() {
					new RetinaImage(this);
				});
			}
			// Activate Retina Images END
			jQuery('.ui-content').on('click', '.alert', function(){
				jQuery(this).fadeOut();
			});
			// Validation START
			jQuery("#admin_page form").validate({
				rules: {
					storage_ttl: {
						minlength: 0
					}
				}
			});
			// Validation END
			
			// New Items Counter START
			headerCount = 0;
			jQuery('.ui-page-active .countable').each(function () {
				var itemId = jQuery(this).attr('id');
				var itemsCount = jQuery(this).find('a').attr('data-count');
				var itemsCount = parseInt(itemsCount, 10);
				var currentCounter = jQuery.jStorage.get(itemId);
				currentCounter = parseInt(currentCounter, 10);
				var diff = itemsCount-currentCounter;
				if (diff > 0) {
					jQuery(this).find('.ui-li-count').html(diff).removeClass('hidden');
				}else if (diff <= 0) {
					jQuery(this).find('.ui-li-count').html(diff).addClass('hidden');
				}
				headerCount = headerCount+diff;
			});
			if (headerCount > 0) {
				jQuery('.counter-header').html(headerCount).removeClass('hidden');
			}else{
				jQuery('.counter-header').html(headerCount).addClass('hidden');
			}
			// New Items Counter END
			if ( jQuery('.disqus-wrap').length == 1 ) {
				jQuery('.disqus-inactive').addClass('disqus-active').removeClass('disqus-inactive').attr('id','disqus_thread');
			}
			if ( jQuery('.owl-carousel').hasClass('owl-active') ) {
				jQuery('.owl-active').owlCarousel({items : 3});
			}
			if ( jQuery('.gallery').hasClass('gallery-active') ) {
				var myPhotoSwipe = jQuery(".gallery-active a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false });
			}
			jQuery('.menu-btn-background').removeClass('accent-color');
			if( typeof( DISQUS ) !== 'undefined' ){
				DISQUS.reset({
					reload: true,
					config: function () {
						this.page.identifier = jQuery('.ui-page-active .page_title').html().replace(/ /g,'-');
						this.page.url = document.location.href;
						this.page.title = jQuery('.ui-page-active .page_title').html();
					}
				});
			}
		});
		jQuery( 'body' ).on( "panelopen", "#left_panel", function( event, ui ) {
			jQuery('.menu-btn-background').addClass('accent-color');
		});
		jQuery( 'body' ).on( "panelclose", "#left_panel", function( event, ui ) {
			jQuery('.menu-btn-background').removeClass('accent-color');
		});
		jQuery( 'body' ).on( "panelopen", "#right_panel", function( event, ui ) {
			jQuery('.share-btn-background').addClass('accent-color');
		});
		jQuery( 'body' ).on( "panelclose", "#right_panel",  function( event, ui ) {
			jQuery('.share-btn-background').removeClass('accent-color');
		});
});
// Colour Picker Plugin
(function(e,t){e.widget("mobile.hsvpicker",e.mobile.widget,{options:{color:"#ff6446",initSelector:":jqmData(role='hsvpicker')"},_create:function(){function o(e,t){for(var n in t)if(typeof t[n]==="string")t[n]=e.find(t[n]).removeAttr("id");else if(typeof t[n]==="object")t[n]=o(e,t[n]);return t}var n={color:this.element.is("input")?"value":"data-"+(e.mobile.ns||"")+"color"},r={container:"#hsvpicker",hue:{selector:"#hsvpicker-hue-selector",hue:"#hsvpicker-hue-hue",valMask:"#hsvpicker-hue-mask-val",eventSource:"[data-event-source='hue']"},sat:{selector:"#hsvpicker-sat-selector",hue:"#hsvpicker-sat-hue",valMask:"#hsvpicker-sat-mask-val",eventSource:"[data-event-source='sat']"},val:{selector:"#hsvpicker-val-selector",hue:"#hsvpicker-val-hue",eventSource:"[data-event-source='val']"}},i=e("<div>"+"  <div id='hsvpicker' class='ui-hsvpicker'>"+"    <div class='hsvpicker-clrchannel-container'>"+"        <div class='hsvpicker-arrow-btn-container'>"+"            <a href='#' class='hsvpicker-arrow-btn' data-target='hue' data-location='left' data-role='button' data-inline='true' data-iconpos='notext' data-icon='arrow-l'></a>"+"        </div>"+"        <div class='hsvpicker-clrchannel-masks-container'>"+"            <div class='hsvpicker-clrchannel-mask hsvpicker-clrchannel-mask-white'></div>"+"            <div id='hsvpicker-hue-hue' class='hsvpicker-clrchannel-mask hue-gradient'></div>"+"            <div id='hsvpicker-hue-mask-val' class='hsvpicker-clrchannel-mask hsvpicker-clrchannel-mask-black' data-event-source='hue'></div>"+"            <div id='hsvpicker-hue-selector' class='hsvpicker-clrchannel-selector ui-corner-all'></div>"+"        </div>"+"        <div class='hsvpicker-arrow-btn-container'>"+"            <a href='#' class='hsvpicker-arrow-btn' data-target='hue' data-location='right' data-role='button' data-inline='true' data-iconpos='notext' data-icon='arrow-r'></a>"+"        </div>"+"    </div>"+"    <div class='hsvpicker-clrchannel-container'>"+"        <div class='hsvpicker-arrow-btn-container'>"+"            <a href='#' class='hsvpicker-arrow-btn' data-target='sat' data-location='left' data-role='button' data-inline='true' data-iconpos='notext' data-icon='arrow-l'></a>"+"        </div>"+"        <div class='hsvpicker-clrchannel-masks-container'>"+"            <div id='hsvpicker-sat-hue' class='hsvpicker-clrchannel-mask'></div>"+"            <div class='hsvpicker-clrchannel-mask  sat-gradient'></div>"+"            <div id='hsvpicker-sat-mask-val' class='hsvpicker-clrchannel-mask hsvpicker-clrchannel-mask-black' data-event-source='sat'></div>"+"            <div id='hsvpicker-sat-selector' class='hsvpicker-clrchannel-selector ui-corner-all'></div>"+"        </div>"+"        <div class='hsvpicker-arrow-btn-container'>"+"            <a href='#' class='hsvpicker-arrow-btn' data-target='sat' data-location='right' data-role='button' data-inline='true' data-iconpos='notext' data-icon='arrow-r'></a>"+"        </div>"+"    </div>"+"    <div class='hsvpicker-clrchannel-container'>"+"        <div class='hsvpicker-arrow-btn-container'>"+"            <a href='#' class='hsvpicker-arrow-btn' data-target='val' data-location='left' data-role='button' data-inline='true' data-iconpos='notext' data-icon='arrow-l'></a>"+"        </div>"+"        <div class='hsvpicker-clrchannel-masks-container'>"+"            <div class='hsvpicker-clrchannel-mask hsvpicker-clrchannel-mask-white'></div>"+"            <div id='hsvpicker-val-hue' class='hsvpicker-clrchannel-mask'></div>"+"            <div class='hsvpicker-clrchannel-mask val-gradient' data-event-source='val'></div>"+"            <div id='hsvpicker-val-selector' class='hsvpicker-clrchannel-selector ui-corner-all'></div>"+"        </div>"+"        <div class='hsvpicker-arrow-btn-container'>"+"            <a href='#' class='hsvpicker-arrow-btn' data-target='val' data-location='right' data-role='button' data-inline='true' data-iconpos='notext' data-icon='arrow-r'></a>"+"        </div>"+"    </div>"+"  </div>"+"</div>"),s=this;r=o(i,r);if(this.element.is("input")){this.element.parent().next(".picker-container").append(r.container)}else{this.element.append(r.container)}e.extend(this,{_ui:r,_dragging_hsv:[0,0,0],_selectorDraggingOffset:{x:-1,y:-1},_dragging:-1});for(var u in this.options)this._setOption(u,n[u]===t||this.element.attr(n[u])===t?this.options[u]:this.element.attr(n[u]),true);r.container.find(".hsvpicker-arrow-btn").buttonMarkup().bind("vclick",function(t){var n=e(this).attr("data-target"),r="hue"===n?0:"sat"===n?1:2,i=0==r?360:1,o=.05*i;s._dragging_hsv[r]=s._dragging_hsv[r]+o*("left"===e(this).attr("data-location")?-1:1);s._dragging_hsv[r]=Math.min(i,Math.max(0,s._dragging_hsv[r]));s._updateSelectors(s._dragging_hsv)});if(this.element.is("input"))this.element.bind("change",function(e){s._setOption("color",s.element.attr("value"))});e(document).bind("vmousemove",function(e){if(s._dragging!=-1){e.stopPropagation();e.preventDefault()}}).bind("vmouseup",function(e){s._dragging=-1});this._bindElements("hue",0);this._bindElements("sat",1);this._bindElements("val",2)},_bindElements:function(e,t){var n=this;this._ui[e].selector.bind("mousedown vmousedown",function(r){n._handleMouseDown(e,t,r,true)}).bind("vmousemove touchmove",function(r){n._handleMouseMove(e,t,r,true)}).bind("vmouseup",function(e){n._dragging=-1});this._ui[e].eventSource.bind("mousedown vmousedown",function(r){n._handleMouseDown(e,t,r,false)}).bind("vmousemove touchmove",function(r){n._handleMouseMove(e,t,r,false)}).bind("vmouseup",function(e){n._dragging=-1})},_documentRelativeCoordsFromEvent:function(e){var t=e?e:window.event,n={x:t.clientX,y:t.clientY},r={x:t.pageX,y:t.pageY},i=0,s=0;if(t.type.match(/^touch/)){r={x:t.originalEvent.targetTouches[0].pageX,y:t.originalEvent.targetTouches[0].pageY};n={x:t.originalEvent.targetTouches[0].clientX,y:t.originalEvent.targetTouches[0].clientY}}if(r.x||r.y){i=r.x;s=r.y}else if(n.x||n.y){i=n.x+document.body.scrollLeft+document.documentElement.scrollLeft;s=n.y+document.body.scrollTop+document.documentElement.scrollTop}return{x:i,y:s}},_targetRelativeCoordsFromEvent:function(n){var r={x:n.offsetX,y:n.offsetY};if(r.x===t||isNaN(r.x)||r.y===t||isNaN(r.y)){var i=e(n.target).offset();r=this._documentRelativeCoordsFromEvent(n);r.x-=i.left;r.y-=i.top}return r},_handleMouseDown:function(e,t,n,r){var i=this._targetRelativeCoordsFromEvent(n),s=r?"selector":"eventSource";if(i.x>=0&&i.x<=this._ui[e][s].outerWidth()&&i.y>=0&&i.y<=this._ui[e][s].outerHeight()){this._dragging=t;if(r){this._selectorDraggingOffset.x=i.x;this._selectorDraggingOffset.y=i.y}this._handleMouseMove(e,t,n,r,i)}},_handleMouseMove:function(e,n,r,i,s){if(this._dragging===n){if(s===t)var s=this._targetRelativeCoordsFromEvent(r);var o=0===n?360:1,u=i?this._dragging_hsv[n]/o+(s.x-this._selectorDraggingOffset.x)/this._ui[e].eventSource.width():s.x/this._ui[e].eventSource.width();this._dragging_hsv[n]=Math.min(1,Math.max(0,u))*o;if(!i){this._selectorDraggingOffset.x=Math.ceil(this._ui[e].selector.outerWidth()/2);this._selectorDraggingOffset.y=Math.ceil(this._ui[e].selector.outerHeight()/2)}this._updateSelectors(this._dragging_hsv);r.stopPropagation();r.preventDefault()}},_updateSelectors:function(e){var t=this._RGBToHTML(this._HSVToRGB(e)),n=this._RGBToHTML(this._HSVToRGB([e[0],1,1])),r=this._RGBToHTML(this._HSVToRGB([e[0],e[1],1]));this._ui.hue.selector.css("left",this._ui.hue.eventSource.width()*e[0]/360);this._ui.hue.selector.css("background",t);this._ui.hue.hue.css("opacity",e[1]);this._ui.hue.valMask.css("opacity",1-e[2]);this._ui.sat.selector.css("left",this._ui.sat.eventSource.width()*e[1]);this._ui.sat.selector.css("background",t);this._ui.sat.hue.css("background",n);this._ui.sat.valMask.css("opacity",1-e[2]);this._ui.val.selector.css("left",this._ui.val.eventSource.width()*e[2]);this._ui.val.selector.css("background",t);this._ui.val.hue.css("background",r);this._updateAttributes(t)},_HTMLToRGB:function(e){e="#"==e.charAt(0)?e.substring(1):e;return[e.substring(0,2),e.substring(2,4),e.substring(4,6)].map(function(e){return parseInt(e,16)/255})},_RGBToHTML:function(e){return"#"+e.map(function(e){var t=e*255,n=Math.floor(t);t=t-n>.5?n+1:n;t=(t<16?"0":"")+(t&255).toString(16);return t}).join("")},_HSVToRGB:function(e){return this._HSLToRGB(this._HSVToHSL(e))},_RGBToHSV:function(e){var t,n,r,i,s,o,u=e[0],a=e[1],f=e[2];t=Math.min(u,Math.min(a,f));n=Math.max(u,Math.max(a,f));r=n-t;i=0;s=0;o=n;if(r>1e-5){s=r/n;if(u===n)i=(a-f)/r;else if(a===n)i=2+(f-u)/r;else i=4+(u-a)/r;i*=60;if(i<0)i+=360}return[i,s,o]},_HSLToRGB:function(e){var t=e[0]/360,n=e[1],r=e[2];if(0===n)return[r,r,r];var i=r<.5?r*(1+n):r+n-r*n,s=2*r-i,o={r:t+1/3,g:t,b:t-1/3};o.r=o.r<0?o.r+1:o.r>1?o.r-1:o.r;o.g=o.g<0?o.g+1:o.g>1?o.g-1:o.g;o.b=o.b<0?o.b+1:o.b>1?o.b-1:o.b;ret=[6*o.r<1?s+(i-s)*6*o.r:2*o.r<1?i:3*o.r<2?s+(i-s)*(2/3-o.r)*6:s,6*o.g<1?s+(i-s)*6*o.g:2*o.g<1?i:3*o.g<2?s+(i-s)*(2/3-o.g)*6:s,6*o.b<1?s+(i-s)*6*o.b:2*o.b<1?i:3*o.b<2?s+(i-s)*(2/3-o.b)*6:s];return ret},_HSVToHSL:function(e){var t=e[2],n=e[1]*t,r=t-n,i=t+r,s=i/2,o=s<.5?i:2-t-r;return[e[0],0==o?0:n/o,s]},_updateAttributes:function(t){this.options.color=t;this.element.attr("data-"+(e.mobile.ns||"")+"color",t);if(this.element.is("input")){this.element.attr("value",t);this.element.triggerHandler("change")}this.element.triggerHandler("colorchanged")},_set_color:function(e,t){if(e.match(/#[0-9a-fA-F]{6}/)&&(e!==this.options.color||t)){this._dragging_hsv=this._RGBToHSV(this._HTMLToRGB(e));this._updateSelectors(this._dragging_hsv);this._updateAttributes(e)}},_set_disabled:function(e,t){if(this.options.disabled!=e||t){this.options.disabled=e;this._ui.container[e?"addClass":"removeClass"]("ui-disabled")}},_setOption:function(e,n,r){if(r===t)r=false;if(this["_set_"+e]!==t)this["_set_"+e](n,r)},enable:function(){this._setOption("disabled",false,true)},disable:function(){this._setOption("disabled",true,true)},refresh:function(){this._setOption("color",this.element.attr("value")||this.element.attr("data-"+(e.mobile.ns||"")+"color"),true)}});e(document).bind("pagecreate create",function(t){e(e.mobile.hsvpicker.prototype.options.initSelector,t.target).not(":jqmData(role='none'), :jqmData(role='nojs')").hsvpicker()})})(jQuery)