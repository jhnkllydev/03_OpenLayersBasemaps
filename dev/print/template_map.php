<?php
// this file is included, and all it does is populate the $html variable with HTML and JavaScript
// This could also be done with a template engine such as Smarty or CodeIgniter's views subsystem
$html = <<<ENDOFHTML
<html>
<head>
    <!-- Google Maps and OpenLayers -->
    <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="http://openlayers.org/dev/OpenLayers.js"></script>
    <link rel="stylesheet" type="text/css" href="http://openlayers.org/dev/theme/default/style.css" /> -->
    <script src="$APPURL/js/OpenLayers-2.12/OpenLayers.js"></script>
    <script src="$APPURL/js/BASEMAPS.js"></script>
    <script src="$APPURL/js/LAYERS.js"></script>
    <!-- <script src="$APPURL/js/jquery-deparam.min.js"></script> -->

    <!-- CSS for the map_canvas and not much else -->
    <link rel="stylesheet" href="$APPURL/js/OpenLayers-2.12/theme/default/style.css" type="text/css">
    <style type="text/css">
    /* set the fixed size for the body and #map_canvas
       and note that map_canvas is the only page content at all
    */
    body {
        margin:0;
        padding: 0;
        width:{$MAP_WIDTH}px;
        height:{$MAP_HEIGHT}px;
    }

    #map_canvas {
        background-color:#BBBBFF;
        width:{$MAP_WIDTH}px;
        height:{$MAP_HEIGHT}px;
    }

    /* suppress the copyright box, which is a fist-sized white box in the dead center of the map! */
    .gmnoprint {
        display: none;
    }
    .olLayerGoogleCopyright {
        display:none;
    }
    </style>

    <!-- and the JavaScript to create the map image, with Markers -->
    <script type="text/javascript">
    /*
    No tricks here at all, the usual initialization of an OpenLayers Google map.
    The only trick, if it can be called that, is that we intentionally don't add any Controls for panning, zooming, etc.
    */
    
    var MAP;
    var SRS_LONLAT = new OpenLayers.Projection("EPSG:4326");
    var SRS_GOOGLE = new OpenLayers.Projection("EPSG:3857");
    //pipes and commas:
    //morongo_bb|0.4,morongo_parcels|0.8,morongo_usd|0.8,HIGHLIGHTS|1,vector|1
	var pdf_ARGS_string = decodeURIComponent("{$printArgs}");
    //var ARGS = $.deparam(pdf_ARGS_string);
    //var lys = pdf_ARGS_string.split(',');
    var lys_string = '{$LYS}';
    var lys = lys_string.split(',');
	
    
    function selectBasemap(which) {
        var baselayer = which;
        MAP.setBaseLayer(baselayer);
        
        var offsetable = ['OpenLayers.Layer.TMS','OpenLayers.Layer.UTFGrid','OpenLayers.Layer.XYZ'];
        if (MAP.baseLayer.CLASS_NAME=='OpenLayers.Layer.Bing'){
            LAYERS['streets_and_labels'].setVisibility(false);
            for (i in LAYERS){
                if ( LAYERS[i].CLASS_NAME=='OpenLayers.Layer.TMS' || LAYERS[i].CLASS_NAME=='OpenLayers.Layer.UTFGrid' || LAYERS[i].CLASS_NAME=='OpenLayers.Layer.XYZ' ) {
                    LAYERS[i].zoomOffset = 1;
                }
            }       
        } else {
            LAYERS['streets_and_labels'].setVisibility(true);
            for (i in LAYERS){
                if ( LAYERS[i].CLASS_NAME=='OpenLayers.Layer.TMS' || LAYERS[i].CLASS_NAME=='OpenLayers.Layer.UTFGrid' || LAYERS[i].CLASS_NAME=='OpenLayers.Layer.XYZ' ) {
                    LAYERS[i].zoomOffset = 0;
                }
            }  
        }
    }
    
    function highlight_WKT(wkt) {
        LAYERS['utf_highlights'].removeAllFeatures();
        //var wkt  = reply.geoms[i];
        var feat = new OpenLayers.Format.WKT().read(wkt);
        LAYERS['utf_highlights'].addFeatures([feat]);
    }  
    
    function initMap() {

        MAP = new OpenLayers.Map('map_canvas', {
            projection: new OpenLayers.Projection("EPSG:3857"),
            units: "m",
            maxResolution: 156543.0339,
            maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
            numZoomLevels: 20,
            controls:[]
        });


        //MAP.addLayer(BASEMAPS['{$_POST['base']}']); 
        MAP.addLayer(BASEMAPS['terrain_land_colorless']); 
        MAP.addLayer(BASEMAPS['binghybrid']); 
        selectBasemap(BASEMAPS['{$_POST['base']}']); 
        
        var center = new OpenLayers.LonLat({$_POST['lon']},{$_POST['lat']}).transform(SRS_LONLAT, MAP.getProjectionObject());
        MAP.setCenter(center,{$_POST['z']});
    
        if (lys) {
            for (var i=0, l=lys.length; i<l; i++) {
                var ly_name = lys[i].split('|')[0];
                var ly_opac = lys[i].split('|')[1];
                if (ly_name != 'HIGHLIGHTS' && ly_name != 'vector') {
                    MAP.addLayer(LAYERS[ly_name]);
                    MAP.getLayersByName(ly_name)[0].setVisibility(true);
                    MAP.getLayersByName(ly_name)[0].setOpacity(ly_opac);
                    //MAP.getLayersByName(ly_name)[0].setOpacity(1);
                }
            }
        }          
        
        highlight_WKT("{$_POST['feat_wkt']}");
        MAP.addLayer(LAYERS['utf_highlights'])
    }
    </script>
</head>
<body onLoad="initMap();">
    <div id="map_canvas"></div>
</body>
</html>
ENDOFHTML;
?>