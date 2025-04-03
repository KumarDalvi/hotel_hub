<?php  $hotel_tbl = $this->My_model->select_where("hotel_table", ["hotel_table_id" => $order_info['hotel_table_id']]);    ?>

<style type="text/css">
@media print {
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background: white !important;
        -webkit-print-color-adjust: exact;
    }

    #bill {
        width: 100%;
        max-width: 80mm; /* ✅ Ensure it fits thermal printers */
        font-size: 11px;
        padding: 8px;
        background: white !important;
        border: none;
        text-align: center;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 4px;
        font-size: 10px;
        border-bottom: 1px dashed black;
        text-align: left;
        white-space: nowrap; /* ✅ Prevents wrapping */
    }

    .table td:first-child { 
        width: 10%; /* ✅ Sr. No. column */
        text-align: center;
    }

    .table td:nth-child(2) {
        width: 50%; /* ✅ Product Name */
        text-align: left;
        white-space: nowrap; /* ✅ Keeps name on one line */
        overflow: hidden;
        text-overflow: ellipsis; /* ✅ Adds "..." if too long */
    }

    .table td:nth-child(3), 
    .table td:nth-child(4) {
        width: 15%; /* ✅ Price and Qty */
        text-align: center;
    }

    .table td:last-child {
        width: 15%; /* ✅ Total */
        text-align: right;
        font-weight: bold;
    }

    .order-info {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
    }

    .thank-you {
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        margin-top: 10px;
    }

    @page {
        size: auto;
        margin: 0;
    }
}

}

}

/* ✅ Specific Fixes for 58mm Thermal Printers */
@media print and (max-width: 58mm) {
    #bill {
        max-width: 58mm;
        font-size: 11px; /* ✅ Slightly larger for better visibility */
        padding: 2px;
    }
    .table td, .table th {
        font-size: 9px; /* ✅ Adjust font size to fit 58mm width */
        border: none; /* ✅ Thermal printers don't need borders */
        padding: 2px 0;
    }
    .table td:last-child, .table th:last-child {
        text-align: right;
    }
}
</style>



<div class="container my-3">
    <div class="card p-2 shadow receipt" id="bill">
        <h4 class="text-center"> <strong><?= isset($_SESSION['hotel_name']) ? $_SESSION['hotel_name'] : 'Hotel' ?></strong> | Order Details</h4>
         
            <p style="text-align: center; margin-top: 0;"><strong><?=$hotel_details[0]['hotel_address']?>, <?=$hotel_details[0]['hotel_mobile']?></strong></p>
        <hr>

       <div class="order-info">
       <span class="me-2"><strong>🆔 Order No:</strong> <?=$order_info['order_id']?></span>
    <span class="me-2"><strong>🪑 Table:</strong> <?=$hotel_tbl[0]['table_no']?></span>
    <span class="me-2"><strong>🗓️ Date:</strong> <?=$order_info['order_date']?></span>
    <span class="me-2"><strong>⏰ Time:</strong> <?=$order_info['order_time']?></span>
    <span class="me-2"><strong>📌 Status:</strong> <span class="status-badge"><?=$order_info['order_status']?></span></span>
