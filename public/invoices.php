<?php
require_once '../lib/start.php';

if ($req['method'] == 'POST'):
[
  'profile_id' => $profile_id,
  'client_id' => $client_id,
  'invoice_number' => $invoice_number,
  'issue_date' => $issue_date_str,
  'due_date' => $due_date_str,
  'rate' => $rate_str,
] = $_POST;

$issue_date = new DateTime($issue_date_str);
$default_interval = new DateInterval('P2W');
$hourly_rate = intval($rate_str);

$i = 1;
$work_items = [];
$total_cost = 0;
while (@$_POST["title-$i"]) {
  $work_item = [
    'title' => $_POST["title-$i"],
    'hours' => $_POST["hours-$i"],
    'description' => $_POST["description-$i"],
  ];
  array_push($work_items, $work_item);
  $total_cost += $work_item['hours'] * $hourly_rate;
  $i++;
}

if ($invoice_number === '') $invoice_number = 1000;
$due_date = $due_date_str === ''
  ? (clone $issue_date) -> add($default_interval)
  : new DateTime($due_date_str);

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

