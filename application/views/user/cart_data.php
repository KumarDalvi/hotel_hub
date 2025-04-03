<?php


if (!empty($_SESSION['cart'])) {
    $grandTotal = 0;
    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product = $products[$product_id]; // Assuming $products contains product details
        $total = $product['product_price'] * $quantity;
        $grandTotal += $total;

        echo "<tr>
                <td>" . htmlspecialchars($product['product_name']) . "</td>
                <td>$quantity</td>
                <td>₹" . number_format($product['product_price'], 2) . "</td>
                <td>₹" . number_format($total, 2) . "</td>
              </tr>";
    }

    echo '</tbody>
          <tfoot>
              <tr>
                  <th colspan="3" class="text-end">Grand Total:</th>
                  <th>₹' . number_format($grandTotal, 2) . '</th>
              </tr>
          </tfoot>
      </table>';
} else {
    echo '<p class="text-center">Your cart is empty.</p>';
}
?>
