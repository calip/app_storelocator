/**
 * storelocator - Javascript admin controller class
 * 
 * Store Locator is a powerful and easy to use location management system. You can customize the appearance of the map, and provide custom labels for entry fields. 
 *
 * @copyright 2019 calip
 *
 * @license MIT
 *
 * @package storelocator
 * @version 1.0
 * @author  Alip <asalip.putra@gmail.com>
 * @link    https://github.com/calip/app_storelocator
 */
SCHLIX.CMS.storelocatorAdminController = class extends SCHLIX.CMS.BaseController
{
    constructor()
    {
        super("storelocator");
        this.map= null;
        this.geocoder= null;
        this.marker= null;
    };


    ///////////////////////////////////////////////////////////

    /**
     * Datatable row format: item title
     * @param {type} elCell
     * @param {type} oRecord
     * @param {type} oColumn
     * @param {type} oData
     * @param {type} oDataTable
     * @returns {undefined}
     */

    onDOMReady (event)
    {
        SCHLIX.Event.on('btn_update_map', 'click', this.tryToCodeAddress, this, true);
        SCHLIX.Event.on('tab_map', 'click', this.initMap, this, true);
        this.initMap();
    };
    
    tryToCodeAddress ()
    {
        var map_zoom = document.getElementById('map_zoom');
        
            
        map_zoom.value = parseInt(map_zoom.value);
        if (map_zoom.value == 0)
            map_zoom.value = 16; // quick fix
        if (map_zoom.value < 0 || map_zoom.value > 19)
            map_zoom.value = this.map.getZoom();

         //FIXME
        var fields = ["street", "city", "province", "country"];
        var alt_fields = ["street", "city", "state",  "country"];
        var address = '';
        var address_array = new Array();
        for (var i = 0; i < fields.length; i++)
        {
            var input = document.getElementById(fields[i]);
            if (input != null && input.value != '')
            {
                address_array.push(input.value);
            }
        }
        address = address_array.join(',');
           var schlix_app =  this; //SCHLIX.CMS.initializedController['SCHLIX.CMS.ContactsAdmin'];
        SCHLIX.Alert.info('Trying to geocode ' + address);
        
        var geocoder_form = SCHLIX.Dom.get('{.leaflet-control-geocoder-form > input}');
        var geocoder_container = SCHLIX.Dom.get('{.leaflet-control-geocoder.leaflet-bar.leaflet-control}');
        var btnsearch = SCHLIX.Dom.get('{button.leaflet-control-geocoder-icon}');
        if (geocoder_form.length > 0 && geocoder_container.length > 0)
        {
            geocoder_container[0].classList.add('leaflet-control-geocoder-expanded');
            var geocoder_box = geocoder_form[0];
            geocoder_box.value = address;            
            this.geocoder._geocode();
            
            
            
        } else SCHLIX.Alert.error('Geocoder input does not exist');
    }; // end func 
    
    onMapMarkerMoved(e)
    {
        //console.log(e);
        
        SCHLIX.Dom.get('latitude').value = e.latlng.lat;
        SCHLIX.Dom.get('longitude').value = e.latlng.lng;
        
    };
    
    onMapClick(e) {
        //this.marker.setLatLng(e.latlng);

        //SCHLIX.Dom.get('latitude').value = e.latlng.lat;
        //SCHLIX.Dom.get('longitude').value = e.latlng.lng;
        var zoom_level = this.map.getZoom();
        var map_zoom = document.getElementById('map_zoom');
        map_zoom.value = zoom_level;
        
        
    };
    
    onMarkGeoCode(e)
    {
        var lat = e.geocode.center.lat;
        var lng = e.geocode.center.lng;
        SCHLIX.Dom.get('latitude').value = lat;
        SCHLIX.Dom.get('longitude').value = lng;
        this.marker.setLatLng(e.geocode.center);
        this.map.setView(new L.LatLng(lat, lng), this.getZoom());
    };
    
    getZoom()
    {
        var map_zoom = document.getElementById('map_zoom');
        var map_zoom_value = (map_zoom != null) ? parseInt(map_zoom.value) : 12;
        return map_zoom_value;
            
    };
    
    onZoomChanged(e)
    {
        var zoom_level = this.map.getZoom();
        var map_zoom = document.getElementById('map_zoom');
        map_zoom.value = zoom_level;
        console.log('Zoom Changed to level ' + zoom_level);
    };
    
    initMap ()
    {
        var latbox = SCHLIX.Dom.get('latitude');
        if (latbox)
        {
            var latvalue =  SCHLIX.Dom.get('latitude').value;
            var longvalue = SCHLIX.Dom.get('longitude').value;
 
            if (latvalue == "")
                   latvalue = 53.4708523;
            if (longvalue == "")
                    longvalue = -113.6200877 ;
            var map;
            var ajaxRequest;
            var plotlist;
            var plotlayers=[];
            
             // set up the map
            this.map = new L.Map('map_canvas', {preferCanvas:true, scrollWheelZoom: false});
            var osm = new L.TileLayer('', {minZoom: 8, maxZoom: 17});
            this.map.setView(new L.LatLng(latvalue, longvalue), this.getZoom());
            this.marker = L.marker([latvalue, longvalue], {draggable: true}).addTo(this.map);
            this.marker.on('move', this.onMapMarkerMoved, this);
            this.marker.bindPopup("<strong>Drag me</strong>").openPopup();
            this.map.addLayer(osm);
            this.map.on('click', this.onMapClick, this);
            this.map.on('zoomend ', this.onZoomChanged, this);
            this.geocoder = L.Control.geocoder({defaultMarkGeocode: false}).addTo(this.map).on('markgeocode',this.onMarkGeoCode, this);
        }
    }; // end func
///////////////////////////////////////////////////////////

    resizeMap ()
    {
        var map_canvas = document.getElementById('map_canvas');
        map_canvas.style.display = 'block';
           var schlix_app =  this; //SCHLIX.CMS.initializedController['SCHLIX.CMS.ContactsAdmin'];
        
        setTimeout(function () {
            var latitude = document.getElementById('latitude');
            var longitude = document.getElementById('longitude');
            var latlng = (latitude.value != 0 && longitude.value != 0) ? new google.maps.LatLng(latitude.value, longitude.value) : new google.maps.LatLng(53.581092, -113.389893);
            google.maps.event.trigger(schlix_app.map, 'resize');
            schlix_app.marker.setPosition(latlng);
            schlix_app.map.setCenter(latlng);
            //google.maps.event.trigger( map_canvas, 'resize' );
        }
        , 200);
    }; // end func
    getCurrentMarkerPosition ()
    {
        var map_zoom = document.getElementById('map_zoom');
        var latitude = document.getElementById('latitude');
        var longitude = document.getElementById('longitude');
        latitude.value = this.marker.getPosition().lat();
        longitude.value = this.marker.getPosition().lng();
        map_zoom.value = this.map.getZoom();

    }; // end func
    
    static formatDataTableCell_CheckBox (elCell, oRecord, oColumn, oData) {

            if (oRecord.getData('is_system_message')) 
                    elCell.innerHTML = '<i class="fa fa-envelope"></i>';
            else
            {            
                var theID = '';
                var theValue = '';

                var app_name = this.parentControl.app_name;
                theID = app_name + '-select-id' + oRecord.getData("id");
                theValue = 'i' + oRecord.getData("id");
                elCell.innerHTML = '<input type="checkbox" class="' + app_name + '-chkselections" name="' + app_name + '-chkselections[]" id="' + theID + '"  value="' + theValue + '" />';

            }
    };
    
    runCommand (command, evt)
    {
        switch (command)
        {
            case 'new-item':
                this.redirectToCMSCommand("newitem");
                return true;
                break;
            case 'config':
                this.redirectToCMSCommand("editconfig");
                return true;
                break;
            case 'refresh':
                this.cms_control.refreshControls();
                return true;
                break;
            default:
                return super.runCommand(command, evt);
                break;
        }
    }
};

