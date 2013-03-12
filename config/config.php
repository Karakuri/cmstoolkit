<?php

return array(
	// ソルト
	'salt' => 'testsalt',
	// セッション設定
	'session' => array(
		// 管理クラスを指定
		'class' => 'mongo',
		// 接続先指定
		'conn' => 'default',
		// 接続データベース指定
		'db' => 'test',
		// 利用コレクション指定
		'collection' => 'sessions',
	),
	// キャッシュ管理クラスを指定
	'cache' => array(
		'default' => array(
			'class' => 'apc',
		),
	),
	// 認証管理クラスを指定
	'auth' => array(
		'default' => array(
			'class' => 'mongo',
			'conn' => 'default',
			'db' => 'test',
			'collection' => 'users',
		),
	),
	// ビュークラスを指定
	'view' => 'twig',
);