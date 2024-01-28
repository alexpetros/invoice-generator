<!DOCTYPE html>
<?php require_once '../lib/start.php' ?>

<title>Profiles</title>
<style>
label {
  display: block;
}
</style>

<h1>Profiles</h1>
<h2>Existing</h2>

<?php
$profiles = db_query($db, 'SELECT * FROM profiles');
$today = (new DateTime());
?>

<?php foreach($profiles as $profile): ?>
<?= $profile["business_name"] ?>
<?php endforeach; ?>


<h2>New</h2>
<form action="/profile" method=post>
<label>Profile Name: <input type=text> </label>
<label>Business Name: <input type=text> </label>
<label>Email: <input type=text> </label>
<label>Phone: <input type=text> </label>
<label>Address 1: <input type=text> </label>
<label>Address 2: <input type=text> </label>
<label>Address 3: <input type=text> </label>
</form>
