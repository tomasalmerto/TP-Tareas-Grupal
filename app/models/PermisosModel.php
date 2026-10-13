<?php

class PermisosModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    
    // Crear permiso

    public function crearPermiso($data){

        $this -> db -> query("INSERT INTO permisos (nombre, descripcion)
                     VALUES (:nombre, :descripcion)");

        $this ->db -> bind('nombre', $data['nombre']);
        $this ->db -> bind(':descripcion', $data['descripcion']);

        if ($this->db->execute()) {
			return true;
		} else {
			return false;
		}
    }

    // Obtener los permisos

    public function obtenerPermisos(){
        $this -> db -> query("SELECT * FROM permisos ORDER BY id ASC");

        return $this -> db -> registers();

    }

    // Obtener permiso por ID

    public function obtenerPermisoPorId($id){
        $this -> db -> query("SELECT * FROM permisos WHERE id = :id");
        $this -> db -> bind(':id', $id);

        return $this -> db -> register();
    }

    //Actualizar permiso

    public function actualizarPermiso($data){

        $this -> db -> query("UPDATE permisos SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");

        $this-> db -> bind(':id', $data['id']);
        $this-> db -> bind(':nombre', $data['nombre']);
        $this-> db -> bind(':descripcion', $data['descripcion']);

        return $this->db->execute();
    }

    //Eliminar permiso
    public function eliminarPermiso($id)
    {
        $this -> db -> query("DELETE FROM permisos WHERE id = :id");
        $this -> db -> bind(':id', $id);

        return $this -> db -> execute();
    }

}