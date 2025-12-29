<?php
/**
 * Summernote Lite editor plugin.
 *
 * It transforms all the editable areas into the Summernote editor (Lite build = no Bootstrap dependency).
 *
 * @author Prakai Nadee <prakai@rmuti.acth>
 * @forked by Robert Isoski @robertisoski
 */

global $Wcms;

if (defined('VERSION')) {
    // WonderCMS has no "enable/disable" toggle per plugin folder.
    // Prevent loading two editor plugins at the same time (can break the admin UI).
    $summernoteEditorExists = is_file($Wcms->rootDir . '/plugins/summernote-editor/summernote-editor.php');
    if ($summernoteEditorExists) {
        if ($Wcms->loggedIn) {
            $Wcms->alert(
                'info',
                'Summernote Lite Editor is installed, but <b>Summernote Editor</b> is also present. Please keep only one editor plugin in the <code>plugins/</code> folder.'
            );
        }
    } else {
        $Wcms->addListener('js', 'wcmsSummernoteLiteLoadJS');
        $Wcms->addListener('css', 'wcmsSummernoteLiteLoadCSS');
    }
}

function wcmsSummernoteLiteLoadJS($args) {
    global $Wcms;
    if ($Wcms->loggedIn) {
        $script = <<<EOT
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.js" integrity="sha384-R5lOA9Vhja/AeGXhZyjsK0c+bpRhE5wPdquWfVrFgnHV6PtTQWggYgeqigzcRf+6" crossorigin="anonymous"></script>
        <script src="{$Wcms->url('plugins/summernote-lite-editor/js/admin.js')}" type="text/javascript"></script>
EOT;
        $args[0] .= $script;
    }
    return $args;
}


function wcmsSummernoteLiteLoadCSS($args) {
    global $Wcms;
    if ($Wcms->loggedIn) {
        $script = <<<EOT
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="{$Wcms->url('plugins/summernote-lite-editor/css/admin.css')}" type="text/css" media="screen">
EOT;
        $args[0] .= $script;
    }
    return $args;
}
