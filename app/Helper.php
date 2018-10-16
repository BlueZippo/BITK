<?php

function render_initials($text) {

    $words = explode(" ", $text);
    $initials = null;
    foreach ($words as $w) {
         $initials .= $w[0];
    }
    return $initials;

}
