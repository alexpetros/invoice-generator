<?php require_once '../../lib/start.php' ?>

<?php
$profiles = db_query($db, 'SELECT * FROM profiles');
$clients = db_query($db, 'SELECT * FROM clients');
$today = (new DateTime());
$is_edit = isset($existing_data);
?>

<!DOCTYPE html>
<title><?= $is_edit ? 'Edit Invoice' : 'New Invoice' ?></title>
<style><?php include('../../templates/app-stylesheet.css')?></style>

<?php if ($is_edit) echo "<script type=text/form_data id=existing_data>$existing_data</script>"; ?>

<form action=/invoices.php method=POST>

<h1><?= $is_edit ? 'Edit Invoice' : 'New Invoice' ?></h1>
<a href="/">Return Home</a>
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
    <div>Title</div>
    <input type=text name=invoice_title required>
  </label>
  <label>
    <div>Invoice #:</div>
    <input type=text name=invoice_number placeholder="Leave blank to auto-generate">
  </label>
  <label>
    <div>Hourly Rate</div>
    <input type=number name=rate required step=1>
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

<section>
  <h2>Work Items</h2>
  <div id=work-items>
  </div>
  <button type=button onclick="clickNewItem()" id=add-button>Add Item</button>
</section>

<section>
  <h2>Finish</h2>
  <button>Generate</button>
</section>

</form>

<template id=work-item-template>
  <fieldset class=work-item>
    <div class=work-item-header>
      <h3>1.</h3>
      <div>
        <button class=down-button onclick="moveDown(this)" type=button>Down</button>
        <button class=up-button onclick="moveUp(this)" type=button>Up</button>
      </div>
    </div>
    <label> <div>Title</div> <input class=title type=text required> </label>
    <label> <div>Hours</div> <input class=hours type=number> </label>
    <label> <div>Price</div> <input class=price type=number> </label>
    <label> <div>Description</div> <textarea class=description></textarea> </label>
    <button type=button onclick="deleteWorkItem(this.parentElement)">Delete</button>
  </fieldset>
</template>

<script>
const existing_data = document.getElementById('existing_data')
const workItemRegex = /^title-[0-9]*$/

if (existing_data) {
  const params = new URLSearchParams(existing_data.textContent)

  // Find the largest-numbered work item
  const workItemNums = Array.from(params.keys())
    .filter(key => key.match(workItemRegex))
    .map(key => key.charAt(key.length - 1))
  const numItems = Math.max(...workItemNums)

  for (let num = 0; num < numItems; num++) addWorkItem()

  for (const [key, value] of params) {
    const e = document.querySelector(`[name=${key}]`)
    if (e) e.value = value
  }

  const fpInput = document.createElement('input')
  const url = new URLSearchParams(window.location.search)
  fpInput.value = url.get('fp')
  fpInput.type = 'hidden'
  fpInput.name = 'filename'
  document.querySelector('form').append(fpInput)
} else {
  addWorkItem()
}

function renumberWorkItems() {
  const fieldsets = document.querySelectorAll('#work-items fieldset')
  fieldsets.forEach((fieldset, i) => {
    const num = i + 1
    fieldset.querySelector('h3').innerText = `${num}.`
    fieldset.querySelector('.title').setAttribute('name', `title-${num}`)
    fieldset.querySelector('.hours').setAttribute('name', `hours-${num}`)
    fieldset.querySelector('.price').setAttribute('name', `price-${num}`)
    fieldset.querySelector('.description').setAttribute('name', `description-${num}`)
  })
}

function addWorkItem() {
  const template = document.querySelector('#work-item-template')
  const workItems = document.querySelector('#work-items')
  const newFieldset = template.content.cloneNode(true)
  workItems.appendChild(newFieldset)
  renumberWorkItems()
}

function clickNewItem() {
  addWorkItem()
  const workItems = document.querySelector('#work-items')
  workItems.lastElementChild.scrollIntoView()
}

function moveDown(button) {
  // Not sure if this is the recommended way to do this
  const thisFieldset = button.closest('fieldset')
  const nextFieldset = thisFieldset.nextElementSibling
  const parent = thisFieldset.parentElement
  if (nextFieldset) parent.insertBefore(thisFieldset, nextFieldset.nextElementSibling)
  renumberWorkItems()
  thisFieldset.scrollIntoView()
}

function moveUp(button) {
  // Not sure if this is the recommended way to do this
  const thisFieldset = button.closest('fieldset')
  const prevFieldset = thisFieldset.previousElementSibling
  const parent = thisFieldset.parentElement
  if (prevFieldset) parent.insertBefore(thisFieldset, prevFieldset)
  renumberWorkItems()
  thisFieldset.scrollIntoView()
}

function deleteWorkItem(fieldset) {
  fieldset.remove()
  renumberWorkItems()
}
</script>
