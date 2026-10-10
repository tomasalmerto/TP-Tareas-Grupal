<?php 

/**
 * BaseController
 * Clase base para controladores. Maneja carga de modelos, 
 * renderizado del layout SPA y respuestas JSON para la API.
 */
class BaseController {

    // Cargar modelo
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    // Cargar vista HTML (para la SPA solo se usa para renderizar layout.php)
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            $this->jsonResponse(['error' => 'La vista requerida no existe'], 404);
        }
    }

    // Responder en formato JSON (uso exclusivo para endpoints API)
    public function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    // Helper para capturar y decodificar payloads JSON enviados por fetch()
    public function getJsonBody() {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
    


/////////////////////////////////////ALEXIS  10.10.26////////////////////////////


    public function tienePermiso($permiso) {
    if (!isset($_SESSION['user_id'])) {
        $this->jsonResponse(['success' => false, 'message' => 'No autenticado'], 401);
    }

    $db = new Database();
    $db->query("SELECT p.nombre FROM permisos p
                INNER JOIN rol_permiso rp ON p.id = rp.id_permiso
                INNER JOIN usuario u ON u.fk_id_rol = rp.id_rol
                WHERE u.id = :uid AND p.nombre = :perm");
    $db->bind('uid', $_SESSION['user_id']);
    $db->bind('perm', $permiso);
    
    if (!$db->register()) {
        $this->jsonResponse(['success' => false, 'message' => 'No tienes permiso para ' . $permiso], 403);
    }
    return true;
}
}