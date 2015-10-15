<?php
use app\models\Parameters;
$Comm = Parameters::find('first');
?><h1>Register</h1>
<?php $this->form->config(array( 'templates' => array('error' => '<p class="alert alert-danger">{:content}</p>'))); ?>
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
    <a href="javascript:void(0);" class="btn btn-success btn-block" onclick="checkUser();" >Check</a>