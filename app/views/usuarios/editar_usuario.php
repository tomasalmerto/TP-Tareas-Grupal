<!-- app/views/usuarios/editar.php -->
<?php
/**
 * @var array $datos
 */
?>
<h1><?php echo $datos['titulo']; ?></h1>

<!-- Pasamos el ID del usuario en la URL del action -->
<form action="/usuarios/editar/<?php echo $datos['usuario']->id; ?>" method="POST">
    
    <div>
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" value="<?php echo $datos['usuario']->nombre; ?>" required>
    </div>
    
    <div>
        <label for="apellido">Apellido:</label><br>
        <input type="text" name="apellido" id="apellido" value="<?php echo $datos['usuario']->apellido; ?>" required>
    </div>

    <div>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?php echo $datos['usuario']->email; ?>" required>
    </div>

    <div>
        <label for="avatar">URL del Avatar:</label><br>
        <input type="text" name="avatar" id="avatar" value="<?php echo $datos['usuario']->avatar; ?>">
    </div>

    <div>
        <label for="rol_id">Rol del Usuario:</label><br>
        <select name="fk_id_rol" id="rol_id" required>
            <?php foreach($datos['roles'] as $rol) : ?>
                <option value="<?php echo $rol->id; ?>" <?php echo ($datos['usuario']->rol_id == $rol->id) ? 'selected' : ''; ?>>
                    <?php echo $rol->nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <br>
    <button type="submit">Actualizar Usuario</button>
    <a href="/usuarios">Cancelar</a>
</form>