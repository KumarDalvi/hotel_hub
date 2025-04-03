<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity']; // Ensure integer

    if ($quantity <= 0) {
        unset($_SESSION['cart'][$product_id]); // Remove item if quantity is 0
    } else {
        $_SESSION['cart'][$product_id] = $quantity; // Update session cart
    }

    echo json_encode(["success" => true, "cart" => $_SESSION['cart']]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: white;
            font-family: 'Poppins', sans-serif;
        }
        .menu-container {
            max-width: 90%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .menu-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }
        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            
        }
        .menu-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        .menu-details {
            flex-grow: 1;
            padding-left: 15px;
        }
        .menu-name {
            font-size: 18px;
            font-weight: 600;
        }
        .menu-price {
            color: #28a745;
            font-weight: bold;
        }
        .quantity-control {
            display: flex;
            align-items: center;
        }
        .qty-btn {
            width: 30px;
            height: 30px;
            font-size: 18px;
            border: none;
            cursor: pointer;
        }
        .qty-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
            margin: 0 5px;
        }
 
        .nav-tabs .nav-link.active 
        {
            box-shadow: 2px 2px 4px black;
            border: 1px solid black;
          font-weight: bold;
            color: green;
        }
        .nav-tabs .nav-link 
        {
            border: 1px solid grey;
            color: black;
        }
        .tbl_icon
        {
             display: inline-block;
    transform: scaleX(-1);
        }

.back-to-top {
    position: fixed;
    bottom: 15px;
    right: 20px;
    width: 50px;
    height: 50px;
    border: none;
    border-radius: 50%;
    background: #007bff;
    color: white;
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 999;
    transition: all 0.3s ease-in-out;
}

.back-to-top:hover {
    background: #0056b3;
    transform: scale(1.1);
}

.back-to-top svg {
    transition: transform 0.2s ease-in-out;
}

