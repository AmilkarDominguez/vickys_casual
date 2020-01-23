var redondeo = 3;

var lat;
var lng;

$(document).ready(function () {
    getLocation();
});

var x = document.getElementById("position");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Tu navegador no soporta.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude.toFixed(redondeo) +
        "<br>Longitude: " + position.coords.longitude.toFixed(redondeo);

    var lat = position.coords.latitude.toFixed(redondeo);
    var lng = position.coords.longitude.toFixed(redondeo);

    console.log(lat);
    console.log(lng);


}


var Basket = [];
var row_index = 1;

function consultarBarcode(barcode_readed) {

    console.log(barcode_readed);

    var obj = {
        user_id: user_id,
        barcode: barcode_readed,
    };

    $.ajax({
        url: "/api/find",
        method: 'get',
        data: obj,
        success: function (result) {
            if (result.success) {
                //console.log(result);
                toastr.success(result.msg);

                AddBasket(result.obj);

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
            console.log(result);
        },

    });

}
var total=0;
function AddBasket(obj){
    Basket.push(obj);
    console.log("CARRITO!");
    console.log(obj);

    var code = '<tr id="tr' + row_index + '">';
    code += '<td>' + obj[0].name + '</td>';
    code += '<td>';
    code += '<span>Precio: ' + obj[0].price + '</span><br>';
    code += '<span>Descuento: ' + obj[0].discount + ' %</span><br>';
    code += '<span>Precio con descuento: ' + obj[0].price_discount + '</span>';
    code += '</td>';
    
    code += '<td><a class="btn btn-danger text-white" onclick="RemoveBasket(' + row_index + ',' + obj[0].id + ','+obj[0].price_discount+')">X</a></td>';

    code += '</tr>'
    $('#table-basket').append(code);
    row_index++;

    //Sumar Total


    total = total+parseFloat(obj[0].price_discount);
    $('#total').html(total);
}


function RemoveBasket(row_i, id, price) {
    $("#tr" + row_i).remove();
    var index = Basket.findIndex(item => item.id === id)
    Basket.splice(index, 1);


    //Restar Total
    total = total-parseFloat(price);
    $('#total').html(total);
}