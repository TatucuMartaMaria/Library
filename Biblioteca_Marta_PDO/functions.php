<?php

function removeSpecialCharacters($str)
{
    $result = preg_replace('/[^a-zA-Z0-9_ -]/s','',$str);
    $result = str_replace(' ', '', $result);
    return $result;
}

function similarText($text1 , $text2)
{
    similar_text(strtolower($text1) , strtolower($text2),$percent);
    return $percent;
}

function convertDateInToNr($date)
{
    $date = str_replace('/', '-', $date);
    $date = date('Y/m/d', strtotime($date));
    $date = (int)removeSpecialCharacters($date);
    return $date;
}

?>