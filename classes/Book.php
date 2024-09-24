<?php
require_once 'Product.php';

class Book extends Product
{
    public $weight;

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (sku, name, price, type, weight) 
                  VALUES (:sku, :name, :price, :type, :weight)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':weight', $this->weight);

        return $stmt->execute();
    }

    // Populate specific attributes for Book
    public function populateSpecificAttributes($data, $required = false)
    {
        $this->weight = $data['weight'] ?? null;
        if (empty($this->weight) && $required) {
            echo "<script>alert('Please provide weight for the book');</script>";
        }
    }

    public function renderAttributes()
    {
        return "<p>Weight: {$this->weight}</p>";
    }
}
