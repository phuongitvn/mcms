/**
 * 
 */
jQuery.ready(function(){
	jQuery('#close,#open,#dock,#undock').click(function() {
		jQuery('#finder'+id).elfinder(jQuery(this).attr('id'));
	})
})
function LoadBr(id,url_connect){
	jQuery('#finder'+id).elfinder({
		url : url_connect+'/connectors/php/connector.php',
		lang : 'en',
		docked : false,

		dialog : {
		 	title : 'File manager',
		 	height : 500,
		 	closeOnEscape: false,
		 	dialogClass: 'no-close',
		 	buttons: {"Close":function() {
		 		jQuery(this).dialog("close");
		 		jQuery("#w_"+id).append('<div id="finder'+id+'"></div>');
		 	}},
		 },
		// Callback example
		editorCallback : function(url) {
			jQuery("#"+id).attr("value",url);
			jQuery("#w_"+id).append('<div id="finder'+id+'"></div>');
		},
	})
}