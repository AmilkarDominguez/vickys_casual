@extends('layouts.dashboard')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card m-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="card-title text-dark">Subcategorias</h2>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <button class="btn btn-outline-primary m-1" id="btn-import">
                            <i class="icon-file-excel"></i>&nbsp;Importar
                        </button>
                        <button class="btn btn-outline-success m-1" id="btn-agregar">
                            <i class="icon-plus"></i>&nbsp;Agregar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-striped ">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Descripción</td>
                                <td>Categoria</td>
                                <td>Estado</td>
                                <td>Editar</td>
                                <td>Eliminar</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals-->
<!-- Modal Datos -->

<div class="modal fade bd-example-modal-lg" id="modal_datos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-data" id="form-data" novalidate>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="md-form mb-3" id="select_tipo"></div>
                        <div class="md-form mb-3">
                            <label><b>Nombre:</b></label>
                            <textarea type="text" class="form-control" rows="4" id="name" name="name" placeholder="Nombre" required></textarea>
                            <div class="invalid-feedback">
                                Dato necesario.
                            </div>
                        </div>
                        <div class="md-form mb-3">
                            <label><b>Descripción:</b></label>
                            <textarea type="text" class="form-control" rows="4" id="description" name="description" placeholder="Descripción" required></textarea>
                            <div class="invalid-feedback">
                                Dato necesario.
                            </div>
                        </div>
                        <div class="md-form mb-3">
                            <label for="state"><b>Estado:</b></label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="state_activo" name="state" class="custom-control-input bg-success" value="ACTIVO" checked>
                                <label class="custom-control-label" for="state_activo">Activo</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="state_inactivo" name="state" class="custom-control-input" value="INACTIVO">
                                <label class="custom-control-label" for="state_inactivo">Inactivo</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar<i class="icon-cancel"></i></button>
                    <button class="btn btn-success" type="submit">Aceptar<i class="icon-ok"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade bd-example-modal-lg" id="modal_eliminar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h2>¿Está seguro que desea eliminar el registro?</h2>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancelar<i class="icon-cancel"></i></button>
                <button class="btn btn-success" id="btn_delete">Aceptar<i class="icon-ok"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Importar -->
<div class="modal fade bd-example-modal-lg" id="modal_import" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Datos </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <p>
                        <span class="text-warning"><i class="icon-attention"></i><b>Importante:</b></span>
                        Utilice la plantilla para importar los datos.
                        <a href="/resources/templates/subcategoria.xlsx" download>Descargar plantilla</a>
                    </p>

                    <p class="text-primary" id="content"></p>
                    <div class="form-group">
                        <input type="file" class="form-control-file" id="files" name="files">
                    </div>
                    <button id="btn_show_import" class="btn btn-info" onclick="MostrarDatosExcel();">Mostrar<i class="icon-eye"></i></button>
                    <div id="DatosExcel" align="center" style="padding-top: 10px">

                        <table id="table_import" class="table table-bordered" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>DESCRIPCION</th>
                                    <th>ID_CATEGORIA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <td>1</td>
                                    <td>Customer Support</td>
                                    <td>New York</td>
                                </tr> -->
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar<i class="icon-cancel"></i></button>
                <button class="btn btn-success" onclick="Save_Import();">Aceptar<i class="icon-ok"></i></button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ URL::asset('js/scripts/subcategory.js') }}"></script>
@endsection