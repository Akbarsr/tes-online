<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'Inventory System' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar p-3 border-end">
            <h4>Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="<?= site_url('items') ?>" class="nav-link">📦 Items</a></li>
                <li class="nav-item"><a href="<?= site_url('stockin') ?>" class="nav-link">⬆ Stock In</a></li>
                <li class="nav-item"><a href="<?= site_url('stockout') ?>" class="nav-link">⬇ Stock Out</a></li>
                <li class="nav-item"><a href="<?= site_url('history_stock') ?>" class="nav-link">🕒 History Stock</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <?= $contents ?>
        </main>
    </div>
</div>
</body>
</html>
