import { API_BASE_URL_USUARIOS } from '../../config.js';
export const renderUsuarios = async (container) => {
  
    container.innerHTML = `
        <div style="padding: 20px;">
            <h2>Cargando usuarios...</h2>
        </div>
    `;

    try {
        const response = await fetch(`${API_BASE_URL_USUARIOS}`);
        const resultado = await response.json();

        if (resultado.success) {
            const usuarios = resultado.data; 

            let html = `
                <div style="padding: 20px;">
                    <h1>Gestión de Usuarios</h1>
                    <div style="margin-bottom: 15px;">
                        <button id="btn-crear-usuario" style="padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                            + Crear Nuevo Usuario
                        </button>
                    </div>
                    <table border="1" cellpadding="8" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

      
            if (usuarios.length > 0) {
                usuarios.forEach(usuario => {
                    html += `
                        <tr>
                            <td>${usuario.id}</td>
                            <td>${usuario.nombre} ${usuario.apellido}</td>
                            <td>${usuario.email}</td>
                            <td>${usuario.rol_nombre || 'Sin rol'}</td>
                            <td>
                                <button class="btn-editar" data-id="${usuario.id}" style="color: blue; cursor: pointer;">Editar</button> 
                               <button class="btn-eliminar" data-id="${usuario.id}" style="color: red; cursor: pointer;">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="5" style="text-align: center;">No hay usuarios registrados</td></tr>`;
            }

            html += `
                        </tbody>
                    </table>
                </div>
            `;

                        
            container.innerHTML = html;

            const botonesEditar = container.querySelectorAll('.btn-editar');
            botonesEditar.forEach(boton => {
                boton.addEventListener('click', (e) => {
                    const idUsuario = e.target.getAttribute('data-id');
 
                    renderEditarUsuario(container, idUsuario);
                });
            });

            const botonesEliminar = container.querySelectorAll('.btn-eliminar');
            botonesEliminar.forEach(boton => {
                boton.addEventListener('click', async (e) => {
                    const idUsuario = e.target.getAttribute('data-id');

                    
                    if (confirm(`¿Estás seguro de que deseas eliminar al usuario con ID ${idUsuario}?`)) {
                        try {
                            const response = await fetch(`${API_BASE_URL_USUARIOS}/eliminar/${idUsuario}`, {
                                method: 'POST' 
                            });
                            const resultado = await response.json();

                            if (resultado.success) {
                                alert('Usuario eliminado con éxito');
                             
                                renderUsuarios(container);
                            } else {
                                alert(resultado.message || 'Error al eliminar');
                            }
                        } catch (error) {
                            console.error("Error:", error);
                            alert('Error de conexión con el servidor.');
                        }
                    }
                });
            });

           
            document.getElementById('btn-crear-usuario').addEventListener('click', () => {
                console.log("Clic en crear usuario");
            });

        } else {
            container.innerHTML = `<h2>Error: ${resultado.message || 'No se pudieron cargar los usuarios'}</h2>`;
        }

    } catch (error) {
        console.error("Error al cargar usuarios:", error);
        container.innerHTML = `<h2>Error de conexión con el servidor.</h2>`;
    }
};

export const renderEditarUsuario = async (container, id) => {
    container.innerHTML = `<h2>Cargando formulario...</h2>`;

    try {
       
        const response = await fetch(`${API_BASE_URL_USUARIOS}/editar/${id}`);
        const resultado = await response.json();

        if (resultado.success) {
            const user = resultado.usuario;
            const roles = resultado.roles;

            
            let opcionesRoles = '';
            roles.forEach(rol => {
                const seleccionado = (user.fk_id_rol == rol.id) ? 'selected' : '';
                opcionesRoles += `<option value="${rol.id}" ${seleccionado}>${rol.nombre}</option>`;
            });

            
            container.innerHTML = `
                <div style="padding: 20px;">
                    <h1>Editar Usuario: ${user.nombre}</h1>
                    <form id="form-editar-usuario">
                        <div style="margin-bottom: 10px;">
                            <label>Nombre:</label><br>
                            <input type="text" id="edit-nombre" value="${user.nombre}" required>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Apellido:</label><br>
                            <input type="text" id="edit-apellido" value="${user.apellido || ''}">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Email:</label><br>
                            <input type="email" id="edit-email" value="${user.email}" required>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Rol:</label><br>
                            <select id="edit-rol" required>
                                ${opcionesRoles}
                            </select>
                        </div>
                        <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                            Guardar Cambios
                        </button>
                        <button type="button" id="btn-cancelar-edicion" style="padding: 10px; margin-left: 10px;">Cancelar</button>
                    </form>
                </div>
            `;

           
            document.getElementById('form-editar-usuario').addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const datosFormulario = {
                    nombre: document.getElementById('edit-nombre').value,
                    apellido: document.getElementById('edit-apellido').value,
                    email: document.getElementById('edit-email').value,
                    fk_id_rol: document.getElementById('edit-rol').value
                };

                try {
                    const updateRes = await fetch(`${API_BASE_URL_USUARIOS}/editar/${id}`, {
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(datosFormulario)
                    });
                    const updateData = await updateRes.json();

                    if (updateData.success) {
                        alert('Usuario actualizado correctamente');
                        renderUsuarios(container); 
                    } else {
                        alert(updateData.message);
                    }
                } catch (err) {
                    alert('Error al guardar los cambios');
                }
            });

            
            document.getElementById('btn-cancelar-edicion').addEventListener('click', () => {
                renderUsuarios(container);
            });

        } else {
            container.innerHTML = `<h2>Error: ${resultado.message}</h2>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<h2>Error al conectar con el servidor</h2>`;
    }
};