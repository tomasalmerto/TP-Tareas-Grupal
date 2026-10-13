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
        
       
        if ($permisos !== false) {
            $this->jsonResponse([
                'success' => true,
                'data' => $permisos
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'No se pudieron cargar los permisos'
            ], 500);
        }
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
            $data = json_decode(file_get_contents("php://input"), true);
            
            
            if (empty($data['nombre'])) {
                $this->jsonResponse([
                    'success' => false, 
                    'message' => 'El nombre del permiso es obligatorio'
                ], 400);
                return;
            }

            $datos_permiso = [
                'nombre' => trim($data['nombre']),
                'descripcion' => trim($data['descripcion'] ?? '')
            ];

            if ($this->permisoModel->crearPermiso($datos_permiso)) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Permiso creado exitosamente'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Error al guardar en la base de datos'
                ], 500);
            }
        } else {
           
            $this->jsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }
    }

    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            $datos_permiso = [
                'id' => $id,
                'nombre' => trim($data['nombre']),
                'descripcion' => trim($data['descripcion'] ?? '')
            ];

            if ($this->permisoModel->actualizarPermiso($datos_permiso)) {
                $this->jsonResponse(['success' => true, 'message' => 'Permiso actualizado']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Error al actualizar'], 500);
            }
        } else {
            
            $permiso = $this->permisoModel->obtenerPermisoPorId($id);

            if ($permiso) {
             
                $this->jsonResponse([
                    'success' => true,
                    'data' => $permiso 
                ]);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Permiso no encontrado'], 404);
            }
        }
    }

    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if ($this->permisoModel->eliminarPermiso($id)) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Permiso eliminado correctamente'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Error al eliminar en la base de datos'
                ], 500);
            }
        }
    }
}