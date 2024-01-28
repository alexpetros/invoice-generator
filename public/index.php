<!DOCTYPE html>
<?php require_once '../lib/start.php' ?>

<title>Invoice Generator</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>

<style>
body {
  max-width: 700px;
}

dl.profile-details {
  display: grid;
  grid-template-columns: fit-content(30%) 1fr;

}

form {
  label {
    margin: .5rem 0;
    display: block;
  }
}
</style>

<h1>Invoice Generator</h1>

<?php
$profiles = db_query($db, 'SELECT * FROM profiles');
$clients = db_query($db, 'SELECT * FROM clients');
$today = (new DateTime())
?>

<section>
<h2>Profiles</h2>
<select name=profiles>
  <option value="" required disabled>--select profile--</option>
<?php
  array_map(function ($profile) {
    echo '<option>'.$profile['business_name'].'</option>';
  }, $profiles);
?>
</select>
<p><a href=/profiles.php>Edit Profiles</a></p>
</section>

<section>
<h2>Clients</h2>
<select name=clients>
  <option value="" required disabled>--select client--</option>
<?php
  array_map(function ($client) {
    echo '<option>'.$client['business_name'].'</option>';
  }, $clients);
?>
</select>
<p><a href=/clients.php>Edit Clients</a></p>
</section>


<section>
<h2>Generate Invoice</h2>
<form action=/invoice method=POST>
<label>
  Invoice #:
  <input type=text placeholder="Leave blank to auto-generate">
</label>
<label>Issue Date:<input type=date value="<?= $today->format('Y-m-d') ?>"></label>
<label>Due Date:<input type=date></label>

<button>Generate</button>
</form>
</section>
