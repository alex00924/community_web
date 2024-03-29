/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.removePlugins = 'forms';
    config.allowedContent = true;
    CKEDITOR.dtd.$removeEmpty['i'] = false;
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.extraPlugins = 'youtube,attach';
    config.filebrowserUploadMethod = 'form'; // Added for file browser
    config.height = 300;
};
