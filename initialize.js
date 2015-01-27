$(document).ready(function() {
	var markers = [];
             
	$.get({
		url: "locations.php",
		data: {
			user_account: "fsdfsd@gmail.com"
		}
	}).
	complete(function(data) {
		var mapOptions = {
			zoom: 12,
			center: new google.maps.LatLng(48.4622985, 35.0003565)
		};

		var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

		setMarkers(map, data);

		var markerCluster = new MarkerClusterer(map, markers);
	});

	function setMarkers(map, locations) {
		for (var i = 0; i < locations.length; i++) {
			var marker = setOptions(map,locations[i], marker);
			markers.push(marker);
		}
	}

	function setOptions(map, location) {

		var myLatLng = new google.maps.LatLng(location.latitude, location.longitude);
		var marker = new google.maps.Marker({
					position: myLatLng,
                    map: map,
                    title: location.user_account
                });
					
		var box_html = '<div><strong>' + location.user_account + '</strong></div>';

		var infowindow = new google.maps.InfoWindow({
			content: box_html
		});

		google.maps.event.addListener(marker, 'click', function () {
				infowindow.open(map, marker);
		});

		return marker;
	}
});			