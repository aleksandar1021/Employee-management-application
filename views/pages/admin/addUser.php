<?php

    $old = $_SESSION['old'] ?? [];
    $errors = $_SESSION['errors'] ?? [];

    unset($_SESSION['old'], $_SESSION['errors']);
?>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">Add new employed</div>
            <div class="card-body">
                
                <form method="POST" action="models/addUser.php">
                    <div class="mb-3">
                        <label class="form-label">Firstname</label>
                        <input type="text" name="firstname" class="form-control" value="<?= old('firstname') ?>">
                        <?= error('firstname') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lastname</label>
                        <input type="text" name="lastname" class="form-control" value="<?= old('lastname') ?>">
                        <?= error('lastname') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">JMBG</label>
                        <input type="text" name="jmbg" class="form-control" value="<?= old('jmbg') ?>">
                        <?= error('jmbg') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="<?= old('email') ?>">
                        <?= error('email') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="pwd" class="form-control" value="<?= old('pwd') ?>">
                        <?= error('pwd') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?= old('address') ?>">
                        <?= error('address') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <select name="position" class="form-select">
                            <option hidden value="0">Select position</option>
                            <?php foreach(getPositions() as $p): ?>
                                <option value="<?= $p->id_role ?>" <?= (old('position') == $p->id_role ? 'selected' : '') ?>>
                                    <?= $p->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('position') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Employment Date</label>
                        <input type="date" name="employment_date" class="form-control" value="<?= old('employment_date') ?>">
                        <?= error('employment_date') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Supervisor</label>
                        <select name="supervisor" class="form-select">
                            <option hidden value="0">Select supervisor</option>
                            <?php foreach(getEmployed() as $s): ?>
                                <option value="<?= $s['id_user'] ?>" <?= (old('supervisor') == $s['id_user'] ? 'selected' : '') ?>>
                                    <?= $s['firstname'] . " " . $s['lastname'] . " - " . $s['email'] ?>
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
                                <option value="<?= $t->id_employment_status ?>" <?= (old('employment_status') == $t->id_employment_status ? 'selected' : '') ?>>
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
                        <input type="submit" class="btn btn-primary" value="Add user">
                    </div>
                </form>
</div>
        </div>
    </div>
