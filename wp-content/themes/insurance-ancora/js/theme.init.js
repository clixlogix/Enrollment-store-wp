/* global jQuery:false */
/* global INSURANCE_ANCORA_STORAGE:false */


// Theme-specific post-formats init
//=====================================================
function insurance_ancora_theme_init_post_formats() {
	"use strict";
	// Put here your theme-specific code to init post-formats
	// It will be called before core init post_formats when page is loaded or after 'Load more' or 'Infinite scroll' actions

	// Tribe Events buttons decoration (add 'sc_button' class)
	jQuery('a.tribe-events-read-more,.tribe-events-button,.tribe-events-nav-previous a,.tribe-events-nav-next a,.tribe-events-widget-link a,.tribe-events-viewmore a')
		.addClass('sc_button sc_button_style_filled');

	// All other buttons decoration (add 'hover' class)
	if (INSURANCE_ANCORA_STORAGE['button_hover'] && INSURANCE_ANCORA_STORAGE['button_hover']!='default') {
		jQuery('button:not(.search_submit):not([class*="sc_button_hover_"]),\
				.sc_button:not(.sc_button_style_border):not([class*="sc_button_hover_"]),\
				.woocommerce .button:not([class*="sc_button_hover_"]),.woocommerce-page .button:not([class*="sc_button_hover_"]),\
				#buddypress a.button:not([class*="sc_button_hover_"])'
				).addClass('sc_button_hover_'+INSURANCE_ANCORA_STORAGE['button_hover']);
		if (INSURANCE_ANCORA_STORAGE['button_hover']!='arrow')
			jQuery('input[type="submit"]:not([class*="sc_button_hover_"]),\
					input[type="button"]:not([class*="sc_button_hover_"]),\
					.isotope_filters_button,\
					.scroll_to_top:not([class*="sc_button_hover_"]),\
					.sc_slider_prev:not([class*="sc_button_hover_"]),.sc_slider_next:not([class*="sc_button_hover_"]),\
					.tagcloud > a:not([class*="sc_button_hover_"])'
					).addClass('sc_button_hover_'+INSURANCE_ANCORA_STORAGE['button_hover']);
	}

	// All text fields decoration (except Calculated Fields Forms)
	//if (INSURANCE_ANCORA_STORAGE['input_hover'])
	//	jQuery('form:not([class*="cp_cff_"]):not([class*="sc_input_hover_"])').addClass('sc_input_hover_'+INSURANCE_ANCORA_STORAGE['input_hover']);

	// Mark field as 'filled' on keypress
	jQuery('[class*="sc_input_hover_"] input, [class*="sc_input_hover_"] textarea').each(function() {
		if (jQuery(this).val()!='')
			jQuery(this).addClass('filled');
		else
			jQuery(this).removeClass('filled');
	});
	jQuery('[class*="sc_input_hover_"] input, [class*="sc_input_hover_"] textarea').on('keypress', function() {
		if (jQuery(this).val()!='')
			jQuery(this).addClass('filled');
		else
			jQuery(this).removeClass('filled');
	});
}


// Theme-specific GoogleMap styles
//=====================================================
function insurance_ancora_theme_googlemap_styles($styles) {
	"use strict";
	// Put here your theme-specific code to add GoogleMap styles
	// It will be called before GoogleMap init when page is loaded
	$styles['greyscale'] = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}];
	$styles['inverse'] = [
		{ "stylers": [
			{ "invert_lightness": true },
			{ "visibility": "on" }
			]
		}
	];
	$styles['simple'] = [
    	{ stylers: [
        	{ hue: "#00ffe6" },
            { saturation: -20 }
			]
		},
		{ featureType: "road",
          elementType: "geometry",
          stylers: [
			{ lightness: 100 },
           	{ visibility: "simplified" }
            ]
		},
		{ featureType: "road",
          elementType: "labels",
          stylers: [
          	{ visibility: "off" }
            ]
		}
	];
	$styles['apple'] = [
		{ "featureType": "landscape.man_made",
		  "elementType": "geometry",
		  "stylers": [
			{"color":"#f7f1df"}
			]
		},
		{ "featureType": "landscape.natural",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#d0e3b4"}
			]
		},
		{ "featureType": "landscape.natural.terrain",
		  "elementType": "geometry",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "poi",
		  "elementType": "labels",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "poi.business",
		  "elementType": "all",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "poi.medical",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#fbd3da"}
			]
		},
		{ "featureType": "poi.park",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#bde6ab"}
			]
		},
		{ "featureType": "road",
		  "elementType": "geometry.stroke",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "road",
		  "elementType": "labels",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "road.highway",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"#ffe15f"}
			]
		},
		{ "featureType": "road.highway",
		  "elementType":"geometry.stroke",
		  "stylers": [
		  	{"color":"#efd151"}
		  	]
		},
		{ "featureType": "road.arterial",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"#ffffff"}
			]
		},
		{ "featureType": "road.local",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"black"}
			]
		},
		{ "featureType": "transit.station.airport",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"#cfb2db"}
			]
		},
		{ "featureType": "water",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#a2daf2"}
			]
		}
	];
	return $styles;
}