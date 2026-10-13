<!-- app/views/roles/index.php -->
<?php
/**
 * @var array $datos
 */
?>
<h1><?php echo $datos['titulo']; ?></h1>

<div style="margin-bottom: 15px;">
    <a href="/roles/crear" style="padding: 10px; background-color: #28a745; color: white; text-decoration: none;">+ Crear Nuevo Rol</a>
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
        <?php foreach($datos['roles'] as $rol) : ?>
        <tr>
           
            <td><?php echo $rol['id']; ?></td>
            <td><?php echo $rol['nombre']; ?></td>
            <td><?php echo $rol['decripcion']; ?></td>
            <td>
                <a href="/roles/editar/<?php echo $rol['id']; ?>" style="color: blue;">Editar</a> | 
                <form action="/roles/eliminar/<?php echo $rol['id']; ?>" method="POST" ...>
                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer; text-decoration: underline;">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>