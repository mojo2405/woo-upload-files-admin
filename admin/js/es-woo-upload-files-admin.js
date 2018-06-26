(function( $ ) {
	'use strict';

    $(function() {

        var $submit = $('#es_submit_files');
        var $file = $('#es_input_files');
        $file.change(
            function(){
                $submit.attr('disabled',($(this).val() ? false : true));
            }
        );

     });

})( jQuery );
