<?php

namespace core\auth;

use core\User;

use core\Session;

use core\exceptions\UserAlreadyExistsException;
use core\Mongo;

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
	
	public function login(\core\credentials\Instance $credentials, $force = false) {
		$name = $this->getName();
		$db = $this->getOption('conn', 'default');
		
		if ($force) {
			$where = array();
			foreach ($credentials->getIdentifier() as $key => $val) {
				$where['credentials.' . $key] = $val;
			}
			$user = $this->collection->findOne($where);
		} else {
			$where = array();
			foreach ($credentials->getPayload() as $key => $val) {
				$where['credentials.' . $key] = $val;
			}
			$user = $this->collection->findOne($where);
		}
		
		if ($user === null) {
			throw new LoginIncorrectException();
		}
		Session::set("auth.$name", new User((string)$user['_id'], $user['userInfo']));
	}
	
	public function createUser(\core\credentials\Instance $credentials, $userInfo) {
		$where = array();
		foreach ($credentials->getIdentifier() as $key => $val) {
			$where['credentials.' . $key] = $val;
		}
		if ($this->collection->count($where) > 0) {
			throw new UserAlreadyExistsException();
		}
		$this->collection->insert(array('credentials' => $credentials->getPayLoad(), 'userInfo' => $userInfo));
	}
	
	public function deleteUser($id) {
		$this->collection->remove(array('_id' => new \MongoId($id)));
	}
	
	public function updateUserCredentials($id, \core\credentials\Instance $credentials) {
		$this->collection->update(array('_id' => new \MongoId($id)), array('$set' => array('credentials' => $credentials->getIdentifier())));
	}
	
	public function updateUserInfo($id, $userInfo) {
		$this->collection->update(array('_id' => new \MongoId($id)), array('$set' => array('userInfo' => $userInfo)));
	}
}