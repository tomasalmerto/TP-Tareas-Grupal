<?php

class PermisosController extends BaseController {
    private $permisoModel;

    public function __construct() {
        // Verificar permisos de admin
        // AuthHelper::requireRole('admin');

        $this->permisoModel = $this->model('PermisosModel');
    }

    public function index() {
        $permisos = $this->permisoModel->obtenerPermisos();
        
        $datos = [
            'titulo' => 'Gestión de Permisos',
            'permisos' => $permisos
        ];

        $this->view('permisos/index', $datos);
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion'])
            ];

            if ($this->permisoModel->crearPermiso($datos)) {
                header('Location: /permisos');
            } else {
                die('Error al crear permiso');
            }
        } else {
            $datos = [
                'titulo' => 'Crear Permiso'
            ];
            $this->view('permisos/crear', $datos);
        }
    }

    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'id' => $id,
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion'])
            ];

            if ($this->permisoModel->actualizarPermiso($datos)) {
                header('Location: /permisos');
            } else {
                die('Error al actualizar permiso');
            }
        } else {
            $permiso = $this->permisoModel->obtenerPermisoPorId($id);
            $datos = [
                'titulo' => 'Editar Permiso',
                'permiso' => $permiso
            ];
            $this->view('permisos/editar', $datos);
        }
    }

    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->permisoModel->eliminarPermiso($id)) {
                header('Location: /permisos');
            } else {
                die('Error al eliminar permiso');
            }
        }
       
    }
}