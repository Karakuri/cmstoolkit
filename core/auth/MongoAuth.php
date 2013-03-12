<?php

namespace core\auth;

class MongoAuth extends Instance {
	public function getUser() {
		$name = $this->getName();
		return Session::get("auth.$name");
	}
	
	public function login(core\credentials\Instance $credentials, $force = false) {
		$name = $this->getName();
		$db = $this->getOption('conn', 'default');
		
		$client = Mongo::getClient($db);
		$db = $client->selectDB($this->getOption('db'));
		$collection = $db->selectCollection($this->getOption('collection'));
		
		if ($force) {
			$user = $collection->findOne(array('credentials' => $credentials->getIdentifier()));
		} else {
			$user = $collection->findOne(array('credentials' => $credentials->getPayLoad()));
		}
		
		if ($user === null) {
			throw new LoginIncorrectException();
		}
		Session::set("auth.$name", new User($user['_id']->id, $user['userInfo']));
	}
	
	public function createUser(core\credentials\Instance $credentials, $userInfo) {
		$name = $this->getName();
		$db = $this->getOption('conn', 'default');
		
		$client = Mongo::getClient($db);
		$db = $client->selectDB($this->getOption('db'));
		$collection = $db->selectCollection($this->getOption('collection'));
		
		if ($collection->count(array('credentials' => $credentials->getIdentifier())) > 0) {
			throw new UserAlreadyExistsException();
		}
		$collection->insert(array('credentials' => $credentials->getPayLoad(), 'userInfo' => $userInfo));
	}
	
	public function deleteUser($id) {}
	public function updateUserCredentials($id, core\credentials\Instance $credentials) {}
	public function updateUserInfo($id, $userInfo) {}
}