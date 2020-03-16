@extends('layouts.dashboard')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card border-primary shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-center">
                        <h2 class="card-title text-primary">Consultas registradas por cliente y sucursal</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="text-primary" for=" "><b>Sucursal:</b></label>
                <div class="md-form mb-3" id="select_sucursal"></div>
            </div>
            <div class="col-md-4">
                <label class="text-primary" for="expiration-date"><b>Fecha Mínima:</b></label>
                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                    <input type="text" id="minimum_date" name="minimum_date" class="form-control datetimepicker-input border-primary" data-target="#datetimepicker2" required />
                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                        <div class="input-group-text bg-primary text-white"><i class="icon-minus"></i><i class="icon-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="text-primary" for="expiration-date"><b>Fecha Máxima:</b></label>
                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                    <input type="text" id="maximum_date" name="maximum_date" class="form-control datetimepicker-input border-primary" data-target="#datetimepicker2" required />
                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text bg-primary text-white"><i class="icon-plus"></i><i class="icon-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 offset-md-8 d-flex justify-content-end">
                <button class="btn btn-outline-success btn-block" id="btn-agregar" onclick="Generate();">
                    <i class="icon-play-circled"></i>Generar
                </button>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <hr>
                <h4 class="card-title text-primary"><i class="icon-box"></i>Registros</h4>
                <div class="table-responsive">
                    <table id="table" class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nro. Consultas</td>
                                <td>Nombre usuario</td>
                                <td>Télefono</td>
                                <td>Email</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            SelectSucursal();
            dateEntry();
        });



        function Generate() {
            //Limpiar DataTable
            $("#table").dataTable().fnDestroy();

            if ($("#store_id").val() == null) {
                toastr.warning("Debe Seleccionar una sucursal");
            } else if ($("#minimum_date").val() == 0) {
                toastr.warning("Debe Seleccionar una Fecha minima.");
            } else if ($("#maximum_date").val() == 0) {
                toastr.warning("Debe seleccionar una Fecha Maxima.");
            } else {
                ListDataTable();
            }
        }

        var table;

        function ListDataTable() {

            // .subtract(1, 'day');
            // var maximum_date = moment($("#maximum_date").val()).add(1, 'd').format( "YYYY-MM-DD");
            // console.log(maximum_date);

            table = $('#table').DataTable({
                dom: 'lfBrtip',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                processing: true,
                serverSide: true,
                "paging": true,
                language: {
                    "url": "/js/assets/Spanish.json"
                },
                ajax: {
                    url: '/countclientstore',
                    data: function(obj) {
                        obj.store_id = $("#store_id").val();
                        obj.minimum_date = $("#minimum_date").val();
                        obj.maximum_date = moment($("#maximum_date").val()).add(1, 'd').format( "YYYY-MM-DD");
                    }
                },
                columns: [{
                        data: 'nro_activities'
                    },
                    {
                        data: 'user_name'
                    },
                    {
                        data: 'user_telephone'
                    },
                    {
                        data: 'user_email'
                    }
                ],
                buttons: [{
                        text: '<i class="icon-eye"></i> ',
                        className: 'rounded btn-dark m-2',
                        titleAttr: 'Columnas',
                        extend: 'colvis'
                    },
                    {
                        text: '<i class="icon-download"></i><i class="icon-file-excel"></i>',
                        className: 'rounded btn-dark m-2',
                        titleAttr: 'Excel',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        text: '<i class="icon-download"></i><i class="icon-file-pdf"></i> ',
                        className: 'rounded btn-dark m-2',
                        titleAttr: 'PDF',
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        text: '<i class="icon-download"></i><i class="icon-print"></i> ',
                        className: 'rounded btn-dark m-2',
                        titleAttr: 'Imprimir',
                        extend: 'print',
                        messageTop: 'Consultas registradas por cliente y sucursal: ' + $("#store_id option:selected").text() + '<br>Fechas: ' + $("#minimum_date").val() + ' - ' + $("#maximum_date").val(),
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    //btn Refresh
                    {
                        text: '<i class="icon-arrows-cw"></i>',
                        className: 'rounded btn-info m-2',
                        action: function() {
                            table.ajax.reload();
                        }
                    }
                ],
                //Metodo para Sumar
                // "footerCallback": function(row, data, start, end, display) {
                //     var api = this.api(),
                //         data;

                //     // Remove the formatting to get integer data for summation
                //     var intVal = function(i) {
                //         return typeof i === 'string' ?
                //             i.replace(/[\$,]/g, '') * 1 :
                //             typeof i === 'number' ?
                //             i : 0;
                //     };

                //     // Total over all pages
                //     total = api
                //         .column(0)
                //         .data()
                //         .reduce(function(a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0);

                //     // Total over this page
                //     pageTotal = api
                //         .column(0, {
                //             page: 'current'
                //         })
                //         .data()
                //         .reduce(function(a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0);

                //     // Update footer
                //     $(api.column(0).footer()).html(
                //         'Total: ' + pageTotal
                //     );

                // }
            });
        }

        function SelectSucursal() {
            $.ajax({
                url: "listsucursal",
                method: 'get',
                data: {
                    by: "all"
                },
                success: function(result) {
                    var code = '<select class="form-control border-primary" name="store_id" id="store_id" required>';
                    code += '<option disabled value="" selected>(Seleccionar)</option>';
                    $.each(result, function(key, value) {
                        code += '<option value="' + value.id + '">' + value.name + '</option>';

                    });
                    code += '</select>';
                    $("#select_sucursal").html(code);
                },
                error: function(result) {
                    toastr.error(result.msg + ' CONTACTE A SU PROVEEDOR POR FAVOR.');
                    console.log(result);
                },

            });

        }

        //fecha de entrada
        function dateEntry() {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#datetimepicker1').datetimepicker();
            $('#datetimepicker2').datetimepicker({
                useCurrent: false
            });
            $("#datetimepicker1").on("change.datetimepicker", function(e) {
                $('#datetimepicker2').datetimepicker('minDate', e.date);
            });
            $("#datetimepicker2").on("change.datetimepicker", function(e) {
                $('#datetimepicker1').datetimepicker('maxDate', e.date);
            });
        }
    </script>

    @endsection