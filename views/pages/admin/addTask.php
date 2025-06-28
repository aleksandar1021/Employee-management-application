<?php
    $old = $_SESSION['old'] ?? [];
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['old'], $_SESSION['errors']);
?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">Add new task</div>
            <div class="card-body">

                <form method="POST" action="models/addTask.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Employed</label>
                        <select name="employed" class="form-select">
                            <option hidden value="">Select employed</option>
                            <?php foreach(getEmployed() as $s): ?>
                                <option value="<?= $s['id_user'] ?>" <?= (old('employed') == $s['id_user'] ? 'selected' : '') ?>>
                                    <?= $s['firstname'] . " " . $s['lastname'] . " - " . $s['email'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('employed') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
                        <?= error('title') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($old['description'] ?? '') ?>">
                        <?= error('description') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Due</label>
                        <input type="date" name="date_due" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= old('date_due') ?>">
                        <?= error('date_due') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option hidden value="">Select status</option>
                            <option value="It has not started" <?= old('status') == 'It has not started' ? 'selected' : '' ?>>It has not started</option>
                            <option value="It has begun" <?= old('status') == 'It has begun' ? 'selected' : '' ?>>It has begun</option>
                            <option value="Done" <?= old('status') == 'Done' ? 'selected' : '' ?>>Done</option>
                        </select>
                        <?= error('status') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option hidden value="">Select priority</option>
                            <option value="Low" <?= old('priority') == 'Low' ? 'selected' : '' ?>>Low</option>
                            <option value="Normal" <?= old('priority') == 'Normal' ? 'selected' : '' ?>>Normal</option>
                            <option value="High" <?= old('priority') == 'High' ? 'selected' : '' ?>>High</option>
                            <option value="Critical" <?= old('priority') == 'Critical' ? 'selected' : '' ?>>Critical</option>
                        </select>
                        <?= error('priority') ?>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                        <?= error('image') ?>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger"><?= $errors['general'] ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Add Task">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
