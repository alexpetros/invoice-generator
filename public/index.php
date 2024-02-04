<?php require_once '../lib/start.php' ?>

<!DOCTYPE html>
<title>Invoice Generator</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>
<style><?php include('../templates/app-stylesheet.css')?></style>

<h1>Invoice Generator</h1>

<a href="/invoices/new.php">New Invoice</a>

<h2>Invoices</h2>
<?php
$gen_dir = 'invoices/generated';

function isHTMLFile($fp) {
  return str_ends_with($fp, '.html');
}

$files = array_filter(scandir("./$gen_dir"), 'isHTMLFile');
?>
<table>
  <tr><th>Invoice</th><th>Edit</th><th>Duplicate</th></tr>
  <?php foreach($files as $file): ?>
  <tr>
    <td><?= "<a href=\"/$gen_dir/$file\">$file</a>" ?>
    <td><?php $encoded = urlencode($file); echo "<a href=\"/invoices/edit.php?fp=$encoded\">Edit</a>" ?>
    <td>Dupe
  </tr>
  <?php endforeach;?>
</table>

