<!DOCTYPE html>
<?php require_once '../lib/start.php' ?>

<?php
if ($req['method'] == 'DELETE'):
$query = 'DELETE FROM clients WHERE client_id = :client_id';
$result = db_query($db, $query, $id);
header("Location: /clients.php");
die();
endif;
?>

<?php
if ($req['method'] == 'POST'):
$query = '
INSERT INTO clients (name, email, phone, address_1, address_2, address_3)
VALUES (:name, :email, :phone, :address_1, :address_2, :address_3);
';
$result = db_query($db, $query, $_POST);
$id = $db -> lastInsertId();
header("Location: /clients.php?id=$id");
die();
endif;
?>

<title>clients</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>
<style><?php include('../templates/app-stylesheet.css')?></style>

<h1>Clients</h1>
<a href="/">Return home</a>
<h2>Existing</h2>
<?php
$clients = db_query($db, 'SELECT client_id, name FROM clients');
$id = $_GET["id"] ?? false;

if ($id) {
  $res = db_query($db, 'SELECT * FROM clients WHERE client_id = :id', ["id" => $id]);
  $main_client = @$res[0];
}
?>

<?php foreach($clients as $client): ?>
<div><a href="/clients.php?id=<?= $client["client_id"] ?>"><?= $client["name"] ?></a></div>
<?php endforeach; ?>

<?php if (isset($main_client)): ?>
<dl class=client-details>
  <dt>Name</dt><dd><?= $main_client["name"]?></dd>
  <dt>Email</dt><dd><?= $main_client["email"]?></dd>
  <dt>Phone</dt><dd><?= $main_client["phone"]?></dd>
  <dt>Address</dt>
  <dd><?= $main_client["address_1"]?><br> <?= $main_client["address_2"]?></dd>
</dl>
<?php endif ?>

<h2>New</h2>
<form action="/clients.php" method=post>
  <label>
    <div>Name:</div>
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
