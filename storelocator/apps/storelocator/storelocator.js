//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
// SCHLIX WEB CONTENT MANAGEMENT SYSTEM - Copyright (C) SCHLIX WEB INC.
// This is a SHARED SOURCE
// You may use this software commercially, but you are not allowed to create a fork or create a derivative of this software
// Please read the license for details
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
function json_decode(jsonstr)
{
    if (jsonstr.replace(/\s/g, "") != "")
    {
        //  var data = eval('('+jsonstr+')'); // no more
        try
        {
            var data = JSON.parse(jsonstr);
            return data;
        }
        catch (exc)
        {
            alert('JSON Decode error: ' + exc);
            return null;
        }
    } else
    {
        alert('SCHLIX AJAX Communication Error.\nServer returns an empty string. Please take a screenshot and e-mail technical support');
        return false;
    }
};
/**
 * Old method to init map. Kept for backward compatibility
 * @param {type} item_zoom
 * @returns {initMap}
 * @deprecated since version 2.2.0
 */
function deprecated_initMap(item_zoom, lat, long)
{       
    var stores = document.getElementById('stores');   
    var stores_data = json_decode(stores.content);

    if (stores_data.length > 0)
    {
        var latvalue = lat == null ? stores_data[0][2] : lat;
        var longvalue = long == null ? stores_data[0][3]: long;

        var map = L.map('store_map_canvas').setView([latvalue, longvalue], item_zoom);
        
        L.tileLayer('', {minZoom: 5, maxZoom: 18}).addTo(map);

        for (var i = 0; i < stores_data.length; i++) {
            marker = new L.marker([stores_data[i][2],stores_data[i][3]])
                .bindPopup("<h3>" + stores_data[i][0] + "</h3>" + "<p>" + stores_data[i][1] + "</p>")
                .addTo(map);
        }
    }
};

function onStoreLocationClick(latitude, longitude)
{
    if (SCHLIX.Dom.get('store_map_canvas'))
    {
        var container = L.DomUtil.get('store_map_canvas');
        if(container != null){
            container._leaflet_id = null;
        }
        deprecated_initMap(14, latitude, longitude);
    }
};

function view_store_map()
{
    if (SCHLIX.Dom.get('store_map_canvas'))
    {
        deprecated_initMap(14);
    }

    $('.list-group li').click(function(e) {
        e.preventDefault()
    
        $that = $(this);
    
        $that.parent().find('li').removeClass('active');
        $that.addClass('active');
    });
};

SCHLIX.Event.onDOMReady(view_store_map);