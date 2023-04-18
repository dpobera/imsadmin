<div class="payment__title text-center">Payment Options</div>
<div class="checkbox--container container text-center my-2" style="width: 100%">
    <span class="form-check mx-3" style="display: inline-block">
        <input class="form-check-input" readonly type="radio" name="payment_option" id="cash_payment" value="1" required />
        <label class="form-check-label" for="cash_payment">
            Cash
        </label>
    </span>
    <span class="form-check mx-3" style="display: inline-block">
        <input class="form-check-input" readonly type="radio" name="payment_option" id="online_payment" value="2" />
        <label class="form-check-label" for="online_payment">
            Online
        </label>
    </span>
    <span class="form-check mx-3" style="display: inline-block">
        <input class="form-check-input" readonly checked type="radio" name="payment_option" id="bank_payment" value="3" />
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
        <label for="" class="form-label">Check Date</label>
        <input type="date" name="check_date" class="form-control " id="trans_date" required />
    </div>
    <div class="mb-3">
        <label for="online_select" class="form-label">Bank</label>
        <select name="bank_select" class="form-select" aria-label="Default select example" required>
            <option readonly selected value="">Open this select menu</option>
            <?php

            if ($payment->banks->num_rows > 0) {
                while ($row = $payment->banks->fetch_assoc()) {
                    # code... 
            ?>
                    <option value="<?php echo $row['bank_id'] ?>"><?php echo $row['bank_code'] ?></option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="trans_date" class="form-label">Check Number</label>
        <input autocomplete="off" type="text" name="check_number" id="ref_num" class="form-control payment__date" id="trans_date" required />
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Tendered Amount</label>
        <input type="text" value="<?php echo number_format($tendered, 2) ?>" class="form-control" required disabled />
        <input type="hidden" name="amount" value="<?php echo $tendered ?>" class="form-control" />
    </div>
</div>