<h1>Media Manager</h1>
<script type="text/javascript" charset="utf-8">
		jQuery().ready(function() {
			
			var f = jQuery('#finder').elfinder({
				url : '<?php echo $ExtUrl;?>/connectors/php/connector.php',
				lang : 'en',
				docked : false

				// dialog : {
				// 	title : 'File manager',
				// 	height : 500
				// }

				// Callback example
				//editorCallback : function(url) {
				//	if (window.console && window.console.log) {
				//		window.console.log(url);
				//	} else {
				//		alert(url);
				//	}
				//},
				//closeOnEditorCallback : true
			})
			// window.console.log(f)
			jQuery('#close,#open,#dock,#undock').click(function() {
				jQuery('#finder').elfinder(jQuery(this).attr('id'));
			})
			
		})
	</script>
	<div id="finder">finder</div>
