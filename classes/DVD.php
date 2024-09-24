<?php
require_once 'Product.php';

class DVD extends Product
{
    public $size;

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (sku, name, price, type, size) 
                  VALUES (:sku, :name, :price, :type, :size)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':size', $this->size);

        return $stmt->execute();
    }

    // Populate specific attributes for DVD
    public function populateSpecificAttributes($data, $required = false)
    {
        $this->size = $data['size'] ?? null;
        if (empty($this->size) && $required) {
            echo "<script>alert('Please provide size for the DVD');</script>";
        }
    }

    public function renderAttributes()
    {
        return "<p>Size: {$this->size}</p>";
    }
}
