<?php require_once '../lib/start.php' ?>

<?php
if ($req['method'] == 'DELETE'):
$query = 'DELETE FROM profiles WHERE profile_id = :profile_id';
$result = db_query($db, $query, $id);
header("Location: /profiles.php");
die();
endif;
?>

<?php
if ($req['method'] == 'POST'):
$query = '
INSERT INTO profiles (name, email, phone, address_1, address_2, address_3)
VALUES (:name, :email, :phone, :address_1, :address_2, :address_3);
';
$result = db_query($db, $query, $_POST);
$id = $db -> lastInsertId();
header("Location: /profiles.php?id=$id");
die();
endif;
?>

<!DOCTYPE html>
<title>Profiles</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>
<style><?php include('../templates/app-stylesheet.css')?></style>

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
$profiles = db_query($db, 'SELECT profile_id, name FROM profiles');
$id = $_GET["id"] ?? false;

if ($id) {
  $res = db_query($db, 'SELECT * FROM profiles WHERE profile_id = :id', ["id" => $id]);
  $main_profile = @$res[0];
}
?>

<?php foreach($profiles as $profile): ?>
<div><a href="/profiles.php?id=<?= $profile["profile_id"] ?>"><?= $profile["name"] ?></a></div>
<?php endforeach; ?>

<?php if (isset($main_profile)): ?>
<dl class=profile-details>
  <dt>Name</dt><dd><?= $main_profile["name"]?></dd>
  <dt>Email</dt><dd><?= $main_profile["email"]?></dd>
  <dt>Phone</dt><dd><?= $main_profile["phone"]?></dd>
  <dt>Address</dt>
  <dd><?= $main_profile["address_1"]?><br> <?= $main_profile["address_2"]?></dd>
</dl>
<?php endif ?>

<h2>New</h2>
<form action="/profiles.php" method=post>
  <label>
    <div>Profile Name:</div>
    <input name=name type=text>
  </label>
  <label>
    <div>Phone:</div>
    <input name=phone type=text>
  </label>
  <label>
    <div>Email</div>
    <input name=email type=text>
  </label>
  <label>
    <div>Address 1:</div>
    <input name=address_1 type=text>
  </label>
  <label>
    <div>Address 2:</div>
    <input name=address_2 type=text>
  </label>
  <label>
    <div>Address 3:</div>
    <input name=address_3 type=text>
  </label>
  <button>Submit</button>
</form>
