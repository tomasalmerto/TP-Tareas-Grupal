-- 1. Tabla de Roles

CREATE TABLE IF NOT EXISTS roles (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(50) NOT NULL,

    descripcion TEXT

);



-- 2. Tabla de Permisos

CREATE TABLE IF NOT EXISTS permisos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(50) NOT NULL, -- Ej: 'usuarios.crear'

    descripcion TEXT

);



-- 3. Relación Muchos a Muchos: Roles y Permisos

CREATE TABLE IF NOT EXISTS rol_permiso (

    id_rol INT,

    id_permiso INT,

    PRIMARY KEY (id_rol, id_permiso),

    FOREIGN KEY (id_rol) REFERENCES roles(id) ON DELETE CASCADE,

    FOREIGN KEY (id_permiso) REFERENCES permisos(id) ON DELETE CASCADE

);



-- 4. Modificar tabla Usuario para incluir Rol y Soft Delete

ALTER TABLE usuario ADD COLUMN fk_id_rol INT AFTER id;

ALTER TABLE usuario ADD COLUMN activo TINYINT(1) DEFAULT 1;

ALTER TABLE usuario ADD FOREIGN KEY (fk_id_rol) REFERENCES roles(id);



-- 5. Tabla de Equipos

CREATE TABLE IF NOT EXISTS equipos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100) NOT NULL,

    descripcion TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



-- 6. Relación Muchos a Muchos: Usuarios y Equipos

CREATE TABLE IF NOT EXISTS usuario_equipo (

    id_usuario INT,

    id_equipo INT,

    es_lider_equipo TINYINT(1) DEFAULT 0, -- Para identificar al líder del equipo

    PRIMARY KEY (id_usuario, id_equipo),

    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE,

    FOREIGN KEY (id_equipo) REFERENCES equipos(id) ON DELETE CASCADE

);



-- 7. Datos Iniciales Obligatorios

INSERT INTO roles (nombre, descripcion) VALUES ('Líder', 'Administrador total'), ('Miembro', 'Usuario de equipo'); 

-- 1. Insertar catálogo de permisos (ajusta los nombres a lo que uses en tus controladores)
INSERT INTO permisos (nombre, descripcion) VALUES
('tareas.crear', 'Permite registrar nuevas tareas'),
('tareas.editar', 'Permite modificar tareas existentes'),
('tareas.eliminar', 'Permite borrar tareas'),
('tareas.ver_todas', 'Ver tareas de todo el equipo'),
('usuarios.gestionar', 'Crear y administrar miembros del equipo');

-- 2. Asignar permisos a los roles
-- Rol 1 (Líder): Acceso a todo
INSERT INTO rol_permiso (id_rol, id_permiso) VALUES
(1, 1), -- tareas.crear
(1, 2), -- tareas.editar
(1, 3), -- tareas.eliminar
(1, 4), -- tareas.ver_todas
(1, 5); -- usuarios.gestionar

-- Rol 2 (Miembro): Solo crear y editar
INSERT INTO rol_permiso (id_rol, id_permiso) VALUES
(2, 1), -- tareas.crear
(2, 2); -- tareas.editar

-- 3. Asignar rol a los usuarios existentes (evita que queden en NULL)
-- Asignamos Líder (1) a tu usuario principal (ej: Juan con ID 11)
UPDATE usuario SET fk_id_rol = 1 WHERE id = 11;

-- Asignamos Miembro (2) al resto de usuarios existentes
UPDATE usuario SET fk_id_rol = 2 WHERE fk_id_rol IS NULL;