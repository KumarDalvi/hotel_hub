
<div class="container p-4 bg-white mt-3 shadow rounded">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h3 class="fw-bold text-primary">✏️ Edit Table</h3>
            
            <form action="<?= base_url() ?>hotel/update_table" method="post" class="mt-3">
                <input type="hidden" name="hotel_table_id" value="<?= $tbl_data[0]['hotel_table_id'] ?>">

                <div class="mb-3">
                    <label for="table_no" class="form-label fw-bold">Category Name</label>
                    <input type="text" id="table_no" name="table_no" value="<?= $tbl_data[0]['table_no'] ?>" 
                        class="form-control border rounded" required>
                </div>
                <input type="hidden" name="hotel_id" value="<?= $tbl_data[0]['hotel_id'] ?>">
                <button type="submit" class="btn btn-primary px-4">
                    💾 Update
                </button>
            </form>
        </div>
    </div>
</div>
