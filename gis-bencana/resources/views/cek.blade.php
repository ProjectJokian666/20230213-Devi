<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>PEMETAAN BENCANA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/img/favicon.png" rel="icon">
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/css/style.css" rel="stylesheet">
    <link href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/mapbox/mapbox-gl.css" rel="stylesheet">
    <style type="text/css">
        .legend {
            background-color: #fff;
            border-radius: 3px;
            bottom: 30px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
            padding: 10px;
            position: absolute;
            right: 10px;
            z-index: 1;
        }

        .legend h4 {
            margin: 0 0 10px;
        }

        .legend div span {
            border-radius: 50%;
            display: inline-block;
            height: 10px;
            margin-right: 5px;
            width: 10px;
        }

        .legend2 {
            background-color: #fff;
            border-radius: 3px;
            bottom: 30px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
            padding: 10px;
            position: absolute;
            left: 10px;
            z-index: 1;
        }

        .legend2 h4 {
            margin: 0 0 10px;
        }

        .legend2 div span {
            border-radius: 50%;
            display: inline-block;
            height: 10px;
            margin-left: 5px;
            width: 10px;
        }

        .marker {
            background-image: url('mapbox-icon.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 400px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }

        .coordinates {
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            position: absolute;
            bottom: 60px;
            left: 40px;
            padding: 5px 10px;
            margin: 0;
            font-size: 11px;
            line-height: 18px;
            border-radius: 3px;
            display: none;
        }
    </style>
<!-- =======================================================
* Template Name: NiceAdmin - v2.5.0
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================== -->
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public" class="logo d-flex align-items-center">
                <img src="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span class="d-none d-md-block ps-2">MASUK</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Icons Navigation -->

    </header>  <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->
            <li class="nav-heading">Umum</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/peta">
                    <i class="bi bi-map"></i>
                    <span>Peta</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/grafik">
                    <i class="bi bi-bar-chart"></i>
                    <span>Grafik</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/informasi">
                    <i class="bi bi-journal-text"></i>
                    <span>Informasi</span>
                </a>
            </li>      </ul>

        </aside>  <!-- End Sidebar-->

        <main id="main" class="main">

<!-- <div class="pagetitle">
<h1>Dashboard</h1>
<nav>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="index.html">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
</ol>
</nav>
</div> -->

<section class="section dashboard">
</section>
<section class="section dashboard">
    <div class="row justify-content-center card">
        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-3">
                    <select class="form-control" id="bencana" name="bencana">
                        <option value="1">Gempa</option>
                        <option value="2">Erosi</option>
                        <option value="3">Banjir</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="tanggal1" name="tanggal1">
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="tanggal2" name="tanggal2">
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-primary" id="btn_lihat">Lihat</button>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div id="maps" style="height:500px;">
                <div id="state-legend" class="legend">
                    <h6>Keterangan</h6>
                    <div><span style="background-color: #360602"></span>Tinggi ( 60% - 100% )</div>
                    <div><span style="background-color: #fc7600"></span>Medium ( 30% - 59% )</div>
                    <div><span style="background-color: #5cfc00"></span>Rendah ( 1% - 29% )</div>
                    <div><span style="background-color: #c8d1e1"></span>Kosong</div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
<!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/NiceAdmin/assets/js/main.js"></script>
<script src="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/Jquery\jquery-3.6.4.min.js"></script>
<script src="http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/mapbox/mapbox-gl.js"></script>
<script>
    var device;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
// true for mobile device
        device = [
            [111.75913914489564, -8.669228758626588],
            [112.45263414965126, -7.170129037865038]
            ];
    } else {
// false for not mobile device
        device = [
            [111.52119039287481, -8.040812976926816],
            [112.69129014605602, -7.586629911014967]
            ];
    }
    mapboxgl.accessToken = 'pk.eyJ1IjoiZmlrcmluYW5kYSIsImEiOiJja2RsbmY3djgxMGlxMnlwZDBha213b3hpIn0.wR7buPys4UOuFLbJJqHzIA';

    const map = new mapboxgl.Map(
    {
// container ID
        container: 'maps', 
// Choose from Mapbox's core styles, or make your own style with Mapbox Studio
// style URL
        style: 'mapbox://styles/mapbox/light-v11',
// starting position
        center: [112.03, -7.824],
// starting zoom
        zoom: 10.5,
        maxBounds: device,
    });

    var hoveredStateId1 = null;

    $("#btn_lihat").on('click',function() {
// console.log($("#bencana").val(),$("#tanggal1").val(),$("#tanggal2").val(),);
        Show_Data_Peta();
    })

    Show_Data_Peta();

    function Show_Data_Peta() {
        $.ajax({
            url:"http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/peta/get_peta",
            type:"GET",
            data : {
                bencana : $("#bencana").val(),
                tanggal1 : $("#tanggal1").val(),
                tanggal2 : $("#tanggal2").val(),
            },
            success:function(data){
                Show_Peta(data.Bencana,data.Rinci)
            }
        });
    }

    function Show_Peta(a,b){

    }


    map.on('load', function () {
        map.loadImage('http://localhost/APP/LARAVEL/20220213%20Devi/app/gis-bencana/public/mapbox/custom_marker.png', function(error, image) {
            if (error) {
                throw error
            }
            map.addImage('custom-marker', image);

            map.addSource('maine', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': [
                    {
                        "type": "Feature",
                        "geometry": {
                            "type": "Polygon",
                            "coordinates": [[
                                [112.0295639, -7.85483885],
                                [112.02954102, -7.85513449],
                                [112.02947235, -7.85597134],
                                [112.0295639, -7.85483885]
                                ]]
                        },
                        "id":"1","properties":
                        {
                            "nama":"Kec Kota",
                            "wilayah":"Erosi 1000024 Kejadian<br>Gempa 20 Kejadian<br>",
                            "bencana":1000044
                        }
                    },
                    {
                        "type": "Feature",
                        "geometry": {
                            "type": "Polygon",
                            "coordinates": [
                                [
                                    [112.02210999, -7.86839962],
                                    [112.02239227, -7.86709166],
                                    [112.02295685, -7.86589432],
                                    [112.02210999, -7.86839962]
                                    ]
                                ]
                        },
                        "id":"2","properties":{
                            "nama":"Kec Pesantren",
                            "wilayah":"Erosi 30 Kejadian<br>Gempa 0 Kejadian<br>",
                            "bencana":30
                        }
                    },
                    {
                        "type": "Feature",
                        "geometry": {
                            "type": "Polygon",
                            "coordinates": [
                                [
                                    [112.0036087, -7.84251118],
                                    [111.99863434, -7.84095144],
                                    [111.99520111, -7.84041834],
                                    [112.0036087, -7.8425]]]    
                        },
                        "id":"3","properties":{
                            "nama":"Kec Mojoroto",
                            "wilayah":"Gempa 7 Kejadian<br>Banjir 0 Kejadian<br>",
                            "bencana":7
                        }
                    },
                    ]
                }
            });

            map.addLayer({ 
                'id': 'isi',
                'type': 'fill', 
                'source': 'maine', 
                'layout': {},
                'paint': { 
                    'fill-color': [
                        "case",
                        ['<=', ['get', "bencana"], 0], "#c8d1e1",
                        ['<=', ['get', "bencana"], 29], "#5cfc00",
                        ['<=', ['get', "bencana"], 59], "#fc7600",
                        ['<=', ['get', "bencana"], 100], "#360602",
                        '#123456'
                        ],
                    'fill-opacity': [
                        'case',
                        ['boolean', ['feature-state', 'hover'], false],
                        1,
                        0.5
                        ]
                }
            });

map.addLayer({ // Add a black outline around the polygon.
    'id': 'batas',
    'type': 'line',
    'source': 'maine',
    'layout': {},
    'paint': {
        'line-width': 1,
        'line-color': '#f0ffff'
    }
});

// map.addLayer({ // Add a layer showing the places.
//  'id': 'places',
//  'type': 'symbol',
//  'source': 'places',
//  'layout': {
//      'icon-image': 'custom-marker',
//      'icon-allow-overlap': true
//  }
// });

var popup1 = new mapboxgl.Popup({
    closeButton: false,
    closeOnClick: false
});

// map.on('click', 'isi', function(e) {
//  new mapboxgl.Popup()
//  .setLngLat(e.lngLat)
//  .setHTML('<h3>' + e.features[0].properties.nama + '</h3><p>' + e.features[0].properties.bencana + ' Bencana</p>')
//  .addTo(map);
// });

map.on('mousemove', 'isi', function(e) {

    if (e.features.length > 0) {
        if (hoveredStateId1) {
// Change the cursor style as a UI indicator.
            map.getCanvas().style.cursor = 'pointer';

// Single out the first found feature.
            var feature1 = e.features[0];

// Display a popup with the name of the county
            popup1.setLngLat(e.lngLat)
            .setHTML(
                '<p class="text-center">'+
                '<h6>'+
                '<strong>' +
                feature1.properties.nama +
                '</strong>'+
                '</h6>'+
                feature1.properties.wilayah+
// '<br>' +
// feature1.properties.bencana+
                '</p>'
                )
            .addTo(map);
            map.setFeatureState({
                source: 'maine',
                id: hoveredStateId1
            }, {
                hover: false
            });
        }
        hoveredStateId1 = e.features[0].id;
        map.setFeatureState({
            source: 'maine',
            id: hoveredStateId1
        }, {
            hover: true
        });
    }
});

map.on('mouseleave', 'isi', function() {
    if (hoveredStateId1) {
        map.getCanvas().style.cursor = '';
        popup1.remove();
        map.setFeatureState({
            source: 'maine',
            id: hoveredStateId1
        }, {
            hover: false
        });
    }
    hoveredStateId1 = null;
});

}
);//z

map.on('idle', function() {
    map.resize()
});
});
</script>
</body>

</html>