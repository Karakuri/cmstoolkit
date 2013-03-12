<?php

return array(
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
	'cache' => 'apc',
	// ビュークラスを指定
	'view' => 'twig',
);