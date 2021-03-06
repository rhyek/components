<?php 
namespace Csgt\Components;

class Logacceso {
	protected $primaryKey = 'accesoid';
	protected $table = 'logacceso';

	public static function getUltimoAcceso() {
		return DB::table('logacceso')
			->select('fechalogin','ip')
			->where('usuarioid',Auth::id())
			->orderBy('fechalogin','DESC')
			->skip(1)
			->first();
	}
}