<?php

namespace core;

class Mongo {
	static $conns = array();

	public static function getClient($name = null) {
		if ($name === null || Config::get("mongo.$name") === null) {
			$name = 'default';
		}
		
		if (!array_key_exists($name, self::$conns)) {
			$host = Config::get("mongo.$name.host");
			$options = array();
			if (Config::get("mongo.$name.username")) {
				$options['username'] = Config::get("mongo.$name.username");
			}
			if (Config::get("mongo.$name.password")) {
				$options['password'] = Config::get("mongo.$name.password");
			}
			if (Config::get("mongo.$name.replicaSet")) {
				$options['replicaSet'] = Config::get("mongo.$name.replicaSet");
			}
			self::$conns[$name] = new MongoClient("mongodb://$host", $options);
			if (Config::get("mongo.$name.readPreference")) {
				self::$conns[$name]->setReadPreference(Config::get("mongo.$name.readPreference"));
			}
		}
		
		return self::$conns[$name];
	}
}