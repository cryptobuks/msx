<?php
use app\models\Trades;
use app\models\Orders;
use lithium\storage\Session;
use lithium\data\Connections;
use app\extensions\action\Functions;
?>
<?php $user = Session::read('default'); ?>
<?php 

$howmany = 100;
$trades = Trades::find('all',array('limit'=>$howmany,'order'=>array('order'=>1)));
		$mongodb = Connections::get('default')->connection;
		$Rates = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( 
				'$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'PerPrice'=>'$PerPrice',					
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',
				)),
				array('$match'=>array(
					'Completed'=>'Y',					
					)),
				array('$group' => array( '_id' => array(
							'FirstCurrency'=>'$FirstCurrency',
							'SecondCurrency'=>'$SecondCurrency',	
							'year'=>array('$year' => '$TransactDateTime'),
							'month'=>array('$month' => '$TransactDateTime'),						
							'day'=>array('$dayOfMonth' => '$TransactDateTime'),												
						'hour'=>array('$hour' => '$TransactDateTime'),
						),
					'min' => array('$min' => '$PerPrice'), 
					'avg' => array('$avg' => '$PerPrice'), 					
					'max' => array('$max' => '$PerPrice'), 
					'last' => array('$last' => '$PerPrice'), 					
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,					
					'_id.hour'=>-1,					
				)),
				array('$limit'=>count($trades))
			)
		));
//print_r($Rates);
?>



<nav class="navbar navbar-light bg-success navbar-fixed-top">
  <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
    <?=COMPANY_NAME?> &#9776;
  </button>
  <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
    <ul class="nav navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/"><strong><img src="/img/logo.png" alt="<?=COMPANY_NAME?>"></strong></a>
      </li>
						<?php if(!$user==""){?>
      <li class="nav-item pull-right">
        <a class="nav-link" href="/logout"><i class="fa fa-power-off"></i> Logout</a>
      </li>
      <li class="nav-item pull-right">
        <a class="nav-link" href="#"><i class="fa fa-user"></i> <?=$user['username']?></a>
      </li>
						<?php }else{?>
						<li class="nav-item pull-right">
        <a class="nav-link" href="/login"><i class="fa fa-user"></i> Login</a>
      </li>
						<li class="nav-item pull-right">
        <a class="nav-link" href="/users/signup"><i class="fa fa-user"></i> Register</a>
      </li>

						<?php }?>
      <li class="nav-item">
        <a class="nav-link" href="/company/aboutus">About</a>
      </li>
    </ul>
  </div>
</nav>
<?php if($user!=""){?>
	<div >
<nav class="navbar navbar-dark bg-inverse" style="padding-bottom:0px">
  <!-- Navbar content -->
		<ul class="nav navbar-nav">
<?php
$sel_curr = $this->_request->params['args'][0];
if($this->_request->params['controller']!='api'){
	$currencies = array();
		foreach($trades as $trade){
			$first_currency = substr($trade['trade'],0,3);		
			$second_currency = substr($trade['trade'],4,3);		
			$avg = 0;
			$price = 0;
			foreach($Rates['result'] as $rate){
			 if($rate['_id']['FirstCurrency']==$first_currency && $rate['_id']['SecondCurrency']==$second_currency){
					$price = $rate['last'];
			 }
			}
?>
	<li class="nav-item" style="text-align:center">
			<a class="nav-link" href="/ex/x/<?=strtolower(str_replace("/","_",$trade['trade']))?>">
			<div><?=$trade['trade']?></div>
			<div><span class="label label-pill label-default"><?=number_format($price,4)?></span></div>
			</a>
	</li>
<?php
		}
}

?>
		</ul>
</nav>	
	</div>
<?php }?>