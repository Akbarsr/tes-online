<!DOCTYPE html>
<html>
<head>
    <title>Form Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="mb-3"><?= $button ?> </h2>

    <?php if(!empty($errors)) echo $errors; ?>

    <form action="<?= $action ?>" method="post">
        <div class="mb-3">
            <label>No</label>
            <input type="text" class="form-control" name="no" value="<?= $no ?>" readonly>
        </div>
        <div class="mb-3">
            <label>Code Item</label>
            <input type="text" class="form-control" name="code_item" value="<?= $code_item ?>" placeholder="misal CLT, SND, CN" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" class="form-control" name="category" value="<?= $category ?>">
        </div>
        <div class="mb-3">
            <label>Item Name</label>
            <input type="text" class="form-control" name="item_name" value="<?= $item_name ?>">
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" class="form-control" name="stock" value="<?= $stock ?>">
        </div>
        <button type="submit" class="btn btn-success"><?= $button ?></button>
        <a href="<?= site_url('items') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
