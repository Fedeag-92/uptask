<?php

namespace Controllers;

use MVC\Router;
use Model\Tarea;
use Model\Usuario;
use Model\Proyecto;


class DashboardController {
    public static function index(Router $router) {

        session_start();
        isAuth();

        $alertas = [];

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        foreach ($proyectos as $proyecto) {
            $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
            $completos = array_filter($tareas, function($tarea) {
                // condition which makes a result belong to div1.
                return ($tarea->estado == 1);
            });
            $proyecto->cantCompletas = count($completos);
            $proyecto->cantTotal = count($tareas);
            if($proyecto->cantTotal != 0){
                $proyecto->porcentaje = round(((($proyecto->cantCompletas)/($proyecto->cantTotal))*100), 0, PHP_ROUND_HALF_UP);
            }else{
                $proyecto->porcentaje = 0;
            }
            
        }

        if(isset($_GET['renombradoResultado']) && isset($_SERVER['HTTP_REFERER'])){
            if(str_contains($_SERVER['HTTP_REFERER'], 'renombrar')){

                $renombrado = $_GET['renombradoResultado'];
                if($renombrado == '0'){
                    Proyecto::setAlerta('info', 'Sin cambios');
                } else if ($renombrado == '1'){
                    Proyecto::setAlerta('exito', 'Proyecto renombrado con exito');
                }
            }
        }

        $alertas = Proyecto::getAlertas();

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos,
            'alertas' => $alertas
        ]);
    }

    public static function crear_proyecto(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            // validación
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)) {
                // Generar una URL única 
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el Proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);

            }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'
        ]);
    }

    public static function proyecto(Router $router) {
        session_start();
        isAuth();

        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function eliminar_proyecto() {
        session_start();

        isAuth();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $proyecto = Proyecto::find($_POST['id']);
            $proyecto->eliminar();
            header('Location: /dashboard');
        }
    }

    public static function renombrar_proyecto(Router $router) {
        session_start();

        isAuth();
        
        $id = $_GET['id'];

        if(!is_numeric($id)) return;
        
        $proyecto = Proyecto::find($_GET['id']);
        $nombreAnterior = $proyecto->proyecto;
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $proyecto->sincronizar($_POST);
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                if($proyecto->proyecto == $nombreAnterior) {
                    header('Location: /dashboard?renombradoResultado=0');
                }else{
                    $proyecto->guardar();
                    header('Location: /dashboard?renombradoResultado=1');
                }
            }

            
        }

        $alertas = $proyecto->getAlertas();
        
        $router->render('dashboard/renombrar-proyecto', [
            'titulo' => 'Renombrar Proyecto',
            'proyecto' => $proyecto,
            'alertas' => $alertas
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario->email == $usuario->email && $existeUsuario->nombre == $usuario->nombre) {
                    Usuario::setAlerta('info', 'Sin cambios');
                } else if($existeUsuario && $existeUsuario->id !== $usuario->id ) {
                    // Mensaje de error
                    Usuario::setAlerta('error', 'Email no válido, ya pertenece a otra cuenta');
                } else {
                    // Guardar el registro
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado Correctamente');

                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;
                }
            }
        }
        
        $alertas = $usuario->getAlertas();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado) {
                    $usuario->password = $usuario->password_nuevo;

                    // Eliminar propiedades No necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    // Hashear el nuevo password
                    $usuario->hashPassword();

                    // Actualizar
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = $usuario->getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
         ]);
    }
}