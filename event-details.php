<?php
include 'src/config/session-config.php';
include 'src/config/db_connect.php';

$slug = isset($_GET['id']) ? trim($_GET['id'], '/') : '';

if (empty($slug)) {
    // header("Location: ../");
    echo "error: Event id is missing";
    exit();
}

$userName=$_SESSION['username'];
$eventID =$slug;



// Check if the user has already joined the event
$sql = "SELECT * FROM joined_events WHERE user_name = ? AND event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userName, $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $joined = true;  // User already joined
} else {
    $joined = false;  // User has not joined yet
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Insert data to mark the user as joined
        $status = 1;  // 1 means joined
        $insert_sql = "INSERT INTO joined_events (user_name, event_id, join_status) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssi", $userName, $eventID, $status);
        $insert_stmt->execute();
        $joined = true;  // After insertion, user is marked as joined
    }
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
    <title>EventHive - Event Details</title>
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
    $sql = mysqli_query($conn, "
    SELECT event_detail.*, places.place_img 
    FROM event_detail
    INNER JOIN places ON event_detail.event_location = places.name
    WHERE event_detail.event_id = '$slug'");

    while($row = mysqli_fetch_assoc($sql)){
?>

    <div class="container mx-auto py-5 xl:py-10 px-2">
        <div class="flex space-x-3 items-center justify-center">
            <div class="w-24">
                <img class="rounded-md" src="<?php echo $row['event_img']?>" alt="">
            </div>
            <div class="text-xl xl:text-4xl font-semibold text-black"><?php echo $row['event_name']?></div>
        </div>
    </div>
    <section class="bg-gray-100">
        <div class="container mx-auto pb-20 pt-10 max-w-6xl">
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 xl:col-span-2 p-5 border rounded-lg">
                    <div>
                        <img class="rounded-lg" src="<?php echo $row['event_img']?>" alt="">
                    </div>
                    <div class="p-5 border rounded-lg bg-white mt-5">
                        <p class="text-base font-medium text-gray-800"><?php echo $row['event_description']?></p>
                    </div>
                    <div class="p-5 border rounded-lg bg-white mt-5">
                        <p class="text-2xl font-semibold text-gray-800 mb-2">Requirements for joining</p>
                        <p class="text-base font-medium text-gray-800"><?php echo $row['req_for_joining']?></p>
                    </div>
                    <div class="p-5 border rounded-lg mt-5">
                        <p class="text-2xl font-semibold text-gray-800">Event info</p>
                        <div class="grid grid-cols-2 gap-4 mt-5">
                            <div class="col-span-2 xl:col-span-1 bg-white rounded-lg px-5 py-3 shadow">
                                <div class="">
                                    <p class="text-xl font-semibold text-gray-900 mb-2">Event type</p>
                                    
                                    <p class="text-lg font-medium text-indigo-600"><?php echo $row['event_type']?></p>
                                </div>
                            </div>
                            <div class="col-span-2 xl:col-span-1 bg-white rounded-lg px-5 py-3 shadow">
                                <div class="">
                                    <p class="text-xl font-semibold text-gray-900 mb-2">Event venue</p>
                                    
                                    <p class="text-lg font-medium text-indigo-600"><?php echo $row['event_venue']?></p>
                                </div>
                            </div>
                        </div>
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
                <div class="col-span-3 xl:col-span-1 py-5 px-5 xl:px-0">
                    <div class="bg-white p-6 rounded-lg shadow-xl">
                        <div class="bg-gray-500 max-h-60 overflow-hidden mb-5 rounded-lg">
                            <img src="<?php echo $row['place_img']?>" alt="" class="bg-cover">
                        </div>
                        <div class="border-l-[5px] border-indigo-700">
                            <div class="pl-2">
                                <p class="text-xl text-gray-900 font-semibold">Event Date</p>
                                <p class="text-base text-gray-700 font-medium py-1"><?php echo $row['event_date']?></p>
                            </div>
                            <div class="pl-2 pt-2">
                                <p class="text-xl text-gray-900 font-semibold">Event Start</p>
                                <p class="text-base text-gray-700 font-medium py-1"><?php echo $row['event_start']?></p>
                            </div>
                            <div class="pl-2 pt-2">
                                <p class="text-xl text-gray-900 font-semibold">Event End</p>
                                <p class="text-base text-gray-700 font-medium py-1"><?php echo $row['event_end']?></p>
                            </div>
                        </div>
                        <div class="rounded-lg mt-5 text-center cursor-pointer" id="joinButton">
                            <?php if ($joined): ?>
                                <!-- If user has joined, show 'Joined' and disable the button -->
                                <button class="text-lg font-semibold text-white text-center !bg-indigo-500 w-full h-full py-4 cursor-pointer rounded-lg transition-all duration-300" id="joinButtonText" disabled>Joined</button>
                            <?php else: ?>
                                <!-- If user has not joined, show 'Join Now' and enable the button -->
                                <form method="POST">
                                    <button type="submit" class="text-lg font-semibold text-white text-center w-full h-full py-4 bg-indigo-700 hover:bg-yellow-600 rounded-lg  transition-all duration-300" id="joinButtonText">Join Now</button>
                                </form>
                            <?php endif; ?>
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