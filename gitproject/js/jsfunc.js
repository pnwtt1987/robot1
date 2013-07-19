function loadCkeditor(){
	  CKEDITOR.replace( 'product_detail',{ toolbar: [
	   { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
       { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
       { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar','Link', 'Unlink', 'Anchor' ] },
       { name: 'others', items: [ '-' ] }, '/',
       { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'TextColor','BGColor','Bold', 'Italic', 'Underline', 'Strike'] },
       { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },'/',
       { name: 'styles', items: [ 'Font','FontSize','Styles', 'Format'] },
       { name: 'tools', items: [ 'Maximize' ] }
       ],uiColor:'#FAAC0F'} );
}