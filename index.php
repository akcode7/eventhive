<?php include 'src/config/db_connect.php';

$sql = "SELECT DISTINCT event_location FROM event_detail WHERE event_status = 'approved'";
$result = $conn->query($sql);

$eventLocations = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eventLocations[] = $row['event_location'];
    }
} else {
    echo "No approved events found.";
}

$coordinates = [];
foreach ($eventLocations as $location) {
    $stmt = $conn->prepare("SELECT name, coordinate FROM places WHERE name = ?");
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    
            $coords = explode(',', $row['coordinate']);
            
            $coordinates[] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [(float)$coords[0], (float)$coords[1]] 
                ],
                'properties' => [
                    'name' => $row['name']
                ]
            ];
        }
    }
}

$geojson = json_encode([
    'type' => 'FeatureCollection',
    'features' => $coordinates
]);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS -->
  <link rel="stylesheet" href="src/css/output.css">
  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
  <!-- Include Mapbox GL JS stylesheet -->
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet" />
  <!-- Include Mapbox GL JS script -->
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
  <title>EventHive - Home</title>
  <style>
      *{
        margin:0;
        padding:0;
        font-family: "ZCOOL XiaoWei", sans-serif;
        }
    /* map */
     @media (max-width: 1279px) { 
        .map {
          position: fixed;
          top: 0;
          left: 0;
          height: 55vh; 
          z-index: -1; 
        }
        .cards-section {
        position: relative;
        z-index: 1; 
        overflow-y: scroll;
        height: calc(100vh - 55vh); 
      }
        
    }

    /* animation for marker */
    .animate-ping {
      animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    @keyframes ping {
      100% {
        transform: scale(5);  
        opacity: 0;            
      }
    }

    .marker {
      position: relative;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background-color: rgba(255, 0, 0, 0.969);
    }

    .marker-ping {
      position: absolute;
      top: -1px;
      left: -1px;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background-color: rgba(230, 9, 9, 0.769); 
      animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    /* User location marker (blue) */
    .user-marker {
      position: relative;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background-color: rgba(0, 0, 255, 0.969); 
    }

    .user-marker-ping {
      position: absolute;
      top: -1px;  
      left: -1px;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background-color: rgba(0, 0, 255, 0.4);
      animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

  </style>
</head>
<body>
  <!-- Header starts -->
  <?php include 'src/component/header.php';?>
  <!-- Header ends -->
  <div class="grid grid-cols-2 xl:h-screen -mt-5">
    <!-- Map Section -->
    <div class="col-span-2 xl:col-span-1 h-[55vh] xl:h-screen map-container">
      <div id="map" class="h-full"></div>
    </div>
    <!-- Cards Section -->
    <div class="col-span-2 xl:col-span-1 xl:px-10 xl:py-12 overflow-y-scroll cards-section pt-3 pb-8 px-4">
      <?php
          $sql = mysqli_query($conn, " SELECT event_detail.*, user_detail.img 
          FROM event_detail
          INNER JOIN user_detail ON event_detail.user_name = user_detail.username 
          WHERE event_detail.event_status = 'approved' 
          ORDER BY event_detail.sno DESC");
          while($row = mysqli_fetch_assoc($sql)){
      ?>
      <!-- Card -->
      <div class="relative mt-3 mb-8">
        <div class="relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8 shadow-xl">
          <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>
          <div class="flex justify-between">
            <div class="px-2 overflow-wrap">
              <h3 class="text-lg font-bold text-gray-900 sm:text-xl break-words"><?php echo $row['event_name']?></h3>
              <a href="user-page.php?user=<?php echo $row['user_name'];?>" class="mt-1 text-xs font-semibold text-gray-800 hover:text-indigo-800 hover:font-bold">@<?php echo $row['user_name']?></a>
            </div>
            <div class="px-2">
              <img alt="" src="<?php echo $row['img']?>" class="size-16 rounded-lg object-cover shadow-sm"/>
            </div>
          </div>
          <div class="mt-4 px-2">
            <p class="text-pretty text-sm text-gray-500">
              <?php 
                  $max_length = 180;
                  $post_title = $row['event_description'];
                  if (strlen($post_title) > $max_length) {
                      $post_title = substr($post_title, 0, $max_length) . '...';
                  }
                  echo $post_title
              ?>
            </p>
          </div>
          <dl class="mt-6 flex gap-4 sm:gap-6 px-2">
            <div class="flex flex-col-reverse">
              <dd class="text-xs font-semibold text-gray-900"><?php echo $row['event_date'];?></dd>
              <dt class="text-sm font-semibold text-indigo-700">Event Date</dt>
            </div>
            <div class="flex flex-col-reverse">
              <dd class="text-xs font-semibold text-gray-900"><?php echo $row['event_location'];?></dd>
              <dt class="text-sm font-semibold text-indigo-700">Event Location</dt>
            </div>
            <div class="flex items-center justify-end">
              <a href="event-details.php?id=<?php echo $row['event_id']?>">
                <dt class="absolute right-0 -mt-[20px] xl:-mt-auto text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 mx-1">View Event</dt>
              </a>
            </div>
          </dl>
        </div>
      </div>
      
      <?php
          }
      ?>
    </div>
  </div>

  <script>
    // Mapbox access token
    mapboxgl.accessToken = 'pk.eyJ1IjoidGhlLW1hcC1tYWtlciIsImEiOiJjbTQ3bnVleTEwN3d5MmxweHI2d21sc2lxIn0.ybOGD3OUFJrDOMMWszY8Rg';

    const map = new mapboxgl.Map({
      container: 'map', 
      style: 'mapbox://styles/mapbox/dark-v10', 
      center: [81.05907530791517, 26.888545268230786], 
      zoom: 16 
    });

    map.on('load', function() {
      if (map.getLayer('bbd-points')) {
        map.removeLayer('bbd-points');
      }
      if (map.getSource('bbd-locations')) {
        map.removeSource('bbd-locations');
      }

      // Add points from GeoJSON
      const coordinates = <?php echo $geojson; ?>;

      coordinates.features.forEach((feature) => {
        const el = document.createElement('div');
        el.className = 'marker';

        // ping element
        const pingElement = document.createElement('div');
        pingElement.className = 'marker-ping';
        el.appendChild(pingElement);

        new mapboxgl.Marker(el)
          .setLngLat(feature.geometry.coordinates)
          .setPopup(new mapboxgl.Popup().setHTML(`<h3>${feature.properties.name}</h3>`))
          .addTo(map);
      });

      // Pointer on hover
      map.on('mouseenter', 'bbd-points', function() {
        map.getCanvas().style.cursor = 'pointer';
      });

      map.on('mouseleave', 'bbd-points', function() {
        map.getCanvas().style.cursor = '';
      });

      // Get user's location and add a blue marker
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          const userCoordinates = [position.coords.longitude, position.coords.latitude];

          console.log('User coordinates:', userCoordinates);

          const userEl = document.createElement('div');
          userEl.className = 'user-marker';

          // ping element for user marker
          const userPingElement = document.createElement('div');
          userPingElement.className = 'user-marker-ping';
          userEl.appendChild(userPingElement);

          new mapboxgl.Marker(userEl)
            .setLngLat(userCoordinates)
            .addTo(map);

        }, function(error) {
          console.error("Error getting location: ", error);  
        });
      }
    });

  </script>

</body>
</html>
