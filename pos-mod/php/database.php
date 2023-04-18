
<?php
class Database
{
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'inventorymanagement';
    protected $mysqli = '';

    public function __construct()
    {
        // Create connection
        $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
        // echo "Connected successfully";
    }

    public function select($column = "*", $table, $where = null)
    {
        if ($where != null) {
            $sql = "SELECT $column FROM $table WHERE $where";
        } else {
            $sql = "SELECT $column FROM $table";
        }

        return $this->mysqli->query($sql);
    }

    public function insert($table, $column, $values)
    {
        $sql = "INSERT INTO $table($column) VALUES ($values)";

        return $this->mysqli->query($sql);
    }

    public function update($table, $set, $where = null)
    {

        if ($where != null) {
            $sql = "UPDATE $table SET $set WHERE $where";
        } else {
            $sql = "UPDATE $table SET $set";
        }

        return $this->mysqli->query($sql);
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }
}
?>