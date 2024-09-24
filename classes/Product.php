<?php
abstract class Product
{
    protected $conn;
    protected $table_name = "products";

    public $sku;
    public $name;
    public $price;
    public $type;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Abstract function that must be implemented by child classes
    abstract public function create();

    // This function should be implemented in child classes
    abstract public function populateSpecificAttributes($data, $required);

    // This function should be implemented in child classes
    abstract public function renderAttributes();
}
