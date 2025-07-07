<div class="modal fade" id="addFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">טופס הוספת נתונים</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="POST" action="add.php">
                    <div class="row g-2">
                        <?php foreach ($fields as $name => $label): ?>
                            <div class="col-md-6">
                                <label class="form-label"><?= $label ?></label>
                                <input type="text" name="<?= $name ?>" class="form-control" <?= $name === 'last_name' ? 'required' : '' ?>>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-success">הוסף</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
