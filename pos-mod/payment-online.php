<div class="payment__title text-center">Payment Options</div>
<div class="checkbox--container container text-center my-2" style="width: 100%">
    <span class="form-check mx-3" style="display: inline-block">
        <input class="form-check-input" readonly type="radio" value="1" name="payment_option" id="cash_payment" required />
        <label class="form-check-label" for="cash_payment">
            Cash
        </label>
    </span>
    <span class="form-check mx-3" style="display: inline-block">
        <input class="form-check-input" checked readonly type="radio" value="2" name="payment_option" id="online_payment" />
        <label class="form-check-label" for="online_payment">
            Online
        </label>
    </span>
    <span class="form-check mx-3" style="display: inline-block">
        <input class="form-check-input" readonly type="radio" value="3" name="payment_option" id="bank_payment" />
        <label class="form-check-label" for="bank_payment">
            Bank Check
        </label>
    </span>
</div>
<div class="form_control-container container mt-5" style="width: 90%">
    <div class="mb-3">
        <label for="" class="form-label">Date</label>
        <input type="date" readonly name="date" value="<?php echo $paymentDate ?>" class="form-control payment__date" id="trans_date" required />
    </div>
    <div class="mb-3">
        <label for="online_select" class="form-label">Online Platform</label>
        <select name="online_select" class="form-select" aria-label="Default select example" required>
            <option disabled selected value="">Open this select menu</option>

            <?php

            if ($payment->online_platform->num_rows > 0) {
                while ($row = $payment->online_platform->fetch_assoc()) {
                    # code... 
            ?>
                    <option value="<?php echo $row['online_platform_id'] ?>"><?php echo $row['online_platform_name'] ?></option>
            <?php
                }
            }
            ?>
        </select>


    </div>
    <div class="mb-3">
        <label for="ref_num" class="form-label">Reference Number</label>
        <input type="text" name="ref_num" id="ref_num" class="form-control payment__date" id="trans_date" required />
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Tendered Amount</label>
        <input type="text" value="<?php echo number_format($tendered, 2) ?>" class="form-control" required disabled />
        <input type="hidden" name="amount" value="<?php echo $tendered ?>" class="form-control" />
    </div>
</div>