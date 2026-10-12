<!-- app/views/roles/index.php -->
<h1><?php echo $datos['titulo']; ?></h1>

<a href="/roles/crear">Crear nuevo rol</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($datos['roles'] as $rol) : ?>
        <tr>
            <td><?php echo $rol->id; ?></td> <!-- Usa $rol['id'] si tu PDO devuelve arrays en lugar de objetos -->
            <td><?php echo $rol->nombre; ?></td>
            <td><?php echo $rol->descripcion; ?></td>
            <td>
                <a href="/roles/editar/<?php echo $rol->id; ?>">Editar</a>
                
                <!-- Formulario para eliminar de forma segura por POST -->
                <form action="/roles/eliminar/<?php echo $rol->id; ?>" method="POST" style="display:inline;">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>