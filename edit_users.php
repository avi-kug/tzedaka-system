<form method="post" action="update_user_permissions.php">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <?php foreach ($all_pages as $page): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   name="permissions[]"
                   value="<?= $page['id'] ?>"
                   <?= in_array($page['id'], $user_permissions) ? 'checked' : '' ?>>
            <label class="form-check-label"><?= htmlspecialchars($page['name']) ?></label>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-success mt-3">שמור</button>
</form>
