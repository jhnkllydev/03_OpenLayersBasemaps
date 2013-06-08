<?php
$link_url="{$APPURL}/?{$_SERVER['QUERY_STRING']}";

//$link_url = str_replace("-", "&#8209;", $link_url);


//error_log($link_url);

$html = <<<ENDOFHTML
<html>
<head>
    <title>Custom map</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <!-- the CSS defines width and height, and also loads some remote fonts. Snazzy, eh? -->
    <link rel="stylesheet" type="text/css" href="$BASEURL/print.css" />

    <!--
    CSS which is defined from PHP
    most notably the map's width & height
    so we don't need to specify them in both the PHP and again the the CSS
    -->
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700&Permanent+Marker' rel='stylesheet' type='text/css'>

    <style type="text/css">
        /* @font-face {
            font-family: VeraSerif;
            src: url('$BASEURL/VeraSerif.ttf'), url('$BASEURL/VeraSerif.eot');
        } */

        #map_image {
            width:{$MAP_WIDTH}px;
            height:{$MAP_HEIGHT}px;
        }
        
        #stateful_url {
            width:668px;
            font-size: 8px;
            color:#555;
        }
        
        #legend2 {
            position: absolute;
            z-index: 9000;
            top: 60px;
            left: 10px;
            background-color: #fff;
            opacity: 0.9;
            width: 250px;
        }
    </style>
    
    <script type="text/javascript">
        function addLyrSwitchrWithoutSliderOrCheckboxButWithPatchVisible() {
        
        }
    </script>
</head>
<body>

<div id="page1" class="page">
    <div id="header">
        
        <h1 id="title">{$_POST['title']}</h1>
        
    </div>

    <img id="map_image" src="{$pngurl}" />
    
    <div id="legend2">Map Layers<br/>
        {$_POST['filterLeg']}
    </div>
    
    <div id="stats">{$allVecRes}</div>

    <div id="footer">
        <!--
        <span><a id="stateful_url" href="{$link_url}">live map</a></span>
        -->
        
        <img id="logo" src="$BASEURL/ginfo_30.png" />
        <!--<table id="legend">
        <tr>
        <td>
        </tr>
        </table>
        -->
    </div>

</div>

</body>
</html>
ENDOFHTML;
?>