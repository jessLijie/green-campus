<?php session_start(); ?>
<?php $currentPage = "locate"; ?>
<html>

<head>
    <link rel="stylesheet" href="css/locate.css" />
    <title>Greenify | Locate</title>
</head>

<body>
    <?php include("header.php") ?>
    <div class="map-container">
        <div id="map"></div>
        <div class="info">
            <center>   
                <div class="labelled-items">
                    <table cellpadding="11px" cellspacing="0" width="100%">
                        <tr>
                            <td style="width:10%"><img src="images/hub.png" alt="" width=25px style="float:right"></td>
                            <td>Recycle Hub</td>
                            <td  style="width:10%"><img src="images/bus.png" alt="" width=25px style="float:right"></td>
                            <td>Bus Stop</td>
                        </tr>
                        <tr>
                            <td><img src="images/bike.png" alt="" width=25px style="float:right"></td>
                            <td>Campus Bike Station</td>
                            <td><img src="images/park.png" alt="" width=25px style="float:right"></td>
                            <td>Green Park</td>
                        </tr>
                    
                        </tr>
                    </table>
                </div>
            </center>

            <div class="events">
                
            </div>
        </div>

    </div>

    <script>
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 1.5602393950091624, lng: 103.63827783102548 },
                zoom: 16,
                mapId: '79fc16395651c35a'
            });

            const hub = "images/hub.png";
            const bike = "images/bike.png";
            const bus = "images/bus.png";
            const park = "images/park.png";

            const markers = [
                [
                    1.5610633368545406, 103.64042591346818, hub
                ]
                ,
                [
                    1.5586772764694763, 103.63833887638042, hub
                ]
                , [
                    1.5617711770954321, 103.63561939498715, hub
                ],
                [
                    1.5618355261964076, 103.64531826263638, hub
                ]
                , [
                    1.5572238356525796, 103.63716434736952, bike
                ],
                [
                    1.5604198455313483, 103.63403152728813, bike
                ],
                [
                    1.5591757617257345, 103.6451895166191, bike
                ],
                [
                    1.5628007624863784, 103.63637041351328, bus
                ],
                [
                    1.5596905551138243, 103.6347396304572, bus
                ],
                [
                    1.5579960264032544, 103.64029716745091, bus
                ],
                [
                    1.5603125969563914, 103.64167045844547, bus
                ],
                [
                    1.5627793127961294, 103.63913845317423, bus
                ],
                [
                    1.5634657027755823, 103.64259313833247,park
                ],
                [
                    1.5648345526143883, 103.63936059611834,park
                ],
                [
                    1.55305617950327, 103.64641245128925,park
                ],
                [
                    1.5568706004434785, 103.63494198708115,park
                ]
            ]

            for (let i = 0; i < markers.length; i++) {
                const currentMarker = markers[i];
                new google.maps.Marker({
                    position: { lat: currentMarker[0], lng: currentMarker[1] },
                    map,
                    icon: {
                        url: currentMarker[2],
                        scaledSize: new google.maps.Size(25, 25)
                    },
                    animation: google.maps.Animation.DROP
                });
            }


        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBte_REyjpbShM5sBpPLVEXRgFRsCbohes&map_ids=79fc16395651c35a&callback=initMap">
    </script>

</body>

</html>