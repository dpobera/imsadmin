<?php
include 'database.php';

class PointOfSales extends Database
{

    public $online_platform;
    public $banks;
    public $jo_id;
    public $jo_number;
    public $customer_id;
    public $customer_name;
    public $jo_total;
    public $paid_amount;
    public $jo_balance;

    public function __construct()
    {
        parent::__construct();

        $this->online_platform = $this->getOnlinePlatforms();
        $this->banks = $this->getBank();
    }

    function getDrList($qry = '')
    {
        $sql =
            "SELECT delivery_receipt.dr_number, 
            customers.customers_name, 
            delivery_receipt.dr_date,
            SUM(dr_products.dr_product_qty * jo_product.jo_product_price)  AS subTotal
            FROM delivery_receipt 
            LEFT JOIN dr_products ON dr_products.dr_number = delivery_receipt.dr_number
            LEFT JOIN jo_product ON jo_product.jo_product_id = dr_products.jo_product_id
            LEFT JOIN jo_tb ON jo_tb.jo_id = jo_product.jo_id
            LEFT JOIN customers ON customers.customers_id = jo_tb.customers_id
            LEFT JOIN dr_inv ON dr_inv.dr_number = delivery_receipt.dr_number 
            WHERE customers.customers_id = '$qry'
            GROUP BY delivery_receipt.dr_number
            ORDER BY delivery_receipt.dr_date DESC";

        $result = $this->mysqli->query($sql);

        return $result;
    }

    function getOnlinePlatforms()
    {
        $result = $this->select("*", "online_platform");

        return $result;
    }

    function getBank()
    {
        $result = $this->select("*", "bank");
        return $result;
    }

    function getPendingJoPayments($limit = "", $qry = "")
    {
        $result = $this->select(
            "*, jo_total - total_paid as jo_balance from(select SUM(jo_product.jo_product_qty * jo_product.jo_product_price) as jo_total,jo_tb.jo_type_id, jo_product.jo_id as jo_id, jo_tb.jo_no, jo_tb.jo_date, customers.customers_name",
            "jo_product
            left join jo_tb on jo_tb.jo_id = jo_product.jo_id 
            left join customers on customers.customers_id = jo_tb.customers_id
            group by jo_id) as t1 LEFT JOIN (SELECT SUM(order_payment.order_payment_debit) as total_paid, order_payment.jo_id as joId from order_payment GROUP by jo_id) as t2 ON t1.jo_id = t2.joId ",
            "jo_type_id = 1 AND (t1.customers_name LIKE '%$qry%' OR t1.jo_no LIKE '%$qry%') HAVING jo_balance > 0 ORDER BY jo_date desc $limit"
        );

        return $result;
    }

    function getJoTotal($jo_id)
    {
        $result = $this->select("SUM(jo_product_price * jo_product_qty) AS joTotal", "jo_product", "jo_id = $jo_id ");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->jo_total = $row['joTotal'];
        }

        return $this->jo_total;
    }

    public function getPaidAmount($jo_id)
    {
        $result = $this->select("SUM(order_payment_debit) AS jo_total_paid", "order_payment", "jo_id = $jo_id ");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->paid_amount = $row['jo_total_paid'];
        }

        return $this->paid_amount;
    }

    public function checkActivePage($page_limit, $page_number)
    {
        if ($page_limit == $page_number) echo "active";
    }
}
