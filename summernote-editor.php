<?php
/**
 * Summernote editor plugin.
 *
 * It transforms all the editable areas into the Summernote inline editor.
 * Now with tokens and login check.
 *
 * @author Prakai Nadee <prakai@rmuti.acth>
 * @forked by Robert Isoski @robertisoski
 * @forked by Stephan Stanisic @stephanstanisic
 * @version 3.0.7
 */

global $Wcms;

if (defined('VERSION')) {
    define('version', VERSION);
    defined('version') or die('Direct access is not allowed.');
}

$Wcms->addListener('js', 'loadSummerNoteJS');
$Wcms->addListener('css', 'loadSummerNoteCSS');
$Wcms->addListener('editable', 'initialSummerNoteVariables');

function initialSummerNoteVariables($contents) {
    global $Wcms;
    $content = $contents[0];
    $subside = $contents[1];

    $contents_path = $Wcms->getConfig('contents_path');
    if (! $contents_path) {
        $Wcms->setConfig('contents_path', $Wcms->filesPath);
        $contents_path = $Wcms->filesPath;
    }
    $contents_path_n = trim($contents_path, '/');
    if ($contents_path != $contents_path_n) {
        $contents_path = $contents_path_n;
        $Wcms->setConfig('contents_path', $contents_path);
    }
    $_SESSION['contents_path'] = $contents_path;

    return [$content, $subside];
}

function loadSummerNoteJS($args) {
    global $Wcms;
    if ($Wcms->loggedIn) {
        $script = <<<EOT
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.8/dist/summernote.min.js" integrity="sha384-rv18XCwOLyh2rO/6Vz9eKWaSP+ljKfFed/npYlSg476id+996jfNDF+5iC3W5KKJ" crossorigin="anonymous"></script>
        <script src="{$Wcms->url('plugins/summernote-editor/js/admin.js')}" type="text/javascript"></script>
        <script src="{$Wcms->url('plugins/summernote-editor/js/files.js')}" type="text/javascript"></script>
EOT;
        $args[0] .= $script;
    }

    return $args;
}

function loadSummerNoteCSS($args) {
    global $Wcms;
    if ($Wcms->loggedIn) {
        $script = <<<EOT
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.11/dist/summernote.css" integrity="sha384-hHEPAd3Dkb316VuNPtIZ6LUrzxvD4PQOTW478Ww6c/aUJKXNDV9pEx5/jZgISR1G" crossorigin="anonymous">
        <link rel="stylesheet" href="{$Wcms->url('plugins/summernote-editor/css/admin.css')}" type="text/css" media="screen">
EOT;
        $args[0] .= $script;
    }

    return $args;
}
