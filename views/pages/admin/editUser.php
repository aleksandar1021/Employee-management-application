<?php
    $old = $_SESSION['old'] ?? [];
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['old'], $_SESSION['errors']);

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Invalid ID.";
        exit;
    }

    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit;
    }
?>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">Edit User</div>
            <div class="card-body">
                <form method="POST" action="models/editUser.php">
                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Firstname</label>
                        <input type="text" name="firstname" class="form-control" value="<?= old('firstname', $user['firstname']) ?>">
                        <?= error('firstname') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lastname</label>
                        <input type="text" name="lastname" class="form-control" value="<?= old('lastname', $user['lastname']) ?>">
                        <?= error('lastname') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">JMBG</label>
                        <input type="text" name="jmbg" class="form-control" value="<?= old('jmbg', $user['JMBG']) ?>">
                        <?= error('jmbg') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="<?= old('email', $user['email']) ?>">
                        <?= error('email') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?= old('address', $user['address']) ?>">
                        <?= error('address') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <select name="position" class="form-select">
                            <option hidden value="0">Select position</option>
                            <?php foreach(getPositions() as $p): ?>
                                <option value="<?= $p->id_role ?>" <?= (old('position', $user['id_role']) == $p->id_role ? 'selected' : '') ?>>
                                    <?= $p->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('position') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Employment Date</label>
                        <input type="date" name="employment_date" class="form-control" value="<?= old('employment_date', $user['employment_date']) ?>">
                        <?= error('employment_date') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Supervisor</label>
                        <select name="supervisor" class="form-select">
                            <option hidden value="-1">Select supervisor</option>
                            <option value="0">None</option>
                            <?php foreach(getEmployed() as $s): ?>
                                <option value="<?= $s['id_user'] ?>" <?= (old('supervisor', $user['supervisor_id']) == $s['id_user'] ? 'selected' : '') ?>>
                                    <?= $s['firstname'] . " " . $s['lastname'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('supervisor') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Employment Status</label>
                        <select name="employment_status" class="form-select">
                            <option hidden value="0">Select status</option>
                            <?php foreach(getEmploymentTypes() as $t): ?>
                                <option value="<?= $t->id_employment_status ?>" <?= (old('employment_status', $user['id_employment_status']) == $t->id_employment_status ? 'selected' : '') ?>>
                                    <?= $t->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('employment_status') ?>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger"><?= $errors['general'] ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" value="Update user">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
