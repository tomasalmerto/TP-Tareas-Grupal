import { API_BASE_URL_PERMISOS } from '../../config.js';

export const renderPermisos = async (container) => {
  
    container.innerHTML = `
        <div style="padding: 20px;">
            <h2>Cargando permisos...</h2>
        </div>
    `;

    try {
        const response = await fetch(`${API_BASE_URL_PERMISOS}`);
        const resultado = await response.json();

        if (resultado.success) {
            const permisos = resultado.data; 

            let html = `
                <div style="padding: 20px;">
                    <h1>Gestión de Permisos</h1>
                    <div style="margin-bottom: 15px;">
                        <button id="btn-crear-permiso" style="padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                            + Crear Nuevo Permiso
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

      
            if (permisos.length > 0) {
                permisos.forEach(permiso => {
                    html += `
                        <tr>
                            <td>${permiso.id}</td>
                            <td>${permiso.nombre}</td>
                            <td>${permiso.descripcion}</td>
                            <td>
                                <button class="btn-editar" data-id="${permiso.id}" style="color: blue; cursor: pointer;">Editar</button> 
                               <button class="btn-eliminar" data-id="${permiso.id}" style="color: red; cursor: pointer;">Eliminar</button>
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
                    const idPermiso = e.target.getAttribute('data-id');
 
                    renderEditarPermiso(container, idPermiso);
                });
            });

            const botonesEliminar = container.querySelectorAll('.btn-eliminar');
            botonesEliminar.forEach(boton => {
                boton.addEventListener('click', async (e) => {
                    const idPermiso = e.target.getAttribute('data-id');

                    
                    if (confirm(`¿Estás seguro de que deseas eliminar el perminso con ID ${idPermiso}?`)) {
                        try {
                            const response = await fetch(`${API_BASE_URL_PERMISOS}/eliminar/${idPermiso}`, {
                                method: 'POST' 
                            });
                            const resultado = await response.json();

                            if (resultado.success) {
                                alert('Permiso eliminado con éxito');
                             
                                renderPermisos(container);
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

           
            document.getElementById('btn-crear-permiso').addEventListener('click', () => {
                renderCrearPermiso(container);
            });

        } else {
            container.innerHTML = `<h2>Error: ${resultado.message || 'No se pudieron cargar los permisos'}</h2>`;
        }

    } catch (error) {
        console.error("Error al cargar permisos:", error);
        container.innerHTML = `<h2>Error de conexión con el servidor.</h2>`;
    }
};

export const renderEditarPermiso = async (container, id) => {
    container.innerHTML = `<h2>Cargando formulario...</h2>`;

    try {
       
        const response = await fetch(`${API_BASE_URL_PERMISOS}/editar/${id}`);
        const resultado = await response.json();

        if (resultado.success) {
            const permiso = resultado.data;

            container.innerHTML = `
                <div style="padding: 20px;">
                    <h1>Editar Permiso: ${permiso.nombre}</h1>
                    <form id="form-editar-permiso">
                        <div style="margin-bottom: 10px;">
                            <label>Nombre:</label><br>
                            <input type="text" id="edit-nombre" value="${permiso.nombre}" required>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Descripcion:</label><br>
                            <input type="text" id="edit-descripcion" value="${permiso.descripcion}">
                        </div>
                        <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                            Guardar Cambios
                        </button>
                        <button type="button" id="btn-cancelar-edicion" style="padding: 10px; margin-left: 10px;">Cancelar</button>
                    </form>
                </div>
            `;

           
            document.getElementById('form-editar-permiso').addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const datosFormulario = {
                    nombre: document.getElementById('edit-nombre').value,
                    descripcion: document.getElementById('edit-descripcion').value,
                };

                try {
                    const updateRes = await fetch(`${API_BASE_URL_PERMISOS}/editar/${id}`, {
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(datosFormulario)
                    });
                    const updateData = await updateRes.json();

                    if (updateData.success) {
                        alert('Permiso actualizado correctamente');
                        renderPermisos(container); 
                    } else {
                        alert(updateData.message);
                    }
                } catch (err) {
                    alert('Error al guardar los cambios');
                }
            });

            
            document.getElementById('btn-cancelar-edicion').addEventListener('click', () => {
                renderPermisos(container);
            });

        } else {
            container.innerHTML = `<h2>Error: ${resultado.message}</h2>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<h2>Error al conectar con el servidor</h2>`;
    }
};

export const renderCrearPermiso = (container) => {
   
    container.innerHTML = `
        <div style="padding: 20px;">
            <h1>Crear Nuevo Permiso</h1>
            <form id="form-crear-permiso">
                <div style="margin-bottom: 10px;">
                    <label>Nombre:</label><br>
                    <input type="text" id="crear-nombre" placeholder="ver usuarios" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Descripción:</label><br>
                    <input type="text" id="crear-descripcion" placeholder="puede gestionar usuarios">
                </div>
                <button type="submit" style="padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                    Guardar Permiso
                </button>
                <button type="button" id="btn-cancelar-creacion" style="padding: 10px; margin-left: 10px;">Cancelar</button>
            </form>
        </div>
    `;

    
    document.getElementById('form-crear-permiso').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const datosFormulario = {
            nombre: document.getElementById('crear-nombre').value,
            descripcion: document.getElementById('crear-descripcion').value
        };

        try {
            const response = await fetch(`${API_BASE_URL_PERMISOS}/crear`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosFormulario)
            });
            
            const resultado = await response.json();

            if (resultado.success) {
                alert('Permiso creado correctamente');
              
                renderPermisos(container); 
            } else {
                alert(resultado.message);
            }
        } catch (error) {
            console.error("Error al crear:", error);
            alert('Error de conexión al intentar crear el permiso');
        }
    });

    
    document.getElementById('btn-cancelar-creacion').addEventListener('click', () => {
        renderPermisos(container);
    });
};