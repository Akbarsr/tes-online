<!DOCTYPE html>
<html>
<head>
    <title>Inventory Items</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body class="container mt-4">
    <h2 class="mb-3">Daftar Barang</h2>
    <a href="<?= site_url('items/create') ?>" class="btn btn-primary mb-3">+ Add Item</a>

    <table class="table table-bordered table-striped" id="itemsTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Code Item</th>
                <th>Category</th>
                <th>Item Name</th>
                <th>Stock</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <tr>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari No"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Code Item"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Category"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Item Name"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Stock"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari User"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Tanggal"></th>
                <th></th> <!-- action tidak perlu filter -->
            </tr>
        </thead>
    </table>

<script>
$(document).ready(function() {
    var table = $('#itemsTable').DataTable({
    "processing": true,
    "serverSide": false,
    "pageLength": 10,
    "orderCellsTop": true,
    "fixedHeader": true,
        "ajax": {
            "url": "<?= site_url('items/get_items') ?>",
            "type": "POST"
        },
    });

    // apply search per kolom
    $('#itemsTable thead tr:eq(1) th').each(function (i) {
        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });
});
</script>
</body>
</html>
