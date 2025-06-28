<?php
    $tasks = getTasks();
?>
<div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Tasks</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php 
                                            if(count($tasks)){ ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Employed Name</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Title</th>
                                                            <th class="text-center">Description</th>
                                                            <th class="text-center">Due Date</th>
                                                            <th class="text-center">Issued by</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Priority</th>
                                                            <th class="text-center">Image</th>
                                                            <th class="text-center">Created At</th>

                                                            <th class="text-center">Edit</th>
                                                            <th class="text-center">Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php 
                                                        foreach ($tasks as $i => $t) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $i + 1 ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($t->name) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($t->firstname) . " " . htmlspecialchars($t->lastname) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($t->email) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($t->title) ?></td>
                                                            <td class="text-center">
                                                                <details style="max-width: 400px;">
                                                                    <summary>Show description</summary>
                                                                    <p>
                                                                        <?= htmlspecialchars($t->description) ?>
                                                                    </p>
                                                                </details>
                                                            </td>
                                                            <td class="text-center"><?= htmlspecialchars($t->due_date) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars(findUserById($t->issued_by)->firstname) . " " . htmlspecialchars(findUserById($t->issued_by)->lastname) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($t->id_status) ?></td>
                                                            <td class="text-center"><?= htmlspecialchars($t->priority) ?></td>

                                                            <td class="text-center">
                                                                <?php
                                                                    if (!empty($t->image)) { ?>
                                                                        <a href="<?= htmlspecialchars($t->image); ?>"><img width="100px" src="<?= htmlspecialchars($t->image); ?>" alt="<?= htmlspecialchars($t->image); ?>"></a>
                                                                    <?php }  else {
                                                                        echo '/';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="text-center"><?= htmlspecialchars($t->created_at) ?></td>

                                                            <td class="text-center">
                                                                <a href="index.php?page=admin&adminPage=editTask&id=<?=$t->id_task?>">
                                                                    <div class="btn btn-success">Edit</div>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <form action="models/deleteTask.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this task ?')">
                                                                    <input type="hidden" name="id_task" value="<?= $t->id_task ?>">
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </td>

                                                        </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                        
                                                    
                                                    </tbody>
                                                </table>
                                            <?php } 
                                            else { ?>
                                            <div class="alert alert-warning" role="alert">There are no tasks yet, add a new one.</div>
                                            <?php } ?>
                                       
                                        <?php if (isset($_SESSION['error'])): ?>
                                                <div class="alert alert-danger">
                                                    <?= htmlspecialchars($_SESSION['error']) ?>
                                                </div>
                                        <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>
                                        <a href="?page=admin&adminPage=addTask"><div class="btn btn-primary">Add new</div></a>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>