<!DOCTYPE html>
<title>Invoice</title>

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
  <dt>Invoice No.</dt><dd><?= $details['number'] ?></dd>
  <dt>Issued Date:</dt><dd><?= $details['issued_date'] ?></dd>
  <dt>Due Date:</dt><dd><?= $details['due_date'] ?></dd>
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
  <tr>
    <td class=description>
      <div class=item-title>Customer Support</div>
    </td>
    <td>10
    <td>70
    <td>700
  </tr>
</table>
</section>

