<?php
require_once __DIR__.'/sqlite.php';

$root = $_SERVER['DOCUMENT_ROOT'];
$db = db_connect("sqlite:$root/../invoices.db");

$req = [
  'method' => $_SERVER['REQUEST_METHOD'],
];

if ($req['method'] == 'DELETE') {
  $info = parse_url($uri);
  parse_str($info['query'], $query) ?? [];
}
?>
