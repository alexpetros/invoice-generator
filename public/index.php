<?php require_once '../lib/start.php' ?>

<!DOCTYPE html>
<title>Invoice Generator</title>
<script src="/static/vendor/htmx-1.9.10.js"></script>
<style><?php include('../templates/app-stylesheet.css')?></style>

<h1>Invoice Generator</h1>

<?php
$profiles = db_query($db, 'SELECT * FROM profiles');
$clients = db_query($db, 'SELECT * FROM clients');
$today = (new DateTime())
?>

<form action=/invoices.php method=POST>

<section>
  <h2>Billing Details</h2>
  <label>
  <div>Profile</div>
  <select name=profile_id>
    <option value="" required disabled>--select profile--</option>
    <?php
      array_map(function ($profile) {
        ['name' => $name, 'profile_id' => $profile_id] = $profile;
        echo "<option value=\"$profile_id\">$name</option>";
      }, $profiles);
    ?>
  </select>
  </label>
</section>

<section>
  <label>
  <div>Client</div>
  <select name=client_id>
    <option value="" required disabled>--select client--</option>
  <?php
  array_map(function ($client) {
    ['name' => $name, 'client_id' => $client_id] = $client;
    echo "<option value=\"$client_id\">$name</option>";
  }, $clients);
  ?>
  </select>
  </label>
  <p>
  <a href=/profiles.php>Add Profiles</a> --
  <a href=/clients.php>Add Clients</a>
  </p>
</section>

<section>
  <h2>Invoice Details</h2>
  <span class=muted>If no due date is provided, it will be automatically set to 2 weeks from the issue date.</span>
  <label>
    <div>Invoice #:</div>
    <input type=text name=invoice_number placeholder="Leave blank to auto-generate">
  </label>
  <label>
    <div>Issue Date:</div>
    <input type=date name=issue_date value="<?= $today->format('Y-m-d') ?>">
  </label>
  <label>
    <div>Due Date:</div>
    <input type=date name=due_date>
  </label>
  <p>
</section>

<section id=work-items>
  <h2>Work Items</h2>
  <button type=button onclick="addWorkItem()" id=add-button>Add Item</button>
</section>

<section>
  <h2>Finish</h2>
  <button>Generate</button>
  </form>
</section>

<template id=work-item-template>
  <fieldset>
    <h3>1.</h3>
    <label> <div>Title</div> <input class=title type=text> </label>
    <label> <div>Description</div> <textarea class=description></textarea> </label>
    <button type=button onclick="deleteWorkItem(this.parentElement)">Delete</button>
  </fieldset>
</template>

<script>
function renumberWorkItems() {
  const fieldsets = document.querySelectorAll('#work-items fieldset')
  fieldsets.forEach((fieldset, i) => {
    const num = i + 1
    fieldset.querySelector('h3').innerText = `${num}.`
    fieldset.querySelector('.title').setAttribute('name', `title-${num}`)
    fieldset.querySelector('.description').setAttribute('name', `description-${num}`)
  })
}

function addWorkItem() {
  const template = document.querySelector('#work-item-template')
  const button = document.querySelector('#add-button')
  const newField = template.content.cloneNode(true)
  button.before(newField)
  renumberWorkItems()
  button.scrollIntoView()
}

function deleteWorkItem(fieldset) {
  fieldset.remove()
  renumberWorkItems()
}
</script>
