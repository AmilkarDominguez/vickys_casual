var dolar = 6.97;
var redondeo = 3;

var lat = 0;
var lng = 0;

$(document).ready(function () {
    getLocation();
    // console.log('llegando');
    // console.log(user_id);
    console.log();
});

var x = document.getElementById("position");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        toastr.warning("No es posible acceder a tu ubicación");
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude.toFixed(redondeo) +
        "<br>Longitude: " + position.coords.longitude.toFixed(redondeo);

    lat = position.coords.latitude.toFixed(redondeo);
    lng = position.coords.longitude.toFixed(redondeo);

    // console.log(lat);
    // console.log(lng);


}


var Basket = [];
var row_index = 1;

function consultarBarcode(barcode_readed) {

    if (lat == 0) {
        toastr.error("No es posible acceder a tu ubicación");
        return 0;
    }



    console.log(barcode_readed);

    var obj = {
        user_id: user_id,
        barcode: barcode_readed,
        lat: lat,
        lng: lng,
    };

    $.ajax({
        url: "/api/find",
        method: 'get',
        data: obj,
        success: function (result) {
            if (result.success) {
                //console.log(result);

                //Verificar ubicaci
                var lat_ = parseFloat(result.obj.store.lat);
                var lng_ = parseFloat(result.obj.store.lng);

                //console.log(lat_);
                // AddBasket(result.obj);

                if (true) {
                    toastr.success(result.msg);
                    AddBasket(result.obj);
                    console.log(result.obj);
                } else {
                    toastr.warning("No se encontraron registros coincidentes");
                }

            } else {
                //console.log(result);
                toastr.warning(result.msg);
            }


            // console.log(result);
            // $.each(result, function (key, value) {
            //     console.log(value);
            // });


        },
        error: function (result) {
            toastr.warning("No se encontraron registros coincidentes");
            console.log(result);
        },

    });

}
var total = 0;
var total_usd = 0;
function AddBasket(obj) {
    Basket.push(obj);
    //console.log("CARRITO!");
    //console.log(obj);

    var code = '<tr id="tr' + row_index + '">';
    code += '<td>' + obj.name + '</td>';
    code += '<td>';
    code += '<span style="text-decoration: line-through;">' + obj.price + ' USD.</span><br>';
    code += '<span class="text-danger">' + obj.price_discount + ' USD.</span><br>';
    code += '<span style="border-style: solid;">-' + obj.discount + ' %</span>';
    code += '</td>';

    code += '<td><a class="btn btn-danger text-white" onclick="RemoveBasket(' + row_index + ',' + obj.id + ',' + obj.price_discount + ')">X</a></td>';

    code += '</tr>'
    $('#table-basket').append(code);
    row_index++;

    //Sumar Total


    total_usd = total_usd + parseFloat(obj.price_discount);
    $('#total_sus').html(total_usd.toFixed(2) + " USD.");

    total = total_usd * dolar;
    $('#total').html(total.toFixed(2) + " Bs.");
}


function RemoveBasket(row_i, id, price) {
    $("#tr" + row_i).remove();
    var index = Basket.findIndex(item => item.id === id)
    Basket.splice(index, 1);


    //Restar Total

    total_usd = total_usd - parseFloat(price);
    $('#total_sus').html(total_usd.toFixed(2) + " USD.");

    total = total_usd * dolar;
    $('#total').html(total.toFixed(2) + " Bs.");
}