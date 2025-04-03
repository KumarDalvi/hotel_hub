<form action="<?=base_url()?>hotel/save_table" method="post">
    <div class="container p-4 bg-white shadow rounded">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3 class="text-primary">Add New Table</h3>
            </div>
            <div class="col-md-10">
                <label class="fw-bold">Enter Table No.</label>
                <input type="text" name="table_no" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-success w-100">Save Table</button>
            </div>
        </div>
    </div>
</form>

<div class="container p-4 bg-white mt-4 shadow rounded">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h3 class="text-primary">Table List</h3>
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        
                        <th>Sr. No.</th>
                        <th>Table No.</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tables as $key => $row) : ?>
                        <tr>
                            
                            <td><?=$key+1?></td>
                            <td><?=$row['table_no']?></td>
                            
                            <td >
                             <button class="btn btn-outline-primary btn-sm me-1" onclick="show_qr(<?=$row['hotel_table_id']?>)">Show QR</button> 
                                <a href="<?=base_url('hotel/edit_table?hotel_table_id=')?><?=$row['hotel_table_id']?>" class="btn btn-warning btn-sm me-1">Edit</a>
                                <a href="<?=base_url('hotel/delete_table?hotel_table_id=')?><?=$row['hotel_table_id']?>" 
                                   onclick="return confirm('Are you sure you want to delete this Table?')" 
                                   class="btn btn-danger btn-sm me-1">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- QR Code Overlay -->
<div id="qrOverlay">
    <div id="qrBox">
        <span id="closeQR" onclick="close_qr()">&times;</span>
        <h4>Table QR Code</h4>
        <div id="qrcode"></div>
    </div>
</div>

<style>
    /* QR Overlay Styling */
    #qrOverlay {
    display: none;  /* Hide modal by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}


    #qrBox {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        position: relative;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    #closeQR {
        position: absolute;
        top: 5px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        color: red;
    }
</style>

<script>
    function show_qr(table_id) {
        document.getElementById('qrcode').innerHTML = ""; // Clear previous QR codes

        // Get hotel_id from PHP session
        let hotel_id = "<?= $_SESSION['hotel_id']; ?>";

        // Generate QR Code with hotel_id and table_no
        new QRCode("qrcode", "<?= base_url() ?>user/index?hotel_id=" + hotel_id + "&table_no=" + table_id);

        document.getElementById('qrOverlay').style.display = "flex"; // Show modal
    }

    function close_qr() {
        document.getElementById('qrOverlay').style.display = "none"; // Hide modal
    }

    // Close Modal When Clicking Outside
    document.getElementById('qrOverlay').addEventListener("click", function (event) {
        let qrBox = document.getElementById('qrBox');
        if (!qrBox.contains(event.target)) { // If clicked outside of qrBox, close modal
            close_qr();
        }
    });
</script>
