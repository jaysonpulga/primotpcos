CKEDITOR.plugins.add( 'removestyles', {
    icons: 'delete',
    init: function( editor ) {
        editor.addCommand( 'removestyles', {
            exec: function( editor ) {
                editor.insertHtml( '<p class="h2">Heading</p><p>&nbsp;</p>' );
            }
        });
    }
});

editor.ui.addButton( 'removestyles', {
    label: 'Remove Style',
    command: 'removestyles',
    toolbar: 'insert'
});