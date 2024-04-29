<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .cabecera {
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>
    <h1 class="text-center">REPORTE</h1>
    <table id="datatablesSimple" class="table" style="text-align:center; font-size: 20px">
        <thead class="cabecera">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Ubicación</th>
                <th>Categorías</th>
                <th>Estado</th>
                <th>Acciones</th>
                <!-- Agregar si es necesario -->
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @php $totalStock = 0; @endphp <!-- Inicializa el total de stock -->
            @foreach ($productos as $item)
                @php $totalStock += $item->stock; @endphp <!-- Acumula el stock de cada producto -->
                <tr>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->marca->caracteristica->nombre }}</td>
                    <td>{{ $item->presentacione->caracteristica->nombre }}</td>
                    <td>
                        @foreach ($item->categorias as $category)
                            <div class="container" style="font-size: small;">
                                <div class="row">
                                    <span
                                        class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{ $category->caracteristica->nombre }}</span>
                                </div>
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @if ($item->estado == 1)
                            <span class="badge rounded-pill text-bg-success">activo</span>
                        @else
                            <span class="badge rounded-pill text-bg-danger">eliminado</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-around">
                            <div>
                                <button title="Opciones" class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg class="svg-inline--fa fa-ellipsis-vertical" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="ellipsis-vertical" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M56 472a56 56 0 1 1 0-112 56 56 0 1 1 0 112zm0-160a56 56 0 1 1 0-112 56 56 0 1 1 0 112zM0 96a56 56 0 1 1 112 0A56 56 0 1 1 0 96z">
                                        </path>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                    <!-----Editar Producto--->
                                    @can('editar-producto')
                                        <li><a class="dropdown-item"
                                                href="{{ route('productos.edit', ['producto' => $item]) }}">Editar</a>
                                        </li>
                                    @endcan
                                    <!----Ver-producto--->
                                    @can('ver-producto')
                                        <li>
                                            <a class="dropdown-item" role="button" data-bs-toggle="modal"
                                                data-bs-target="#verModal-{{ $item->id }}">Ver</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                            <div>
                                <!----Separador----->
                                <div class="vr"></div>
                            </div>
                            <div>
                                <!------Eliminar producto---->
                                @can('eliminar-producto')
                                    @if ($item->estado == 1)
                                        <button title="Eliminar" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $item->id }}"
                                            class="btn btn-datatable btn-icon btn-transparent-dark">
                                            <svg class="svg-inline--fa fa-trash-can" aria-hidden="true" focusable="false"
                                                data-prefix="far" data-icon="trash-can" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z">
                                                </path>
                                            </svg>
                                        </button>
                                    @else
                                        <button title="Restaurar" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $item->id }}"
                                            class="btn btn-datatable btn-icon btn-transparent-dark">
                                            <i class="fa-solid fa-rotate"></i>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </td>
                    <!-- Mostrar el stock de cada producto si es necesario -->
                    <td>{{ $item->stock }}</td>
                </tr>
                <!-- Tus modales aquí -->
                <div class="modal fade" id="verModal-{{ $item->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del producto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p><span class="fw-bolder">Descripción: </span>{{ $item->descripcion }}
                                        </p>
                                    </div>
                                    {{-- <div class="col-12">
                                        <p><span class="fw-bolder">Fecha de vencimiento:
                                            </span>{{ $item->fecha_vencimiento == '' ? 'No tiene' : $item->fecha_vencimiento }}
                                        </p>
                                    </div> --}}
                                    <div class="col-12">
                                        <p><span class="fw-bolder">Stock: </span>{{ $item->stock }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-bolder">Imagen:</p>
                                        <div>
                                            @if ($item->img_path != null)
                                                <img src="{{ Storage::url('public/productos/' . $item->img_path) }}"
                                                    alt="{{ $item->nombre }}"
                                                    class="img-fluid img-thumbnail border-4 rounded">
                                            @else
                                                <img src="" alt="{{ $item->nombre }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de confirmación-->
                <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ $item->estado == 1 ? '¿Seguro que quieres eliminar el producto?' : '¿Seguro que quieres restaurar el producto?' }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{ route('productos.destroy', ['producto' => $item->id]) }}"
                                    method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Fila para mostrar el total -->
            <tr>
                <td colspan="7" class="text-right"><strong>Total Stock:</strong></td>
                <td><strong>{{ $totalStock }}</strong></td>
            </tr>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
