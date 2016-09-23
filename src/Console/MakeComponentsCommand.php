<?php

namespace Csgt\Components\Console;

use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;

class MakeComponentsCommand extends Command {
  use AppNamespaceDetectorTrait;

  protected $signature = 'make:csgtcomponents';

  protected $description = 'Vista components';

  protected $views = [
    'roles/edit.stub'    => 'roles/edit.blade.php',
    'usuarios/edit.stub' => 'usuarios/edit.blade.php',
  ];

  protected $controllers = [
    'RolesController',
    'UsuariosController'
  ];

  protected $models = [
    'Authmenu' => 'Menu',
  ];

  protected $langs = [
    'es/usuario.stub'       => 'es/usuario.php',
    'en/usuario.stub'       => 'en/usuario.php',
  ];

  public function fire() {
    $this->createDirectories();
    $this->exportControllers(); 
    $this->exportModels();
    $this->exportViews();
    $this->exportLangs();

    file_put_contents(
      base_path('routes/web.php'),
      file_get_contents(__DIR__.'/stubs/make/routes.stub'),
      FILE_APPEND
    );

    $this->info('Vistas & Controladores para Components generadas correctamente.');
  }

  protected function exportControllers() {
    foreach ($this->controllers as $controller) {
      file_put_contents(
        app_path('Http/Controllers/'.$controller . '.php'),
        $this->compileControllerStub($controller)
      );
    }
  }

  protected function exportViews() {
    foreach ($this->views as $key => $value) {
      copy(
        __DIR__.'/stubs/make/views/'.$key,
        base_path('resources/views/'.$value)
      );
    }
  }

  protected function exportLangs() {
    foreach ($this->langs as $key => $value) {
      copy(
        __DIR__.'/stubs/make/lang/'.$key,
        base_path('resources/lang/'.$value)
      );
    }
  }

  protected function exportModels() {
    foreach ($this->models as $modelName => $folder) {
      file_put_contents(
      app_path('Models/'. ($folder<>''? $folder .'/':'') . $modelName . '.php'),
      $this->compileModelStub($modelName)
    );
    }
  }

  protected function createDirectories() {

    if (! is_dir(resource_path('views/roles'))) {
      mkdir(resource_path('views/roles'), 0755, true);
    }

    if (! is_dir(resource_path('views/usuarios'))) {
      mkdir(resource_path('views/usuarios'), 0755, true);
    }

    if (! is_dir(app_path('Models/Menu'))) {
      mkdir(app_path('Models/Menu'), 0755, true);
    }
  }

  protected function compileControllerStub($aPath, $aExtension = "stub") {
    return str_replace(
      '{{namespace}}',
      $this->getAppNamespace(),
      file_get_contents(__DIR__.'/stubs/make/controllers/' . $aPath . '.' . $aExtension)
    );
  }

  protected function compileModelStub($aModel, $aExtension = "stub") {
    return str_replace(
      '{{namespace}}',
      $this->getAppNamespace(),
      file_get_contents(__DIR__.'/stubs/make/models/' . $aModel . '.' . $aExtension)
    );
  }


}