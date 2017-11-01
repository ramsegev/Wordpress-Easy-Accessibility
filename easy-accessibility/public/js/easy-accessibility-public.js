(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
})( jQuery );


$(document).ready(function() {
	function appendStyle(app_css,app_id){
		var head = document.getElementsByTagName('head')[0];
		var style = document.createElement('style');
		var css = app_css;
		
		style.type = 'text/css';
		style.id = app_id;
		if (style.styleSheet) {
		  style.styleSheet.cssText = css;
		} else {
		  style.appendChild(document.createTextNode(css));
		}
		
		head.appendChild(style);
	}
	
	$('#accessibility_menu').click(function(){
		$('#accessibility_menu_content').toggle("fold", { direction: "right" }, 600);
	});
	$('#accessibility_menu_content').click(function(e) {
        e.stopPropagation();
   });
	
/**************************************************************************/

/********************* Resize Text ****************************************/
	var $accessibility_menu_tags = $("#accessibility_menu"
	+",#accessibility_menu_content"
	+",#fontSize"
	+",#btn-decrease"
	+",#btn-orig"
	+",#btn-increase"
	+",#dark_contrast"
	+",#btn_orig_contrast"
	+",#bright_contrast"	
	+",#white_mouse"
	+",#normal_mouse"
	+",#black_mouse"	
	+",#color_links"
	+",#normal_link"
	+",#underline_links"
	+",#readable_font_arial"
	+",#readable_font_normal"
	+",#readable_font_san"
	+",#animation_off"
	+",#animation_on"
	+",#img_desc_off"
	+",#img_desc_on"
	+",.tree_column"
	+",.two_column"
	+",.title");
	var $affectedElements = $("p,div,a,span,nav,ul,li").not($accessibility_menu_tags); // Can be extended, ex. $("div, p, span.someClass")

	//'::-webkit-input-placeholder',':-moz-placeholder','::-moz-placeholder',':-ms-input-placeholder'
  
	// Storing the original size in a data attribute so size can be reset
	$affectedElements.each( function(){
		var $this = $(this);
		$this.data("orig-size", $this.css("font-size") );
	});

	$("#btn-increase").click(function(){
		changeFontSize(10);
		cookieSet.fontSize = cookieSet.fontSize + 10;
		add_to_cookie();
	})
	$("#btn-decrease").click(function(){
		changeFontSize(-10);
		cookieSet.fontSize = cookieSet.fontSize - 10;
		add_to_cookie();
	})

	$("#btn-orig").click(function(){
		$affectedElements.each( function(){
			var $this = $(this);
			$this.css( "font-size" , $this.data("orig-size") );
	   });
		cookieSet.fontSize = 0;
		add_to_cookie();
	})
	
	/********************להגביל את גודל הפונט לעד 200%  *************/
	function changeFontSize(direction){
		$affectedElements.each( function(){
			var $this = $(this);
			//$this.css( "font-size" , parseInt($this.css("font-size"))+direction );
			//$this.css( "font-size" , parseInt($this.css("font-size"))+direction );
			//$this.css( "font-size" , parseInt($this.css("font-size"))+direction );
			var font_size  = $this.css("font-size");
			var calc = 'calc('+font_size+' + '+direction+'%)';
			$this.css( "font-size" , calc) ;
		});
	}
	
/**************************************************************************/

/*********************Readable Font*************************************/

	$("#readable_font_arial").click(function(){
		$affectedElements.not('.fa').css("font-family", 'arial');
		cookieSet.font_family = "#readable_font_arial";
		add_to_cookie();
	});
	$("#readable_font_normal").click(function(){
		$affectedElements.css("font-family", '');
		cookieSet.font_family = "#readable_font_normal";
		add_to_cookie();
	});
	$("#readable_font_san").click(function(){
		$affectedElements.not('.fa').css("font-family", 'san-sarif');
		cookieSet.font_family = "#readable_font_san";
		add_to_cookie();
	});
	
	
/**************************************************************************/

/********************* Contrast ****************************************/
	$("#dark_contrast").click(function(){
		$('#contrast_bright').remove();
		$affectedElements.css('color', '');
		negativar("100%");
		cookieSet.contrast = "#dark_contrast";
		add_to_cookie();
	});
	$("#btn_orig_contrast").click(function(){
		$('#contrast_dark').remove();
		$('#contrast_bright').remove();
		$affectedElements.css('color', '');
		cookieSet.contrast = "#btn_orig_contrast";
		add_to_cookie();
	});
	$("#bright_contrast").click(function(){
		$('#contrast_dark').remove();
		removeBackground();	
		var rgb = getRGB($affectedElements.css('color'));
		
		for(var i = 0; i < rgb.length; i++){
			rgb[i] = Math.min(0, rgb[i] - 40);
		}
		
		var newColor = 'rgb(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ')';
		
		$affectedElements.css('color', newColor);
		cookieSet.contrast = "#bright_contrast";
		add_to_cookie();
	});
	/*********bright*********************************/
	function removeBackground(){
		var css = '*{background-color:#fff!important; background-image:none !important;} \מ body{background:#fff !important; color:#000 !important;background-image:none !important;}';
		appendStyle(css,'contrast_bright');
	}
	

	function getRGB(color) {
		var result;
		
		// Look for rgb(num,num,num)
		if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color)) return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

		// Look for rgb(num%,num%,num%)
		if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color)) return [parseFloat(result[1]) * 2.55, parseFloat(result[2]) * 2.55, parseFloat(result[3]) * 2.55];

		// Look for #a0b1c2
		if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color)) return [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)];

		// Look for #fff
		if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color)) return [parseInt(result[1] + result[1], 16), parseInt(result[2] + result[2], 16), parseInt(result[3] + result[3], 16)];
	}

	

