<?php

include 'PointOfSales.php';

class Payments extends PointOfSales
{

    public function __construct($jo_id)
    {
        parent::__construct();

        $this->jo_id = $jo_id;
        $this->getJoDetails($jo_id);
        $this->getCustomerName($this->customer_id);
        $this->getJoTotal($jo_id);
        $this->getPaidAmount($jo_id);
        $this->jo_balance = $this->jo_total - $this->paid_amount;
    }

    private function getJoDetails($jo_id)
    {

        $result =  $this->select("jo_no, customers_id", "jo_tb", "jo_id = $jo_id");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->jo_number = $row['jo_no'];
            $this->customer_id = $row['customers_id'];
        }

        return 0;
    }

    private function getCustomerName($customer_id)
    {
        $result = $this->select("customers_name", "customers", "customers_id = $customer_id");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->customer_name = $row['customers_name'];
        }

        return 0;
    }



    private function onlinePayment($state)
    {
        if (!$this->insert('online_payment', 'order_payment_id,online_platform_id,online_payment_reference,online_payment_amount,online_payment_date', "'$state->last_id','$state->online_select','$state->ref_num', '$state->amount','$state->date'")) return 0;

        return 1;
    }

    private function chequePayment($state)
    {

        if (!$this->insert("cheque_payment", "order_payment_id, cheque_number, cheque_date, cheque_amount, bank_id", "'$state->last_id', '$state->check_number', '$state->check_date', '$state->amount', '$state->bank_select'")) return 0;

        return 1;
    }


    public function savePayment($payment = [])
    {
        $state = json_decode(json_encode($payment));

        $state->amount = str_replace(',', '', $state->amount);

        if (!$this->insert('order_payment', 'payment_type_id,jo_id,order_payment_debit,order_payment_date', "'$state->payment_option', '$this->jo_id','$state->amount','$state->date'")) return 0;

        $state->last_id = $this->mysqli->insert_id;

        if ($payment['payment_option'] == 2) {
            if (!$this->onlinePayment($state)) return 0;
        }

        if ($payment['payment_option'] == 3) {
            if (!$this->chequePayment($state)) return 0;
        }

        return 1;
    }
}
