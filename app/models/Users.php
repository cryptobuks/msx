<?php
namespace app\models;
use lithium\util\Validator;
use lithium\util\String;

class Users extends \lithium\data\Model {

	protected $_schema = array(
		'_id'	=>	array('type' => 'id'),
		'username'	=>	array('type' => 'string', 'null' => false),
		'firstname'	=>	array('type' => 'string', 'null' => false),
		'lastname'	=>	array('type' => 'string', 'null' => false),
	
 	'walletid'	=>	array('type' => 'string', 'null' => false),
		'password'	=>	array('type' => 'string', 'null' => false),
		
		'email'	=>	array('type' => 'string', 'null' => false),		
		'xemail'	=>	array('type' => 'string', 'null' => false),
		
		'created'	=>	array('type' => 'datetime', 'null' => false),
		'ip'	=>	array('type' => 'string', 'null' => true),		
	);

	protected $_meta = array(
		'key' => '_id',
		'locked' => true
	);

	public $validates = array(
		'email' => array(
			array('uniqueEmail', 'message' => 'This Email is already used'),
			array('notEmpty', 'message' => 'Please enter your email address'),			
			array('email', 'message' => 'Not a valid email address'),						
		),
		'walletid' => array(
			array('uniqueWalletID', 'message' => 'This WalletID is already taken'),
			array('notEmpty', 'message' => 'Please enter a WalletID'),
		)
		);
}


	
	Validator::add('uniqueWalletID', function($value, $rule, $options) {
		$conflicts = Users::count(array('walletid' => $value));
		if($conflicts) return false;
		return true;
	});
	Validator::add('uniqueEmail', function($value, $rule, $options) {
		$conflicts = Users::count(array('email' => $value));
		if($conflicts) return false;
		return true;
	});
	Validator::add('uniqueUsername', function($value, $rule, $options) {
		$conflicts = Users::count(array('username' => $value));
		if($conflicts) return false;
		return true;
	});

	
	Users::applyFilter('save', function($self, $params, $chain) {
		if ($params['data']) {
			$params['entity']->set($params['data']);
			$params['data'] = array();
		}
		if (!$params['entity']->exists()) {
			$params['entity']->created = new \MongoDate();
		}
		return $chain->next($self, $params, $chain);
	});
 	
	
?>