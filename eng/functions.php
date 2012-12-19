<?php
function punix($punix)
{
    $punix = strtolower($punix);
    $punix = preg_replace("/[^a-zA-Z0-9_-_\s]/", "", $punix);
    $punix = preg_replace("/ /", "_", $punix);

    return $punix;
}

function purl()
{
    return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function psafe($psafe)
{
    $psafe = preg_replace("/[^a-zA-Z0-9\s]/", "", $psafe);
    $psafe = preg_replace("/ /", "", $psafe);

    return $psafe;
}

function pemail($pemail)
{
    $pemail = preg_replace("/[^a-zA-Z0-9---_-_@-@.-.\s]/", "", $pemail);
    $pemail = preg_replace("/ /", "", $pemail);
    $pemail = strtolower($pemail);

    return $pemail;
}

function pdisplay($pdisplay)
{
    $pdisplay = htmlentities(stripslashes($pdisplay), ENT_QUOTES);
    return $pdisplay;
}

function pstamp($nid, $taco)
{


    $timeago = $nid;

    $calc = $taco - $timeago;
    $calc2 = $calc / 60;
    $calc2r = round($calc2);
    $calc3 = $calc2r / 60;
    $calc3r = round($calc3);
    $calc4 = $calc3r / 24;
    $calc4r = round($calc4);
    $calc5 = $calc4r / 7;
    $calc5r = round($calc5);
    $calc6 = $calc5r / 4;
    $calc6r = round($calc6);
    $calc7 = $calc6r / 12;
    $calc7r = round($calc7);

    if ($calc6r >= "12")
    {
        $value_to_return = "$calc7r year(s) ago ($calc6r months)";
    }
    elseif ($calc5r >= "4")
    {
        $value_to_return = "$calc6r month(s) ago";
    }
    elseif ($calc4r >= "7")
    {
        $value_to_return = "$calc5r week(s) ago";
    }
    elseif ($calc3r >= "24")
    {
        $value_to_return = "$calc4r day(s) ago";
    }
    elseif ($calc2r >= "60")
    {
        $value_to_return = "$calc3r hour(s) ago";
    }
    elseif ($calc >= "60")
    {
        $value_to_return = "$calc2r minute(s) ago";
    }
    else
    {
        $value_to_return = "$calc seconds ago";
    }

    return $value_to_return;
}
?>