<!DOCTYPE html>
<html>
<head>
    <title>History Stock</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body class="container mt-4">
    <h2 class="mb-3">History Stock</h2>

    <table class="table table-bordered table-striped" id="historyTable">
        <thead>
            <tr>
                <th>Code Item</th>
                <th>Item Name</th>
                <th>Type</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
            <tr>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Code Item"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Item Name"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Type"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Category"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Qty"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari User"></th>
                <th><input type="text" class="form-control form-control-sm column-search" placeholder="Cari Tanggal"></th>
            </tr>
        </thead>
    </table>

<script>
$(document).ready(function() {
    var table = $('#historyTable').DataTable({
        "processing": true,
        "serverSide": false,
        "pageLength": 10,
        "orderCellsTop": true,
        "fixedHeader": true,
        "ajax": {
            "url": "<?= site_url('history_stock/get_history') ?>",
            "type": "POST"
        },
    });

    // filter per kolom
    $('#historyTable thead tr:eq(1) th').each(function (i) {
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
