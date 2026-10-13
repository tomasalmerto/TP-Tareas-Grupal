<!-- app/views/permisos/index.php -->
<?php
/**
 * @var array $datos
 */
?>
<h1><?php echo $datos['titulo']; ?></h1>

<div style="margin-bottom: 15px;">
    <a href="/permisos/crear" style="padding: 10px; background-color: #28a745; color: white; text-decoration: none;">+ Crear Nuevo Permiso</a>
</div>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($datos['permisos'] as $permiso) : ?>
        <tr>
           
            <td><?php echo $permiso['id']; ?></td>
            <td><?php echo $permiso['nombre']; ?></td>
            <td><?php echo $permiso['decripcion']; ?></td>
            <td>
                <a href="/permisos/editar/<?php echo $permiso['id']; ?>" style="color: blue;">Editar</a> | 
                <form action="/permisos/eliminar/<?php echo $permiso['id']; ?>" method="POST" ...>
                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer; text-decoration: underline;">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>