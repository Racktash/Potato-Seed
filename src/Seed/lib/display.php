<?php
namespace display;
function url($punix)
{
    $punix = strtolower($punix);
    $punix = preg_replace("/[^a-zA-Z0-9_-_\s]/", "", $punix);
    $punix = preg_replace("/ /", "_", $punix);

    return $punix;
}

function alphanum($displayalphanum)
{
    $displayalphanum = preg_replace("/[^a-zA-Z0-9\s]/", "", $displayalphanum);
    $displayalphanum = preg_replace("/ /", "", $displayalphanum);

    return $displayalphanum;
}

function email($pemail)
{
    $pemail = preg_replace("/[^a-zA-Z0-9---_-_@-@.-.\s]/", "", $pemail);
    $pemail = preg_replace("/ /", "", $pemail);
    $pemail = strtolower($pemail);

    return $pemail;
}

function html($string)
{
    $filtered_string = htmlentities(stripslashes($string), ENT_COMPAT|ENT_SUBSTITUTE|ENT_QUOTES, 'UTF-8');
    return $filtered_string;
}
?>
