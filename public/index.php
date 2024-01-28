<!DOCTYPE html>
<?php require_once '../lib/start.php' ?>

<title>Invoice Generator</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>
<style><?php include('../templates/app-stylesheet.css')?></style>

<h1>Invoice Generator</h1>

<?php
$profiles = db_query($db, 'SELECT * FROM profiles');
$clients = db_query($db, 'SELECT * FROM clients');
$today = (new DateTime())
?>

<section>
<form action=/invoice method=POST>
<h2>Billing Details</h2>

<label>
<div>Profile</div>
<select name=profiles>
  <option value="" required disabled>--select profile--</option>
<?php
  array_map(function ($profile) {
    echo '<option>'.$profile['name'].'</option>';
  }, $profiles);
?>
</select></label>

<label>
<div>Client</div>
<select name=clients>
  <option value="" required disabled>--select client--</option>
<?php
  array_map(function ($client) {
    echo '<option>'.$client['name'].'</option>';
  }, $clients);
?>
</select>
</label>

<p>
<a href=/profiles.php>Add Profiles</a> --
<a href=/clients.php>Add Clients</a>
</p>

<h2>Invoice Details</h2>
<span class=muted>If no due date is provided, it will be automatically set to 2 weeks from the issue date.</span>
</p>
<label>
  <div>Invoice #:</div>
  <input type=text placeholder="Leave blank to auto-generate">
</label>
<label>
  <div>Issue Date:</div>
  <input type=date value="<?= $today->format('Y-m-d') ?>">
</label>
<label>
  <div>Due Date:</div>
  <input type=date>
</label>
<p>

<h2>Work Items</h2>

<button>Generate</button>
</form>
</section>

<script>

</script>
