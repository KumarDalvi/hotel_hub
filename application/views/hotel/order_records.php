<form method="GET" class="mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <input type="text" name="search_order_id" class="form-control w-auto" placeholder="🔍 Order No" 
               value="<?= isset($_GET['search_order_id']) ? $_GET['search_order_id'] : '' ?>">

        <input type="date" name="search_date" class="form-control w-auto" 
               value="<?= isset($_GET['search_date']) ? $_GET['search_date'] : '' ?>">

        <input type="text" name="search_table" class="form-control w-auto" placeholder="🪑 Table No" 
               value="<?= isset($_GET['search_table']) ? $_GET['search_table'] : '' ?>">

        <select name="search_status" class="form-control w-auto">
            <option value="">📌 Select Status</option>
            <option value="complete" <?= isset($_GET['search_status']) && $_GET['search_status'] == 'complete' ? 'selected' : '' ?>>Complete</option>
            <option value="cancel" <?= isset($_GET['search_status']) && $_GET['search_status'] == 'cancel' ? 'selected' : '' ?>>Cancel</option>
        </select>

        <button type="submit" class="btn btn-success">🔍 Search</button>
        <a href="<?= base_url('hotel/order_records') ?>" class="btn btn-danger">❌ Reset</a>
          <a href="<?= base_url('hotel/export_order_records') ?>" class="btn btn-primary">📥 Export to Excel</a>

    </div>
</form>




<div class="table-responsive">
    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th style="width: 150px;" class="text-wrap">🆔 Order No</th>
                <th style="width: 100px;" class="text-wrap">🪑 Table</th>
                <th>🗓️ Date</th>
                <th>⏰ Time</th>
                <th>📌 Status</th>
                
                <th>💰 Grand Total</th>
                <th>🖨️ Print Bill</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_info as $row): ?>
                <?php 
                    $order_id = $row['order_id'];
                    $hotel_id = $row['hotel_id'];
                    $sql = "SELECT * FROM products, order_products 
                            WHERE order_products.order_id = {$order_id} 
                            AND products.product_id = order_products.product_id
                            AND order_products.hotel_id = '{$hotel_id}' 
                            AND products.hotel_id = '{$hotel_id}'"; 
                    $order_products = $this->db->query($sql)->result_array();
                    
                    $grand_total = 0;
                    $order_status = strtolower($row['order_status']); // Normalize status
                ?>
                <tr>
                    <td class="fw-bold text-wrap" style="width: 150px;"><?= $row['order_id']; ?></td>
                    <td style="width: 100px;" class="text-wrap">
                        <?php 
                            $tbl_sql = "SELECT table_no FROM hotel_table WHERE hotel_table_id = ".$row['hotel_table_id'];
                            $query = $this->db->query($tbl_sql); 
                            $table = $query->row_array();
                            echo isset($table['table_no']) ? $table['table_no'] : "N/A"; 
                        ?>
                    </td>
                    <td><?= date("d M Y", strtotime($row['order_date'])); ?></td>
                    <td><?= date("h:i A", strtotime($row['order_time'])); ?></td>
                    <td>
                        <span class="badge bg-<?= ($order_status == 'complete') ? 'success' : (($order_status == 'cancel') ? 'danger' : 'warning'); ?>">
                            <?= ucfirst($order_status); ?>
                        </span>
                    </td>
                   <?php if (!empty($order_products)): ?>
                                <?php foreach ($order_products as $product): ?>
                                    <?php 
                                        $item_total = $product['qty'] * $product['product_price'];
                                        $grand_total += $item_total;
                                    ?>
                                   
                                <?php endforeach; ?>
                            <?php else: ?>
                                
                            <?php endif; ?>
                    <td class="fw-bold <?= ($order_status == 'cancel') ? 'text-danger' : 'text-success'; ?>">
                        <?= ($order_status == 'cancel') ? '<del>₹ ' . number_format($grand_total, 2) . '</del>' : '₹ ' . number_format($grand_total, 2); ?>
                    </td>
                    <td>
                        <a href="<?= base_url() ?>hotel/order_details/<?= $order_id ?>" class="btn btn-primary btn-sm">
                            🖨️ Print
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
