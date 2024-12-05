
<?php
include 'src/config/session-config.php';
include 'src/config/db_connect.php';

$slug = isset($_GET['id']) ? trim($_GET['id'], '/') : '';

if (empty($slug)) {
    // header("Location: ../");
    echo "error: Event id is missing";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/output.css">
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
    <script src="index.js"></script>
    <title>EventHive</title>
    <style>
        *{
        margin:0;
        padding:0;
        font-family: "ZCOOL XiaoWei", sans-serif;
        }
    </style>
</head>
<body>
       <!-- Header starts -->
    <?php include 'src/component/header.php';?>
    <!-- Header ends -->

<?php
    $sql = mysqli_query($conn, "SELECT * FROM `event_detail` WHERE  `event_id` = '$slug'");
    while($row = mysqli_fetch_assoc($sql)){
?>

    <div class="container mx-auto py-5 xl:py-10">
        <div class="flex space-x-3 items-center justify-center">
            <div class="w-12 xl:w-24">
                <img class="rounded-md" src="https://unfold2024.devfolio.co/_next/image?url=https%3A%2F%2Fassets.devfolio.co%2Fhackathons%2Fbeea3a652dd04c86b1890bd76bca5451%2Fassets%2Ffavicon%2F93.png&w=1440&q=75" alt="">
            </div>
            <div class="text-2xl xl:text-4xl font-semibold text-black"><?php echo $row['event_name']?></div>
        </div>
    </div>
    <section class="bg-gray-100">
        <div class="container mx-auto pb-20 pt-10 max-w-6xl">
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 xl:col-span-2 p-5 border rounded-lg">
                    <div>
                        <img class="rounded-lg hidden" src="https://unfold2024.devfolio.co/_next/image?url=https%3A%2F%2Fassets.devfolio.co%2Fhackathons%2Fbeea3a652dd04c86b1890bd76bca5451%2Fassets%2Fcover%2F856.jpeg&w=1440&q=100" alt="">
                    </div>
                    <div class="p-5 border rounded-lg bg-white mt-5">
                        <p class="text-base font-medium text-gray-800"><?php echo $row['event_description']?></p>
                    </div>
                    <div class="p-5 border rounded-lg mt-5">
                        <p class="text-2xl font-semibold text-gray-800">Hosts</p>
                        <div class="grid grid-cols-2 gap-4 mt-5">
                            <div class="col-span-2 xl:col-span-1 bg-white rounded-lg px-5 py-3 shadow">
                                <div class="flex items-center space-x-3">
                                    <div class=" bg-gray-200 px-[17px] py-2 rounded-full">
                                        <span class="text-4xl font-semibold text-gray-500"><?php echo strtoupper($row['user_name'][0]); ?></span>
                                    </div>
                                    <p class="text-xl font-semibold text-gray-900"><?php echo $row['user_name']?></p>
                                </div>
                            </div>
                            <div class="col-span-2 xl:col-span-1 bg-white rounded-lg px-5 py-3 shadow">
                                <div class="flex items-center space-x-3">
                                    <div class=" bg-gray-200 px-[17px] py-2 rounded-full">
                                        <span class="text-4xl font-semibold text-gray-500"><?php echo strtoupper($row['event_approver'][0]); ?></span>
                                    </div>
                                    <p class="text-xl font-semibold text-gray-900"><?php echo $row['event_approver']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden xl:block col-span-1 py-5">
                    <div class="bg-white p-6 rounded-lg shadow-xl">
                        <div class="bg-gray-500 h-60 mb-5 rounded-lg">
                            
                        </div>
                        <div class="border-l-[5px] border-indigo-700">
                            <div class="pl-2">
                                <p class="text-xl text-gray-900 font-semibold">Event Start</p>
                                <p class="text-base text-gray-700 font-medium py-1"><?php echo $row['event_start']?></p>
                            </div>
                            <div class="pl-2 pt-4">
                                <p class="text-xl text-gray-900 font-semibold">Event End</p>
                                <p class="text-base text-gray-700 font-medium py-1"><?php echo $row['event_end']?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





 
    <?php
  }
  ?>
<script>
       // Mapbox access token
       mapboxgl.accessToken = 'pk.eyJ1IjoiamFtZXNjYWRvd25lciIsImEiOiJjbTQ4eHc2dGYwNGxkMnBxNW96NGVpeXNzIn0.CpjezxPOs7sXq_TU8F9CiA';

</script>
</body>
</html>