<!DOCTYPE html>
<html lang="zn-cn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <meta name="author" content="">
  <title><?php echo $this->_config['WebName'];?></title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
<body>
  
<?php /* php注释 */ ?>
<?php if ($this->_vars['a']){?>
123
<?php }else{?>
321
<?php } ?>
<br />
<?php foreach ($this->_vars['array'] as $key=>$value) {?>
  <?php echo $key;?>...<?php echo $value;?><br />
<?php }?>
系统变量<?php echo $this->_config['WebName'];?><br />
普通变量<?php echo $this->_vars['name'];?><br />
 
  <script src="/js/jquery-2.2.1.min.js" type="text/javascript"></script>
  <script src="/js/bootstrap.min.js" type="text/javascript"></script>
  <script type="text/javascript">
  </script>
</body>
</html>