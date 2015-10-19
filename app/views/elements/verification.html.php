<?php
$verify = "phone";
switch ($verify) {
	case "email":
		$next = 1;
		break;
	case "phone":
		$next = 2;
		break;
	case "document":
		$next = 3;
		break;
	case "wait":
		$next = 4;
		break;		
	default:
		$next = 10;
}
?>
<h1>Verification steps</h1>
<div class="btn-group" role="group" aria-label="Verification">
  <button type="button" 
		<?php if($next>1){?>
		class="btn btn-success"><span class="fa fa-check fa-lg"></span>
		<?php }else{?>
		class="btn btn-primary"><span class="fa fa-asterisk fa-lg"></span>
		<?php }?>
		 &nbsp;Email</button>
			
		<button type="button" 
		<?php if($next>2){?>
		class="btn btn-success"><span class="fa fa-check fa-lg"></span>
		<?php }else{?>
		class="btn btn-primary"><span class="fa fa-asterisk fa-lg"></span>
		<?php }?>
		 &nbsp;Phone</button>
			
  <button type="button" 
		<?php if($next>3){?>
		class="btn btn-success"><span class="fa fa-check fa-lg"></span>
		<?php }else{?>
		class="btn btn-primary"><span class="fa fa-asterisk fa-lg"></span>
		<?php }?>
		 &nbsp;Document</button>
		
<button type="button" 
		<?php if($next>4){?>
		class="btn btn-success"><span class="fa fa-check fa-lg"></span>
		<?php }else{?>
		class="btn btn-primary"><span class="fa fa-asterisk fa-lg"></span>
		<?php }?>
		 &nbsp;Waiting for approval</button>

		
	</div>
<hr>