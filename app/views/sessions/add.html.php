<?php

?>
<p class="alert alert-danger" id="LoginAlert"><?=COMPANY_NAME?> <?=COMPANY_URL?>: <strong><a href="/users/signup" >Registration is FREE!</a></strong></p>
<div class="row container-fluid">
	<div class="col-md-6" >
		
		<div class="card card-block">
   <div class="card-header bg-success">
				<h3 class="card-title">Login</h3>
			</div>
								<p>Please make sure you enter your <span style="color:red">username</span>, not your email. Your username & password are <span style="color:red">case sensitive</span>!</p>
			<?=$this->form->create(null,array('class'=>'form-group has-error')); ?>
  <fieldset class="form-group">
    <label for="username">Username: <i class="fa fa-asterisk" id="UserNameIcon"></i></label>
    <?=$this->form->field('username', array('label'=>'','placeholder'=>'userName', 'class'=>'form-control','onBlur'=>'SendPassword();')); ?>
    <small class="text-muted"></small>
  </fieldset>

		<fieldset class="form-group">
    <label for="password">Password: <i class="fa fa-asterisk" id="PasswordIcon"></i></label>
    <?=$this->form->field('password', array('type'=>'password','label'=>'','placeholder'=>'password', 'class'=>'form-control'));?>
    <small class="text-muted"></small>
  </fieldset>

		
			<div class="alert alert-danger"  id="LoginEmailPassword" style="display:none">
			
		<fieldset class="form-group">
    <label for="password">Login Email Password: <i class="fa fa-asterisk" id="PasswordIcon"></i></label>
    <?=$this->form->field('loginpassword', array('type'=>'password','label'=>'','placeholder'=>'password', 'maxlength'=>'6', 'class'=>'form-control'));?>
    <small class="text-muted">Please check your registered email in 5 seconds. You will receive "<strong>Login Email Password</strong>" use it in the box below.</small>
  </fieldset>
			
				</div>



			<div style="display:none" id="TOTPPassword" class="alert alert-danger">
			<div class="form-group has-error">			
				<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-asterisk"></i>
					</span>
			<?=$this->form->field('totp', array('type' => 'password', 'label'=>'','class'=>'span1','maxlength'=>'6', 'placeholder'=>'123456','class'=>'form-control')); ?>	
				</div>		
			</div>		
				<small><strong>Time based One Time Password (TOTP) from your smartphone</strong></small>	
			</div>
		
			<?=$this->form->submit('Login' ,array('class'=>'btn btn-primary btn-block','id'=>'LoginButton','disabled'=>'disabled')); ?>
			<?=$this->form->end(); ?>
			<a href="/users/forgotpassword">Forgot password?</a>
		</div>
	</div>
	<div class="col-md-6 well">
	
		<div style="padding-top:0;" class="panel-body">
		<h3 style="margin-top:0;">Sign up</h3>
		Don't have an account. <a href="/users/signup" >Register</a><br>
		Please read the <a href="/company/termsofservice">terms of service</a> page before you sign up.<br>
		<h3>Security</h3>
		We use <strong>Two Factor Authentication</strong> for your account to login to <?=COMPANY_URL?>.<br>
		We use <strong>Time-based One-time Password Algorithm (TOTP)</strong> for login, withdrawal/deposits and settings.<br>
		Optional Google Authenticator can be activated via settings.<br>
Customers must password verify coin withdrawal.<br>
All coin withdrawals are admin approved for extra security.<br>
		<p><h3>TOTP Project and downloads</h3>
			<ul>
			<li><a href="http://code.google.com/p/google-authenticator/" target="_blank">Google Authenticator</a></li>
			<li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">TOTP Android App</a></li>
			<li><a href="http://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">TOTP iOS App</a></li>
			</ul>
		</p>
	</div>
</div>