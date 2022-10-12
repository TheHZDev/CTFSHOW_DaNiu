<?php
require_once "DaNiuChatConfig.php";
global $jsFilePath, $auth_add_key, $auth_delete_key, $auth_modify_key;
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    header('Content-Type: application/javascript; charset=UTF-8');
    echo explode('let ', file_get_contents($jsFilePath))[1];
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
    header('Content-Type: text/html; charset=UTF-8');
    if (!isset($_POST['control']) || !isset($_POST['data']))
        die('大牛无法理解');

    function extractJSON(string $jsFilePath): array {
        $newJSData = file_get_contents($jsFilePath);
        return json_decode(explode("');", explode("JSON.parse('", $newJSData)[1])[0], true);
    }

    function writeJSON(array $phpContent, string $jsFilePath): void{
        $newJSData = json_encode($phpContent, JSON_UNESCAPED_UNICODE);
        file_put_contents($jsFilePath, 'let DaNiuDict = JSON.parse(\''.$newJSData.'\');');
    }

    if ($_POST['control'] === 'add') {
        $jsData = extractJSON($jsFilePath);
        $flag_add = true;
        if (array_key_exists($_POST['data'], $jsData))
            $flag_add = false;
        if (!isset($_POST['data2']) || str_starts_with($$_POST['data2'], 'kw del '))
            die('大牛无法理解');
        if ($flag_add && (empty($auth_add_key) || (isset($_POST['auth']) && in_array($_POST['auth'], $auth_add_key))))
            $jsData[$_POST['data']] = $_POST['data2'];
        elseif (!$flag_add && (empty($auth_modify_key) || (isset($_POST['auth']) && in_array($_POST['auth'], $auth_modify_key))))
            $jsData[$_POST['data']] = $_POST['data2'];
        else
            die('你无权修改大牛的记忆');
        writeJSON($jsData, $jsFilePath);
        die('大牛记住了');
    } elseif (in_array($_POST['control'], array("del", "delete"))){
        if (empty($auth_delete_key) || (isset($_POST['auth']) && in_array($_POST['auth'], $auth_delete_key))){
            $jsData = extractJSON($jsFilePath);
            if (!array_key_exists($_POST['data'], $jsData))
                die('大牛无法理解');
            unset($jsData[$_POST['data']]);
            writeJSON($jsData, $jsFilePath);
            die('大牛忘记了');
        } else
            die('你无权修改大牛的记忆');
    } else {
        die('大牛无法理解');
    }
}
