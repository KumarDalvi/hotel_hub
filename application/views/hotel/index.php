<style>
@media (min-width: 1024px) and (max-width: 1440px) {
    .tbl_body {
        height: 180px !important; 
    }
   
}

</style>
<div class="text-end mb-3">
    <button id="refreshBtn" class="btn btn-primary">
        🔄 Refresh
    </button>
</div>
<div class="container">
    <div class="row">
        <?php foreach ($tables as $row):
            $hotel_id = $_SESSION['hotel_id'];
            $sql = "SELECT *, (SELECT SUM(total) FROM order_products WHERE order_products.order_id = order_tbl.order_id) AS ttl 
                    FROM order_tbl 
                    WHERE order_status = 'active' 
                    AND hotel_table_id = '" . $row['hotel_table_id'] . "' 
                    AND hotel_id = '" . $hotel_id . "';";

            $orders = $this->db->query($sql)->result_array();
            $hasActiveOrder = isset($orders[0]['ttl']);
        ?>


            <div class="col-md-3 mb-4">
                <div class="tbl_body bg-white p-3 shadow-sm rounded text-center border 
                    <?= $hasActiveOrder ? 'border-success shadow-lg' : 'border-muted' ?>">
                    <h5 class="fw-bold text-primary">Table<span class="text-secondary"> : <?= $row['table_no'] ?></span></h5>
                    <hr>

                    <?php if ($hasActiveOrder): ?>
                        <h4 class="text-success fw-bold">&#8377; <?= number_format($orders[0]['ttl']) ?></h4>

                        <!-- Button Container -->
                        <div class="d-flex justify-content-center flex-wrap mt-3 gap-1">
                            <a href="<?= base_url() ?>hotel/order_details/<?= $orders[0]['order_id'] ?>" 
                               class="btn btn-sm btn-outline-primary">
                                📜 View Details
                            </a>
                            <a href="<?= base_url() ?>hotel/payment_qr/<?= $orders[0]['order_id'] ?>" 
                               class="btn btn-sm btn-outline-success">
                                💰 Pay Bill
                            </a>
                            <a href="<?= base_url() ?>hotel/close_order/<?= $orders[0]['order_id'] ?>" 
                               class="btn btn-sm btn-outline-warning">
                                🚪 Close Order
                            </a>
                            <a href="<?= base_url() ?>hotel/cancel_order/<?= $orders[0]['order_id'] ?>" 
                               class="btn btn-sm btn-outline-danger">
                                ❌ Cancel
                            </a>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mt-2 fw-semibold">🚫 No Active Order</p>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>

<!-- Load Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<!-- Sales Chart -->
<canvas id="salesChart" style="width:90%;" class="mt-4 shadow-lg p-3 mb-5 bg-body-tertiary rounded bg-white"></canvas>

<script>
    var ctx = document.getElementById("salesChart").getContext("2d");
    var salesChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: [<?= "'" . implode("', '", $x_axis) . "'" ?>],
            datasets: [{
                label: "Sales (₹)",
                backgroundColor: "#007bff",
                borderColor: "#0056b3",
                borderWidth: 1,
                data: [<?= implode(", ", $y_axis) ?>]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: "📊 Last 7 Days Sales: ₹ <?= number_format(array_sum($y_axis)) ?>",
                    font: { size: 18, weight: "bold", family: "Arial" },
                    color: "#333"
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { font: { size: 14, family: "Arial" }, color: "#555" }
                }
            }
        }
    });
</script>
<script>
    document.getElementById("refreshBtn").addEventListener("click", function() {
        this.innerHTML = "Refreshing... 🔄";
        setTimeout(() => {
            location.reload();
        }, 500); // Small delay for effect
    });
</script>

