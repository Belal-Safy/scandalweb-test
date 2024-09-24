<?php include 'header.php'; ?>

<?php
include '../controllers/ProductController.php';
$productController = new ProductController();

// Handle deletion of products
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productIds'])) {
    $productIds = json_decode($_POST['productIds'], true);
    if ($productIds && $productController->deleteProducts($productIds)) {
        // // Successfully deleted products
        // echo "<script>alert('Products deleted successfully!');</script>";
    } else {
        // Error handling
        echo "<script>alert('Error deleting products.');</script>";
    }
}

// Get all products
$products = $productController->getAllProducts();
?>

<div class="container">
    <div class="flex space-between">

        <h1>Product List</h1>
        <div class="actions">
            <button class="btn" onclick="window.location.href='add.php';">Add</button>
            <button class="btn mass-delete-btn" id="delete-product-btn">Mass Delete</button>
        </div>
    </div>
    <hr class="sep">

    <div class="product-grid">
        <?php
        // Loop through products and generate HTML for each
        foreach ($products as $product) {
            echo "<div class='product-item'>";
            echo "<input type='checkbox' class='delete-checkbox' value='{$product->id}'>";
            echo "<p><strong>{$product->sku}</strong></p>";
            echo "<p>{$product->name}</p>";
            echo "<p>\${$product->price}</p>";
            echo ($product->renderAttributes());
            echo "</div>";
        }
        ?>
    </div>
</div>

<!-- CSS styles -->
<style>
    .mass-delete-btn {
        background-color: #dc3545;
    }

    .product-grid {
        margin-top: 50px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .product-item {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .product-item input[type="checkbox"] {
        position: absolute;
        top: 10px;
        left: 10px;
        transform: scale(1.2);
    }

    .product-item p {
        margin: 10px 0;
        color: #555;
    }

    .product-item p strong {
        font-size: 1.2em;
        color: #333;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- JavaScript to handle mass delete -->
<script>
    document.getElementById('delete-product-btn').addEventListener('click', function() {
        let checkedProducts = document.querySelectorAll('.delete-checkbox:checked'); // Select checked checkboxes
        let productIds = [];

        // Collect selected product IDs
        checkedProducts.forEach(function(checkbox) {
            productIds.push(checkbox.value); // Get the value of each checked checkbox
        });

        // Ensure there are products selected for deletion
        if (productIds.length > 0) {
            // Create a form to submit via POST
            let form = document.createElement('form');
            form.method = 'POST';
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'productIds';
            input.value = JSON.stringify(productIds); // Convert the array of product IDs to a JSON string
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit(); // Submit the form
        } else {
            alert('No products selected for deletion.');
        }
    });
</script>

<?php include 'footer.php'; ?>