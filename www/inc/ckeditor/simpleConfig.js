/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
  // Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
  config.toolbar = [
  	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
  	{ name: 'paragraph', groups: [ 'blocks', 'align', 'bidi' ], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
  	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
  	{ name: 'tools', items: [ 'Maximize'] }
  ];
  config.filebrowserBrowseUrl = '/admin/lib/kcfinder/browse.php?opener=ckeditor&type=soubory';
  config.filebrowserImageBrowseUrl = '/admin/lib/kcfinder/browse.php?opener=ckeditor&type=img';
//  config.filebrowserFlashBrowseUrl = '/admin/lib/kcfinder/browse.php?opener=ckeditor&type=flash';
  config.filebrowserUploadUrl = '/admin/lib/kcfinder/upload.php?opener=ckeditor&type=soubory';
  config.filebrowserImageUploadUrl = '/admin/lib/kcfinder/upload.php?opener=ckeditor&type=img';
//  config.filebrowserFlashUploadUrl = '/admin/lib/kcfinder/upload.php?opener=ckeditor&type=flash';
  config.htmlEncodeOutput = false;
  config.entities = false;
  //config.skin = 'office2013';
};
