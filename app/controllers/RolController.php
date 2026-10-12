<?php

class RolController extends BaseController {
    private $rolModel;

    public function __construct() {
        // verificar si el usuario es Admin antes de dejarlo continuar
        // AuthHelper::requireRole('admin'); 
        $this->rolModel = $this->model('RolModel');
    }

   // Muestra la lista de todos los roles
    public function index() {
        $roles = $this->rolModel->obtenerRoles();
        
        $datos = [
            'titulo' => 'Gestión de Roles',
            'roles' => $roles
        ];

        $this->view('roles/index', $datos);
    }

    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar datos del POST
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion'])
            ];
            
            if ($this->rolModel->crearRol($datos)) {
                // Redirigir si fue exitoso
                header('Location: /roles');
            } else {
                die('Algo salió mal al crear el rol');
            }
        } else {
            // Si es GET, mostramos el formulario vacío
            $datos = [
                'titulo' => 'Crear Rol',
                'nombre' => '',
                'descripcion' => ''
            ];
            $this->view('roles/crear', $datos);
        }
    }

   
   // Muestra el formulario con los datos a editar
   
    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'id' => $id,
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion'])
            ];

            if ($this->rolModel->actualizarRol($datos)) {
                header('Location: /roles');
            } else {
                die('Algo salió mal al actualizar el rol');
            }
        } else {
           
            $rol = $this->rolModel->obtenerRolPorId($id);

            $datos = [
                'titulo' => 'Editar Rol',
                'rol' => $rol
            ];
            $this->view('roles/editar', $datos);
        }
    }

   
    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->rolModel->eliminarRol($id)) {
                header('Location: /roles');
            } else {
                die('Algo salió mal al eliminar el rol');
            }
        } else {
            $rol = $this->rolModel->obtenerRolPorId($id);
            $datos = [
                'rol' => $rol
            ];
            $this->view('roles/eliminar', $datos);
        }
    }
}