var MAP, OSM;
var SRS_4326 = new OpenLayers.Projection("EPSG:4326");
var SRS_3857 = new OpenLayers.Projection("EPSG:3857");
var START_XY = new OpenLayers.LonLat(-118,38).transform(SRS_4326,SRS_3857);
var STOCKTON_XY = new OpenLayers.LonLat(-121,38).transform(SRS_4326,SRS_3857);
var START_Z = 4;

var BASEMAP_SWATCHES = {};


$(window).load(function() {
    initMap();
    addBaseSwitcher();
    initGeolocate();
});

function initMap(){
    MAP = new OpenLayers.Map('map');
    //OSM = new OpenLayers.Layer.OSM("OpenStreetMap");

    //MAP.addLayer(OSM);

    for (var nam in BASEMAPS) {
        if(nam !== '000sites131b') { //debugging
            MAP.addLayer(BASEMAPS[nam]);
        }
    }    

    MAP.setCenter(STOCKTON_XY, 8);

//MAP.addControl(new OpenLayers.Control.LayerSwitcher());
}


function addBaseSwitcher() {

	$('body').append('<div id="baseSwitcher"></div>');

	for (var nam in BASEMAPS) {
		//console.log(nam);
		var base_swatch = '<div class="baseSwatch" id="MAP_'+nam+'" title="'+nam+'"></div>';
		$('#baseSwitcher').append(base_swatch);
		BASEMAP_SWATCHES[nam] = new OpenLayers.Map('MAP_'+nam , {
			controls: []
		} );
		var swatch_base = BASEMAPS[nam].clone();
		BASEMAP_SWATCHES[nam].addLayer(swatch_base);
		BASEMAP_SWATCHES[nam].setCenter(START_XY, START_Z);
		
		$('#MAP_'+nam).click(function(){
			//MAP.addLayer(BASEMAPS[nam]);
			

			temp = $(this).attr('title');
			MAP.addLayer(BASEMAPS[temp]);
			MAP.setBaseLayer(BASEMAPS[temp]);
			//console.log(nam);
			console.log($(this).attr('title'));
		});
	}  

}