/***********dark************************************/	
	function negativar(perVal) {
		var percent = perVal;
		//var head = document.getElementsByTagName('head')[0];
		//var style = document.createElement('style');
		
		var css = 'html {-webkit-filter: invert('+percent+');' +
			'-moz-filter: invert('+percent+');' +
			'-o-filter: invert('+percent+');' +
			'-ms-filter: invert('+percent+'); ' +
			'filter: invert('+percent+'); ';
		
		if (navegador()[0] == 'Firefox') {
			css += 'filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'invert\'><feColorMatrix in=\'SourceGraphic\' type=\'matrix\' values=\'-1 0 0 0 1 0 -1 0 0 1 0 0 -1 0 1 0 0 0 1 0\'/></filter></svg>#invert"); }';
		} else {
			css += ' } ';
		}
		
		//style.type = 'text/css';
		/* style.id = 'contrast_dark';
		if (style.styleSheet) {
		  style.styleSheet.cssText = css;
		} else {
		  style.appendChild(document.createTextNode(css));
		}
		
		head.appendChild(style); */
		appendStyle(css,'contrast_dark');
	  }

		function navegador(){
	  var N= navigator.appName, ua= navigator.userAgent, tem;
	  var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
	  if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
	  M= M? [M[1], M[2]]: [N, navigator.appVersion,'-?'];
	  return M;
	 }

/**************************************************************************/

/***************************Cursor size************************************/
	
	
	/******************* problems on chrome not showing the right cursor in text input*********/
	/**font cursor**
	auto = \uf245
	pointer = \uf25a
	test = \uf246
	***************/
	var canvasObj = {
		width: 64,
		height: 64,
		font_color: "#fff",
		font_size:"64px",
		font: '',
		x: 32,
		y: 32,
		tag: '',
		class_name:'',
		mouse_onof: false
		
	};
	var classObj = {
		white_mouse_auto: 'white_mouse_auto',
		white_mouse_text: 'white_mouse_text',
		white_mouse_pointer: 'white_mouse_pointer',
		black_mouse_auto: 'black_mouse_auto',
		black_mouse_text: 'black_mouse_text',
		black_mouse_pointer: 'black_mouse_pointer'
	};
	
	function cleanMouseStyle(){
		for(var key in classObj) {
			obj_id = '#'+ classObj[key];
			$(obj_id).detach();		
		}
		canvasObj.mouse_onof = false;
	}
	function cleanMouseClass(){
		for(var key in classObj) {
			obj_class = '.'+ classObj[key];
			$(obj_class).removeClass(classObj[key]);	
		}	
	}
