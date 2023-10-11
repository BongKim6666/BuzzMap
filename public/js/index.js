var map;
var marker; // 将 marker 对象提升到外部作用域

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
}
