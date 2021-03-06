<?php
namespace Csgt\Components\Http\Controllers;

use \Csgt\Components\Authusuario;
use Cancerbero, Crypt, DB, Input, Session, Hash, Redirect, Auth;
class usuariosController extends crudController {
/*
	public function __construct() {
		Crud::setExport(true);
		Crud::setTitulo('Usuarios');
		Crud::setTablaId('usuarioid');
		Crud::setTabla('authusuarios');
		Crud::setTemplate(config('csgtcomponents.template','layouts.app'));

		if(config('csgtcomponents::usuariossoftdelete')) 
			Crud::setSoftDelete(true);

		Crud::setCampo(['nombre'=>'Nombre','campo'=>'authusuarios.nombre']);
		Crud::setCampo(['nombre'=>'Email','campo'=>'authusuarios.email']);
		
		Crud::setCampo(['nombre'=>'Creado','campo'=>'authusuarios.created_at', 'tipo'=>'datetime']);
		Crud::setCampo(['nombre'=>'Activo','campo'=>'authusuarios.activo','tipo'=>'bool']);

		if(!Cancerbero::isGod()) {
			Crud::setPermisos(Cancerbero::tienePermisosCrud('usuarios'));
		}
		else
			Crud::setPermisos(array('add'=>true, 'edit'=>true,'delete'=>true));
	}

	public function edit($id) {
		$data = DB::table('authusuarios')
			->where('usuarioid', Crypt::decrypt($id))
			->first();

		$roles = DB::table('authroles')
			->select('nombre','rolid')
			->orderBy('nombre');

		$roles->where('rolid','<>',config('csgtcancerbero.rolbackdoor'));
		
		$roles = $roles->get();

		$uroles = DB::table('authusuarioroles')
			->where('usuarioid', Crypt::decrypt($id))
			->pluck('rolid')
			->toArray();
		

		return view('csgtcomponents::usuarioEdit')
			->with('templateincludes',['selectize','formvalidation'])
			->with('template', config('csgtcomponents.template','layouts.app'))
			->with('roles', $roles)
			->with('data', $data)
			->with('uroles', $uroles)
			->with('id', $id);
	}

	public function create() {
    return self::edit(Crypt::encrypt(0));
	}

	public function store() {
		$id = Input::get('id');

		$pass = Input::get('password');
		if ($id=='')
			$usuario = new Authusuario;
		else
			$usuario = Authusuario::find(Crypt::decrypt($id));

		$usuario->nombre = Input::get('nombre');
		$usuario->email  = Input::get('email');

		if ($pass<>'')
			$usuario->password = Hash::make(Input::get('password'));
		$usuario->activo = (Input::has('activo')?1:0);

		//Ahora validamos si la password debe ser cambiada
		if (config('csgtlogin.vencimiento.habilitado')) {
			if(Input::has('vencimiento')) {
				$usuario->{config('csgtlogin.vencimiento.campo')} = date_create();
			}
		}



		$usuario->save();
		$roles = Input::get('rolid');
		//Borramos todos los roles actuales
		DB::table('authusuarioroles')->where('usuarioid', $usuario->usuarioid)->delete();

		foreach($roles as $rol) {
			DB::table('authusuarioroles')->insert(
				[
					'rolid'      => Crypt::decrypt($rol),
					'usuarioid'  => $usuario->usuarioid,
					'created_at' => date_create(),
					'updated_at' => date_create()
				]);
		}
			
		
		return Redirect::route('usuarios.index');
	}

	public function destroy($aId) {

		try{
			if (Crud::getSoftDelete()){
				$query = DB::table('authusuarios')
					->where('usuarioid', Crypt::decrypt($aId))
					->update(array('deleted_at'=>date_create(), config('csgtlogin.password.campo') =>''));
			}
			else
				$query = DB::table('authusuarios')
					->where('usuarioid', Crypt::decrypt($aId))
					->delete();

			Session::flash('message', 'Registro borrado exitosamente');
			Session::flash('type', 'warning');

		} catch (\Exception $e) {
			Session::flash('message', 'Error al borrar campo. Revisar datos relacionados.');
			Session::flash('type', 'danger');
		}

		return Redirect::to('/usuarios');
	}
*/
}