.back-to-top:hover svg {
    transform: translateY(-3px);
}



 .custom-button {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        color: white;
        font-size: 20px;
        font-weight: bold;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        position: relative;
        transition: 0.3s ease-in-out;
        box-shadow: 0px 4px 15px rgba(0, 123, 255, 0.4);
        text-transform: uppercase;
        overflow: hidden;
        z-index: 1;
    }

    .custom-button::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transform: skewX(-45deg);
        transition: 0.5s;
    }

    .custom-button:hover::before {
        left: 150%;
    }

    .custom-button:hover {
        background: linear-gradient(135deg, #00c6ff, #007bff);
        box-shadow: 0px 6px 20px rgba(0, 123, 255, 0.6);
        transform: scale(1.05);
    }

    .custom-button:active {
        transform: scale(0.95);
    }
    
        
    </style>
</head>
<body>

<div class="menu-container mt-4 mb-5" id="top_view">
     <h4 class="text-center"> <strong><?= isset($_SESSION['hotel_name']) ? $_SESSION['hotel_name'] : 'Hotel' ?></strong></h4>
         
            <p style="text-align: center; margin-top: 0;"><strong><?=$hotel_details[0]['hotel_address']?>, <?=$hotel_details[0]['hotel_mobile']?></strong></p>
    <h2 class="menu-header">📜 Hotel Menu | <span class="me-2"><span class="tbl_icon">🪑</span> Table: <?=$_GET['table_no']?></span> <span style="text-align: right; cursor: pointer;" onclick="openCartModal()">🛒 View Cart</span>
</h2>
    
    
      
    <ul class="nav nav-tabs" id="menuTabs">
        <?php foreach ($cats as $index => $category): ?>
            <li class="nav-item me-2 mb-2">
                <a class="nav-link <?= $index === 0 ? 'active' : '' ?>" data-bs-toggle="tab" href="#cat<?= $category['category_id']; ?>">
                    <?= $category['category_name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content mt-3">
        <?php foreach ($cats as $index => $category): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="cat<?= $category['category_id']; ?>">
                <?php foreach ($products as $product): ?>
                    <?php if ($product['category_id'] == $category['category_id']): ?>
                        <div class="menu-item">
                            <img src="<?= base_url('uploads/' . $product['product_image']); ?>" alt="<?= $product['product_name']; ?>">
                            <div class="menu-details">
                                <div class="menu-name"> <?= $product['product_name']; ?> </div>
                                <div class="menu-price"> ₹<?= number_format($product['product_price'], 2); ?> </div>
                            </div>
                            <div class="quantity-control">
                                <button class="btn btn-sm btn-danger qty-btn minus" data-id="<?= $product['product_id']; ?>">−</button>
                                <input type="text" class="form-control text-center qty-input" 
                                       min="0"  
                                       data-id="<?= $product['product_id']; ?>" 
                                       value="<?= isset($_SESSION['cart'][$product['product_id']]) ? $_SESSION['cart'][$product['product_id']] : 0; ?>">

                                <button class="btn btn-sm btn-success qty-btn plus" data-id="<?= $product['product_id']; ?>">+</button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
<div class="d-flex justify-content-center">

  

    <a href="<?=base_url()?>user/send_to_kitchen" class="w-100" style="max-width: 350px; position: fixed; bottom: 10px; left: 50%; transform: translateX(-50%); text-align: center;">
        <button class="custom-button">Submit Order</button>
    </a>
    <button id="backToTop" class="back-to-top">
    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 15l-6-6-6 6"></path>
    </svg>
</button>
</div>
</div>
<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🛒 Your Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($_SESSION['cart'])): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grandTotal = 0;
                            foreach ($_SESSION['cart'] as $product_id => $quantity): 
                                $product = $products[$product_id]; // Assuming $products contains product details
                                $total = $product['product_price'] * $quantity;
                                $grandTotal += $total;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($product['product_name']); ?></td>
                                <td><?= $quantity; ?></td>
                                <td>₹<?= number_format($product['product_price'], 2); ?></td>
                                <td>₹<?= number_format($total, 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Grand Total:</th>
                                <th>₹<?= number_format($grandTotal, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <p class="text-center">Your cart is empty.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="<?=base_url()?>user/send_to_kitchen" class="btn btn-primary">Submit Order</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Open Modal -->
<script>
    function openCartModal() {
        // Store a flag in sessionStorage before refreshing
        sessionStorage.setItem("openModal", "true");
        
        // Refresh the page
        location.reload();
    }

    // After the page reloads, check if the flag is set
    window.onload = function () {
        if (sessionStorage.getItem("openModal") === "true") {
            sessionStorage.removeItem("openModal"); // Remove the flag
            let myModal = new bootstrap.Modal(document.getElementById("cartModal"));
            myModal.show(); // Open the modal
        }
    };
</script>

<?php



// Handle AJAX request to get cart data
if (isset($_POST['fetch_cart'])) {
    $response = ['cart' => [], 'grandTotal' => 0];

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            if (isset($products[$product_id])) {
                $product = $products[$product_id];
                $total = $product['product_price'] * $quantity;
                $response['cart'][] = [
                    'name' => htmlspecialchars($product['product_name']),
                    'quantity' => $quantity,
                    'price' => $product['product_price'],
                    'total' => $total
                ];
                $response['grandTotal'] += $total;
            }
        }
    }

    echo json_encode($response);
    exit;
}
?>

<script>
    $(document).ready(function () {
        $(".qty-btn").click(function () {
            let input = $(this).siblings(".qty-input");
            let productId = $(this).data("id");
            let value = parseInt(input.val());

            if ($(this).hasClass("plus")) {
                value++;
            } else if ($(this).hasClass("minus")) {
                value = Math.max(0, value - 1); // Prevent negative values
            }

            input.val(value);

            // Send updated quantity to server
            $.post(window.location.href, { product_id: productId, quantity: value }, function (response) {
                console.log("Cart updated:", response);
            }, "json");
        });

        // Prevent manual non-numeric input
        $(".qty-input").on("input", function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
        });

        // Update cart when manually changing input field
        $(".qty-input").on("change", function () {
            let productId = $(this).data("id");
            let value = parseInt($(this).val()) || 0; // Ensure it's a valid number

            $.post(window.location.href, { product_id: productId, quantity: value }, function (response) {
                console.log("Cart updated:", response);
            }, "json");
        });
    });
  document.addEventListener("DOMContentLoaded", function () {
    var backToTop = document.getElementById("backToTop");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) {
            backToTop.style.display = "flex";
        } else {
            backToTop.style.display = "none";
        }
    });

    backToTop.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});



</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
