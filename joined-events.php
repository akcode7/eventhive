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


<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Process form submission
if (isset($_GET['event_id'])) {
    // Get input data
    $event_id = $_GET['event_id'];

    $event_status = "approved";
   
    $sql = "UPDATE `event_detail` SET `event_status` = ? WHERE `event_id` = '$event_id'";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("s", $event_status);

    // Execute the statement
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
     
        echo ' <div id="model-popup" class="absolute top-28">

        <div  tabindex="-1"  class=" flex item-center items-baseline overflow-y-auto overflow-x-hidden fixed  z-50 justify-center md:items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full top-0 mx-auto">
                <div class="relative bg-white rounded-lg shadow py-8 w-full mx-auto ">
                    <p onclick="cancelbookbtn()" class="absolute top-3 end-2.5 text-gray-800 bg-transparent cursor-pointer hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center " ">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
        </p>
                    <div class="p-4 md:p-5 text-center">
                        
                       
                    <svg  class="mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256"
                    style="fill:#000000;">
                    <g fill="#43ff28" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path></g></g>
                    </svg>
                        <h3 class="mb-5 text-2xl font-medium text-green-400 ">Successfully Updated</h3>
                       
                    </div>
                </div>
            </div>
        </div>
        </div>';
        echo '  <script>
        function cancelbookbtn() {
           let element = document.getElementById("model-popup");
           element.classList.toggle("hidden");
        }
        </script>';
       
    } else {
        echo "insert error";
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
        <title>EventHive - Joined Event</title>
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
    <div class="container mx-auto p-5">
        <h1 class="py-3 text-bold text-2xl text-center">Joind Events</h1>
        <div class="flex justify-center items-center mx-auto pt-8">
            <ul class="max-w-5xl divide-y divide-gray-200 shadow-lg border p-5 w-full overflow-x-scroll">
                <?php
                    $sql = mysqli_query($conn, "
                        SELECT event_detail.*
                        FROM event_detail
                        INNER JOIN joined_events ON event_detail.event_id = joined_events.event_id
                        WHERE joined_events.user_name = '$username'
                    ");

                    while($row = mysqli_fetch_assoc($sql)){
                ?>
                <li class="pb-3 sm:pb-4">
                    <div class="flex items-center space-x-4 py-3">
                        <div class="flex-shrink-0">
                            <img class="w-28 md:w-40 rounded-md" src="<?php echo $row['event_img']?>" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-10">
                            <p class="text-base font-semibold text-gray-800 truncate">
                                <?php echo $row['event_name']?>
                            </p>
                            <p class="text-sm text-gray-500 truncate ">
                                <?php echo $row['event_date']?>
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900">
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


    <script>
function approvebtn() {
   let element = document.getElementById("model-popup");
   element.classList.toggle("hidden");
}
</script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>