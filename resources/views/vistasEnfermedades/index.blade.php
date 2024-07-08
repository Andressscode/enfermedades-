@extends('layouts.app')

@section('content')
    <h1>Listado de Enfermedades Dentales</h1>
    <a href="{{route('categorias.pdf')}}" class="btn btn-success mb-3">PDF</a>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSucursalModal">
        Agregar
    </button>
    
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enfermedades as $enfermedad)
                    <tr>
                        <td>{{ $enfermedad->id }}</td>
                        <td>{{ $enfermedad->nombre }}</td>
                        <td>{{ $enfermedad->descripcion }}</td>
                        <td>
                            <button type="button" class="btn btn-primary"
                                onclick="mostrarDatosEditar('{{ $enfermedad->id }}', '{{ $enfermedad->nombre }}', '{{ $enfermedad->descripcion }}')"
                                data-bs-target="#editSucursalModal">Editar</button>
                            <button class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addSucursalModal" tabindex="-1" aria-labelledby="addSucursalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSucursalModalLabel">Agregar Nueva Enfermedad</h5>
                    <img src="/img/Logo4.png" alt="" style="width: 100px; height: auto;">
                </div>
                <div class="modal-body">
                    <form id="addEnfermedadForm">
                        <div class="mb-3">
                            <label for="enfermedadName" class="form-label">Nombre de la Enfermedad</label>
                            <input type="text" class="form-control" id="enfermedadName" required>
                        </div>
                        <div class="mb-3">
                            <label for="enfermedadDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="enfermedadDescription" rows="3" required></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:  #acd90b; color: black; border: none;">Cerrar</button>
                        <button type="button" id="enfermedadSubmit" class="btn btn-primary" style="background-color:  #acd90b; color: black; border: none;">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSucursalModal" tabindex="-1" aria-labelledby="editEnfermedadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEnfermedadModalLabel">Editar Enfermedad</h5>
                    <img src="/img/Logo4.png" alt="" style="width: 100px; height: auto;">
                </div>
                <div class="modal-body">
                    <form id="editEnfermedadForm">
                        <input type="hidden" id="editEnfermedadId">
                        <div class="mb-3">
                            <label for="editEnfermedadName" class="form-label">Nombre de la Enfermedad</label>
                            <input type="text" class="form-control" id="editEnfermedadName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEnfermedadDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editEnfermedadDescription" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="miVariableOculta" id="miVariableOculta" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:  #acd90b; color: black; border: none;">Cerrar</button>
                        <button type="button" id="btn" class="btn btn-primary" style="background-color:  #acd90b; color: black; border: none;">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Script JavaScript para manejar el formulario de agregar enfermedad -->
    <script>
        function closeModalAndReload() {
            const modal = document.getElementById('addSucursalModal');
            const modalBootstrap = bootstrap.Modal.getInstance(modal);
            modalBootstrap.hide();

            // Recarga la página actual
            location.reload();
        }

        document.getElementById('enfermedadSubmit').addEventListener('click', async function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('nombre', document.getElementById('enfermedadName').value);
            formData.append('descripcion', document.getElementById('enfermedadDescription').value);

            Swal.fire({
                title: '¿Quieres guardar estos datos?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const config = {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        };
                        const response = await axios.post('/enfermedades/create', formData, config);
                        console.log(response.data);

                        closeModalAndReload();
                    } catch (error) {
                        Swal.fire('Error al guardar la enfermedad', error.response.data.message, 'error');
                    }
                } else {
                    console.log('Cancelado');
                }
            });
        });

        function recargarPagina() {
            const modal = document.getElementById('editSucursalModal');
            const modalBootstrap = bootstrap.Modal.getInstance(modal);
            modalBootstrap.hide();

            // Recarga la página actual
            location.reload();
        }

        document.getElementById('editEnfermedadForm').addEventListener('click', async function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('nombre', document.getElementById('editEnfermedadName').value);
            formData.append('descripcion', document.getElementById('editEnfermedadDescription').value);
            let id = document.getElementById('miVariableOculta').value;
            console.log(id);

            Swal.fire({
                title: '¿Quieres actualizar el registro?',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const url = `/enfermedades/${id}`;
                    try {
                        const response = await axios.post(url, {
                            ...Object.fromEntries(formData),
                            _method: 'patch'
                        }, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        });
                        console.log(response.data);
                        Swal.fire('¡Registro Actualizado!', '', 'success');
                        recargarPagina();
                    } catch (error) {
                        Swal.fire('Error al actualizar el registro', error.response.data.message, 'error');
                    }
                }
            });
        });

        function mostrarDatosEditar(id, nombre, descripcion) {
            document.getElementById('editEnfermedadName').value = nombre;
            document.getElementById('editEnfermedadDescription').value = descripcion;
            document.getElementById('miVariableOculta').value = id;

            var myModal = new bootstrap.Modal(document.getElementById('editSucursalModal'));
            myModal.show();
        }
    </script>
@endsection
