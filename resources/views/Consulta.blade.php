@extends('layouts.vc_app')


@section('styles')
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/assistant.css') }}" rel="stylesheet">
<link href="{{ asset('css/image_bg.css') }}" rel="stylesheet">
<link href="css/image_bg.css" rel="stylesheet">

@endsection

@section('content')


<ul class="cb-slideshow">
    <li><span>Image 01</span>

    </li>
    <li><span>Image 02</span>

    </li>
    <li><span>Image 03</span>

    </li>
    <li><span>Image 04</span>

    </li>
    <li><span>Image 05</span>

    </li>
    <li><span>Image 06</span>

    </li>
</ul>


<div class="container">
    <img class="mb-4" src="resources/vc_black.png" alt="" width="350">
    <h2 class="h3 mb-3 font-weight-normal text-black">ASSISTANT</h2>
    <!-- <a class="btn btn-lg bg-black btn-block text-white" data-toggle="modal" data-target="#exampleModal">
        Consulta aquí precios y descuentos
    </a> -->



    <p id="position"></p>



    <section id="container" class="container">
        <div class="controls">
            <fieldset class="input-group">

                <label for="file-upload" class="custom-file-upload">
                    <i class="fas fa-camera"></i> Escanear
                </label>
                <input id="file-upload" type="file" accept="image/*" capture="camera" />

                <!-- <input type="file" accept="image/*" capture="camera"/> -->
                <!-- <button>Rerun</button> -->
            </fieldset>
            <fieldset hidden class="reader-config-group">
                <label>
                    <span>Barcode-Type</span>
                    <select name="decoder_readers">
                        <option value="code_128" selected="selected">Code 128</option>
                        <option value="code_39">Code 39</option>
                        <option value="code_39_vin">Code 39 VIN</option>
                        <option value="ean">EAN</option>
                        <option value="ean_extended">EAN-extended</option>
                        <option value="ean_8">EAN-8</option>
                        <option value="upc">UPC</option>
                        <option value="upc_e">UPC-E</option>
                        <option value="codabar">Codabar</option>
                        <option value="i2of5">Interleaved 2 of 5</option>
                        <option value="2of5">Standard 2 of 5</option>
                        <option value="code_93">Code 93</option>
                    </select>
                </label>
                <label>
                    <span>Resolution (long side)</span>
                    <select name="input-stream_size">
                        <option selected="selected" value="320">320px</option>
                        <option value="640">640px</option>
                        <option value="800">800px</option>
                        <option value="1280">1280px</option>
                        <option value="1600">1600px</option>
                        <option value="1920">1920px</option>
                    </select>
                </label>
                <label>
                    <span>Patch-Size</span>
                    <select name="locator_patch-size">
                        <option value="x-small">x-small</option>
                        <option value="small">small</option>
                        <option value="medium">medium</option>
                        <option selected="selected" value="large">large</option>
                        <option value="x-large">x-large</option>
                    </select>
                </label>
                <label>
                    <span>Half-Sample</span>
                    <input type="checkbox" name="locator_half-sample" />
                </label>
                <label>
                    <span>Single Channel</span>
                    <input type="checkbox" name="input-stream_single-channel" />
                </label>
                <label>
                    <span>Workers</span>
                    <select name="numOfWorkers">
                        <option value="0">0</option>
                        <option selected="selected" value="1">1</option>
                    </select>
                </label>
            </fieldset>
        </div>
        <div id="result_strip">
            <ul class="thumbnails"></ul>
        </div>
        <!-- <div id="interactive" class="viewport"></div>
        <div id="debug" class="detection"></div> -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-basket" class="table table-striped">
                        <thead>
                            <tr class="bg-black text-white">
                                <td>Item</td>
                                <td>Precio</td>
                                <td>Quitar</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <p class="bg-black text-white">Total <b id="total_sus">0</b><br><b id="total">0</b></p>
                </div>
            </div>
        </div>

    </section>





</div>


@endsection
@section('scripts')

<script>
    var user_id={{ Auth::id() }};
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvz_UKeOLY0eG2D5Gr_kuT9K7xwKAwB6E"></script> -->
<script src="{{ asset('js/modernizr.custom.86080.js') }}"></script>
<script src="{{ asset('js/quagga.js') }}"></script>
<script src="{{ asset('js/scripts/consulta.js') }}"></script>
<script src="{{ asset('js/file_input.js') }}"></script>





@endsection