<?php
use lithium\storage\Session;
$user = Session::read('default');
?>
	<div class="col-md-6">
<div class="card card-block" >
		<div class="card-header bg-success">
			<h3 class="card-title"  style="font-weight:bold" href="#">Orders:
			Sell <?=$first_curr?> &gt; <?=$second_curr?> <small><span class="pull-right">* - [Self] <?=$user['username']?></span></small></h3>
<?php  foreach($TotalSellOrders['result'] as $TSO){
	$SellAmount = $TSO['Amount'];
	$SellTotalAmount = $TSO['TotalAmount'];
}

?>			
			</div>
		<div id="SellOrders">
			<table class="table table-condensed table-bordered table-hover" style="font-size:14px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>					
					<th style="text-align:center " >Price</th>
					<th style="text-align:center " ><?=$first_curr?></th>
					<th style="text-align:center " ><?=$second_curr?></th>					
					</tr>
					<tr>
					<th style="text-align:center " >Total &raquo;</th>
					<th style="text-align:right " ><?=number_format($SellAmount,8)?></th>
					<th style="text-align:right " ><?=number_format($SellTotalAmount,8)?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$SellOrderAmount = 0; $FillSellOrderAmount =0;
					$ids = '';
					foreach($SellOrders['result'] as $SO){
						if($user['_id']!=$SO['_id']['user_id']){
							$FillSellOrderAmount = $FillSellOrderAmount + round($SO['Amount'],8);
							$SellOrderAmount = $SellOrderAmount + round($SO['Amount'],8);							
							$TotalSellOrderPrice = $TotalSellOrderPrice + round($SO['Amount']*$SO['_id']['PerPrice'],8);
							$SellOrderPrice = round($TotalSellOrderPrice/$SellOrderAmount,8);
							$ids = $ids .','.$SO['_id']['id'].'';
						}
						

						?>
					<tr onClick="SellOrderFill(<?=$SellOrderPrice?>,<?=$SellOrderAmount?>,'<?=$ids?>');"  style="cursor:pointer;<?php if($user['username']==$SO['_id']['username']){?>background-color:#A5FC8F;<?php } ?>" class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Buy <?=$SellOrderAmount?> <?=$first_curr?> at <?=$SellOrderPrice?> <?=$second_curr?>">
						<td style="text-align:right"><?php if($user['username']==$SO['_id']['username']){?><span class="pull-left">*</span><?php }?><?=$SO['No']?></td>											
						<td style="text-align:right"><?=number_format(round($SO['_id']['PerPrice'],8),8)?></td>						
						<td style="text-align:right"><?=number_format(round($SO['Amount'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($SO['Amount']*$SO['_id']['PerPrice'],8),8)?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>