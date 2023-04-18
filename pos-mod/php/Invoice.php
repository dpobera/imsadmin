<?php
include 'PointOfSales.php';


class Invoice extends PointOfSales
{
    public $invoice_number;

    public function __construct($invoice_number)
    {
        parent::__construct();

        $this->invoice_number = $invoice_number;
    }

    function checkDuplicateInvoice()
    {
        $sql = "SELECT invoice_number FROM invoice WHERE invoice_number = '$this->invoice_number'";

        $result = $this->mysqli->query($sql);

        if ($result->num_rows > 0) {
            return true;
        }

        return false;
    }

    function saveInvoice($user_id, $dr_number = [])
    {
        $values = $this->invoice_number . ',' . $user_id;
        $this->insert('invoice', 'invoice_number,user_id', $values);

        foreach ($dr_number as $value) {
            // $sql = "INSERT INTO dr_inv (dr_number, inv_number) VALUES ('$value','$this->invoice_number')";
            // $this->mysqli->query($sql);
            $drInvValues = $value . ',' . $this->invoice_number;
            $this->insert('dr_inv', 'dr_number, inv_number', $drInvValues);
        }
    }
}
