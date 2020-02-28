var table;
var id = 0;

var title_modal_data = "Nuevo registro";
$(document).ready(function () {
    ListDatatable();
});


// datatable catalogos
function ListDatatable() {
    table = $('#table').DataTable({
        dom: 'lfBrtip',
        //dom: 'lfrtip',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        processing: true,
        serverSide: true,
        "paging": true,
        language: {
            "url": "/js/assets/Spanish.json"
        },
        ajax: {
            url: 'Activity_dt'
        },
        columns: [
            {
                data: 'user.name'
            },
            {
                data: 'user.gender'
            },
            {
                data: 'user.telephone'
            },
            {
                data: 'user.email'
            },
            {
                data: 'store'
            },
            {
                data: 'barcode'
            },
            {
                data: 'product'
            },
            {
                data: 'created_at'
            },
            {
                data: 'Eliminar',
                orderable: false,
                searchable: false
            },
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
            }
        },
        {
            text: '<i class="icon-download"></i><i class="icon-file-pdf"></i> ',
            className: 'rounded btn-dark m-2',
            titleAttr: 'PDF',
            extend: 'pdf',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
            }
        },
        {
            text: '<i class="icon-download"></i><i class="icon-print"></i> ',
            className: 'rounded btn-dark m-2',
            titleAttr: 'Imprimir',
            extend: 'print',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
            }
        },
        //btn Refresh
        {
            text: '<i class="icon-arrows-cw"></i>',
            className: 'rounded btn-info m-2',
            action: function () {
                table.ajax.reload();
            }
        }
        ],
    });
};
//List Select
function SelectStore() {
    $.ajax({
        url: "/Store_list",
        method: 'get',
        success: function (result) {
            var code = '<div class="form-group">';
            code += '<label><b>Sucursal:</b></label>';
            code += '<select class="form-control" name="store_id" id="store_id" required>';
            code += '<option disabled value="" selected>(Seleccionar)</option>';
            $.each(result, function (key, value) {
                code += '<option value="' + value.id + '">' + value.name + '</option>';
            });
            code += '</select>';
            code += '<div class="invalid-feedback">';
            code += 'Dato necesario.';
            code += '</div>';
            code += '</div>';
            $("#select_tienda").html(code);
        },
        error: function (result) {

            toastr.error(result.msg + ' CONTACTE A SU PROVEEDOR POR FAVOR.');
            console.log(result);
        },
    });
}


function SelectSubcategory() {
    $.ajax({
        url: "/Subcategory_list",
        method: 'get',
        success: function (result) {
            var code = '<div class="form-group">';
            code += '<label><b>Subcategoria:</b></label>';
            code += '<select class="form-control" name="subcategory_id" id="subcategory_id" required>';
            code += '<option disabled value="" selected>(Seleccionar)</option>';
            $.each(result, function (key, value) {
                code += '<option value="' + value.id + '">' + value.name + '</option>';
            });
            code += '</select>';
            code += '<div class="invalid-feedback">';
            code += 'Dato necesario.';
            code += '</div>';
            code += '</div>';
            $("#select_subcategoria").html(code);
        },
        error: function (result) {

            toastr.error(result.msg + ' CONTACTE A SU PROVEEDOR POR FAVOR.');
            console.log(result);
        },
    });
}
