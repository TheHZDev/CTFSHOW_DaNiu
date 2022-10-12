<?php
header('Content-Type: text/plain; charset=UTF-8');
if(isset($_POST['query'])){
    $strData = trim($_POST['query']);
    if (count(explode(' ', $strData)) < 2 || !str_starts_with($strData, 'kw ')){
        http_response_code(400);
        die('No data!');
    }
    $strData = substr($strData, 3); // [kw ]{key} {text}
    if (str_starts_with($strData, '"') && str_contains($strData, '" "')){
        $tVar = explode('" "', $strData);
        die('control=add&data='.substr($tVar[0], 1).'&data2='.substr($tVar[1], 0, strlen($tVar[1]) - 1));
    } elseif (str_starts_with($strData, '"') && !str_contains($strData, '" "')){
        $tVar = explode('" ', $strData);
        die('control=add&data='.substr($tVar[0], 1).'&data2='.$tVar[1]);
    } elseif (!str_starts_with($strData, '"') && str_contains($strData, ' "')){
        $tVar = explode(' "', $strData);
        die('control=add&data='.$tVar[0].'&data2='.substr($tVar[1], 0, strlen($tVar[1]) - 1));
    } elseif (!str_starts_with($strData, '"') && !str_contains($strData, ' "') && !str_contains($strData, '" ') && !str_contains($strData, '" "')){
        $tVar = explode(' ', $strData);
        die('control=add&data='.$tVar[0].'&data2='.$tVar[1]);
    }
}