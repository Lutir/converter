<?php

require("class.php");
require("json.php");

$docObj = new Doc2Txt("hell.doc");
$txt = $docObj->convertToText();

$resultObj = new json($txt);
$result = $resultObj->response();
echo $result;
// echo $txt;
?>
