<!DOCTYPE html>
<?php require_once '../lib/start.php' ?>

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
$profiles = db_query($db, 'SELECT profile_id, name FROM profiles');
$id = $_GET["id"] ?? false;

if ($id) {
  $res = db_query($db, 'SELECT * FROM profiles WHERE profile_id = :id', ["id" => $id]);
  $main_profile = $res[0];
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
<label>Profile Name: <input name=name type=text> </label>
<label>Email: <input name=email type=text> </label>
<label>Phone: <input name=phone type=tel> </label>
<label>Address 1: <input name=address_1 type=text> </label>
<label>Address 2: <input name=address_2 type=text> </label>
<label>Address 3: <input name=address_3 type=text> </label>
<button>Submit</button>
</form>
