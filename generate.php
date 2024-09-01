<?php
if (count($argv) != 2) {
  echo "Usage: $argv[0] INVOICE_NAME.json\n";
  exit(1);
}

$filename = $argv[1];
$raw_json_data = file_get_contents($filename);
$data = json_decode($raw_json_data, true);

if ($data == NULL) {
  echo "Failed to parse JSON from $filename\n";
  exit(1);
}

[
  'profile' => $profile,
  'client' => $client,
  'title' => $invoice_title,
  'invoice_number' => $invoice_number,
  'issue_date' => $issue_date_str,
  'due_date' => $due_date_str,
  'hourly_rate' => $hourly_rate,
  'work_items' => $work_items,
] = $data;

$issue_date = new DateTime($issue_date_str);
$default_interval = new DateInterval('P3W');

$due_date = $due_date_str === ''
  ? (clone $issue_date) -> add($default_interval)
  : new DateTime($due_date_str);

$total_cost = 0;
foreach ($work_items as $work_item) {
  $total_cost +=  $work_item['price'] ?? ($work_item['hours'] * $hourly_rate);
}

include('./templates/invoice-template.php');

// FUNCTIONS FOR FILE SAVING
// Moving these over from the old generation code
// They're not in use yet
function get_next_filename($filename) {
  // Save the HTML as a file, and then output it to the user
  if (empty($filename)) {
    $filecase_title = str_replace(" ", "-", strtolower($invoice_title));
    if ($invoice_number === '') $invoice_number = $next_invoice_num;
    $filename = "$invoice_number-$filecase_title.html";
  } else {
    $invoice_number = explode('-', $filename)[0];
  }
}

function save_file($filename, $data) {
  // Save template HTML output as file
  ob_start();
  include('../templates/invoice-template.php');
  $invoice = ob_get_contents();
  ob_end_clean();

  echo $filename;
  file_put_contents("./invoices/generated/$filename", $invoice);
}

?>
