<!-- app/views/usuarios/crear.php -->
<?php
/**
 * @var array $datos
 */
?>

<h1><?php echo $datos['titulo']; ?></h1>

<form action="/usuarios/crear" method="POST">
    <div>
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required>
    </div>
    
    <div>
        <label for="apellido">Apellido:</label><br>
        <input type="text" name="apellido" id="apellido" required>
    </div>

    <div>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required>
    </div>

    <div>
        <label for="pass">Contraseña:</label><br>
        <input type="password" name="pass" id="pass" required>
    </div>

    <div>
        <label for="avatar">URL del Avatar:</label><br>
        <input type="text" name="avatar" id="avatar" value="/public/img/default-avatar.png">
    </div>

    <div>
        <label for="rol_id">Rol del Usuario:</label><br>
        <select name="fk_id_rol" id="rol_id" required>
            <option value="">-- Selecciona un rol --</option>
            <?php foreach($datos['roles'] as $rol) : ?>
                <option value="<?php echo $rol->id; ?>">
                    <?php echo $rol->nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <br>
    <button type="submit">Guardar Usuario</button>
    <a href="/usuarios">Cancelar</a>
</form>