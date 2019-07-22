/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
  //config.skin = 'office2013';
	// config.uiColor = '#AADC6E';
  // Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
  config.toolbar = [
  	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
  	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
  	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll'] },
  	//{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
  	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
  	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
  	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
  	{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'Iframe', 'SpecialChar' ] },
  	{ name: 'styles', items: [ 'Styles', 'Format' ] },
  	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
  	{ name: 'others', items: [ '-' ] },
  	{ name: 'about', items: [ 'About' ] }
  ];
  // Toolbar groups configuration.
  config.toolbarGroups = [
  	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
  	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
  	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
  	{ name: 'forms' },
  	'/',
  	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
  	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
  	{ name: 'links' },
  	{ name: 'insert' },
  	'/',
  	{ name: 'styles' },
  	{ name: 'tools' },
  	{ name: 'others' },
  	{ name: 'about' }
  ];
  config.filebrowserBrowseUrl = '../../../inc/kcfinder/browse.php?opener=ckeditor&type=soubory';
  config.filebrowserImageBrowseUrl = '../../../inc/kcfinder/browse.php?opener=ckeditor&type=img';
//  config.filebrowserFlashBrowseUrl = '/admin/lib/kcfinder/browse.php?opener=ckeditor&type=flash';
  config.filebrowserUploadUrl = '../../../inc/kcfinder/upload.php?opener=ckeditor&type=soubory';
  config.filebrowserImageUploadUrl = '../../../inc/kcfinder/upload.php?opener=ckeditor&type=img';
//  config.filebrowserFlashUploadUrl = '/admin/lib/kcfinder/upload.php?opener=ckeditor&type=flash';
  config.htmlEncodeOutput = false;
  config.entities = false;
  //extrenal css sheet
  //config.stylesSet = [];
  config.contentsCss = '/css/bootstrap.min.css';
  config.stylesSet =
  [
    // Block Styles
  	{ name : 'Tabulka',  element : 'table', attributes: { 'class' : 'table table-bordered table-striped'} },
    { name : 'Obrázek - mobil',  element : 'img', attributes: { 'class' : 'img-responsive'} }
  ];
  config.extraPlugins = 'stylesheetparser'; //nepomuze, pokud nejsou styly plne kvalifikovane
  config.extraPlugins = 'removeformat';
  config.extraPlugins = 'iframe';
  config.justifyClasses = [ 'text-left', 'text-center', 'text-right', 'text-justify' ];
};
