<?php include_once 'php/jo_modal-inc.php' ?>

<!-- <link rel="stylesheet" href="styles/jo_modal-style.css"> -->
<script defer src="js/jo_modal-script.js"></script>

<div style="padding: 2%;">
  <div class="input-group flex-nowrap">
    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
    <input type="text" class="form-control jo__modal--input jo__modal--input__search" placeholder="Search JO-Order No..." aria-label="Username" aria-describedby="addon-wrapping" style="width: 50%;">
  </div>
  <br>
  <table class="jo__modal--table table table-hover">
    <thead>
      <tr>
        <th>JO No.</th>
        <th>Customer</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($joId)) {
        $jolimit = 0;

        while (count($joId) !== $jolimit) {
          echo
          "<tr>
              <td class='jo__modal--td__jonumber'>" . $joNum[$jolimit] . "</td>
              <td>" . $joCustomerName[$jolimit] . "</td>
              <td>" . $joDate[$jolimit] . "</td>
            </tr>";

          $jolimit++;
        }
      }

      ?>
      <!-- <tr>
            <td>12-23456</td>
            <td>Philippine Acrylic and Chemical Corp.</td>
            <td>999,999.99</td>
            <td>01-01-2021</td>
          </tr> -->
    </tbody>
  </table>
</div>