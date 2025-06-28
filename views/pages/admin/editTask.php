<?php
    $old = $_SESSION['old'] ?? [];
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['old'], $_SESSION['errors']);

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error'] = "Invalid task ID.";
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    }

    $taskId = $_GET['id'];
    $task = getTaskById($taskId);

    if (!$task) {
        $_SESSION['error'] = "Task not found.";
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    }

    $selectedEmployed   = $old['employed']    ?? $task->id_user;
    $selectedTitle      = $old['title']       ?? $task->title;
    $selectedDesc       = $old['description'] ?? $task->description;
    $selectedDueDate    = $old['date_due']    ?? $task->due_date;
    $selectedStatus     = $old['status']      ?? $task->id_status;
    $selectedPriority   = $old['priority']    ?? $task->priority;
?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">Edit Task</div>
            <div class="card-body">

                <form method="POST" action="models/editTask.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_task" value="<?= htmlspecialchars($task->id_task) ?>">

                    <div class="mb-3">
                        <label class="form-label">Employed</label>
                        <select name="employed" class="form-select">
                            <option hidden value="">Select employed</option>
                            <?php foreach(getEmployed() as $s): ?>
                                <option value="<?= $s['id_user'] ?>" <?= $selectedEmployed == $s['id_user'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['firstname'] . " " . $s['lastname'] . " - " . $s['email']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('employed') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="<?= htmlspecialchars($selectedTitle) ?>">
                        <?= error('title') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control"
                               value="<?= htmlspecialchars($selectedDesc) ?>">
                        <?= error('description') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Due</label>
                        <input type="date" name="date_due" class="form-control"
                               min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($selectedDueDate) ?>">
                        <?= error('date_due') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option hidden value="">Select status</option>
                            <?php foreach (["It has not started", "It has begun", "Done"] as $status): ?>
                                <option value="<?= $status ?>" <?= $selectedStatus === $status ? 'selected' : '' ?>>
                                    <?= $status ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('status') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option hidden value="">Select priority</option>
                            <?php foreach (["Low", "Normal", "High", "Critical"] as $p): ?>
                                <option value="<?= $p ?>" <?= $selectedPriority === $p ? 'selected' : '' ?>>
                                    <?= $p ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('priority') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image (optional)</label>
                        <input type="file" name="image" class="form-control">
                        <?= error('image') ?>
                        <?php if (!empty($task->image)): ?>
                            <div class="mt-2">
                                <img width="300px" src="<?= htmlspecialchars($task->image) ?>" width="100px" alt="Task Image">
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger"><?= $errors['general'] ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Update Task">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
