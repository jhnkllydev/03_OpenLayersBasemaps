var BASEMAPS = [];

// Bing API key for http://www.mapsportal.org
var apiKey = "AiecIf8cAgrFbHnHLpNfNIAmSqk9wo89f1yDtEMLJJdGpPJPa6G9-WpF3WC8EvTn";
//var layer_base_url = "http://websites.greeninfo.org/mapcollaborator/cpad/";

var BASEMAPS = {};

//base maps 
BASEMAPS.parkinfo_light = new OpenLayers.Layer.XYZ("parkinfo_light",	["http://tilestache-1.greeninfo.org/tilestache/tilestache.py/basemap_cpadlight_nolabels/${z}/${x}/${y}.jpg",
"http://tilestache-2.greeninfo.org/tilestache/tilestache.py/basemap_cpadlight_nolabels/${z}/${x}/${y}.jpg",
"http://tilestache-3.greeninfo.org/tilestache/tilestache.py/basemap_cpadlight_nolabels/${z}/${x}/${y}.jpg",
"http://tilestache-4.greeninfo.org/tilestache/tilestache.py/basemap_cpadlight_nolabels/${z}/${x}/${y}.jpg"
],
    {/* singleTile: true, ratio: 1.25, */ sphericalMercator: true, isBaseLayer: true}
);

BASEMAPS.terrain_land_colorless = new OpenLayers.Layer.XYZ('terrain_land_colorless',
'http://a.tiles.mapbox.com/v3/greeninfo.map-p71hkhvk/${z}/${x}/${y}.png',
{sphericalMercator: true, isBaseLayer: true}
);

BASEMAPS.googlestreets = new OpenLayers.Layer.Google("googlestreets", {
    numZoomLevels: 22
});




BASEMAPS.bingstreets = new OpenLayers.Layer.Bing({
    key: apiKey,
    type: "Road",
    name: "bingstreets"
});
BASEMAPS.binghybrid = new OpenLayers.Layer.Bing({
    key: apiKey,
    type: "AerialWithLabels",
    name: "binghybrid"
});

BASEMAPS['parkinfo'] = new OpenLayers.Layer.XYZ("parkinfo",
    ["http://tilestache-1.greeninfo.org/tilestache/tilestache.py/parkinfo_withlabels/${z}/${x}/${y}.jpg",
    "http://tilestache-2.greeninfo.org/tilestache/tilestache.py/parkinfo_withlabels/${z}/${x}/${y}.jpg",
    "http://tilestache-3.greeninfo.org/tilestache/tilestache.py/parkinfo_withlabels/${z}/${x}/${y}.jpg",
    "http://tilestache-4.greeninfo.org/tilestache/tilestache.py/parkinfo_withlabels/${z}/${x}/${y}.jpg"
    ],
    { sphericalMercator: true, isBaseLayer: true}
); 
/* var g_gray_roads_style = [
	{ featureType: "all", elementType: "all", stylers: [{visibility: "off"}] },
	{ featureType: "landscape.natural", elementType: "geometry", stylers: [{visibility: "on"}, {saturation: "-80"}, {lightness: "60"}] },
	{ featureType: "water", elementType: "geometry", stylers: [{visibility: "on" }, {lightness: 40}] },
	{ featureType: "road", elementType: "all", stylers: [{visibility: "on" }, {lightness: 40}, {saturation: -100}] },
	{ featureType: "administrative.locality", elementType: "labels", stylers: [{visibility: "on" }, {lightness: 20}] },
	{ featureType: "administrative.province", stylers: [{visibility: "on" }, {lightness: 40}] },
	{ featureType: "administrative.country", stylers: [{visibility: "on" }, {lightness: 40}] },
	{ featureType: "administrative.land_parcel", stylers: [{visibility: "on" }] }
]; */

//BASEMAPS['g_streets'] = new OpenLayers.Layer.Google('g_streets', {numZoomLevels: 20});

/* BASEMAPS['g_streets'] = new OpenLayers.Layer.Google('Google Streets', {numZoomLevels: 20, type: 'styled',sphericalMercator: true });
var styledMapOptions = { name: "Google Streets Canvas" };
var styledMapType = new google.maps.StyledMapType(g_gray_roads_style, styledMapOptions);
 */
/*
after BASEMAPS['g_streets'] is added to map:
BASEMAPS['g_streets'].mapObject.mapTypes.set('styled', styledMapType);
BASEMAPS['g_streets'].mapObject.setMapTypeId('styled');
*/

/* BASEMAPS['g_hybrid'] = new OpenLayers.Layer.Google('Google Hybrid',
	{type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20, sphericalMercator: true, 'maxExtent': new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34)} );	
 */

/* BASEMAPS['mapbox_light'] = new OpenLayers.Layer.XYZ('Gray',
'http://a.tiles.mapbox.com/v3/greeninfo.map-8ljrd2bt/${z}/${x}/${y}.png',
{isBaseLayer: true}
); */

/* 
BASEMAPS['g_hybrid'] = new OpenLayers.Layer.Google('Google Hybrid',
	{type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20, sphericalMercator: true, 'maxExtent': new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34)} );	


BASEMAPS['mapbox_light'] = new OpenLayers.Layer.XYZ('Gray',
'http://a.tiles.mapbox.com/v3/greeninfo.map-8ljrd2bt/${z}/${x}/${y}.png',
{sphericalMercator: true, isBaseLayer: true}
); */