/********creating canvas from font ***************/
	function cursorCanvas(){

		if($("#" + canvasObj.class_name).length == 0) {
			var canvas = document.createElement("canvas");
			canvas.width = canvasObj.width;
			canvas.height = canvasObj.height;
			var ctx = canvas.getContext("2d");
			ctx.fillStyle = canvasObj.font_color;
			ctx.fill();
			ctx.shadowColor = "#000";
			ctx.shadowOffsetX = 3; 
			ctx.shadowOffsetY = 3; 
			ctx.shadowBlur = 2;
			ctx.font = "bold "+ canvasObj.font_size +" FontAwesome";
			ctx.textAlign = "center";
			ctx.textBaseline = "middle";
			ctx.fillText(canvasObj.font, canvasObj.x, canvasObj.y);
			var dataURL = canvas.toDataURL('image/png')
			var css = '.'+ canvasObj.class_name +'{cursor:url('+dataURL+'), auto !important}'; 
			if(canvasObj.mouse_onof){
				appendStyle(css,canvasObj.class_name);
			}
		}

	}
	
	
/*********** Changing cursor color **************/
	function mouseColor(color,class_color){
		
		cleanMouseStyle();
		canvasObj.font_color = color;
		canvasObj.class_name = class_color +'_mouse_auto';
		cursorCanvas();			
		canvasObj.mouse_onof = true;
		window.onmouseover=function(event) {
		
		//$( 'div' ).find( '*' ).mouseenter(function(event){
			var currentCursor = $(event.target).css('cursor') ;
			var currentCursor1 = $(event.target).css('pointer-events') ;
			var currentTag = event.target.tagName ;
				if(currentCursor=="auto"){
					canvasObj.class_name = class_color +'_mouse_auto';
					canvasObj.tag = currentTag;
					canvasObj.font="\uf245";
				}
				if(currentCursor=="pointer"){
					canvasObj.class_name = class_color +'_mouse_pointer';
					canvasObj.tag = currentTag;
					canvasObj.font="\uf25a";
				}
				if(currentCursor=="text"){
					canvasObj.class_name = class_color +'_mouse_text';
					canvasObj.tag = currentTag;
					canvasObj.font="\uf246";
				}
			cursorCanvas();
			cleanMouseClass();
			$(event.target).addClass(canvasObj.class_name);
		//});	
};		
	}

	$("#normal_mouse").click(function(){
		cleanMouseStyle();
		cleanMouseClass();
		cookieSet.cursor = "#normal_mouse";
		add_to_cookie();
	});
	$("#white_mouse").click(function(){
		mouseColor("#fff",'white');
		cookieSet.cursor = "#white_mouse";
		add_to_cookie();
	});
	
	$("#black_mouse").click(function(){
		mouseColor("#000",'black');
		cookieSet.cursor = "#black_mouse";
		add_to_cookie();
	});
	
/**************************************************************************/

/*************************** Links ****************************************/
$("#color_links").click(function(){
		$('a').css('background-color','#FFFF00');
		$('a').css('border','1px solid #000');
		cookieSet.links = "#color_links";
		add_to_cookie();
	});
$("#normal_link").click(function(){
		$('a').css('background-color','');
		$('a').css('border','');
		$('a').css('text-decoration','none');
		cookieSet.links = "#normal_link";
		add_to_cookie();
	});
$("#underline_links").click(function(){
		$('a').css('text-decoration','underline');
		$('a').css('border','');
		cookieSet.links = "#underline_links";
		add_to_cookie();
	});
	
/**************************************************************************/

/*************************** animation ****************************************/
$("#animation_off").click(function(){
		$.fx.off = true;
		cookieSet.animation = "#animation_off";
		add_to_cookie();
	});
$("#animation_on").click(function(){
		$.fx.off = false;
		cookieSet.animation = "#animation_on";
		add_to_cookie();
	});

/**************************************************************************/

