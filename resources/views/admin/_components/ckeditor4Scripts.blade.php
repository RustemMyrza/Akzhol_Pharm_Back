<script src="{{ asset('adminlte-assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/ckfinder/ckfinder.js') }}"></script>
<script>
    let ckeditorElements = $('.ckeditor4')
    let height = {{ $height ?? 200 }}

    ckeditorElements.each(function () {
        let elementName = $(this).attr('name');

        CKFinder.setupCKEditor();
        CKEDITOR.replace(elementName, {
            toolbar: [
                { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' , ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            ],
            allowedContent: true,
            width: '100%',
            height: height,
            tabSize: 4,
            autoParagraph: false,
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            codemirror: {
                autoCloseBrackets: true,

                // Whether or not you want tags to automatically close themselves
                autoCloseTags: true,

                // Whether or not to automatically format code should be done when the editor is loaded
                autoFormatOnStart: true,

                // Whether or not to automatically format code which has just been uncommented
                autoFormatOnUncomment: true,

                // Whether or not to continue a comment when you press Enter inside a comment block
                continueComments: true,

                // Whether or not you wish to enable code folding (requires 'lineNumbers' to be set to 'true')
                enableCodeFolding: true,

                // Whether or not to enable code formatting
                enableCodeFormatting: true,

                // Whether or not to enable search tools, CTRL+F (Find), CTRL+SHIFT+F (Replace), CTRL+SHIFT+R (Replace All), CTRL+G (Find Next), CTRL+SHIFT+G (Find Previous)
                enableSearchTools: true,

                // Whether or not to highlight all matches of current word/selection
                highlightMatches: true,

                // Whether, when indenting, the first N*tabSize spaces should be replaced by N tabs
                indentWithTabs: false,

                // Whether or not you want to show line numbers
                lineNumbers: true,

                // Whether or not you want to use line wrapping
                lineWrapping: true,

                // Define the language specific mode 'htmlmixed' for html  including (css, xml, javascript), 'application/x-httpd-php' for php mode including html, or 'text/javascript' for using java script only
                mode: 'htmlmixed',

                // Whether or not you want to highlight matching braces
                matchBrackets: true,

                // Whether or not you want to highlight matching tags
                matchTags: true,

                // Whether or not to show the showAutoCompleteButton   button on the toolbar
                showAutoCompleteButton: true,

                // Whether or not to show the comment button on the toolbar
                showCommentButton: true,

                // Whether or not to show the format button on the toolbar
                showFormatButton: true,

                // Whether or not to show the search Code button on the toolbar
                showSearchButton: true,

                // Whether or not to show Trailing Spaces
                showTrailingSpace: true,

                // Whether or not to show the uncomment button on the toolbar
                showUncommentButton: true,

                // Whether or not to highlight the currently active line
                styleActiveLine: true,

                // Set this to the theme you wish to use (codemirror themes)
                theme: 'monokai',

                // "Whether or not to use Beautify for auto formatting On start
                useBeautifyOnStart: true
            },
            filebrowserImageUploadUrl: "{{ route('admin.ckeditor.uploadImage',  ['_token' => csrf_token()]) }}",
            filebrowserImageUploadMethod: 'form',
            filebrowserUploadUrl: "{{ route('admin.ckeditor.uploadImage',  ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
        });
    })
</script>
