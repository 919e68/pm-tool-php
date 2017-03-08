<!DOCTYPE html>
<html>
<head>
  <title>Sign in</title>

  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/common/bootstrap-3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/common/css/style.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/login.css">

  <script type="text/javascript" src="<?php echo $this->base ?>/assets/common/jquery/jquery-3.1.1.min.js"></script>
  <script src="<?php echo $this->base ?>/assets/common/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</head>

<body ng-app="login">
  <?php echo $this->fetch('content') ?>
  
  <?php echo $this->element('angular') ?>
  <script src="<?php echo $this->base ?>/assets/js/login.js"></script>
</body>
</html>
