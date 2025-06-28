<div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Employment status</h3>
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
                                                    <th class="text-center">Name</th>
                                                    

                                                    <th class="text-center">Edit</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                $status = getEmploymentTypes(); 
                                                foreach ($status as $i => $p) {
                                            ?>
                                                <tr>
                                                    <td><?= $i + 1 ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($p->name) ?></td>
                                                    
                                                    <td class="text-center">
                                                        <a href="index.php?page=admin&adminPage=editEmploymentStatus&id=<?=$p->id_employment_status?>">
                                                            <div class="btn btn-success">Edit</div>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="models/deleteEmploymentStatus.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this status ?')">
                                                            <input type="hidden" name="id_status" value="<?= $p->id_employment_status ?>">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            <?php
                                                }
                                            ?>
                                                
                                               
                                            </tbody>
                                        </table>
                                        <?php if (isset($_SESSION['error'])): ?>
                                                <div class="alert alert-danger">
                                                    <?= htmlspecialchars($_SESSION['error']) ?>
                                                </div>
                                        <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>
                                        <a href="?page=admin&adminPage=addEmploymentStatus"><div class="btn btn-primary">Add new</div></a>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>