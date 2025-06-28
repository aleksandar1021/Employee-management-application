<?php
    isLoggedUser();
    $user = getUser();
    $user = getUser(); 
    $imageToShow = $user->user_image != 'avatar.jpg' ? $user->user_image : "assets/images/users/avatar.jpg";
    
?>
<div id="statisticContainer">
    <h1>Statistic for tasks</h1>
    <div id="statistic">
        <p><span>On hold: </span><?= getStatisticForTasks('It has not started') ?></p>&nbsp;&nbsp;
        <p><span>In progress: </span><?= getStatisticForTasks('It has begun') ?></p>&nbsp;&nbsp;
        <p><span>Finished: </span><?= getStatisticForTasks('Done') ?></p>
    </div>
</div>

<form class="form" method="POST" action="models/userEditSelf.php" autocomplete="off" enctype="multipart/form-data">
    <div class="control">  
        <h1>Edit your account</h1>
    </div>

    <div class="control block-cube block-input">
        <input name="password" id="password" type="password" placeholder="Password" />
        <div class="bg-top"><div class="bg-inner"></div></div>
        <div class="bg-right"><div class="bg-inner"></div></div>
        <div class="bg"><div class="bg-inner"></div></div>
    </div>

    <div class="control block-cube block-input">
        <input name="rePassword" id="rePassword" type="password" placeholder="Retype Password" />
        <div class="bg-top"><div class="bg-inner"></div></div>
        <div class="bg-right"><div class="bg-inner"></div></div>
        <div class="bg"><div class="bg-inner"></div></div>
    </div>

    <br>

    <img class="imageUser" width="200px" src="<?= htmlspecialchars($imageToShow) ?>" alt="user image" />

    <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="file" name="image" id="image">

    <br><br><br><br>

    <button class="btn block-cube block-cube-hover" type="submit" id="set">
        <div class="bg-top"><div class="bg-inner"></div></div>
        <div class="bg-right"><div class="bg-inner"></div></div>
        <div class="bg"><div class="bg-inner"></div></div>
        <div class="text">Save</div>
    </button>
    <br><br>
    <span id="loginErrors">
        <?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0): ?>
            <div class="alert alert-danger">
            <ul style="list-style-type: none;">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div style="color: green;">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
        <?php unset($_SESSION['success']); endif; ?>    
    </span>
</form>
