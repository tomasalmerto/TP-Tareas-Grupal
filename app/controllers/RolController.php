<?php

class RolController extends BaseController {
    private $rolModel;

    public function __construct() {
        // AuthHelper::requireRole('admin'); 
        $this->rolModel = $this->model('RolModel');
    }

    // Muestra la lista de todos los roles (Devuelve JSON)
    public function index() {
        $roles = $this->rolModel->obtenerRoles();
        
        if ($roles !== false) {
            $this->jsonResponse([
                'success' => true,
                'data' => $roles
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error al obtener los roles'
            ], 500);
        }
    }

    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Leer el JSON enviado por fetch
            $data = json_decode(file_get_contents("php://input"), true);
            
            $datos = [
                'nombre' => trim($data['nombre'] ?? ''),
                'descripcion' => trim($data['descripcion'] ?? '')
            ];
            
            if ($this->rolModel->crearRol($datos)) {
                $this->jsonResponse([
                    'success' => true, 
                    'message' => 'Rol creado correctamente'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false, 
                    'message' => 'Algo salió mal al crear el rol'
                ], 500);
            }
        }
    }

   
    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT') {
           
            $data = json_decode(file_get_contents("php://input"), true);
            
            $datos = [
                'id' => $id,
                'nombre' => trim($data['nombre'] ?? ''),
                'descripcion' => trim($data['descripcion'] ?? '')
            ];

            if ($this->rolModel->actualizarRol($datos)) {
                $this->jsonResponse([
                    'success' => true, 
                    'message' => 'Rol actualizado correctamente'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false, 
                    'message' => 'Algo salió mal al actualizar el rol'
                ], 500);
            }
        } else {
          
            $rol = $this->rolModel->obtenerRolPorId($id);

            if ($rol) {
                $this->jsonResponse([
                    'success' => true,
                    'data' => $rol
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false, 
                    'message' => 'Rol no encontrado'
                ], 404);
            }
        }
    }

    
    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->rolModel->eliminarRol($id)) {
                $this->jsonResponse([
                    'success' => true, 
                    'message' => 'Rol eliminado correctamente'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false, 
                    'message' => 'Algo salió mal al eliminar el rol'
                ], 500);
            }
        }
    }
}