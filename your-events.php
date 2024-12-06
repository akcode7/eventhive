<?php
session_start();

if (isset($_SESSION['username'])) {
    
    $username = $_SESSION['username'];
   
} else {
    
    header("location: src/authentication/login.php"); 
    exit();
}
include 'src/config/db_connect.php';

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
        <title>EventHive - Your Events</title>
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
    <div class="container mx-auto px-4 py-3">
        <h1 class="py-3 text-bold text-2xl text-center">Your Events</h1>
        <div class="flex justify-center items-center mx-auto pt-8">
            <ul class="max-w-5xl divide-y divide-gray-200 shadow-lg border p-5 w-full overflow-x-scroll">
                <?php
                    $sql = mysqli_query($conn, "SELECT * FROM `event_detail` WHERE  `user_name` = '$username'");
                    while($row = mysqli_fetch_assoc($sql)){
                ?>
                <li class="pb-3 sm:pb-4">
                    <div class="flex items-center space-x-4 py-3">
                        <div class="flex-shrink-0">
                            <img class="w-28 md:w-40 rounded-md" src="<?php echo $row['event_img']?>" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-min">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                <?php echo $row['event_name']?>
                            </p>
                            <p class="text-sm text-gray-500 truncate ">
                                <?php echo $row['event_date']?>
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900">
                            <a href="event-participant.php?id=<?php echo urlencode($row['event_id']); ?>" class="text-lg font-bold text-yellow-500 px-2 cursor-pointer">Participant</a>
                            <a href="edit-event.php?id=<?php echo urlencode($row['event_id']); ?>" class="text-lg font-bold text-teal-500 px-2 cursor-pointer">Edit</a>
                            <a href="event-details.php?id=<?php echo urlencode($row['event_id']); ?>" class="text-lg font-bold text-blue-500 px-2 cursor-pointer">View</a>
                        </div>
                    </div>
                </li>

                <?php
                    }
                ?>
            </ul>
        </div>

    </div>
   
</body>
</html>