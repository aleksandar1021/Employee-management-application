<?php
    $old = $_SESSION['old'] ?? [];
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['old'], $_SESSION['errors']);
?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">Add new employment status</div>
            <div class="card-body">
                
                <form method="POST" action="models/addEmploymentStatus.php">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                        <?php if (isset($errors['name'])): ?>
                            <div class="text-danger"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger"><?= $errors['general'] ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Add Position">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
