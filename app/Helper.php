<?php

function render_initials($text) {

    $words = explode(" ", $text);
    $initials = null;
    foreach ($words as $w) {
         $initials .= $w[0];
    }
    return $initials;

}

function is_image($link) {

    $supported_image = array(
        'gif',
        'jpg',
        'jpeg',
        'png'
    );

    $src_file_name = $link;
    $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));
    if (in_array($ext, $supported_image)) {
        return $link;
    } else {
        return false;
    }

}
