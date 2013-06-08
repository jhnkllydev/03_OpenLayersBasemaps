/* This is a subclass of the ZoomBox control, which has only 1 twist:
  On completion of a box zoom, it deactivates itself, activates the pan control,
  and ensures that the WMSGetFeatureInfo control is active.
*/

OpenLayers.Control.SelfCancelingZoomBox = OpenLayers.Class(OpenLayers.Control.ZoomBox, {

    zoomBox: function (position) {
        OpenLayers.Control.ZoomBox.prototype.zoomBox.apply(this, arguments);
        // deactivate this here boxzoom control, and enable the pan and query controls
        CONTROL_BOXZOOM.deactivate();
        CONTROL_DRAGPAN.activate();
        //CONTROL_WMSQUERY.deactivate(); // click handler seems to misbehave but this resets it
        //CONTROL_WMSQUERY.activate();
    },

    CLASS_NAME: "OpenLayers.Control.ZoomBox"
});