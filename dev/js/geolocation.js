var style = {
    fillColor: '#000',
    fillOpacity: 0.1,
    strokeWidth: 0
};

var vec_location = new OpenLayers.Layer.Vector('vector');

/* var MAP = new OpenLayers.MAP('MAP');
var layer = new OpenLayers.Layer.OSM( "Simple OSM MAP");

MAP.addLayers([layer, vector]);

MAP.setCenter(
    new OpenLayers.LonLat(-71.147, 42.472).transform(
        new OpenLayers.Projection("EPSG:4326"),
        MAP.getProjectionObject()
    ), 12
);
*/

var firstGeolocation = true;

var pulsate = function(feature) {
    var point = feature.geometry.getCentroid(),
        bounds = feature.geometry.getBounds(),
        radius = Math.abs((bounds.right - bounds.left)/2),
        count = 0,
        grow = 'up';

    var resize = function(){
        if (count>16) {
            clearInterval(window.resizeInterval);
        }
        var interval = radius * 0.03;
        var ratio = interval/radius;
        switch(count) {
            case 4:
            case 12:
                grow = 'down'; break;
            case 8:
                grow = 'up'; break;
        }
        if (grow!=='up') {
            ratio = - Math.abs(ratio);
        }
        feature.geometry.resize(1+ratio, point);
        vector.drawFeature(feature);
        count++;
    };
    window.resizeInterval = window.setInterval(resize, 50, point, radius);
};

var geolocate = new OpenLayers.Control.Geolocate({
    bind: false,
    geolocationOptions: {
        enableHighAccuracy: false,
        maximumAge: 0,
        timeout: 7000
    }
});

function initGeolocate() {
    MAP.addControl(geolocate);
    MAP.addLayer(vec_location);

    geolocate.events.register("locationupdated",geolocate,function(e) {
        vec_location.removeAllFeatures();
        var circle = new OpenLayers.Feature.Vector(
            OpenLayers.Geometry.Polygon.createRegularPolygon(
                new OpenLayers.Geometry.Point(e.point.x, e.point.y),
                e.position.coords.accuracy/2,
                40,
                0
            ),
            {},
            style
        );
        vec_location.addFeatures([
            new OpenLayers.Feature.Vector(
                e.point,
                {},
                {
                    graphicName: 'cross',
                    strokeColor: '#f00',
                    strokeWidth: 2,
                    fillOpacity: 0,
                    pointRadius: 10
                }
            ),
            circle
        ]);
        if (firstGeolocation) {
            MAP.zoomToExtent(vec_location.getDataExtent());
            pulsate(circle);
            firstGeolocation = false;
            this.bind = true;
        }
    });
    geolocate.events.register("locationfailed",this,function() {
        OpenLayers.Console.log('Location detection failed');
    });
    
    //locateMe();
    stalkMe();

}
/* document.getElementById('locate').onclick = function() {
    vector.removeAllFeatures();
    geolocate.deactivate();
    document.getElementById('track').checked = false;
    geolocate.watch = false;
    firstGeolocation = true;
    geolocate.activate();
};
document.getElementById('track').onclick = function() {
    vector.removeAllFeatures();
    geolocate.deactivate();
    if (this.checked) {
        geolocate.watch = true;
        firstGeolocation = true;
        geolocate.activate();
    }
};
document.getElementById('track').checked = false; */

function locateMe() {
    vec_location.removeAllFeatures();
    geolocate.deactivate();
    //document.getElementById('track').checked = false;
    geolocate.watch = false;
    firstGeolocation = true;
    geolocate.activate();
}
function stalkMe() {
    vec_location.removeAllFeatures();
    geolocate.deactivate();
    //if (this.checked) {
        geolocate.watch = true;
        firstGeolocation = true;
        geolocate.activate();
    //}
}