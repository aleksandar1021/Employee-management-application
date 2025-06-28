<div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Employed </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>JMBG</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Position</th>
                                                    <th>Employment Date</th>
                                                    <th>Supervisor</th>
                                                    <th>Status</th>

                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php

                                                //var_dump(getEmployed());
                                                $employers = getEmployed(); 
                                                $filteredEmployers = array_filter($employers, function($employer) {
                                                    return $employer['email'] !== 'aleksa_kandic@yahoo.com';
                                                });
                                                foreach ($filteredEmployers as $i => $e) {
                                            ?>
                                                <tr>
                                                    <td><?= $i + 1 ?></td>
                                                    <td><?= htmlspecialchars($e['firstname']) ?></td>
                                                    <td><?= htmlspecialchars($e['lastname']) ?></td>
                                                    <td><?= htmlspecialchars($e['JMBG']) ?></td>
                                                    <td><?= htmlspecialchars($e['email']) ?></td>
                                                    <td><?= htmlspecialchars($e['address']) ?></td>
                                                    <td><?= htmlspecialchars($e['position']) ?></td>
                                                    <td><?= htmlspecialchars($e['employment_date']) ?></td>
                                                    <td>
                                                    <?php
                                                        if (!empty($e['supervisor_firstname']) && !empty($e['supervisor_lastname'])) {
                                                            echo htmlspecialchars($e['supervisor_firstname']) . " " . htmlspecialchars($e['supervisor_lastname']);
                                                        } else {
                                                            echo '/';
                                                        }
                                                    ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($e['employment_status']) ?></td>
                                                    <td>
                                                        <a href="index.php?page=admin&adminPage=editUser&id=<?=$e['id_user']?>">
                                                            <div class="btn btn-success">Edit</div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form action="models/deleteUser.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? If you delete it, its tasks will be deleted with it.')">
                                                            <input type="hidden" name="id_user" value="<?= $e['id_user'] ?>">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            <?php
                                                }
                                            ?>
                                                
                                               
                                            </tbody>
                                        </table>
                                        <a href="?page=admin&adminPage=addUser"><div class="btn btn-primary">Add new</div></a>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>