</div>


        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>₹</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
               <?php
                $ttl=0;
                
                
                
                foreach($order_products as $key => $row)
                    {
                        $ttl += $row['total'];
               ?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$row['product_name']?></td>
                    <td><?=number_format($row['product_price'])?></td>
                    <td><?=$row['qty']?></td>
                    <td><strong><?=number_format($row['total'])?></strong></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
            <tfoot>
                <tr style="background: #f8f9fa;">
                    <td colspan="4" class="text-end"><strong>💰 Grand Total:</strong></td>
                    <td><strong>₹ <?=number_format($ttl)?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <button class="btn btn-primary print-btn mt-2" onclick="printBill()">🖨️ Print Details</button> <!-- ✅ Hidden in Print Mode -->
</div>


<script>
function printBill() {
    let rows = document.querySelectorAll("tbody tr");
    let productMap = {}; // To store grouped data

    rows.forEach(row => {
        let cells = row.children;
        let productName = cells[1].innerText.trim();
        let price = parseFloat(cells[2].innerText.replace(/,/g, ''));
        let qty = parseInt(cells[3].innerText);
        let total = parseFloat(cells[4].innerText.replace(/,/g, ''));

        if (productMap[productName]) {
            productMap[productName].qty += qty;
            productMap[productName].total += total;
        } else {
            productMap[productName] = { price, qty, total };
        }
    });

    let groupedHTML = "";
    let grandTotal = 0;
    let index = 1;

    for (let product in productMap) {
        let { price, qty, total } = productMap[product];
        grandTotal += total;
        groupedHTML += `
            <tr>
                <td style="text-align: center;">${index++}</td>
                <td>${product}</td>
                <td style="text-align: right;">₹ ${price.toLocaleString()}</td>
                <td style="text-align: center;">${qty}</td>
                <td style="text-align: right;"><strong>₹ ${total.toLocaleString()}</strong></td>
            </tr>`;
    }

    // Order details
    let orderID = "<?= $order_info['order_id'] ?>";
    let orderDate = "<?= date('d-M-Y', strtotime($order_info['order_date'])) ?>";
    let orderTime = "<?= date('h:i A', strtotime($order_info['order_time'])) ?>";
    let orderStatus = "<?= ucfirst($order_info['order_status']) ?>";
    let hotel_tbl_no = "<?= ucfirst($hotel_tbl[0]['table_no']) ?>";
    

    // Hotel details
    let hotelName = "<?= $hotel_details[0]['hotel_name'] ?>";
    let hotelAddress = "<?= $hotel_details[0]['hotel_address'] ?>";
    let hotelMobile = "<?= $hotel_details[0]['hotel_mobile'] ?>";

    let billContent = `
        <div id="bill" style="width: 100%; margin: auto; font-family: Arial, sans-serif; padding: 20px;">
            <h2 style="text-align: center; margin-bottom: 5px;">${hotelName}</h2>
            <p style="text-align: center; margin-top: 0;"><strong>${hotelAddress}, ${hotelMobile}</strong></p>
            <hr style="border: 1px solid black;">

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td><strong>Order ID:</strong> #${orderID}</td>
                    <td style="text-align: right;"><strong>Date:</strong> ${orderDate}</td>
                </tr>
                <tr>
                    <td><strong>Time:</strong> ${orderTime}</td>
                    <td style="text-align: right;"><strong>Status:</strong> ${orderStatus}</td>
                </tr>
                <tr>
                <td><strong>Table:</strong> ${hotel_tbl_no}</td>
                
                </tr>
                
            </table>

            <hr style="border: 1px solid black;">

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid black;">
                        <th style="text-align: center; width: 5%;">#</th>
                        <th style="text-align: left; width: 45%;">Product</th>
                        <th style="text-align: right; width: 15%;">Price</th>
                        <th style="text-align: center; width: 10%;">Qty</th>
                        <th style="text-align: right; width: 25%;">Total</th>
                    </tr>
                </thead>
                <tbody>${groupedHTML}</tbody>
                <tfoot>
                    <tr style="border-top: 2px solid black;">
                        <td colspan="4" style="text-align: right; padding: 8px;"><strong>Grand Total:</strong></td>
                        <td style="text-align: right;"><strong>₹ ${grandTotal.toLocaleString()}</strong></td>
                    </tr>
                </tfoot>
            </table>

            <hr style="border: 1px solid black;">

            <p style="text-align: center; font-size: 18px;"><strong>🙏 Thank you for dining with us! We hope to see you again soon! 🎉</strong></p>
        </div>`;

    let originalContent = document.body.innerHTML;
    document.body.innerHTML = billContent;
    window.print();
    document.body.innerHTML = originalContent;
}

</script>

