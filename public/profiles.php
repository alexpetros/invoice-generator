<!DOCTYPE html>
<?php require_once '../lib/start.php' ?>

<title>Profiles</title>
<style>
label {
  display: block;
}
dl.profile-details {
  display: grid;
  grid-template-columns: fit-content(30%) 1fr;
}

</style>

<h1>Profiles</h1>
<a href="/">Return home</a>
<h2>Existing</h2>
<?php
$profiles = db_query($db, 'SELECT profile_id, business_name FROM profiles');
$id = $_GET["id"] ?? false;

if ($id) {
  $res = db_query($db, 'SELECT * FROM profiles WHERE profile_id = :id', ["id" => $id]);
  $main_profile = $res[0];
}
?>

<?php foreach($profiles as $profile): ?>
<div><a href="/profiles.php?id=<?= $profile["profile_id"] ?>"><?= $profile["business_name"] ?></a></div>
<?php endforeach; ?>

<?php if (isset($main_profile)): ?>
<dl class=profile-details>
  <dt>Name</dt><dd><?= $main_profile["business_name"]?></dd>
  <dt>Email</dt><dd><?= $main_profile["email"]?></dd>
  <dt>Phone</dt><dd><?= $main_profile["phone"]?></dd>
  <dt>Address</dt>
  <dd><?= $main_profile["address_1"]?><br> <?= $main_profile["address_2"]?></dd>
</dl>
<?php endif ?>

<h2>New</h2>
<form action="/profile" method=post>
<label>Profile Name: <input type=text> </label>
<label>Business Name: <input type=text> </label>
<label>Email: <input type=text> </label>
<label>Phone: <input type=text> </label>
<label>Address 1: <input type=text> </label>
<label>Address 2: <input type=text> </label>
<label>Address 3: <input type=text> </label>
<button>Submit</button>
</form>
