/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
var url = "/phalcon/core/";
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = url+'library/ckfinder/ckfinder.html';
   	config.filebrowserImageBrowseUrl = url+'library/ckfinder/ckfinder.html?type=Images';
   	config.filebrowserFlashBrowseUrl = url+'library/ckfinder/ckfinder.html?type=Flash';
   	config.filebrowserUploadUrl = 	url+'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   	config.filebrowserImageUploadUrl = url+'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   	config.filebrowserFlashUploadUrl = url+'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
   	config.allowedContent = true;
};
