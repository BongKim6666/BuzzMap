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
    zoomControl: false,
    streetViewControl: true,
    mapTypeControl: false, //マップタイプ コントロール
    streetViewControl: false, //ストリートビュー コントロール
  });

  var input = document.getElementById("addressInput");
  var autocomplete = new google.maps.places.Autocomplete(input);

  autocomplete.addListener("place_changed", function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    map.setCenter(place.geometry.location);

    // 移除先前的标记（如果有）
    if (marker) {
      marker.setMap(null);
    }

    // 添加新的标记
    marker = new google.maps.Marker({
      position: place.geometry.location,
      map: map,
      title: place.name,
    });

    // 添加标记点击事件以显示详细信息
    google.maps.event.addListener(marker, "click", function () {
      var placeId = place.place_id; // 获取地点的 Place ID

      // 使用 Places API 获取详细信息
      var placesService = new google.maps.places.PlacesService(map);
      placesService.getDetails(
        { placeId: placeId },
        function (placeDetails, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            // 获取到地点的详细信息
            var name = placeDetails.name;
            var address = placeDetails.formatted_address;
            var phoneNumber = placeDetails.formatted_phone_number;
            var website = placeDetails.website;

            // 显示详细信息
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
  console.log(infoWindow);

  const locationButton = document.getElementById("locationButton");

  map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
  locationButton.addEventListener("click", () => {
    // Try HTML5 geolocation.
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
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
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
