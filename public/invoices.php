<?php require_once '../lib/start.php'; ?>

<?php
if ($req['method'] == 'POST'):
[
  'profile_id' => $profile_id,
  'client_id' => $client_id,
  'invoice_title' => $invoice_title,
  'invoice_number' => $invoice_number,
  'issue_date' => $issue_date_str,
  'due_date' => $due_date_str,
  'rate' => $rate_str
] = $_POST;

$files = array_filter(scandir("./invoices/generated"));
$raw_form_data = file_get_contents('php://input');

// Get next invoice number
$numbered_files = array_filter($files, fn($x) => preg_match("/[0-9]*-.*\.html/", $x));
$nums = array_map(fn($x) => explode('-', $x)[0], $numbered_files);
$next_invoice_num =  max($nums) + 1;

// Save the HTML as a file, and then output it to the user
$filename = $_POST['filename'] ?? '';
if (empty($filename)) {
  $filecase_title = str_replace(" ", "-", strtolower($invoice_title));
  if ($invoice_number === '') $invoice_number = $next_invoice_num;
  $filename = "$invoice_number-$filecase_title.html";
} else {
  $invoice_number = explode('-', $filename)[0];
}

$issue_date = new DateTime($issue_date_str);
$default_interval = new DateInterval('P3W');
$hourly_rate = intval($rate_str);

$i = 1;
$work_items = [];
$total_cost = 0;
while (@$_POST["title-$i"]) {
  $work_item = [
    'title' => $_POST["title-$i"],
    'hours' => $_POST["hours-$i"],
    'price' => $_POST["price-$i"],
    'description' => $_POST["description-$i"],
  ];
  array_push($work_items, $work_item);
  $total_cost +=  empty($work_item['price']) ?? ($work_item['hours'] * $hourly_rate);

  $i++;
}

$due_date = $due_date_str === ''
  ? (clone $issue_date) -> add($default_interval)
  : new DateTime($due_date_str);

// Get the profile and client info
$profile = db_query($db, 'SELECT * FROM profiles WHERE profile_id = ?', [$profile_id])[0];
$client = db_query($db, 'SELECT * FROM clients WHERE client_id = ?', [$client_id])[0];

// Save template HTML output as file
ob_start();
include('../templates/invoice-template.php');
$invoice = ob_get_contents();
ob_end_clean();

echo $filename;
file_put_contents("./invoices/generated/$filename", $invoice);

header("Location: /");
http_response_code(303);
die();
endif;
?>

<?php
if ($req['method'] == 'DELETE'):
$fp = $query['fp'];
unlink("./invoices/generated/$fp");
header("HX-Redirect: /");
http_response_code(303);
die();
endif;
?>
