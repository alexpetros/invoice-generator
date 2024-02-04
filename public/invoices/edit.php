<?php require_once '../../lib/start.php' ?>

<?php
$fp = $_GET["fp"] ?? false;

// Get the script tag with the form_data
$doc = new DOMDocument;
@$doc->loadHTMLFile("./generated/$fp");
$raw_data_element = $doc->getElementById('raw_data');
$existing_data = $raw_data_element -> textContent;

include('./new.php')
?>

