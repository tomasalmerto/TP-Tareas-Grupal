<?php

class RolModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Crear un nuevo rol
    
    public function crearRol(array $data)
    {
        $this -> db -> query("INSERT INTO roles (nombre, descripcion, created_at) VALUES (:nombre, :descripcion, CURRENT_TIMESTAMP)");
        
        $this -> db -> bind(':nombre', $data['nombre']);
        $this -> db -> bind(':descripcion', $data['descripcion']);

        return $this -> db -> execute();
    }

     // Obtener todos los roles
    
    public function obtenerRoles()
    {
        $this -> db -> query("SELECT * FROM roles ORDER BY id ASC");
        
        return $this -> db -> registers();
    }

    
     // Obtener un solo rol por su ID
    
    public function obtenerRolPorId(int $id)
    {
        $this -> db -> query("SELECT * FROM roles WHERE id = :id");
        $this -> db -> bind(':id', $id);
        
        return $this -> db -> register();
    }

    // Actualizar un rol existente
     
    public function actualizarRol(array $data)
    {
        $this -> db -> query("UPDATE roles SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
        
        $this -> db -> bind(':id', $data['id']);
        $this -> db -> bind(':nombre', $data['nombre']);
        $this -> db -> bind(':descripcion', $data['descripcion']);

        return $this -> db -> execute();
    }

    
    // Eliminar un rol
    
    public function eliminarRol(int $id)
    {
        $this -> db -> query("DELETE FROM roles WHERE id = :id");
        $this -> db -> bind(':id', $id);

        return $this -> db -> execute();
    }

    //Asignar rol 

    public function asignarPermisoARol(int $rol_id, int $permiso_id)
    {
        $this -> db -> query("INSERT INTO rol_permisos (rol_id, permiso_id) VALUES (:rol_id, :permiso_id)");
        $this -> db -> bind(':rol_id', $rol_id);
        $this -> db -> bind(':permiso_id', $permiso_id);
        return $this -> db -> execute();
    }

    //Obtener todos los permisos asignados a un rol
     
    public function obtenerPermisosDeRol(int $rol_id)
    {
        
        $this -> db -> query("
            SELECT p.nombre, p.descripcion 
            FROM permisos p
            INNER JOIN rol_permisos rp ON p.id = rp.permiso_id
            WHERE rp.rol_id = :rol_id
        ");
        $this -> db -> bind(':rol_id', $rol_id);
        
        return $this -> db -> registers();
    }
}