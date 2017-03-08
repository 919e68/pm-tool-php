<!DOCTYPE html>
<html>
<head>
  <base href="<?php echo $this->base ?>">
  <title>Projects</title>

  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/common/bootstrap-3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/common/css/style.css">

  <script type="text/javascript" src="<?php echo $this->base ?>/assets/common/jquery/jquery-3.1.1.min.js"></script>
  <script src="<?php echo $this->base ?>/assets/common/bootstrap-3.3.7/js/bootstrap.min.js"></script>

</head>

<body ng-app="pm-tool">
  <?php echo $this->fetch('content') ?>
  
  <?php echo $this->element('angular') ?>
  
</body>
</html>
