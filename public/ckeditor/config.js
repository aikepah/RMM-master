/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
    config.filebrowserImageUploadUrl = '/rmm/public/ckeditor/upload_image.php';
    config.filebrowserUploadUrl = '/rmm/public/ckeditor/upload_image.php';
    config.extraPlugins='simpleuploads'; 
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'document',	   groups: [ 'mode' ] },
		{ name: 'others' },
		{ name: 'insert' },
//		{ name: 'forms' },
//		{ name: 'tools' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
//		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'paragraph',   groups: [ 'list', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' },
//		{ name: 'about' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
//	config.removeButtons = 'Anchor,Underline,Subscript,Superscript';
	config.removeButtons = 'Anchor,Subscript,Superscript,Image,addFile,Save,Print,NewPage';
	config.removePlugins = 'iframe,forms,pagebreak,templates,preview,flash,smiley,div';
//    config.removeButtons = "addFile";
	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';
    config.readOnly = false;
    config.baseFloatZIndex = 102000;
    config.allowedContent = true;

	// Make dialogs simpler.
//	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
