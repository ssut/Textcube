<?php
function tinyMCE_handleconfig($configVal) {
	$config = Setting::fetchConfigVal($configVal);
	if (isset($config['editormode']) && $config['editormode'] != 'simple' && $config['editormode'] != 'advanced') return false;
	return true;
}

function tinyMCE_editorinit(&$editor) {
	global $configVal, $entry, $pluginURL;
	$context = Model_Context::getInstance();
	$blogid = getBlogId();
	$config = Setting::fetchConfigVal($configVal);
	if(empty($config['editormode'])) $config['editormode'] = 'advanced';
	ob_start();
?>
			var editor = new tinymce.Editor('editWindow', {
				// General options
				mode : 'exact',
				theme : 'advanced',
				language : '<?php echo strtolower($context->getProperty('blog.language'));?>',
				popup_css_add: "<?php echo $pluginURL;?>/popup.css",
<?php
	if($config['editormode'] == 'simple') {
?>
				plugins : "autolink,autoresize,lists,style,advimage,advlink,emotions,inlinepopups,preview,media,contextmenu,fullscreen,noneditable,visualchars,xhtmlxtras,wordcount,advlist,TTMLsupport",
				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,preview,fullscreen",
				theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,hr,|,undo,redo,|,link,unlink,anchor,image,media,code,|,forecolor,backcolor,|,charmap,emotions,|,visualchars,restoredraft",
				theme_advanced_buttons3 : "",
				theme_advanced_buttons4 : "",
<?php
	} else {
?>
				plugins : "autolink,autoresize,lists,pagebreak,style,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,wordcount,advlist,TTMLsupport",
				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,pagebreak,restoredraft,|,styleprops,|,code,cleanup,|,preview,fullscreen",
				theme_advanced_buttons2 : "undo,redo,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,sub,sup,|,link,unlink,anchor,image,charmap,media,advhr,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,visualaid,|,ltr,rtl",
				theme_advanced_buttons3 : "",
				theme_advanced_buttons4 : "",
<?php
	}
?>
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example content CSS (should be your site CSS)
				content_css : "<?php echo (file_exists(ROOT.'/skin/blog/'.$context->getProperty('skin.skin').'/wysiwyg.css') ? $context->getProperty('uri.service').'/skin/blog/'.$context->getProperty('skin.skin').'/wysiwyg.css' : $context->getProperty('uri.service').'/resources/style/default-wysiwyg.css');?>",

				// Drop lists for link/image/media dialogs
				external_link_list_url : "lists/link_list.js",
				external_image_list_url : "lists/image_list.js",
				media_external_list_url : "lists/media_list.js",

				// Style formats
				style_formats : [
					{title : 'Bold text', inline : 'b'}
				],
				forced_root_block : false,
				width : "100%",
				theme_advanced_toolbar_location : "external"
			});
			editor.initialize = function() {
				this.render();
			};
			editor.addObject = function(data) {
				this.plugins.TTMLsupport.addObject(data);
			};
			editor.finalize = function() {
				this.syncTextarea();
				this.destroy();
			};
			editor.syncTextarea = function(){
				this.save();
			};
			editor.syncEditorWindow = function() {
				this.load();
			};
			editor.onKeyUp.add(editorChanged);
			editor.onMouseDown.add(editorChanged);
			editor.propertyFilePath = "<?php echo $context->getProperty('service.path');?>/attach/<?php echo $context->getProperty('blog.id');?>/";
			return editor;
<?php
	$result = ob_get_contents();
	ob_end_clean();
	return $result;
}

function tinyMCE_adminheader($target, $mother) {
	global $suri, $pluginURL;

	if ($suri['directive'] == '/owner/entry/post' || $suri['directive'] == '/owner/entry/edit') {
		$target .= "\t<script type=\"text/javascript\" src=\"$pluginURL/tiny_mce/tiny_mce.js\"></script>\n";
	}
	return $target;
}
?>