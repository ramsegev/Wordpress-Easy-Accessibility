(function( $ ) {
    'use strict';

    /**
     * All of the code for your admin-specific JavaScript source
     * should reside in this file.
     *
     * Note that this assume you're going to use jQuery, so it prepares
     * the $ function reference to be used within the scope of this
     * function.
     *
     * From here, you're able to define handlers for when the DOM is
     * ready:
     *
     * $(function() {
     *
     * });
     *
     * Or when the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and so on.
     *
     * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
     * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
     * be doing this, we should try to minimize doing that in our own work.
     */


    $(function(){
		$( "#post_type_list" ).change(function() {
		    var post_type = $('#post_type_list option:selected').text();
			$.ajax({
             method: "GET",
             url: ajaxurl ,
			 page: "class-easy-accessibility-admin.php" ,
			 action: "get_post_list",
             data: { 
                 the_post_type:  post_type
             },
			 success:function(response){
						$( "#post_type_list_posts" ).show();
						$( "#post_type_list_posts" ).html(response);
                       },
			error: function(errorThrown){
				alert(errorThrown);
					}
          })
          .done(function( msg ) {
             // console.log( "Data Saved: " + msg );
          });
		});
    $( "#post_type_list_posts" ).change(function() {
		    var post_id = $('#post_type_list_posts option:selected').val();
			
			$.ajax({
             method: "GET",
			// async: false,
			// cache: false,
             url: ajaxurl,
			 //dataType: 'json',
			 page: "class-easy-accessibility-admin.php" ,
			 action: "get_the_content_by_id",
             data: { 
                 post_id:  post_id,
             },
			 beforeSend: function() {
					$('#editHtml').html("working on it");
				  },
			 success:function(response){
				// alert(response);
				
						$( "#editHtml" ).html(response);
						$(".check_code").show();
						$("#submit_post").show();
						//$( ".check_code" ).text(res.editor_content);
						//$("#show_page").html($('#AC_menu_by_paste').load(scriptParams.site_url+"/?p="+post_id));
						//alert ($("#mycustomeditor").html());
                       },
			error: function(errorThrown){
				alert(errorThrown);
					}
          })
          .done(function( msg ) {

          });
		});

	/* $(".tablinks ").click(function(e){
		var id = e.target.id;
		alert(id);		
	}); */	
//sending url to wai validation	
		$( "#submit_post" ).click(function() {

			var data = { 
                uri: scriptParams.site_url+"/?p=",
             };
			ajax_wai(data);
		});
		$( "#submit_theme,#submit_plugin" ).click(function() {

			var data = { 
                uri: scriptParams.site_url+"/?p=",
				content: get_theme_content(),
             };
			ajax_wai(data);
		});
		
	 	 function ajax_wai(data) {
		    var post_id = $('#post_type_list_posts option:selected').val();
			var page_iframe = "<iframe id=custom_ifram src="+scriptParams.site_url+"/?p="+post_id +" ></iframe>";
			$.ajax({
			method: 'POST',
            url: ajaxurl,
			page: "class-easy-accessibility-admin.php",
			action: "validate_wai",
			data: data,
			beforeSend: function() {
					$(".check_code").show();
					$('.check_code').html("validating you code");
				  },
				success:function(response){
						$( ".check_code" ).html(response);
						var page_iframe = "<iframe id=custom_ifram src="+scriptParams.site_url+"/?p="+post_id +" ></iframe>";
						$("#show_page").html(page_iframe);
                },
				error: function(errorThrown){
						alert("error: " +errorThrown.error);
						$( ".check_code" ).text(errorThrown.totalCount);
					}
          })
          .done(function( msg ) {
              //console.log( "Data Saved: " + msg );
          });  
		}
		 
		
		
		
			var page_iframe_them = "<iframe id=iframThemeEditor class=iframeEditor src="+scriptParams.site_url+"/wp-admin/theme-editor.php ></iframe>";
			$( "#editthem" ).html(page_iframe_them);
			var page_iframe_plugin = "<iframe id=iframThemeEditor class=iframeEditor src="+scriptParams.site_url+"/wp-admin/plugin-editor.php ></iframe>";
			$( "#editplugin" ).html(page_iframe_plugin);

			$( ".iframeEditor" ).load(function(){ 
				//$( ".check_code" ).css('width','100%');
				//$(".check_code").show();
				$( ".iframeEditor" ).contents().find('#wpadminbar, #adminmenumain, .updated, .update-nag, #screen-meta-links,#wpfooter').hide(); 
				$( ".iframeEditor" ).contents().find('.wp-toolbar').css('overflow', 'hidden'); 
				$( ".iframeEditor" ).contents().find('#templateside').css({'overflow':'auto','height': '500px'}); 
				$( ".iframeEditor" ).contents().find('#wpcontent').css({'margin':'0','padding': '0'}); 
				var content = $( ".iframeEditor" ).contents().find('#newcontent').val();
				var scriptTag = "<script>alert(1)<";
				scriptTag +=  "/script>";
				$( "#check_theme_code" ).contents().find('head').append(scriptTag); 
			}) 
			
	
});  // End of DOM Ready

})( jQuery );

function choose_edit(evt, type) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(type).style.display = "block";
		evt.currentTarget.className += " active";
		
		if (type == "Themes"){
			document.getElementById("submit_theme").style.display = "block";
			document.getElementById("submit_post").style.display = "none";
			document.getElementById("submit_plugin").style.display = "none";
		}
		if (type == "Plugins"){
			document.getElementById("submit_plugin").style.display = "block";
			document.getElementById("submit_post").style.display = "none";
			document.getElementById("submit_theme").style.display = "none";
		}
		if (type == "Posts"){
			document.getElementById("submit_plugin").style.display = "none";
			document.getElementById("submit_theme").style.display = "none";
		}
	}
	
	
function get_theme_content(){
	var iframe = document.getElementById('iframThemeEditor');
	var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
	var input = innerDoc.getElementById('newcontent'); 
	return input.value;
}