/*************************** Image description ****************************************/

	function descOn(){

		window.onmousemove = function (event) {
			if(!$('body').hasClass('tooltip_off')){
				var tooltip = $(event.target); 
				var alt = $(event.target).attr("alt"); 
				var x = (event.clientX + 20);
				var y = (event.clientY + 20);
				$('.tooltip_box').css({
					'top': y,
					'left':x
					});
				if((!$(event.target).hasClass('tooltip')) && (event.target.tagName == 'IMG')){
					$(event.target).addClass('tooltip');
					if($(event.target).parent().find('details').length != 0){
						$(event.target).parent().find('.tooltip_box').css('display','block');
					}
					else{
						$('.tooltip').parent().append('<details open class=tooltip_box><summery class=tooltip_sum><lable>Image descritopm</lable</summery><p class=tooltip_desc>'+alt+'</p></details>');
					}
				}
				if(event.target.tagName != 'IMG')
				{
					$('IMG').removeClass('tooltip');
					$(event.target).find('.tooltip_box').css('display','none');
				} 
			}
		};
	} 
	function descOff(){
		$('body').addClass('tooltip_off');
		$('.tooltip_box').css('display','none');
	}
	$("#img_desc_off").click(function(){
			descOff();
			cookieSet.img_desc = "#img_desc_off";
			add_to_cookie();
		});
	$("#img_desc_on").click(function(){
			$('body').removeClass('tooltip_off');
			descOn();
			cookieSet.img_desc = "#img_desc_on";
			add_to_cookie();
		});


	
	
/**************************************************************************/
	function descOff(){
		$('body').addClass('tooltip_off');
		$('.tooltip_box').css('display','none');
	}
	$("#img_desc_off").click(function(){
			descOff();
		});
	$("#img_desc_on").click(function(){
			$('body').removeClass('tooltip_off');
			descOn();
		});


	
	
/**************************************************************************/
/*************************** Update Cookie ****************************************/
	var cookieSet = {};
	if (document.cookie.indexOf("easyaccess=") >= 0) {
	  	cookieSet = read_cookie();
		for (var el in cookieSet) {
			if( cookieSet.hasOwnProperty(el) ) {
				if (el == 'fontSize') {
					  changeFontSize(0);				
					  changeFontSize(cookieSet.fontSize);				
				}
				else{
					$(cookieSet[el]).click();
				} 
			}
		} 
	}
	else {
		cookieSet = {
		  fontSize: 0,
		  contrast: "#btn_orig_contrast",
		  cursor: "#normal_mouse",
		  links: "#normal_link",
		  font_family: "#readable_font_normal",
		  animation: "#animation_on",
		  img_desc: "#img_desc_off"         
		};
	}
	function add_to_cookie(){
		var cookie = ["easyaccess", '=', JSON.stringify(cookieSet), '; domain=.', window.location.host.toString(), '; path=/; expires=Thu, 01 Jan 2270 00:00:00 GMT";'].join('');
		document.cookie = cookie;
	}
	function read_cookie() {
		var result = document.cookie.match(new RegExp("easyaccess" + '=([^;]+)'));
		result && (result = JSON.parse(result[1]));
		return result;
	}
/**************************************************************************/
/*************************** Tabindex ****************************************/
/*****לבדוק אם לאוביקט יש ילד ואם כן אל להשתמש ב
aria-labelledby
וב 
aria-describedby
להוסיף טאב אינדקס */
$('div').children()

/**************************************************************************/
/*************************** Add labels ****************************************/
addlabels();
function addlabels(){
	var inputid = '';
	$("input").each( function(){
		if($(this).attr("placeholder")){
			inputid = $(this).attr("placeholder");
		}
		else if($(this).attr("name")){
			inputid = $(this).attr("name");
		}
		if(!$(this).attr("id")){
			$(this).wrap( "<label class=texthidden>"+inputid+"</label>" );
		}
		else{
			$(this).before("<label for="+$(this).attr("id")+" class=visuallyhidden>"+inputid+"</label>");
		}
	});
}

/**************************************************************************/

	
	$( "#accessibility_menu" ).draggable();
});
