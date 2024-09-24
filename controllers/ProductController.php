<?php
require_once '../classes/Database.php';
require_once '../classes/ProductFactory.php'; // Factory class to create product objects dynamically

class ProductController
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Function to fetch all products from the database
    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $productFactory = new ProductFactory();
        $products = [];

        foreach ($productsData as $productData) {
            $type = $productData['type'];
            $product = $productFactory->createProduct($type, $this->conn);

            if ($product) {
                $product->id = $productData['id'];
                $product->sku = $productData['sku'];
                $product->name = $productData['name'];
                $product->price = $productData['price'];
                $product->type = $productData['type'];

                $product->populateSpecificAttributes($productData);
                $products[] = $product;
            }
        }

        return $products;
    }

    // Function to handle product creation
    public function addNewProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate common inputs
            $sku = $_POST['sku'] ?? null;
            $name = $_POST['name'] ?? null;
            $price = $_POST['price'] ?? null;
            $type = $_POST['type'] ?? null;

            if (empty($name) || empty($price) || empty($type)) {
                echo "<script>alert('Please, submit required data');</script>";
                return;
            }

            // Create a specific product instance dynamically using the ProductFactory
            $productFactory = new ProductFactory();
            $product = $productFactory->createProduct($type, $this->conn);

            if (!$product) {
                echo "<script>alert('Invalid product type');</script>";
                return;
            }

            // Set common product attributes
            $product->sku = $sku;
            $product->name = $name;
            $product->price = $price;
            $product->type = $type;

            // Dynamically populate product-specific attributes
            $product->populateSpecificAttributes($_POST, true);

            // Try to create the product
            try {
                if ($product->create()) {
                    header("Location:../views/list.php?success=1");
                } else {
                    echo "<div id='temp-notification' class='notification show'>Error adding product!</div>";
                }
            } catch (\Throwable $th) {
                echo "<div id='temp-notification' class='notification show'>This SKU has been used before!</div>";
            }
        }
    }

    // Function to delete selected products from the database
    public function deleteProducts($productIds)
    {
        $productIds = array_map('intval', $productIds); // Sanitize IDs
        $query = "DELETE FROM products WHERE id IN (" . implode(',', array_fill(0, count($productIds), '?')) . ")";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($productIds);
    }
}
