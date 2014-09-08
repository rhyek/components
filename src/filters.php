<?php

Route::filter('menu', function(){
	if(!Session::has('menu')){
		$elMenu    = new Menu;
		$menuItems = Authmenu::getMenuForRole();
		Session::put('menu', $elMenu->generarMenu($menuItems));
	}		
});

Route::filter('god', function(){
	if(!$this->cancerbero->isGod()) 
		return View::make('cancerbero::error')->with('mensaje', $result->error . ' (' . Route::currentRouteName() . ')');
});

