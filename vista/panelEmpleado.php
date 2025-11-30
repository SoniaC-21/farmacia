<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado - Farmacia</title>
    <link rel="stylesheet" href="estilos_empleado.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Panel Empleado</h2>
        <ul class="sidebar-menu">
            <li><a href="#" class="menu-item active" data-section="inventario">📦 Inventario</a></li>
            <li><a href="#" class="menu-item" data-section="compras">🛒 Compras</a></li>
            <li><a href="#" class="menu-item" data-section="ventas">💰 Ventas</a></li>
            <li><a href="#" class="menu-item" data-section="agregar">➕ Agregar Producto</a></li>
            <li><a href="#" class="menu-item" data-section="agregarCompra">🧾 Agregar Compra</a></li>
            <li><a href="#" class="menu-item" data-section="agregarVenta">💵 Agregar Venta</a></li>
            <li><a href="../">Cerrar sesión</a></li>
        </ul>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="header">
            <h1>Panel de Empleado</h1>
        </div>

        <!-- Sección: Inventario -->
        <div id="inventario" class="section active">
            <h2>Inventario de Productos</h2>
            <div class="search-box">
                <input type="text" id="buscarProducto" placeholder="Buscar producto por nombre...">
            </div>
            <div id="alert-inventario"></div>
                <div class="table-responsive">
                    <table id="tablaInventario">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Presentación</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Fecha Caducidad</th>
                                <th>Requiere Receta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyInventario">
                            <tr>
                                <td colspan="8" style="text-align: center;">Cargando productos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        <!-- Sección: Compras -->
        <div id="compras" class="section">
            <h2>Historial de Compras</h2>
            <div id="alert-compras"></div>
            <table id="tablaCompras">
                <thead>
                    <tr>
                        <th>ID Compra</th>
                        <th>Fecha</th>
                        <th>ID Proveedor</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyCompras">
                    <tr>
                        <td colspan="5" style="text-align: center;">Cargando compras...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Sección: Ventas -->
        <div id="ventas" class="section">
            <h2>Historial de Ventas</h2>
            <div id="alert-ventas"></div>

            <table id="tablaVentas">
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Fecha</th>
                        <th>ID Cliente</th>
                        <th>Total</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyVentas">
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Cargando ventas...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Sección: Agregar Producto -->
        <div id="agregar" class="section">
            <h2>Agregar Nuevo Producto</h2>
            <div id="alert-agregar"></div>
            <form id="formAgregarProducto">
                <div class="form-group">
                    <label>Nombre del Producto *</label>
                    <input type="text" id="nombreProducto" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Presentación</label>
                        <input type="text" id="presentacionProducto" placeholder="Ej: Caja de 20, Frasco 100ml">
                    </div>
                    <div class="form-group">
                        <label>Precio *</label>
                        <input type="number" id="precioProducto" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Cantidad Existente *</label>
                        <input type="number" id="cantidadProducto" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Caducidad</label>
                        <input type="date" id="fechaCaducidadProducto">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>ID Proveedor</label>
                        <input type="number" id="idProveedorProducto" min="0">
                    </div>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; margin-top: 25px;">
                            <input type="checkbox" id="necesitaRecetaProducto" style="width: auto; margin-right: 10px;">
                            Requiere Receta Médica
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Producto</button>
            </form>
        </div>
    

        <!-- Sección: Agregar Compra -->
        <div id="agregarCompra" class="section">
            <h2>Registrar Nueva Compra</h2>
            <div id="alert-agregar-compra"></div>

            <form id="formAgregarCompra">
                <div class="form-group">
                    <label>Fecha de Compra *</label>
                    <input type="date" id="fechaCompra" required>
                </div>

                <div class="form-group">
                    <label>ID Proveedor *</label>
                    <input type="number" id="idProveedorCompra" min="1" required>
                </div>

                <div class="form-group">
                    <label>Total de Compra *</label>
                    <input type="number" id="totalCompra" step="0.01" min="0" required>
                </div>

                <button type="submit" class="btn btn-primary">Registrar Compra</button>
            </form>
        </div>

        <!-- Sección: Agregar Venta -->
        <div id="agregarVenta" class="section">
            <h2>Registrar Nueva Venta</h2>
            <div id="alert-agregar-venta"></div>

            <form id="formAgregarVenta">
                <div class="form-group">
                    <label>Cliente *</label>
                    <select id="clienteVenta" required>
                        <option value="">Seleccione un cliente...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Buscar Producto</label>
                    <div class="search-container">
                        <input type="text" id="buscarProductoVenta" placeholder="Buscar por nombre...">
                        <button type="button" class="btn btn-primary" onclick="buscarProductoParaVenta()">Buscar</button>
                    </div>
                </div>

                <div id="resultadosBusquedaVenta"></div>

                <h3>Productos en la Venta</h3>
                <div id="productosVenta">
                    <p>No hay productos agregados</p>
                </div>

                <div class="total-box">
                    <strong>Total: $<span id="totalVenta">0.00</span></strong>
                </div>

                <button type="submit" class="btn btn-primary" id="btnRegistrarVenta" disabled>Registrar Venta</button>
            </form>
        </div>

    </div>

    <!-- Modal para Detalles de Compra/Venta -->
    <div id="modalDetalle" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="tituloModalDetalle">Detalles</h3>
                <button class="close-modal" onclick="cerrarModal()">&times;</button>
            </div>
            <div id="contenidoDetalle"></div>
        </div>
    </div>

    <script>
        // Cambiar secciones
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                
                // Actualizar menú activo
                document.querySelectorAll('.menu-item').forEach(m => m.classList.remove('active'));
                this.classList.add('active');
                
                // Mostrar sección correspondiente
                document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
                document.getElementById(section).classList.add('active');
                
                // Cargar datos según la sección
                if (section === 'inventario') {
                    cargarInventario();
                } 
                else if (section === 'compras') {
                    cargarCompras();
                } 
                else if (section === 'ventas') {
                    cargarVentas();
                }
                else if (section === 'agregarVenta') {
                    cargarClientes();
                    productosVentaLista = [];
                    actualizarListaProductosVenta();
                }

            });
        });

        // Cargar inventario
        function cargarInventario() {
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'accion=obtener_productos'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarInventario(data.data);
                } else {
                    mostrarAlerta('alert-inventario', 'Error al cargar productos', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-inventario', 'Error al cargar productos', 'error');
            });
        }

        // Mostrar inventario en tabla
        function mostrarInventario(productos) {
            const tbody = document.getElementById('tbodyInventario');
            
            if (productos.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay productos registrados</td></tr>';
                return;
            }
            
            tbody.innerHTML = productos.map(producto => {
                const fechaCaducidad = producto.fecha_caducidad ? new Date(producto.fecha_caducidad).toLocaleDateString('es-ES') : '-';
                const requiereReceta = producto.necesita_receta == 1 || producto.necesita_receta == '1' ? 'Sí' : 'No';
                
                return `
                <tr>
                    <td>${producto.id_producto}</td>
                    
                    <td title="${producto.nombre_producto}">${producto.nombre_producto}</td>
                    <td>${producto.presentacion_producto || '-'}</td>
                    <td>$${parseFloat(producto.precio_producto || 0).toFixed(2)}</td>
                    <td>
                        <input type="number" class="stock-input" value="${producto.cantidad_existente || 0}" 
                               data-id="${producto.id_producto}" min="0" 
                               onchange="actualizarStock(${producto.id_producto}, this.value)">
                    </td>
                    <td>${fechaCaducidad}</td>
                    <td>${requiereReceta}</td>
                    <td class="actions-cell">
                        <button class="btn btn-danger btn-small" onclick="eliminarProducto(${producto.id_producto})">Eliminar</button>
                    </td>
                </tr>
            `;
            }).join('');
        }

        // Actualizar stock
        function actualizarStock(id, stock) {
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `accion=actualizar_stock&id=${id}&stock=${stock}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('alert-inventario', 'Stock actualizado correctamente', 'success');
                } else {
                    mostrarAlerta('alert-inventario', data.message || 'Error al actualizar stock', 'error');
                    cargarInventario(); // Recargar para restaurar valor
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-inventario', 'Error al actualizar stock', 'error');
                cargarInventario();
            });
        }

        // Eliminar producto
        function eliminarProducto(id) {
            if (!confirm('¿Está seguro de eliminar este producto?')) {
                return;
            }
            
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `accion=eliminar_producto&id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('alert-inventario', 'Producto eliminado correctamente', 'success');
                    cargarInventario();
                } else {
                    mostrarAlerta('alert-inventario', data.message || 'Error al eliminar producto', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-inventario', 'Error al eliminar producto', 'error');
            });
        }

        // Cargar compras
        function cargarCompras() {
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'accion=obtener_compras'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarCompras(data.data);
                } else {
                    mostrarAlerta('alert-compras', 'Error al cargar compras', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-compras', 'Error al cargar compras', 'error');
            });
        }
        
        // Cargar ventas
        function cargarVentas() {
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'accion=obtener_ventas'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarVentas(data.data);
                } else {
                    mostrarAlerta('alert-ventas', 'Error al cargar ventas', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-ventas', 'Error al cargar ventas', 'error');
            });
        }


        // Mostrar ventas en tabla
        function mostrarVentas(ventas) {
            const tbody = document.getElementById('tbodyVentas');

            if (ventas.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;">No hay ventas registradas</td></tr>';
                return;
            }

            tbody.innerHTML = ventas.map(v => `
                <tr>
                    <td>${v.id_venta}</td>
                    <td>${v.fecha_venta || v.fecha}</td>
                    <td>${v.id_cliente}</td>
                    <td>$${parseFloat(v.total_venta || 0).toFixed(2)}</td>
                    <td><button class="btn btn-primary btn-small" onclick="verDetalleVenta(${v.id_venta})">Ver detalles</button></td>
                </tr>
            `).join('');
        }


        // Mostrar compras en tabla
        function mostrarCompras(compras) {
            const tbody = document.getElementById('tbodyCompras');
            
            if (compras.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No hay compras registradas</td></tr>';
                return;
            }
            
            tbody.innerHTML = compras.map(compra => `
                <tr>
                    <td>${compra.id_compra}</td>
                    <td>${compra.fecha_compra || compra.fecha}</td>
                    <td>${compra.id_proveedor}</td>

                    <td>$${parseFloat(compra.total_compra || 0).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-primary btn-small" onclick="verDetalleCompra(${compra.id_compra})">Ver Detalles</button>
                    </td>
                </tr>
            `).join('');
        }

        // Ver detalles de compra
        function verDetalleCompra(id_compra) {
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `accion=obtener_detalle_compra&id_compra=${id_compra}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarDetalleCompra(data.data);
                    document.getElementById('modalDetalle').classList.add('active');
                } else {
                    alert('Error al cargar detalles de la compra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar detalles de la compra');
            });
        }

        // Ver detalles de venta
        function verDetalleVenta(idVenta) {
            const formData = new FormData();
            formData.append("accion", "obtener_detalle_venta");
            formData.append("id_venta", idVenta);

            fetch("../controlador/panelEmpleadoControler.php", {
                method: "POST",
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return res.json();
            })
            .then(data => {
                if (!data.success) {
                    alert("Error al cargar detalles: " + (data.message || "Error desconocido"));
                    return;
                }

                mostrarModalDetalleVenta(data.data);
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error al cargar detalles de la venta");
            });
        }


        // Mostrar detalles de compra en modal
        function mostrarDetalleCompra(detalles) {
            const modal = document.getElementById('modalDetalle');
            const titulo = document.getElementById('tituloModalDetalle');
            const contenido = document.getElementById('contenidoDetalle');
            
            if (!modal || !titulo || !contenido) {
                alert("Error: No se encontraron los elementos del modal");
                return;
            }

            titulo.innerText = "Detalle de Compra";
            
            if (detalles.length === 0) {
                contenido.innerHTML = '<p>No hay detalles disponibles</p>';
                modal.classList.add('active');
                return;
            }
            
            let html = '<table class="tabla-detalle"><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr></thead><tbody>';
            let total = 0;
            
            detalles.forEach(detalle => {
                const precio = detalle.precio || detalle.precio_producto || detalle.precio_compra_producto || 0;
                const cantidad = parseFloat(detalle.cantidad || 0);
                const subtotal = parseFloat(precio) * cantidad;
                total += subtotal;
                html += `
                    <tr>
                        <td>${detalle.nombre_producto || '-'}</td>
                        <td>${cantidad}</td>
                        <td>$${parseFloat(precio).toFixed(2)}</td>
                        <td>$${subtotal.toFixed(2)}</td>
                    </tr>
                `;
            });
            
            html += '</tbody></table>';
            html += `<p style="margin-top: 20px; font-weight: bold; font-size: 18px;">Total: $${total.toFixed(2)}</p>`;
            
            contenido.innerHTML = html;
            modal.classList.add('active');
        }

        function mostrarModalDetalleVenta(detalles) {
            const modal = document.getElementById("modalDetalle");
            const titulo = document.getElementById("tituloModalDetalle");
            const contenido = document.getElementById("contenidoDetalle");

            if (!modal || !titulo || !contenido) {
                alert("Error: No se encontraron los elementos del modal");
                return;
            }

            titulo.innerText = "Detalle de Venta";

            if (detalles.length === 0) {
                contenido.innerHTML = '<p>No hay detalles disponibles</p>';
                modal.classList.add('active');
                return;
            }

            let html = '<table class="tabla-detalle"><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr></thead><tbody>';
            let total = 0;

            detalles.forEach(d => {
                const precio = parseFloat(d.precio_venta_producto || 0);
                const cantidad = parseFloat(d.cantidad || 0);
                const subtotal = precio * cantidad;
                total += subtotal;
                
                html += `
                    <tr>
                        <td>${d.nombre_producto || '-'}</td>
                        <td>${cantidad}</td>
                        <td>$${precio.toFixed(2)}</td>
                        <td>$${subtotal.toFixed(2)}</td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            html += `<p style="margin-top: 20px; font-weight: bold; font-size: 18px;">Total: $${total.toFixed(2)}</p>`;

            contenido.innerHTML = html;
            modal.classList.add('active');
        }


        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modalDetalle').classList.remove('active');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalDetalle').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });

        // Formulario agregar producto
        document.getElementById('formAgregarProducto').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombre = document.getElementById('nombreProducto').value;
            const precio = document.getElementById('precioProducto').value;
            const cantidad = document.getElementById('cantidadProducto').value;
            const presentacion = document.getElementById('presentacionProducto').value;
            const fechaCaducidad = document.getElementById('fechaCaducidadProducto').value;
            const idProveedor = document.getElementById('idProveedorProducto').value;
            const necesitaReceta = document.getElementById('necesitaRecetaProducto').checked;
            
            let body = `accion=agregar_producto&nombre=${encodeURIComponent(nombre)}&precio=${precio}&cantidad=${cantidad}&presentacion=${encodeURIComponent(presentacion)}`;
            
            if (fechaCaducidad) {
                body += `&fecha_caducidad=${fechaCaducidad}`;
            }
            if (idProveedor) {
                body += `&id_proveedor=${idProveedor}`;
            }
            if (necesitaReceta) {
                body += `&necesita_receta=1`;
            }
            
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: body
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('alert-agregar', 'Producto agregado correctamente', 'success');
                    this.reset();
                    // Cambiar a inventario y recargar
                    setTimeout(() => {
                        document.querySelector('[data-section="inventario"]').click();
                    }, 1000);
                } else {
                    mostrarAlerta('alert-agregar', data.message || 'Error al agregar producto', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-agregar', 'Error al agregar producto', 'error');
            });
        });

        // Variables globales para venta
        let productosVentaLista = [];

        // Cargar clientes
        function cargarClientes() {
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'accion=obtener_clientes'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('clienteVenta');
                    select.innerHTML = '<option value="">Seleccione un cliente...</option>';
                    data.data.forEach(cliente => {
                        const option = document.createElement('option');
                        option.value = cliente.id_cliente;
                        option.textContent = `${cliente.nombre_cliente} (${cliente.email_cliente})`;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Buscar producto para venta
        function buscarProductoParaVenta() {
            const nombre = document.getElementById('buscarProductoVenta').value.trim();
            
            if (nombre.length === 0) {
                document.getElementById('resultadosBusquedaVenta').innerHTML = '';
                return;
            }

            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `accion=buscar_producto&nombre=${encodeURIComponent(nombre)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarResultadosBusqueda(data.data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Mostrar resultados de búsqueda
        function mostrarResultadosBusqueda(productos) {
            const div = document.getElementById('resultadosBusquedaVenta');
            
            if (productos.length === 0) {
                div.innerHTML = '<p style="color: #999;">No se encontraron productos</p>';
                return;
            }

            let html = '<div style="border: 1px solid #ddd; border-radius: 6px; padding: 10px; max-height: 300px; overflow-y: auto;">';
            html += '<table style="width: 100%; font-size: 14px;">';
            html += '<thead><tr><th>Producto</th><th>Precio</th><th>Stock</th><th>Acción</th></tr></thead><tbody>';

            productos.forEach(prod => {
                const stock = parseInt(prod.cantidad_existente || 0);
                const puedeAgregar = stock > 0;
                html += `
                    <tr>
                        <td>${prod.nombre_producto}</td>
                        <td>$${parseFloat(prod.precio_producto || 0).toFixed(2)}</td>
                        <td>${stock}</td>
                        <td>
                            ${puedeAgregar ? 
                                `<button type="button" class="btn btn-primary btn-small" onclick="agregarProductoAVenta(${prod.id_producto}, '${prod.nombre_producto.replace(/'/g, "\\'")}', ${prod.precio_producto}, ${stock})">Agregar</button>` :
                                '<span class="sin-stock">Sin stock</span>'
                            }
                        </td>
                    </tr>
                `;
            });

            html += '</tbody></table></div>';
            div.innerHTML = html;
        }

        // Agregar producto a la lista de venta
        function agregarProductoAVenta(idProducto, nombre, precio, stock) {
            // Verificar si ya está en la lista
            const existe = productosVentaLista.find(p => p.id_producto === idProducto);
            if (existe) {
                alert('Este producto ya está en la lista. Puede modificar la cantidad desde la lista.');
                return;
            }

            productosVentaLista.push({
                id_producto: idProducto,
                nombre: nombre,
                precio: parseFloat(precio),
                cantidad: 1,
                stock: parseInt(stock)
            });

            actualizarListaProductosVenta();
            document.getElementById('buscarProductoVenta').value = '';
            document.getElementById('resultadosBusquedaVenta').innerHTML = '';
        }

        // Actualizar lista de productos en la venta
        function actualizarListaProductosVenta() {
            const div = document.getElementById('productosVenta');
            const totalSpan = document.getElementById('totalVenta');
            const btnRegistrar = document.getElementById('btnRegistrarVenta');

            if (productosVentaLista.length === 0) {
                div.innerHTML = '<p style="color: #999;">No hay productos agregados</p>';
                totalSpan.textContent = '0.00';
                btnRegistrar.disabled = true;
                return;
            }

            let html = '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
            html += '<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acción</th></tr></thead><tbody>';

            let total = 0;

            productosVentaLista.forEach((prod, index) => {
                const subtotal = prod.precio * prod.cantidad;
                total += subtotal;

                html += `
                    <tr>
                        <td>${prod.nombre}</td>
                        <td>$${prod.precio.toFixed(2)}</td>
                        <td>
                            <input type="number" 
                                   value="${prod.cantidad}" 
                                   min="1" 
                                   max="${prod.stock}"
                                   class="cantidad-input"
                                   onchange="actualizarCantidadVenta(${index}, this.value)">
                            <small class="stock-info">(Stock: ${prod.stock})</small>
                        </td>
                        <td>$${subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-small" onclick="eliminarProductoVenta(${index})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            div.innerHTML = html;
            totalSpan.textContent = total.toFixed(2);
            btnRegistrar.disabled = false;
        }

        // Actualizar cantidad de un producto
        function actualizarCantidadVenta(index, cantidad) {
            cantidad = parseInt(cantidad);
            const prod = productosVentaLista[index];
            
            if (cantidad < 1) {
                cantidad = 1;
            }
            if (cantidad > prod.stock) {
                cantidad = prod.stock;
                alert(`La cantidad no puede ser mayor al stock disponible (${prod.stock})`);
            }

            prod.cantidad = cantidad;
            actualizarListaProductosVenta();
        }

        // Eliminar producto de la lista
        function eliminarProductoVenta(index) {
            productosVentaLista.splice(index, 1);
            actualizarListaProductosVenta();
        }

        // Formulario agregar venta
        document.getElementById('formAgregarVenta').addEventListener('submit', function(e) {
            e.preventDefault();

            const idCliente = document.getElementById('clienteVenta').value;

            if (!idCliente) {
                mostrarAlerta('alert-agregar-venta', 'Debe seleccionar un cliente', 'error');
                return;
            }

            if (productosVentaLista.length === 0) {
                mostrarAlerta('alert-agregar-venta', 'Debe agregar al menos un producto', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('accion', 'registrar_venta_completa');
            formData.append('id_cliente', idCliente);
            formData.append('productos', JSON.stringify(productosVentaLista.map(p => ({
                id_producto: p.id_producto,
                cantidad: p.cantidad
            }))));

            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('alert-agregar-venta', `Venta registrada correctamente. Total: $${data.total.toFixed(2)}`, 'success');
                    
                    // Reset form
                    document.getElementById('formAgregarVenta').reset();
                    productosVentaLista = [];
                    actualizarListaProductosVenta();
                    document.getElementById('resultadosBusquedaVenta').innerHTML = '';

                    // Cambiar a sección ventas y recargar tabla
                    setTimeout(() => {
                        document.querySelector('[data-section="ventas"]').click();
                    }, 1500);
                } else {
                    mostrarAlerta('alert-agregar-venta', data.message || 'Error al registrar venta', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('alert-agregar-venta', 'Error al registrar venta', 'error');
            });
        });

        // Formulario agregar compra
document.getElementById('formAgregarCompra').addEventListener('submit', function(e) {
    e.preventDefault();

    const fecha = document.getElementById('fechaCompra').value;
    const proveedor = document.getElementById('idProveedorCompra').value;
    const total = document.getElementById('totalCompra').value;

    const body = `accion=agregar_compra&fecha_compra=${fecha}&id_proveedor=${proveedor}&total_compra=${total}`;

    fetch('../controlador/panelEmpleadoControler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarAlerta('alert-agregar-compra', 'Compra registrada correctamente', 'success');

            // Reset form
            document.getElementById('formAgregarCompra').reset();

            // Cambiar a sección compras y recargar tabla
            setTimeout(() => {
                document.querySelector('[data-section="compras"]').click();
            }, 1000);
        } else {
            mostrarAlerta('alert-agregar-compra', data.message || 'Error al registrar compra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarAlerta('alert-agregar-compra', 'Error al registrar compra', 'error');
    });
});


        // Buscar producto
        document.getElementById('buscarProducto').addEventListener('input', function() {
            const nombre = this.value.trim();
            
            if (nombre.length === 0) {
                cargarInventario();
                return;
            }
            
            fetch('../controlador/panelEmpleadoControler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `accion=buscar_producto&nombre=${encodeURIComponent(nombre)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarInventario(data.data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Mostrar alerta
        function mostrarAlerta(id, mensaje, tipo) {
            const alertDiv = document.getElementById(id);
            alertDiv.innerHTML = `<div class="alert alert-${tipo === 'success' ? 'success' : 'error'}">${mensaje}</div>`;
            setTimeout(() => {
                alertDiv.innerHTML = '';
            }, 3000);
        }

        // Buscar producto con Enter
        document.getElementById('buscarProductoVenta').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                buscarProductoParaVenta();
            }
        });

        // Cargar inventario al iniciar
        cargarInventario();
    </script>
</body>
</html>
