<?php

class UsuarioModel {
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    
   // Función para dar de alta al usuario.
    
    public function crear_usuario($data)
    {
        $keyw = "keyword";
        
       
        $this->db->query("INSERT INTO usuario
                          (nombre, apellido, avatar, email, pass, fk_id_rol, created_at) 
                          VALUES 
                          (:nombre, :apellido, :avatar, :email, aes_encrypt(:pass,:keyword), :fk_id_rol, CURRENT_TIMESTAMP)");
                          
        $this->db->bind('nombre', $data['nombre']);
        $this->db->bind('apellido', $data['apellido']);
        $this->db->bind('avatar', $data['avatar']);                  
        $this->db->bind('email', $data['email']);
        $this->db->bind('pass', $data['pass']);
        
        $rol_default = isset($data['fk_id_rol']) ? $data['fk_id_rol'] : 3; 
        $this->db->bind('fk_id_rol', $rol_default);
        $this->db->bind('keyword', $keyw);
        
        return $this->db->execute();
    }

    
    // Obtener todos los usuarios activos
   public function obtener_usuarios()
    {
        $this->db->query("SELECT u.id, u.nombre, u.apellido, u.email, u.avatar, r.nombre AS rol_nombre 
                          FROM usuario u
                          LEFT JOIN roles r ON u.fk_id_rol = r.id
                          WHERE u.deleted_at IS NULL");
        return $this->db->registers(); 
    }
    
     // READ: Obtener un solo usuario por ID
    public function obtener_usuario_por_id($id)
    {
        $this->db->query("SELECT id, nombre, apellido, email, avatar, fk_id_rol 
                          FROM usuario 
                          WHERE id = :id AND deleted_at IS NULL");
        $this->db->bind('id', $id);
        return $this->db->register(); 
    }

    
     //UPDATE: Actualizar los datos básicos y el rol de un usuario

    public function actualizar_usuario($data)
    {
        $this->db->query("UPDATE usuario SET 
                          nombre = :nombre, 
                          apellido = :apellido, 
                          avatar = :avatar, 
                          email = :email,
                          fk_id_rol = :fk_id_rol,
                          updated_at = CURRENT_TIMESTAMP 
                          WHERE id = :id AND deleted_at IS NULL");
                          
        $this->db->bind('nombre', $data['nombre']);
        $this->db->bind('apellido', $data['apellido']);
        $this->db->bind('avatar', $data['avatar']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('fk_id_rol', $data['fk_id_rol']);
        $this->db->bind('id', $data['id']);
        
        return $this->db->execute();
    }
 
     //DELETE: Borrado lógico del usuario (Soft Delete)
  
    public function eliminar_usuario($id) {
        $this->db->query("DELETE FROM usuario WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>