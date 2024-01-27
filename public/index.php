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
$clients = db_query($db, 'SELECT * FROM businesses');
$profile = $profiles[0]
?>

<section>
<h2>Profiles</h2>
<select name=profiles>
<?php
  array_map(function ($profile) {
    echo '<option>'.$profile['business_name'].'</option>';
  }, $profiles);
?>
</select>

<dl class=profile-details>
  <dt>Name</dt><dd><?= $profile["business_name"]?></dd>
  <dt>Email</dt><dd><?= $profile["email"]?></dd>
  <dt>Phone</dt><dd><?= $profile["phone"]?></dd>
  <dt>Address</dt>
  <dd><?= $profile["address_1"]?><br> <?= $profile["address_2"]?>
  </dd>
</dl>
</section>

<section>
<h2>Clients</h2>
<select name=clients>
<?php
  array_map(function ($client) {
    echo '<option>'.$client['business_name'].'</option>';
  }, $clients);
?>
</select>


<section>
<h2>Generate Invoice</h2>
<form action=/invoice method=POST>
<label>
  Invoice #:
  <input type=text placeholder="Leave blank to auto-generate">
</label>
<label>Issue Date:<input type=date></label>
<label>Due Date:<input type=date></label>

<button>Generate</button>
</form>
</section>
