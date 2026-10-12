<?php

class AuthModel {
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /* Método para buscar el mail y la contraseña para comprobar si existe y poder loguear */
     public function buscar_por_mail($data)
    {
        // Cambiamos rol_id por fk_id_rol
        $this->db->query("SELECT id, nombre, email, avatar, fk_id_rol, aes_decrypt(pass, 'keyword') AS pass 
                          FROM usuario
                          WHERE email = :email
                          AND deleted_at IS NULL");
        
        $this->db->bind('email', $data['email']);
        return $this->db->register(); 
    }

    /* Método para cambiar contraseña (recuperación de cuenta, etc.) */
    public function change_pass($pass, $email)
    {
        $keyw = 'keyword';
        $this->db->query("UPDATE usuario SET
                          pass = aes_encrypt(:new_pass,:keyword),
                          updated_at = CURRENT_TIMESTAMP
                          WHERE email = :mail AND deleted_at IS NULL");
                          
        $this->db->bind('new_pass', $pass);
        $this->db->bind('keyword', $keyw);
        $this->db->bind('mail', $email);
        
        return $this->db->execute();
    }
}
?>