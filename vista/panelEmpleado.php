<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado - Farmacia</title>
    <link rel="stylesheet" href="../estilos.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1d6df7;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            padding-bottom: 15px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1d6df7;
            margin-bottom: 10px;
        }

        /* Secciones */
        .section {
            display: none;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section.active {
            display: block;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #1d6df7;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background: #f9f9f9;
        }

        /* Formularios */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Botones */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-primary {
            background: #1d6df7;
            color: white;
        }

        .btn-primary:hover {
            background: #004be0;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Buscador */
        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        /* Alertas */
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Modal para detalles de compra */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .close-modal:hover {
            color: #333;
        }

        .actions-cell {
            display: flex;
            gap: 5px;
        }

        .stock-input {
            width: 80px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Panel Empleado</h2>
        <ul class="sidebar-menu">
            <li><a href="#" class="menu-item active" data-section="inventario">📦 Inventario</a></li>
            <li><a href="#" class="menu-item" data-section="compras">🛒 Compras</a></li>
            <li><a href="#" class="menu-item" data-section="agregar">➕ Agregar Producto</a></li>
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
    </div>

    <!-- Modal para Detalles de Compra -->
    <div id="modalDetalle" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalles de la Compra</h3>
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
                } else if (section === 'compras') {
                    cargarCompras();
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
                    <td>${producto.nombre_producto}</td>
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

        // Mostrar detalles de compra en modal
        function mostrarDetalleCompra(detalles) {
            const contenido = document.getElementById('contenidoDetalle');
            
            if (detalles.length === 0) {
                contenido.innerHTML = '<p>No hay detalles disponibles</p>';
                return;
            }
            
            let html = '<table><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr></thead><tbody>';
            let total = 0;
            
            detalles.forEach(detalle => {
                const precio = detalle.precio || detalle.precio_producto || 0;
                const subtotal = parseFloat(detalle.cantidad) * parseFloat(precio);
                total += subtotal;
                html += `
                    <tr>
                        <td>${detalle.nombre_producto}</td>
                        <td>${detalle.cantidad}</td>
                        <td>$${parseFloat(precio).toFixed(2)}</td>
                        <td>$${subtotal.toFixed(2)}</td>
                    </tr>
                `;
            });
            
            html += '</tbody></table>';
            html += `<p style="margin-top: 20px; font-weight: bold; font-size: 18px;">Total: $${total.toFixed(2)}</p>`;
            
            contenido.innerHTML = html;
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

        // Cargar inventario al iniciar
        cargarInventario();
    </script>
</body>
</html>
