<?php

require_once 'XmlProcessor.php';
header("Content-Type: text/xml");

$dom = new XmlProcessor();
$f = $dom->createFragment("fuck");
//$f->ab = "cd";
echo $dom->renderXML();

?>
