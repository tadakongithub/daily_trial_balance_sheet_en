<?php
$lang = 'eng';
function checkLang($eng, $jp) {
    global $lang;
    switch ($lang) {
        case 'eng':
            $message = $eng;
        break;
        case 'jp':
            $message = $jp;
        break;
    }
    echo $message;
}

function returnLang($eng, $jp) {
    global $lang;
    switch ($lang) {
        case 'eng':
            $message = $eng;
        break;
        case 'jp':
            $message = $jp;
        break;
    }
    return $message;
}
?>