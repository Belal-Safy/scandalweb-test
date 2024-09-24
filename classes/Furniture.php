<?php
require_once 'Product.php';

class Furniture extends Product
{
    public $height;
    public $width;
    public $length;

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (sku, name, price, type, height, width, length) 
                  VALUES (:sku, :name, :price, :type, :height, :width, :length)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':height', $this->height);
        $stmt->bindParam(':width', $this->width);
        $stmt->bindParam(':length', $this->length);

        return $stmt->execute();
    }

    // Populate specific attributes for Furniture
    public function populateSpecificAttributes($data, $required = false)
    {
        $this->height = $data['height'] ?? null;
        $this->width = $data['width'] ?? null;
        $this->length = $data['length'] ?? null;

        if ((empty($this->height) || empty($this->width) || empty($this->length)) && $required) {
            echo "<script>alert('Please provide dimensions for the furniture');</script>";
        }
    }

    public function renderAttributes()
    {
        return "<p>Dimensions: {$this->height}x{$this->width}x{$this->length}</p>";
    }
}
