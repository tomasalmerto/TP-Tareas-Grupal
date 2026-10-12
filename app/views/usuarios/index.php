<!-- app/views/usuarios/index.php -->
<?php
/**
 * @var array $datos
 */
?>
<h1><?php echo $datos['titulo']; ?></h1>

<div style="margin-bottom: 15px;">
    <a href="/usuarios/crear" style="padding: 10px; background-color: #28a745; color: white; text-decoration: none;">+ Crear Nuevo Usuario</a>
</div>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th>Nombre Completo</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($datos['usuarios'] as $usuario) : ?>
        <tr>
           
            <td><?php echo $usuario['id']; ?></td>
            <td><img src="<?php echo $usuario['avatar']; ?>" alt="Avatar" width="40"></td>
            <td><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></td>
            <td><?php echo $usuario['email']; ?></td>
            <td><?php echo $usuario['rol_nombre']; ?></td>
            <td>
                <a href="/usuarios/editar/<?php echo $usuario['id']; ?>" style="color: blue;">Editar</a> | 
                <form action="/usuarios/eliminar/<?php echo $usuario['id']; ?>" method="POST" ...>
                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer; text-decoration: underline;">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>