<?php
require_once '../lib/start.php';

if ($req['method'] == 'POST'):
[
  'profile_id' => $profile_id,
  'client_id' => $client_id,
  'invoice_title' => $invoice_title,
  'invoice_number' => $invoice_number,
  'issue_date' => $issue_date_str,
  'due_date' => $due_date_str,
  'rate' => $rate_str,
] = $_POST;

$raw_form_data = file_get_contents('php://input');

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
$client = db_query($db, 'SELECT * FROM clients WHERE client_id = ?', [$client_id])[0];

// Save template HTML output as file
ob_start();
include('../templates/invoice-template.php');
$invoice = ob_get_contents();
ob_end_clean();

// Save the HTML as a file, and then output it to the user
$filecase_title = str_replace(" ", "-", strtolower($invoice_title));
$filename = "$invoice_number-$filecase_title.html";
file_put_contents("./invoices/generated/$filename", $invoice);

header("Location: /");
die();
endif;
?>

