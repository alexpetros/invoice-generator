<!DOCTYPE html>
<title>Invoice</title>
<style><?php require __DIR__.'/invoice-stylesheet.css'; ?></style>

<div class=profile-info>
  <h1>Invoice</h1>
  <section class=profile>
    <h2><?= $profile['name'] ?></h2>
    <address>
    <div class=addr><?= $profile['address_1'] ?></div>
    <div class=addr><?= $profile['address_2'] ?></div>
    <div class=email><a><?= $profile['email'] ?></a></div>
    <div class=tel><?= $profile['phone'] ?></div>
    </address>
  </section>
</div>

<div class=main-info>
  <section class=client>
  <h3>Bill To</h3>
  <address>
  <div class=name><?= $client['name'] ?></div>
  <div class=addr><?= $client['address_1'] ?></div>
  <div class=addr><?= $client['address_2'] ?></div>
  <div class=tel><?= $client['phone'] ?></div>
  </address>
  </section>

  <section class=invoice>
  <h3>Invoice Details</h3>
  <dl>
  <dt>Invoice No.</dt><dd><?= $invoice_number ?></dd>
  <dt>Issued Date:</dt><dd><?= $issue_date -> format('Y-m-d')?></dd>
  <dt>Due Date:</dt><dd><?= $due_date -> format('Y-m-d')?></dd>
  </dl>
  </section>
</div>

<section>
<h2>Work Items</h2>
<table>
  <tr>
    <th class=description>Description
    <th>Hours
    <th>Cost/hr
    <th>Total
  </tr>
  <?php foreach($work_items as $item): ?>
  <tr>
    <td class=description>
      <div class=item-title><?= $item['title'] ?></div>
    </td>
    <td><?= $item['hours'] ?>
    <td><?= $hourly_rate ?>
    <td><?= $item['hours'] * $hourly_rate ?>
  </tr>
  <?php endforeach; ?>
  <tr class=divider>
    <td class=hidden></td>
    <td class=hidden></td>
    <td>Subtotal</td>
    <td><?= $total_cost ?></td>
  <tr>
    <td class=hidden></td>
    <td class=hidden></td>
    <td>Total</td>
    <td><?= $total_cost ?></td>
  </tr>
</table>
</section>

