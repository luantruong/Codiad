<?php

/*
*  Copyright (c) Codiad & Kent Safranski (codiad.com), distributed
*  as-is and without warranty under the MIT License. See 
*  [root]/license.txt for more. This information must remain intact.
*/

require_once('../../config.php');
require_once('class.filemanager.php');

//////////////////////////////////////////////////////////////////
// Verify Session or Key
//////////////////////////////////////////////////////////////////

checkSession();

?>
<label>Upload Files</label>

<div id="upload-drop-zone">
    
    <span id="upload-wrapper">
    
        <input id="fileupload" type="file" name="upload[]" data-url="components/filemanager/controller.php?action=upload&path=<?php echo($_GET['path']); ?>" multiple>
        <span id="upload-clicker">Drag Files or Click Here to Upload</span>
    
    </span>

    <div id="upload-progress"><div class="bar"></div></div>
    
    <div id="upload-complete">Complete!</div>

</div>

<button onclick="modal.unload();">Close Uploader</button>

<script>

$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        dropZone: '#upload-drop-zone',
        progressall: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#upload-progress .bar').css(
                'width',
                progress + '%'
            );
            if(progress>98){ $('#upload-complete').fadeIn(200); }
        },
        done: function(e, data){
            $.each(data.result, function (index, file){
                filemanager.create_object('<?php echo($_GET['path']); ?>','<?php echo($_GET['path']); ?>/'+file.name,'file');
            });
            setTimeout(function(){
                $('#upload-progress .bar').animate({'width':0},700);
                $('#upload-complete').fadeOut(200);
            },1000);
        }
    });
});

</script>