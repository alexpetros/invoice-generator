<?php require_once '../lib/start.php' ?>

<!DOCTYPE html>
<title>Invoice Generator</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>
<style><?php include('../templates/app-stylesheet.css')?></style>

<h1>Invoice Generator</h1>

<h2>Invoices</h2>
<p><a href="/invoices/new.php">New Invoice</a></p>
<?php
$gen_dir = 'invoices/generated';

$files = array_filter(scandir("./$gen_dir"), fn($x) => str_ends_with($x, '.html'));

?>
<table class=invoice-table>
  <tr><th class=invoice>Invoice</th><th>Edit</th><th>Delete</th></tr>
  <?php foreach($files as $file):
    $encoded = urlencode($file);
  ?>
  <tr>
    <td class=invoice><?= "<a href=\"/$gen_dir/$file\">$file</a>" ?>
    <td><?php echo "<a href=\"/invoices/edit.php?fp=$encoded\">Edit</a>" ?>
    <td><button hx-delete="<?= "/invoices.php?fp=$encoded" ?>"
                hx-confirm="Are you sure you want to delete this invoice?">
                Delete
        </button>
  </tr>
  <?php endforeach;?>
</table>

