<?php
use app\models\Parameters;
$Comm = Parameters::find('first');
?>
<?php $this->form->config(array( 'templates' => array('error' => '<p class="alert alert-danger">{:content}</p>'))); 
?>
<div class="row container-fluid">
	<div class="col-sm-6 col-md-6" >
		<div class="card card-block">
			<div class="card-header bg-success">
				<h3 class="card-title">Register</h3>
			</div>
		<!-- -->
				<?=$this->form->create($Users,array('class'=>'has-error')); ?>
  <fieldset class="form-group">
    <label for="firstname">First Name: <i class="fa fa-asterisk" id="FirstNameIcon"></i></label>
    <?=$this->form->field('firstname', array('label'=>'','placeholder'=>'First Name', 'class'=>'form-control','onkeyup'=>'CheckFirstName(this.value);' )); ?>
    <small class="text-muted"></small>
  </fieldset>
		<fieldset class="form-group">
    <label for="lastname">Last Name: <i class="fa fa-asterisk" id="LastNameIcon"></i></label>
    <?=$this->form->field('lastname', array('label'=>'','placeholder'=>'Last Name', 'class'=>'form-control','onkeyup'=>'CheckLastName(this.value);' )); ?>
    <small class="text-muted"></small>
  </fieldset>
		<fieldset class="form-group">
    <label for="username">User Name: <i class="fa fa-asterisk" id="UserNameIcon"></i></label>
    <?=$this->form->field('username', array('label'=>'','placeholder'=>'User Name', 'class'=>'form-control','onkeyup'=>'CheckUserName(this.value);' )); ?>
    <small class="text-muted">Character or Numbers, no spaces</small>
  </fieldset>

		<fieldset class="form-group">
    <label for="email">Email: <i class="fa fa-asterisk" id="EmailIcon"></i></label>
    <?=$this->form->field('email', array('label'=>'','placeholder'=>'name@youremail.com', 'class'=>'form-control','onkeyup'=>'CheckEmail(this.value);' )); ?>
    <small class="text-muted">Your email address</small>
  </fieldset>

		<fieldset class="form-group">
    <label for="password">Password: <i class="fa fa-asterisk" id="PasswordIcon"></i></label>
    <?=$this->form->field('password', array('type'=>'password','label'=>'','placeholder'=>'123456', 'class'=>'form-control','onkeyup'=>'CheckPassword(this.value);' )); ?>
    <small class="text-muted">Length at least 10, characters or numbers</small>
  </fieldset>

		<fieldset class="form-group">
    <label for="password1">Repeat password: <i class="fa fa-asterisk" id="Password2Icon"></i></label>
    <?=$this->form->field('password2', array('type'=>'password','label'=>'','placeholder'=>'123456', 'class'=>'form-control','onkeyup'=>'CheckPassword(this.value);' )); ?>
    <small class="text-muted">Please repeat the same password</small>
  </fieldset>
		<a href="javascript:void(0);" class="btn btn-primary btn-block" onclick="registerUser();" >Register</a>
		
		<?=$this->form->end(); ?>
		<!-- -->
		<hr>
		</div>
	</div>
	
	<div class="col-sm-6 col-md-6" >
		<div class="card card-block">
			<div class="card-header bg-info">
				<h3 class="card-title">Advantages</h3>
			</div>
		<h3><?=COMPANY_NAME?> Inc. <?=COMPANY_URL?></h3>
		<ul>
			<li>Fees are <strong><?=$Comm['value']?></strong>% per transaction.</li>
    	<li>Crypto coins stored on blockchain with MultiSig.</li>
    <li>Two Factor Authentication(2FA) login and coin withdrawal, with optional (3FA) login.</li>
    <li>Exchange available to all internationally and nationally.</li>
		</ul>
		<p>To become an <?=COMPANY_NAME?> customer and use our platform and services, you only need the following;
		<ul>
						<li>Full KYC required</li>
						<li>Verify email and phone</li>
						<li>Verify address proof, government photo id, utility bill</li>
		</ul>
		</p>

		</p>
		Any issues please contact us at <a href="mailto:support@<?=COMPANY_URL?>">support@<?=COMPANY_URL?></a>
		</p>
		<hr>
		</div>
	</div>
</div>