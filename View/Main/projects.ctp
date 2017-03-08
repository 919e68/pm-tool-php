<!DOCTYPE html>
<html>
<head>
  <title>Projects</title>

  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/common/bootstrap-3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/common/css/style.css">

  <script type="text/javascript" src="<?php echo $this->base ?>/assets/common/jquery/jquery-3.1.1.min.js"></script>
  <script src="<?php echo $this->base ?>/assets/common/bootstrap-3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
  <div class="main">
    <div class="top"></div>

    <div class="left">
      <div class="brand">
        PMTOOL
      </div>

      <div class="user-info">
        <img src="<?php echo $this->base ?>/assets/dummy/img/1.png">
        <div class="name">Wilson Anciro</div>
        <div class="email">konekred@gmail.com</div>
        <div class="action"><a href="#logout">signout</a></div>
      </div>

      <div class="left-menu">
        <ul>
          <li class="active"><a href="#messages">Messages</a></li>
          <li><a href="#groups">Groups</a></li>
          <li><a href="#settings">Settings</a></li>
        </ul>
      </div>

      <div class="messages">
        <div class="title">Online Users</div>

        <div class="user">
          <img src="<?php echo $this->base ?>/assets/dummy/img/2.png">
          <div class="name">Daley Connell</div>
          <div class="location">Manila, Philippines</div>
        </div>
        <div class="user">
          <img src="<?php echo $this->base ?>/assets/dummy/img/3.png">
          <div class="name">Alvin Ryan</div>
          <div class="location">Manila, Philippines</div>
        </div>
        <div class="user">
          <img src="<?php echo $this->base ?>/assets/dummy/img/4.png">
          <div class="name">Jerrold Jeff</div>
          <div class="location">Manila, Philippines</div>
        </div>
        <div class="user">
          <img src="<?php echo $this->base ?>/assets/dummy/img/5.png">
          <div class="name">Delano Merrick</div>
          <div class="location">Manila, Philippines</div>
        </div>
        <div class="user">
          <img src="<?php echo $this->base ?>/assets/dummy/img/6.png">
          <div class="name">Kendal Beaumont</div>
          <div class="location">Manila, Philippines</div>
        </div>


        <div class="title">Offline Users</div>
        
      </div>
    </div>

    <div class="content">
      <h1>Hello World</h1>

      <div class="row">

        <div class="col-md-3">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Downloads</span>
              <span class="info-box-number">114,381</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>

              <span class="progress-description">
                70% Increase in 30 Days
              </span>
            </div>
          </div>
        </div>

      </div>


    </div>
  </div>

  <?php echo $this->element('angular') ?>
  <script src="<?php echo $this->base ?>/assets/js/project.js"></script>
</body>
</html>
