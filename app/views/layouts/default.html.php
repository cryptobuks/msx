<?php
use lithium\storage\Session;
use app\models\Pages;
use app\models\Details; 
use app\models\Parameters; 
if(!isset($title)){
	$page = Pages::find('first',array(
		'conditions'=>array('pagename'=>'home')
	));
	$title = $page['title'];
	$keywords = $page['keywords'];
	$description = $page['description'];
}
$user = Session::read('default');
$detail = Details::find("first",array(
			"conditions"=>array("user_id"=>$user["_id"])
));
$parameters = Parameters::find('first');
//Pagetime Start
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$pagestarttime = $mtime; 
//Pagetime End
?>
<!doctype html>
<html lang="en">
<head>    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo $this->html->charset();?>
	<meta name="keywords" content="<?php if(isset($keywords)){echo $keywords;} ?>">	
	<meta name="description" content="<?php if(isset($description)){echo $description;} ?>">		
 <meta name="author" content="">
 <link rel="shortcut icon" href="favicon.ico">
	<title><?php echo MAIN_TITLE;?><?php if(isset($title)){echo $title;} ?></title>
	<?php echo $this->html->style(array('bootstrap.min', 'dashboard','font/css/font-awesome.min.css')); ?>
	<?php echo $this->html->script(array('main','jquery','bootstrap', 'lib/btc','lib/crypto','lib/bitcoinjs','lib/qrcode','lib/mnemonic')); ?>
	
	<?php echo $this->scripts(); ?>
	<?php echo $this->styles(); ?>
	<style type="text/css">
body {
	font-family: 'Roboto', sans-serif;
	font-family: 'Source Sans Pro', sans-serif;
}
</style>
	<!-- Google Web fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,600' rel='stylesheet' type='text/css'>
<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<body class="container-fluid">
	<div class="content" style="margin-top:60px;margin-bottom:110px">
		<?php echo $this->_render('element', 'header');?>
		<?php echo $this->content(); ?>
	</div>
<?php 
//Pagetime Start
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$pageendtime = $mtime;
	$pagetotaltime = ($pageendtime - $pagestarttime);
//Pagetime End
?><div class="footer">
			<?php echo $this->_render('element', 'footer', compact('pagetotaltime'));?>	
		</div>
</div>
</body>
</html>