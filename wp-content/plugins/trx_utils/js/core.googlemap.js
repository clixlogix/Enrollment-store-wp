function insurance_ancora_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof google=="undefined") {
		return;
	}
	if (typeof INSURANCE_ANCORA_STORAGE['googlemap_init_obj'] == 'undefined') insurance_ancora_googlemap_init_styles();
	INSURANCE_ANCORA_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: INSURANCE_ANCORA_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		insurance_ancora_googlemap_create(id);

	} catch (e) {
		
		dcl(INSURANCE_ANCORA_STORAGE['strings']['googlemap_not_avail']);

	};
}

function insurance_ancora_googlemap_create(id) {
	"use strict";

	// Create map
	INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].dom, INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers)
		INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	insurance_ancora_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].map)
			INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].map.setCenter(INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function insurance_ancora_googlemap_add_markers(id) {
	"use strict";
	for (var i in INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'].geocoder == '') INSURANCE_ANCORA_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			INSURANCE_ANCORA_STORAGE['googlemap_init_obj'].geocoder.geocode({address: INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						insurance_ancora_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(INSURANCE_ANCORA_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].title;
			INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].map.setCenter(INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].map,
								INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			INSURANCE_ANCORA_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function insurance_ancora_googlemap_refresh() {
	"use strict";
	for (var id in INSURANCE_ANCORA_STORAGE['googlemap_init_obj']) {
		insurance_ancora_googlemap_create(id);
	}
}

function insurance_ancora_googlemap_init_styles() {
	"use strict";
	// Init Google map
	INSURANCE_ANCORA_STORAGE['googlemap_init_obj'] = {};
	INSURANCE_ANCORA_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.insurance_ancora_theme_googlemap_styles!==undefined)
		INSURANCE_ANCORA_STORAGE['googlemap_styles'] = insurance_ancora_theme_googlemap_styles(INSURANCE_ANCORA_STORAGE['googlemap_styles']);
}