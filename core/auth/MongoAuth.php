<?php

namespace core\auth;

class MongoAuth extends Instance {
	private $collection;
	
	public function init() {
		$client = Mongo::getClient($this->getOption('conn', 'default'));
		$db = $client->selectDB($this->getOption('db'));
		$this->collection = $db->selectCollection($this->getOption('collection'));
	}

	public function getUser() {
		$name = $this->getName();
		return Session::get("auth.$name");
	}
	
	public function login(core\credentials\Instance $credentials, $force = false) {
		$name = $this->getName();
		$db = $this->getOption('conn', 'default');
		
		if ($force) {
			$user = $this->collection->findOne(array('credentials' => $credentials->getIdentifier()));
		} else {
			$user = $this->collection->findOne(array('credentials' => $credentials->getPayLoad()));
		}
		
		if ($user === null) {
			throw new LoginIncorrectException();
		}
		Session::set("auth.$name", new User($user['_id']->id, $user['userInfo']));
	}
	
	public function createUser(core\credentials\Instance $credentials, $userInfo) {
		if ($this->collection->count(array('credentials' => $credentials->getIdentifier())) > 0) {
			throw new UserAlreadyExistsException();
		}
		$collection->insert(array('credentials' => $credentials->getPayLoad(), 'userInfo' => $userInfo));
	}
	
	public function deleteUser($id) {
		$this->collection->remove(array('_id' = new MongoId($id)));
	}
	
	public function updateUserCredentials($id, core\credentials\Instance $credentials) {
		$this->collection->update(array('_id' => new MongoId($id)), array('credentials' => $credentials->getIdentifier()));
	}
	
	public function updateUserInfo($id, $userInfo) {
		$this->collection->update(array('_id' => new MongoId($id)), array('userInfo' => $userInfo));
	}
}