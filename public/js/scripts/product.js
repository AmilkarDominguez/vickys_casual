var table;
var id = 0;

var title_modal_data = "Nuevo Producto";
$(document).ready(function () {
    //ListDatatable();
    catch_parameters();
    SelectStore();
    SelectSubcategory();
    ListDatatable();
});


// datatable catalogos
function ListDatatable() {
    table = $('#table').DataTable({
        dom: 'lfBrtip',
        //dom: 'lfrtip',
        processing: true,
        serverSide: true,
        "paging": true,
        language: {
            "url": "/js/assets/Spanish.json"
        },
        ajax: {
            url: 'Product_dt'
        },
        columns: [{
                data: 'name'
            },
            {
                data: 'barcode'
            },
            {
                data: 'price'
            },
            {
                data: 'discount',
                "render": function (data, type, row) {
                    return row.discount + ' %';
                }
            },
            {
                data: 'price_discount'
            },
            {
                data: 'store.name'
            },
            {
                data: 'subcategory.name'
            },
            {
                data: 'state',
                "render": function (data, type, row) {
                    if (row.state === 'ACTIVO') {
                        return '<center><p class="bg-success text-white"><b>ACTIVO</b></p></center>';
                    } else if (row.state === 'INACTIVO') {
                        return '<center><p class="bg-warning text-white"><b>INACTIVO</b></p></center>';
                    } else if (row.state === 'ELIMINADO') {
                        return '<center><p class="bg-danger text-white"><b>ELIMINADO</b></p></center>';
                    }
                }
            },
            {
                data: 'Editar',
                orderable: false,
                searchable: false
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
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                text: '<i class="icon-download"></i><i class="icon-file-pdf"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'PDF',
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                text: '<i class="icon-download"></i><i class="icon-print"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Imprimir',
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
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

// guarda los datos nuevos
function Save() {
    $.ajax({
        url: "Product",
        method: 'post',
        data: catch_parameters(),
        success: function (result) {
            if (result.success) {
                toastr.success(result.msg);

            } else {
                toastr.warning(result.msg);
            }
        },
        error: function (result) {
            console.log(result.responseJSON.message);
            toastr.error("CONTACTE A SU PROVEEDOR POR FAVOR.");
        },
    });
    table.ajax.reload();
}

// captura los datos
function Edit(id) {
    $.ajax({
        url: "Product/{Product}/edit",
        method: 'get',
        data: {
            id: id
        },
        success: function (result) {
            show_data(result);
        },
        error: function (result) {
            toastr.error(result + ' CONTACTE A SU PROVEEDOR POR FAVOR.');
            console.log(result);
        },
    });
};
/// muestra la vista con los datos capturados
var data_old;

function show_data(obj) {
    ClearInputs();
    obj = JSON.parse(obj);
    id = obj.id;
    $("#name").val(obj.name);
    $("#barcode").val(obj.barcode);
    $("#price").val(obj.price);
    $("#discount").val(obj.discount);
    $("#store_id").val(obj.store_id);
    $("#subcategory_id").val(obj.subcategory_id);
    if (obj.state == "ACTIVO") {
        $('#state_activo').prop('checked', true);
    }
    if (obj.state == "INACTIVO") {
        $('#state_inactivo').prop('checked', true);
    }
    $("#title-modal").html("Editar Registro");

    data_old = $(".form-data").serialize();

    $('#modal_datos').modal('show');
};

// actualiza los datos
function Update() {
    var data_new = $(".form-data").serialize();
    if (data_old != data_new) {
        $.ajax({
            url: "Product/{Product}",
            method: 'put',
            data: catch_parameters(),
            success: function (result) {
                if (result.success) {
                    toastr.success(result.msg);

                } else {
                    toastr.warning(result.msg);
                }
            },
            error: function (result) {
                console.log(result.responseJSON.message);
                toastr.error("CONTACTE A SU PROVEEDOR POR FAVOR.");
            },
        });
        table.ajax.reload();

    }
}


//funcion para eliminar valor seleccionado
function Delete(id_) {
    id = id_;
    $('#modal_eliminar').modal('show');
}
$("#btn_delete").click(function () {
    $.ajax({
        url: "Product/{Product}",
        method: 'delete',
        data: {
            id: id
        },
        success: function (result) {
            if (result.success) {
                toastr.success(result.msg);
            } else {
                toastr.warning(result.msg);
            }
        },
        error: function (result) {
            toastr.error(result.msg + ' CONTACTE A SU PROVEEDOR POR FAVOR.');
            console.log(result);
        },

    });
    table.ajax.reload();
    $('#modal_eliminar').modal('hide');
});









//////////////////////////////////////////////

// METODOS NECESARIOS
// funcion para volver mayusculas
function Mayus(e) {
    e.value = e.value.toUpperCase();
}

// obtiene los datos del formulario
function catch_parameters() {
    var p_d = $("#price").val() - ($("#price").val() * ($("#discount").val() / 100));
    var data = $(".form-data").serialize();
    data += "&user_id=" + user_id;
    data += "&id=" + id;
    data += "&price_discount=" + p_d.toFixed(2);
    //console.log(data);
    return data;

}

// muestra el modal
$("#btn-agregar").click(function () {
    // console.log("arrived");
    ClearInputs();
    $("#title-modal").html(title_modal_data);
    $("#modal_datos").modal("show");
});

// metodo de bootstrap para validar campos

(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('form-data');
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    event.stopPropagation();
                    if (id == 0) {
                        Save();
                    } else {
                        Update();
                    }
                    $('#modal_datos').modal('hide');
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

/// limpi campos despues de utilizar el modal
function ClearInputs() {
    var forms = document.getElementsByClassName('form-data');
    Array.prototype.filter.call(forms, function (form) {
        form.classList.remove('was-validated');
    });
    //__Clean values of inputs
    $("#form-data")[0].reset();
    id = 0;
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



//Metodos para importar
$("#btn-import").click(function () {
    table_import.clear().draw();
    $('#files').val('');
    $("#btn_show_import").hide();
    $("#modal_import").modal("show");
});


var result;

function handleFile(e) {
    //Get the files from Upload control
    var files = e.target.files;
    var i, f;
    //Loop through files
    for (i = 0, f = files[i]; i != files.length; ++i) {
        var reader = new FileReader();
        var name = f.name;
        reader.onload = function (e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            var sheet_name_list = workbook.SheetNames;
            sheet_name_list.forEach(function (y) {
                /* iterate through sheets */
                //Convert the cell value to Json
                var roa = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                if (roa.length > 0) {
                    result = roa;

                }
            });
            //Get the first column first cell value
            //alert(result[0].Column1);
            $('#btn_show_import').show();
        };
        reader.readAsArrayBuffer(f);
    }
}

var table_import;
//Change event to dropdownlist
$(document).ready(function () {
    $('#files').change(handleFile);
    table_import = $('#table_import').DataTable({
        language: {
            "url": "/js/assets/Spanish.json"
        },
    });
});


function MostrarDatosExcel() {
    $('#content').html('<img src="/resources/loader.gif" alt="loading" /><br/> Un momento, por favor...');
    //console.log(result);
    table_import.clear();
    for (var i = 0; i < result.length; i++) {
        //Limpiar Nulls

        if (result[i].ID == null) {
            result[i].ID = "";
        }
        if (result[i].BAR_CODE == null) {
            result[i].BAR_CODE = "";
        }
        if (result[i].NOMBRE == null) {
            result[i].NOMBRE = "";
        }
        if (result[i].PRECIO == null) {
            result[i].PRECIO = "";
        }
        if (result[i].DESCUENTO == null) {
            result[i].DESCUENTO = "";
        }
        if (result[i].ID_SUCURSAL == null) {
            result[i].ID_SUCURSAL = "";
        }
        if (result[i].SUCURSAL == null) {
            result[i].SUCURSAL = "";
        }
        if (result[i].ID_SUBCATEGORIA == null) {
            result[i].ID_SUBCATEGORIA = "";
        }
        if (result[i].SUBCATEGORIA == null) {
            result[i].SUBCATEGORIA = "";
        }

        table_import.row.add([
            result[i].ID,
            result[i].BAR_CODE,
            result[i].NOMBRE,
            result[i].PRECIO,
            result[i].DESCUENTO,
            result[i].ID_SUCURSAL,
            result[i].SUCURSAL,
            result[i].ID_SUBCATEGORIA,
            result[i].SUBCATEGORIA
        ]).draw(false);
    }
    $('#content').fadeIn(1000).html(' Datos leidos');
};




function Save_Import() {
    for (var i = 0; i < result.length; i++) {
        $('#content').html('<img src="/resources/loader.gif" alt="loading" /><br/>Un momento, por favor...');
        var objeto = {

            name: result[i].NOMBRE,
            barcode: result[i].BAR_CODE,
            price: result[i].PRECIO,
            discount: result[i].DESCUENTO,
            price_discount: (result[i].PRECIO - (result[i].PRECIO * (result[i].DESCUENTO / 100))).toFixed(2),
            store_id: result[i].ID_SUCURSAL,
            subcategory_id: result[i].ID_SUBCATEGORIA

        };


        $.ajax({
            url: "Product",
            method: 'post',
            data: objeto,
            success: function (result) {
                if (result.success) {
                    //toastr.success(result.msg);

                } else {
                    toastr.warning(result.msg);
                }
            },
            error: function (result) {
                console.log(result.responseJSON.message);
                toastr.error("CONTACTE A SU PROVEEDOR POR FAVOR.");
            },
        });
        $('#content').fadeIn(1000).html('');
        table.ajax.reload();
    }
    $('#modal_import').modal('hide');
    toastr.success("Datos importados correctamente");

};
