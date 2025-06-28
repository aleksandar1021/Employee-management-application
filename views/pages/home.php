<?php
    isLoggedUser();
    $tasks = getTasksByUserId();
    isFirstLogin();
?>


  <br>
  <img 
    src="<?= $_SESSION['user']->user_image != 'avatar.jpg'? $_SESSION['user']->user_image : 'assets/images/users/avatar.jpg' ?>" 
    alt="user image" 
    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;"
  >

<br>
<br>

 <h1>My Tasks</h1>
<br>
<?php 
  if(count($tasks)){ ?>
   <div class="dd-dropdown">
      <button class="dd-dropdown-button" data-filter="status">Filter by status</button>
      <div class="dd-dropdown-content">
        <a href="" data-value="It has not started">It has not started</a>
        <a href="" data-value="It has begun">It has begun</a>
        <a href="" data-value="Done">Done</a>
      </div>
    </div>

    <div class="dd-dropdown">
        <button class="dd-dropdown-button" data-filter="priority">Filter by priority</button>
        <div class="dd-dropdown-content">
          <a href="" data-value="Low">Low</a>
          <a href="" data-value="Normal">Normal</a>
          <a href="" data-value="High">High</a>
          <a href="" data-value="Critical">Critical</a>
        </div>
    </div>

    <div class="dd-dropdown">
        <button class="dd-dropdown-button" data-filter="sort">Choose sort method</button>
        <div class="dd-dropdown-content">
          <a href="" data-value="asc">Sort by date ASC</a>
          <a href="" data-value="desc">Sort by date DESC</a>
        </div>
    </div>

    <input type="text" placeholder="Search by name" class="gradient-input" id="searchInput">



  <?php } ?>



 <br>
 <br>
 <div id="taskResults"></div>

 <div id="rask-result" class="task-container">
    
  <?php 
  if(count($tasks)){
    foreach($tasks as $i => $t){ ?>
      <div class="task-card">
          <div class="task-info">
            <h3><?= $t->title ?></h3>
            <p><strong>Description:</strong> <?= $t->description ?> </p>
            <p><strong>Task name:</strong> <spam style="color:greenyellow"><?= $t->name ?></spam> </p>
            <p><strong>Priority:</strong> <?= $t->priority ?></p>
            <p><strong>Issued by:</strong> <?= findUserById($t->issued_by)->firstname . " " . findUserById($t->issued_by)->lastname?></p>
            <p><strong>Date due:</strong> <?= $t->due_date ?></p>
            <p><strong>Created at:</strong> <?= $t->date_of_create ?></p>

            <?php
              if(!empty($t->image)){ ?>
                <img width="300px" src="<?= $t->image ?>" alt="<?= $t->title ?>" class="task-image" />
              <?php } ?>
          </div>
          <div class="task-buttons">
          <input type="button" class="getToWork" value="Get to work" data-id="<?= $t->id_task ?>" <?= $t->id_status != 'It has not started'? 'disabled' : '' ?>/>
          <input type="button" class="finishTask" value="Finish task" data-id="<?= $t->id_task ?>" <?= $t->id_status == 'Done' || $t->id_status == 'It has not started'? 'disabled' : '' ?> />
          </div>
      </div>
    <?php }} else{
      echo("<br><h2 style='color:yellow'>no tasks yet</h2>");
    }?>


  </div>


  <style>
    /* body {
      background-color: #121212;
      color: white;
      font-family: 'Courier New', monospace;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    } */

    .dd-dropdown {
      position: relative;
      display: inline-block;
    }

    .dd-dropdown-button {
      background-color: #121212;
      color: white;
      padding: 12px 16px;
      font-size: 16px;
      border: 2px solid;
      border-image: linear-gradient(45deg, #00f0ff, #ff00ff) 1;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .dd-dropdown-button:hover {
      background-color: #1e1e1e;
    }

    .dd-dropdown-content {
      display: none;
      position: absolute;
      background-color: #1a1a1a;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      border: 2px solid;
      border-image: linear-gradient(45deg, #00f0ff, #ff00ff) 1;
      border-radius: 8px;
      z-index: 1;
    }

    .dd-dropdown-content a {
      color: white;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-family: 'Courier New', monospace;
    }

    .dd-dropdown-content a:hover {
      background-color: #333;
    }

    .dd-dropdown:hover .dd-dropdown-content {
      display: block;
    }
  </style>




  


  <style>
    body {
      /* background-color: #111; */
      color: #fff;
      /* font-family: 'Courier New', monospace; */
      /* padding: 20px; */
      margin: 0;
    }

    header {
      text-align: center;
      margin-bottom: 30px;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #aaa;
    }

    .task-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
      max-width: 900px;
      margin: auto;
    }

    .task-card {
      background-color: #1a1a1a;
      border: 1px solid transparent;
      border-image: linear-gradient(45deg, #00f, #f0f) 1;
      border-radius: 12px;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    .task-info {
      width: 60%;
    }

    .task-info h3 {
      margin-top: 0;
      margin-bottom: 10px;
    }

    .task-info p {
      margin: 6px 0;
    }

    .task-buttons {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .task-buttons input {
      background-color: #222;
      border: 1px solid #555;
      color: white;
      padding: 10px 16px;
      cursor: pointer;
      border-radius: 6px;
      transition: 0.3s;
      min-width: 100px;
    }

    .task-buttons input:disabled {
      background-color: #555;       
      border-color: #777;
      color: #ccc;
      cursor: not-allowed;
      opacity: 0.6;                 
    }
    .task-buttons button:hover {
      background-color: #333;
    }

    .task-image {
      max-width: 100%;
      margin-top: 10px;
      border-radius: 8px;
    }

    @media (max-width: 700px) {
      .task-card {
        flex-direction: column;
      }

      .task-info {
        max-width: 100%;
      }

      .task-buttons {
        flex-direction: row;
        justify-content: flex-end;
        margin-top: 15px;
      }

      .task-buttons button {
        flex: 1;
      }
    }
  </style>
