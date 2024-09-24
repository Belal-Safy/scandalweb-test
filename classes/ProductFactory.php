<?php
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

class ProductFactory
{
    // Factory method to create a product object based on the type
    public function createProduct($type, $conn)
    {
        $class = $type;

        if (class_exists($class)) {
            return new $class($conn); // Dynamically instantiate the correct class
        }

        return null;
    }
}