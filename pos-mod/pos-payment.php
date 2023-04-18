<?php include 'header-pos.php';
if (!isset($_SESSION['user'])) {
    header("location: login-page.php");
}
include('../php/config.php');

?>


<div style="padding:2%;margin-top:-1.4cm;">
    <!-- <h2>IMS CASHIERING</h2> -->
    <br>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" style="cursor: not-allowed;">
            <a class="nav-link disabled" data-bs-toggle="tab" href="#" style="color: grey;cursor:not-allowed">Job-Order</a>
        </li>
        <li class="nav-item" style="cursor: not-allowed;">
            <a class="nav-link disabled" data-bs-toggle="tab" href="#" style="color: grey;cursor:not-allowed">Cashiering</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#menu2">Payments</a>
        </li>


    </ul>
    <div class="row">
        <div class="col">
            <!-- Tab panes -->
            <div class="tab-content">

                <div id="menu2" class="tab-pane active" style="background-color: white;padding:1% ;border-left:1px solid #dee2e6;border-bottom:1px solid #dee2e6;border-right:1px solid #dee2e6;"><br>
                    <h3>Payments</h3>
                    <div class="tab__content tab__content--payment">
                        <h1>Pending Payments</h1>

                        <div class="pending__payments--search--container">
                            <input type="text" class="pending__payments--search" placeholder="🔎 Search Pending Payments...">
                        </div>
                        <div class="container-transaction-list">
                            <table class="tbl-transaction">
                                <thead>
                                    <tr>
                                        <th>Transaction No.</th>
                                        <th>Customer Name</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Transaction Date</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody class="transaction-list">
                                    <!-- <tr>
                                    <td>00000001</td>
                                    <td>Karl Siat</td>
                                    <td>100000.00</td>
                                    <td>09/21/2021</td>
                                    </tr>
                                    <tr>
                                    <td>00000002</td>
                                    <td>Danielle Paz</td>
                                    <td>200000.00</td>
                                    <td>09/23/2021</td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>

                        <div id="payment-modal">
                            <div class="container-payment-details">

                                <div class="payment__modal--close">
                                    <p>X</p>
                                </div>

                                <form class="payment" method="get" action="payment.php">
                                    <div class="payment-type">
                                        <h1>Payment Type</h1>
                                        <div class="container-radio-button">
                                            <span>
                                                <input type="radio" id="cash" name="payment-type" value="" checked class="radio--payment-type" />
                                                <label for="cash" class="label--payment-type">CASH</label>
                                                <input type="radio" id="online" value="" name="payment-type" class="radio--payment-type" />
                                                <label for="online" class="label--payment-type">ONLINE</label>
                                                <input type="radio" id="cheque" value="" name="payment-type" class="radio--payment-type" />
                                                <label for="cheque" class="label--payment-type">CHEQUE</label>
                                            </span>
                                        </div>
                                    </div>

                                    <fieldset class="online-details">
                                        <div class="online-details">
                                            <label for="">Online Platform:</label>
                                            <select name="" id="onlinePlatform" disabled>
                                                <option value="">-Select Field-</option>

                                                <?php
                                                include 'php/config.php';
                                                include 'php/functions.php';

                                                $onlinePlatforms = getOnlinePlatforms($db);
                                                foreach ($onlinePlatforms as $value) {
                                                    $id = $value['online_platform_id'];
                                                    $platform = $value['online_platform_name'];

                                                    echo "
                            <option value='$id'>$platform</option>";
                                                }

                                                ?>

                                            </select>
                                            <label for="">Transaction Date:</label>
                                            <input type="date" class="transaction-date" name="payment_date" disabled />
                                            <label for="">Reference Number:</label>
                                            <input type="text" class="reference-number" name="ref_num" disabled />
                                        </div>
                                    </fieldset>

                                    <fieldset class="bank-details">
                                        <div class="bank-details">
                                            <label for="">Bank:</label>
                                            <select name="" id="bankName" disabled>
                                                <option value="">-Select Field-</option>
                                                <option value="1">BPI</option>
                                                <option value="2">BDO</option>
                                                <option value="3">MBTC</option>
                                                <option value="4">CBC</option>
                                            </select>
                                            <label for="">Cheque Date:</label>
                                            <input type="date" class="cheque-date" name="payment_date" disabled />
                                            <label for="">Cheque Number:</label>
                                            <input type="text" class="cheque-number" name="ref_num" disabled />
                                        </div>
                                    </fieldset>

                                    <div class="payment-details">
                                        <label for="">Amount:</label>
                                        <input type="text" class="payment-balance" value="1000.00" disabled /><br />
                                        <label for="">Tendered Amount:</label>
                                        <input type="text" class="payment-tendered" placeholder="Enter Amount" /><br />
                                        <label for="" class="change-balance">Change: </label>
                                        <input type="text" class="payment-change" disabled value="0.00" />
                                    </div>

                                    <div class='container--button__save'>
                                        <button class="button__save--payment">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <?php include_once '../pos/footer.php'; ?>
                </div>
            </div>
        </div>

    </div>
</div>




<!--  CUSTOMER MODAL -->
<div id="customerModal" class="customer-modal modal">
    <!-- Modal content -->
    <div class="customer-modal-content">
        <div class="customer-nav">
            <span class="customer-search-container">
                <input autocomplete="off" type="text" id="searchCustomer" placeholder="Search Customer...   " />
            </span>
            <button class="button--new__customer">New Customer</button>
            <span class="modal__note">Select Customer then Press ENTER</span>
            <span class="customer__modal--close"> X </span>
        </div>
        <div class="customer-table-container">
            <table id="customer-table">
                <thead>
                    <tr class="head">
                        <th class="customer-id">ID</th>
                        <th class="customer-name">Name</th>
                        <th class="customer-address">Address</th>
                        <th class="customer contact">Contact</th>
                    </tr>
                </thead>
                <tbody id="customer-list">
                    <!-- <tr class="customer-data">
                  <td class="customer-id">000001</td>
                  <td class="customer-name">Karl Siat</td>
                  <td class="customer-address">
                    635 Mercedes Ave., Pasig City
                  </td>
                  <td class="customer-contact">09876543210</td>
                </tr>
                <tr class="customer-data">
                  <td class="customer-id">000002</td>
                  <td class="customer-name">Dave Obera</td>
                  <td class="customer-address">
                    635 Mercedes Ave., Pasig City
                  </td>
                  <td class="customer-contact">09876543210</td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>