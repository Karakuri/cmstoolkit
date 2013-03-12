<?php

namespace core\session;

class MongoSession implements Instance {
	private $collection;
	private $data;

	function open($savePath, $sessionName) {
		try {
			$db = Config::get('config.session.conn', 'default');
			$client = Mongo::getClient($db);
			$db = $client->selectDB(Config::get('config.session.db'));
			$this->collection = $db->selectCollection(Config::get('config.session.collection'));
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	function close() {
		return true;
	}
	
	function read($id) {
		$payload = $this->collection->findOne(array('_id' => new MongoId($id)));
		$this->data = $payload['data'] !== null ? '' : $payload['data'];
		return $this->data;
	}
	
	function write($id, $data) {
		if ($this->data != $data) {
			$this->collection->save(array('_id' => new MongoId($id), 'data' => $data, 'updateDate' => new MongoDate()));
		}
	}
	
	function destroy($id) {
		try {
			$this->collection->remove(array('_id' => new MongoId($id)));
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	function gc($maxlifetime) {
		try {
			$collection->remove(array('updateDate' => array('$lt' => new MongoDate(time() - $maxlifetime))));
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
}