<?php

return [

	// MainController
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],

	'main' => [
		'controller' => 'main',
		'action' => 'index',
	],
	
	'add' => [
		'controller' => 'main',
		'action' => 'add',
	],
	
	'edit' => [
		'controller' => 'main',
		'action' => 'edit',
    ],
    
	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],

	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],
	
	'account/logout' => [
		'controller' => 'account',
		'action' => 'logout',
    ],
];