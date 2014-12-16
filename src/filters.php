<?php

Route::filter('menu', function(){
	if(!Session::has('menu')){
		$elMenu     = new Menu;
		$elAuthMenu = new Authmenu;
		$menuItems  = $elAuthMenu->getMenuForRole();
		Session::put('menu', $elMenu->generarMenu($menuItems));
	}		
});

Route::filter('god', function(){
	$cancerbero = new Cancerbero;

	if(!$cancerbero->isGod()) 
		return View::make('cancerbero::error')->with('mensaje', $result->error . ' (' . Route::currentRouteName() . ')');
});

