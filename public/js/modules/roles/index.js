import { API_BASE_URL_ROLES } from '../../config.js';

export const renderRoles = async (container) => {
  
    container.innerHTML = `
        <div style="padding: 20px;">
            <h2>Cargando roles...</h2>
        </div>
    `;

    try {
        const response = await fetch(`${API_BASE_URL_ROLES}`);
        const resultado = await response.json();

        if (resultado.success) {
            const roles = resultado.data; 

            let html = `
                <div style="padding: 20px;">
                    <h1>Gestión de Roles</h1>
                    <div style="margin-bottom: 15px;">
                        <button id="btn-crear-rol" style="padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                            + Crear Nuevo Rol
                        </button>
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
            `;

      
            if (roles.length > 0) {
                roles.forEach(rol => {
                    html += `
                        <tr>
                            <td>${rol.id}</td>
                            <td>${rol.nombre}</td>
                            <td>${rol.descripcion}</td>
                            <td>
                                <button class="btn-editar" data-id="${rol.id}" style="color: blue; cursor: pointer;">Editar</button> 
                               <button class="btn-eliminar" data-id="${rol.id}" style="color: red; cursor: pointer;">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="5" style="text-align: center;">No hay permisos</td></tr>`;
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
                    const idRol = e.target.getAttribute('data-id');
 
                    renderEditarRol(container, idRol);
                });
            });

            const botonesEliminar = container.querySelectorAll('.btn-eliminar');
            botonesEliminar.forEach(boton => {
                boton.addEventListener('click', async (e) => {
                    const idRol = e.target.getAttribute('data-id');

                    
                    if (confirm(`¿Estás seguro de que deseas eliminar el rol con ID ${idRol}?`)) {
                        try {
                            const response = await fetch(`${API_BASE_URL_ROLES}/eliminar/${idRol}`, {
                                method: 'POST' 
                            });
                            const resultado = await response.json();

                            if (resultado.success) {
                                alert('Rol eliminado con éxito');
                             
                                renderRoles(container);
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

           
            document.getElementById('btn-crear-rol').addEventListener('click', () => {
                renderCrearRol(container);
            });

        } else {
            container.innerHTML = `<h2>Error: ${resultado.message || 'No se pudieron cargar los roles'}</h2>`;
        }

    } catch (error) {
        console.error("Error al cargar roles:", error);
        container.innerHTML = `<h2>Error de conexión con el servidor.</h2>`;
    }
};

export const renderEditarRol = async (container, id) => {
    container.innerHTML = `<h2>Cargando formulario...</h2>`;

    try {
       
        const response = await fetch(`${API_BASE_URL_ROLES}/editar/${id}`);
        const resultado = await response.json();

        if (resultado.success) {
            const rol = resultado.data;

            container.innerHTML = `
                <div style="padding: 20px;">
                    <h1>Editar Rol: ${rol.nombre}</h1>
                    <form id="form-editar-rol">
                        <div style="margin-bottom: 10px;">
                            <label>Nombre:</label><br>
                            <input type="text" id="edit-nombre" value="${rol.nombre}" required>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Descripcion:</label><br>
                            <input type="text" id="edit-descripcion" value="${rol.descripcion}">
                        </div>
                        <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                            Guardar Cambios
                        </button>
                        <button type="button" id="btn-cancelar-edicion" style="padding: 10px; margin-left: 10px;">Cancelar</button>
                    </form>
                </div>
            `;

           
            document.getElementById('form-editar-rol').addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const datosFormulario = {
                    nombre: document.getElementById('edit-nombre').value,
                    descripcion: document.getElementById('edit-descripcion').value,
                };

                try {
                    const updateRes = await fetch(`${API_BASE_URL_ROLES}/editar/${id}`, {
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(datosFormulario)
                    });
                    const updateData = await updateRes.json();

                    if (updateData.success) {
                        alert('Rol actualizado correctamente');
                        renderRoles(container); 
                    } else {
                        alert(updateData.message);
                    }
                } catch (err) {
                    alert('Error al guardar los cambios');
                }
            });

            
            document.getElementById('btn-cancelar-edicion').addEventListener('click', () => {
                renderRoles(container);
            });

        } else {
            container.innerHTML = `<h2>Error: ${resultado.message}</h2>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<h2>Error al conectar con el servidor</h2>`;
    }
};

export const renderCrearRol = (container) => {
   
    container.innerHTML = `
        <div style="padding: 20px;">
            <h1>Crear Nuevo Rol</h1>
            <form id="form-crear-rol">
                <div style="margin-bottom: 10px;">
                    <label>Nombre:</label><br>
                    <input type="text" id="crear-nombre" placeholder="admin" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Descripción:</label><br>
                    <input type="text" id="crear-descripcion" placeholder="control total">
                </div>
                <button type="submit" style="padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                    Guardar Rol
                </button>
                <button type="button" id="btn-cancelar-creacion" style="padding: 10px; margin-left: 10px;">Cancelar</button>
            </form>
        </div>
    `;

    
    document.getElementById('form-crear-rol').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const datosFormulario = {
            nombre: document.getElementById('crear-nombre').value,
            descripcion: document.getElementById('crear-descripcion').value
        };

        try {
            const response = await fetch(`${API_BASE_URL_ROLES}/crear`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosFormulario)
            });
            
            const resultado = await response.json();

            if (resultado.success) {
                alert('Rol creado correctamente');
              
                renderRoles(container); 
            } else {
                alert(resultado.message);
            }
        } catch (error) {
            console.error("Error al crear:", error);
            alert('Error de conexión al intentar crear el rol');
        }
    });

    
    document.getElementById('btn-cancelar-creacion').addEventListener('click', () => {
        renderRoles(container);
    });
};