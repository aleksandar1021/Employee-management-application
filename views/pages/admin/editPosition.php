<?php
    $old = $_SESSION['old'] ?? [];
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['old'], $_SESSION['errors']);

    $position = null;

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo '<div class="alert alert-danger">Invalid position ID.</div>';
        return;
    }

    $id = (int)$_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM role WHERE id_role = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $position = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$position) {
        echo '<div class="alert alert-danger">Position not found.</div>';
        return;
    }

    $nameValue = $old['name'] ?? $position['name'];
?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">Edit Position</div>
            <div class="card-body">

                <form method="POST" action="models/editPosition.php">
                    <input type="hidden" name="id_position" value="<?= htmlspecialchars($position['id_role']) ?>">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($nameValue) ?>">
                        <?php if (isset($errors['name'])): ?>
                            <div class="text-danger"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger"><?= $errors['general'] ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
