/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
  config.skin = 'office2013';
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
  	{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'SpecialChar' ] },
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
  config.filebrowserBrowseUrl = '/admin/lib/kcfinderIntranet/browse.php?opener=ckeditor&type=soubory&aim=intranet';
  config.filebrowserImageBrowseUrl = '/admin/lib/kcfinderIntranet/browse.php?opener=ckeditor&type=img&aim=intranet';
//  config.filebrowserFlashBrowseUrl = '/admin/lib/kcfinder/browse.php?opener=ckeditor&type=flash';
  config.filebrowserUploadUrl = '/admin/lib/kcfinderIntranet/upload.php?opener=ckeditor&type=soubory&aim=intranet';
  config.filebrowserImageUploadUrl = '/admin/lib/kcfinderIntranet/upload.php?opener=ckeditor&type=img&aim=intranet';
//  config.filebrowserFlashUploadUrl = '/admin/lib/kcfinder/upload.php?opener=ckeditor&type=flash';
  config.htmlEncodeOutput = false;
  config.entities = false;
  //extrenal css sheet
  //config.stylesSet = [];
  config.contentsCss = 'css/stylist.css';
  config.stylesSet =
  [
    // Block Styles
  	{ name : 'Odstavec - výrazný',  element : 'p', attributes: { 'class' : 'vyrazny'} },
    { name : 'Písmo zelené - pro celý odstavec', element: 'p', attributes: { 'class' : 'barva_pisma_zelena'} },
    { name : 'Písmo červené - pro celý odstavec', element: 'p', attributes: { 'class' : 'barva_pisma_cervena'} },
    { name : 'Písmo modré - pro celý odstavec', element: 'p', attributes: { 'class' : 'barva_pisma_modra'} },
    { name : 'Písmo malé - pro celý odstavec', element: 'p', attributes: { 'class' : 'male_pismo'} },
    { name : 'Písmo velké - pro celý odstavec', element: 'p', attributes: { 'class' : 'velke_pismo'} },
    { name : 'Písmo extra velké - pro celý odstavec', element: 'p', attributes: { 'class' : 'extra_velke_pismo'} },
    { name : 'Modrý rámeček',       element : 'p', attributes: { 'class' : 'modry_ramecek'} },
    { name : 'Červený rámeček',     element : 'p', attributes: { 'class' : 'cerveny_ramecek'} },
    { name : 'Zelený rámeček',      element : 'p', attributes: { 'class' : 'zeleny_ramecek'} },
    { name : 'Nezobrazuj mě',       element : 'p', attributes: { 'class' : 'xyz'} },
    //inline
    { name : 'Písmo zelené',      element: 'span', attributes: { 'class' : 'barva_pisma_zelena'} },
    { name : 'Písmo červené',     element: 'span', attributes: { 'class' : 'barva_pisma_cervena'} },
    { name : 'Písmo modré',       element: 'span', attributes: { 'class' : 'barva_pisma_modra'} },
    { name : 'Písmo malé',        element: 'span', attributes: { 'class' : 'male_pismo'} },
    { name : 'Písmo velké',       element: 'span', attributes: { 'class' : 'velke_pismo'} },
    { name : 'Písmo extra velké', element: 'span', attributes: { 'class' : 'extra_velke_pismo'} },
    //objects
    { name : 'Vyskakovací obrázek', element : 'img', attributes: { 'class' : 'obrazek_lightbox'} },
    //tabulky
    { name : 'Základní styl tabulky', element : 'table', attributes: { 'class' : 'knihovna'} },
    { name : 'Záhlaví tabulky',     element : 'tr', attributes: { 'class' : 'zahlavi'} },
  ];
  config.extraPlugins = 'stylesheetparser'; //nepomuze, pokud nejsou styly plne kvalifikovane
};
