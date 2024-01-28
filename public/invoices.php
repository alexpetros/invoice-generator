<?php require_once '../lib/start.php' ?>

<?php if ($req['method'] == 'POST'):
[
  'profile_id' => $profile_id,
  'client_id' => $client_id,
  'issue_date' => $issue_date,
] = $_POST;

$profile = db_query($db, 'SELECT * FROM profiles WHERE profile_id = ?', [$profile_id])[0];
$client = db_query($db, 'SELECT * FROM clients WHERE client_id = ?', [$profile_id])[0];

/* $query = ' */
/* INSERT INTO profiles (name, email, phone, address_1, address_2, address_3) */
/* VALUES (:name, :email, :phone, :address_1, :address_2, :address_3); */
/* '; */

/* $result = db_query($db, $query, $_POST); */
/* $id = $db -> lastInsertId(); */
/* header("Location: /profiles.php?id=$id"); */
include('../templates/invoice-template.php');
die();
endif;
?>

