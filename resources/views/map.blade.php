<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tapi map test</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJPn8U_q_qOicjpFVmB1sqELaybHU206o"></script>
        <!-- Styles -->
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            #map, .control {
                width: 16%;
                float: left;
                margin: 5px 0 0 5px;
            }
            #map {
                width: 82.9%;
                height: 99%;
                float: right;
                margin: 5px 5px 0;
            }
        </style>
    </head>
    <body>
        <div class="control">
            <table>
                <tr>
                    <td>Token</td>
                    <td><input type="text" id="token" placeholder="token" value=""></td>
                </tr>
                <tr>
                    <td>Postcode</td>
                    <td><input type="text" id="postcode" placeholder="postcode" value="BH23 4SH"></td>
                </tr>
                <tr>
                    <td>Zoom</td>
                    <td><input type="number" id="zoom" placeholder="zoom" value="11"></td>
                </tr>
                <tr>
                    <td>Radius</td>
                    <td><input type="number" id="radius" placeholder="radius" value="10"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="button" id="submit" value="Search"></td>
                </tr>
            </table>
        </div>
        <div id="map"></div>
        <script>
            $(function() {
                $('#submit').click(function(e) {

                    $.ajaxSetup({
                        headers: {
                            'Authorization': 'Bearer ' + $('#token').val(),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    codeAddress();
                });

                function codeAddress() {
                    var postcode = $('#postcode').val();
                    var zoom = parseInt($('#zoom').val());
                    var radius = $('#radius').val();
                    var map = new google.maps.Map(document.getElementById('map'), { zoom: zoom });
                    var geocoder = new google.maps.Geocoder();
                    var gmarkers = [];

                    $.get("api/v1/properties/area?postcode=" + postcode + "&radius=" + radius)
                    .done(function(response) {
                        console.log(response.data);
                        for (var i = 0; i < gmarkers.length; i++) {
                            gmarkers[i].setMap(null);
                        }

                        for (var i = 0; i < response.data.length; i++) {
                            var latLng = new google.maps.LatLng(response.data[i].latitude, response.data[i].longitude);
                            var marker = new google.maps.Marker({
                                position: latLng,
                                map: map
                            });
                            marker.setMap(map);
                            gmarkers.push(marker);
                        }
                    });

                    geocoder.geocode({ 'address': postcode}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                            });

                            var cityCircle = new google.maps.Circle({
                                strokeColor: '#FF0000',
                                strokeOpacity: 0.5,
                                strokeWeight: 2,
                                fillColor: '#FF0000',
                                fillOpacity: 0.2,
                                map: map,
                                center: map.center,
                                radius: radius / 3959 * 6378100
                            });
                        } else {
                            alert('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }

                codeAddress();
            });
        </script>
    </body>
</html>
