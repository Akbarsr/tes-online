<!DOCTYPE html>
<html>
<head>
    <title>Form Stock Out</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="mb-3"><?= $button ?> </h2>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('stockout/store') ?>" class="row g-3 mb-4">
        <div class="mb-3">
            <label>Category</label>
            <select id="category" name="category" class="form-control" required>
                <option value="">Pilih Category</option>
                <?php foreach($items as $i): ?>
                    <option value="<?= $i->category ?>"><?= $i->category ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Code Item</label>
            <select id="code_item" name="code_item" class="form-control" required>
                <option value="">Pilih Code</option>
                <?php foreach($items as $i): ?>
                    <option value="<?= $i->code_item ?>" data-category="<?= $i->category ?>" data-name="<?= $i->item_name ?>">
                        <?= $i->code_item ?> - <?= $i->item_name ?> (Stok: <?= $i->stock ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Item Name</label>
            <input type="text" id="item_name" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Qty Out</label>
            <input type="number" name="qty_out" class="form-control" min="1" required>
        </div>

        <div class="mb-3 align-self-end">
            <button type="submit" class="btn btn-primary">Kurangi</button>
            <a href="<?= site_url('stockout') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    <script>
        const categorySelect = document.getElementById('category');
        const codeItemSelect = document.getElementById('code_item');
        const itemNameInput = document.getElementById('item_name');

        // Filter code item berdasarkan category
        categorySelect.addEventListener('change', function() {
            const category = this.value;
            for (let option of codeItemSelect.options) {
                if (option.value === "") continue;
                option.style.display = option.getAttribute('data-category') === category ? 'block' : 'none';
            }
            codeItemSelect.value = "";
            itemNameInput.value = "";
        });

        // Auto isi item name dari code item
        codeItemSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            itemNameInput.value = selected.getAttribute('data-name') || '';
        });
    </script>
</body>
</html>
