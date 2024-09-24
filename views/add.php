<?php include 'header.php'; ?>
<?php
require_once '../controllers/ProductController.php';
$controller = new ProductController();
$controller->addNewProduct();
?>
<div class="container">

    <form id="product_form" method="POST">
        <div id="notification" class="notification"></div>
        <div class="flex space-between">
            <h1>Add New Product</h1>
            <div class="actions">
                <button type="submit" class="btn">Save</button>
                <button class="btn cancel-btn" onclick="window.location.href='list.php';">Cancel</button>
            </div>
        </div>
        <hr class="sep">

        <div class="form-fields">
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku">
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price">
            </div>

            <div class="form-group">
                <label for="productType">Type Switcher</label>
                <select id="productType" name="type">
                    <option value="">Select Type</option>
                    <option value="DVD">DVD</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Book">Book</option>
                </select>
            </div>

            <!-- DVD Specific Fields -->
            <div id="dvdFields" class="typeFields" style="display:none;">
                <div class="form-group">
                    <label for="size">Size (MB)</label>
                    <input type="number" id="size" name="size">
                </div>
                <bold>Please, provide size</bold>
            </div>

            <!-- Book Specific Fields -->
            <div id="bookFields" class="typeFields" style="display:none;">
                <div class="form-group">
                    <label for="weight">Weight (KG)</label>
                    <input type="number" id="weight" name="weight">
                </div>

                <bold>Please, provide weight</bold>
            </div>

            <!-- Furniture Specific Fields -->
            <div id="furnitureFields" class="typeFields" style="display:none;">
                <div class="form-group">
                    <label for="height">Height (CM)</label>
                    <input type="number" id="height" name="height">
                </div>

                <div class="form-group">
                    <label for="width">Width (CM)</label>
                    <input type="number" id="width" name="width">
                </div>

                <div class="form-group">
                    <label for="length">Length (CM)</label>
                    <input type="number" id="length" name="length">
                </div>

                <bold>Please, provide dimensions</bold>
            </div>
        </div>
    </form>
</div>


<style>
form {
    width: 100%;
}

.form-fields {
    width: fit-content;
    margin: auto;
    margin-top: 50px;
}

.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

label {
    width: 150px;
    font-size: 16px;
    margin-bottom: 0;
}

input[type="text"],
input[type="number"],
select {
    /* flex: 1; */
    width: 300px;
    padding: 10px;
    margin-bottom: 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

.actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.cancel-btn {
    background-color: #c2c0c0;
}
</style>

<script>
// Switch form fields based on product type
document.getElementById('productType').addEventListener('change', function() {
    let typeFields = document.getElementsByClassName('typeFields');
    for (let i = 0; i < typeFields.length; i++) {
        typeFields[i].style.display = 'none';
    }

    let type = this.value;
    if (type === 'DVD') {
        document.getElementById('dvdFields').style.display = 'block';
    } else if (type === 'Furniture') {
        document.getElementById('furnitureFields').style.display = 'block';
    } else if (type === 'Book') {
        document.getElementById('bookFields').style.display = 'block';
    }
});

function showNotification(message) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.classList.add('show');

    // Automatically hide the notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

function validateInputs() {
    const sku = document.querySelector('#sku').value.trim();
    const name = document.querySelector('#name').value.trim();
    const price = document.querySelector('#price').value.trim();
    const type = document.querySelector('#productType').value;

    if (!name || !price || !type) {
        showNotification('Please, submit required data');
        return false;
    }

    if (type === "DVD") {
        const size = document.querySelector('#size').value.trim();
        if (!size) {
            showNotification('Please, provide the data of indicated type');
            return false;
        }
    }

    if (type === "Book") {
        const weight = document.querySelector('#weight').value.trim();
        if (!weight) {
            showNotification('Please, provide the data of indicated type');
            return false;
        }
    }

    if (type === "Furniture") {
        const height = document.querySelector('#height').value.trim();
        const width = document.querySelector('#width').value.trim();
        const length = document.querySelector('#length').value.trim();
        if (!height || !width || !length) {
            showNotification('Please, provide the data of indicated type');
            return false;
        }
    }

    return true;
}

// Function to hide the notification after 3 seconds
function hideNotification() {
    const notification = document.getElementById('temp-notification');
    if (notification) {
        notification.classList.remove('show');

        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}

// Automatically call hideNotification when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    setInterval(() => {
        hideNotification();
    }, 5000);
});

document.querySelector('#product_form').addEventListener('submit', function(event) {
    if (!validateInputs()) {
        event.preventDefault();
    }
});
</script>

<?php include 'footer.php'; ?>