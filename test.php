
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/output.css">
    <script src="index.js"></script>
    <title>EventHive</title>
</head>
<body>
<style>
    /**
 * @license
 * Copyright 2024 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */

/* Optional: Makes the sample page fill the window. */
html, body {
  height: 100%;
  margin: 0;
}

/* Shift the flag icon to the right so that the bottom of the flagpole
 * aligns with the anchor point. */
.flag-icon {
  position: relative;
  left: 10px;
}
</style>
    <gmp-map center="26.888641086875605, 81.05903983007525" zoom="16" map-id="DEMO_MAP_ID">
      <gmp-advanced-marker position="26.888776237171417, 81.0589923272311" title="Bondi Beach">
        <img class="flag-icon"
             src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"/>
      </gmp-advanced-marker>
      <gmp-advanced-marker position="26.887931588206563, 81.05808036414905" title="Coogee Beach">
        <img class="flag-icon"
             src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"/>
      </gmp-advanced-marker>
      <gmp-advanced-marker position="26.887291942306096, 81.05910929839457" title="Cronulla Beach">
        <img class="flag-icon"
             src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"/>
      </gmp-advanced-marker>
      <gmp-advanced-marker position="26.886935559931715, 81.05772425928674" title="Manly Beach">
        <img class="flag-icon"
             src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"/>
      </gmp-advanced-marker>
      <gmp-advanced-marker position="26.885339164707034, 81.05883286456537" title="Maroubra Beach">
        <img class="flag-icon"
             src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"/>
      </gmp-advanced-marker>
    </gmp-map>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&loading=async&libraries=marker&v=beta&solution_channel=GMP_CCS_complexmarkers_v3"
      defer
    ></script>
</body>
</html>