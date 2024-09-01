<!DOCTYPE html>
<title><?= $invoice_title ?></title>
<style><?php require __DIR__.'/invoice-stylesheet.css'; ?></style>
<script type=text/form-data id=raw_data>
<?= $raw_json_data."\n" ?>
</script>

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
  <dt>Issued Date:</dt><dd><?= $issue_date -> format('M j, Y')?></dd>
  <dt>Due Date:</dt><dd><?= $due_date -> format('M j, Y')?></dd>
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
      <div class=item-description><?= $item['description'] ?></div>
    </td>
    <td><?= empty($item['price']) ? $item['hours'] : '-' ?>
    <td><?= empty($item['price']) ? $hourly_rate : '-' ?>
    <td><?= empty($item['price']) ? $item['hours'] * $hourly_rate : $item['price'] ?>
  </tr>
  <?php endforeach; ?>
  <tr class="divider emphasis">
    <td class=hidden></td>
    <td class=hidden></td>
    <td class=total>Subtotal</td>
    <td><?= $total_cost ?></td>
  <tr class="emphasis">
    <td class=hidden></td>
    <td class=hidden></td>
    <td class=total>Total</td>
    <td><?= $total_cost ?></td>
  </tr>
</table>
</section>

<section class=late-fee-notice>
<h3>Late Fee Notice</h3>
Please note that invoices past due incur a late fee of 2%, charged daily.
</section>
