let map;
let marker;

function initMap() {
  const myLatLng = {
    lat: 35.6937632,
    lng: 139.7036319,
  };
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: myLatLng,
    fullscreenControl: false,
    zoomControl: true,
    streetViewControl: true,
    mapTypeControl: false,
    streetViewControl: true,
  });

  var input = document.getElementById("addressInput");
  var autocomplete = new google.maps.places.Autocomplete(input);

  autocomplete.addListener("place_changed", function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    map.setCenter(place.geometry.location);

    // Remove previous marker (if any)
    if (marker) {
      marker.setMap(null);
    }

    // Add a new marker
    marker = new google.maps.Marker({
      position: place.geometry.location,
      map: map,
      title: place.name,
    });

    google.maps.event.addListener(marker, "click", function () {
      var placeId = place.place_id;
      var placesService = new google.maps.places.PlacesService(map);
      placesService.getDetails(
        { placeId: placeId },
        function (placeDetails, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            var name = placeDetails.name;
            var address = placeDetails.formatted_address;
            var phoneNumber = placeDetails.formatted_phone_number;
            var website = placeDetails.website;

            alert(`
            Name: ${name}
            Address: ${address}
            Phone: ${phoneNumber}
            Website: ${website}
          `);
          } else {
            alert("Failed to fetch place details: " + status);
          }
        }
      );
    });
  });

  infoWindow = new google.maps.InfoWindow();

  const locationButton = document.getElementById("locationButton");

  map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
  locationButton.addEventListener("click", autoGetLocation);

  // Add an event listener to the map for double-clicks
  google.maps.event.addListener(map, "dblclick", function (event) {
    const clickedLat = event.latLng.lat();
    const clickedLng = event.latLng.lng();
    console.log(event.latLng);
    map.panTo(event.latLng);

    // Do something with the latitude and longitude, e.g., display or use them
    console.log(
      "Double-clicked at Latitude: " + clickedLat + ", Longitude: " + clickedLng
    );
  });
}

function autoGetLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        map.zoom = 18;
        infoWindow.setPosition(pos);
        infoWindow.setContent("現在位置です！");
        infoWindow.open(map);
        map.setCenter(pos);
      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
    );
  } else {
    handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}

window.initMap = initMap;
