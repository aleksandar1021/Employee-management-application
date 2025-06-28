<?php
    $messages = getMessages(); 
?>
<div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Messages from users</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <?php 
                                            if(count($messages)){ ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-center">User Name</th>
                                                    <th class="text-center">Title</th>
                                                    <th class="text-center">Message</th>

                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                foreach ($messages as $i => $m) {
                                            ?>
                                                <tr>
                                                    <td><?= $i + 1 ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($m->firstname . " " . $m->lastname) ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($m->title) ?></td>
                                                    <td class="text-center">
                                                        <details style="max-width: 400px;">
                                                            <summary>Show message</summary>
                                                            <p>
                                                                <?= htmlspecialchars($m->message) ?>
                                                            </p>
                                                        </details>
                                                    </td>
                                                 
                                                    <td class="text-center">
                                                        <form action="models/deleteMessage.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this message ?')">
                                                            <input type="hidden" name="id_contact" value="<?= $m->id_contact ?>">
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
                                            <div class="alert alert-warning" role="alert">There are no messages yet.</div>
                                            <?php } ?>
                                        <?php if (isset($_SESSION['error'])): ?>
                                                <div class="alert alert-danger">
                                                    <?= htmlspecialchars($_SESSION['error']) ?>
                                                </div>
                                        <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>
                                        <a href="?page=admin&adminPage=addPosition"><div class="btn btn-primary">Add new</div></a>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>