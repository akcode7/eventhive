<?php
include 'src/config/session-config.php';
include 'src/config/db_connect.php';

$slug = isset($_GET['id']) ? trim($_GET['id'], '/') : '';

if (empty($slug)) {
    
    echo "error: Event id is missing";
    exit();
}
?>


<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data
    $event_id = $_GET['id'];
    $eventname = $_POST['eventname'];
    $event_type = $_POST['eventtype'];
    $event_date = $_POST['eventdate'];
    $eventvenue = $_POST['eventvenue'];
    $eventstart = $_POST['eventstart'];
    $joiningreq = $_POST['joiningreq'];
    $eventend = $_POST['eventend'];
    $eventdiscription = $_POST['eventdiscription'];
   
    $sql = "UPDATE `event_detail` SET `event_name` = ? , `event_type` = ?, `event_date` = ?, `event_start` = ?, `event_end` = ?, `event_venue` = ?, `event_description` = ?, `req_for_joining` = ? WHERE `event_id` = '$event_id'";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssssssss", $eventname, $event_type, $event_date, $eventstart, $eventend, $eventvenue, $eventdiscription, $joiningreq);

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
                   
                    <svg class="mx-auto mb-4"xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256"
                    style="fill:#000000;">
                    <g fill="#ff0101" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.69047,0 -23,10.30953 -23,23c0,12.69047 10.30953,23 23,23c12.69047,0 23,-10.30953 23,-23c0,-12.69047 -10.30953,-23 -23,-23zM25,4c11.60953,0 21,9.39047 21,21c0,11.60953 -9.39047,21 -21,21c-11.60953,0 -21,-9.39047 -21,-21c0,-11.60953 9.39047,-21 21,-21zM32.99023,15.98633c-0.26377,0.00624 -0.51439,0.11645 -0.69727,0.30664l-7.29297,7.29297l-7.29297,-7.29297c-0.18827,-0.19353 -0.4468,-0.30272 -0.7168,-0.30274c-0.40692,0.00011 -0.77321,0.24676 -0.92633,0.62377c-0.15312,0.37701 -0.06255,0.80921 0.22907,1.09303l7.29297,7.29297l-7.29297,7.29297c-0.26124,0.25082 -0.36648,0.62327 -0.27512,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27512l7.29297,-7.29297l7.29297,7.29297c0.25082,0.26124 0.62327,0.36648 0.97371,0.27512c0.35044,-0.09136 0.62411,-0.36503 0.71547,-0.71547c0.09136,-0.35044 -0.01388,-0.72289 -0.27512,-0.97371l-7.29297,-7.29297l7.29297,-7.29297c0.29724,-0.28583 0.38857,-0.7248 0.23,-1.10546c-0.15857,-0.38066 -0.53454,-0.62497 -0.94679,-0.61524z"></path></g></g>
                    </svg>
                        <h3 class="mb-5 text-2xl font-medium text-red-600 ">Detail already exists </h3>
                       
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
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/output.css">
    <script src="index.js"></script>
    <title>EventHive - Edit Event</title>
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
    <div class="container mx-auto">
        <section class="bg-white">
            <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Edit Event</h2>
                <?php
                    $sql = mysqli_query($conn, "SELECT * FROM `event_detail` WHERE `event_id` = '$slug'");
                    while($row = mysqli_fetch_assoc($sql)){
                ?>
                <form method="POST">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Event Name</label>
                            <input type="text" name="eventname" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['event_name']?>" required="">
                        </div>
                        <div class="w-full">
                            <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 ">Event Type</label>
                            <input type="text" name="eventtype"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['event_type']?>" required="">
                        </div>
                        <div class="w-full">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 ">Event Date</label>
                            <input type="date" name="eventdate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['event_date']?>" required="">
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Event Start</label>
                            <select id="category" name="eventstart" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="" value="<?php echo $row['event_start']?>"><?php echo $row['event_start']?></option>
                                <option value="9:00 Am">9:00 Am</option>
                                <option value="9:30 Am">9:30 Am</option>
                                <option value="10:00 Am">10:00 Am</option>
                                <option value="10:30 Am">10:30 Am</option>
                                <option value="11:00 Am">11:00 Am</option>
                                <option value="11:30 Am">11:30 Am</option>
                                <option value="12:00 pm">12:00 pm</option>
                                <option value="12:30 pm">12:30 pm</option>
                                <option value="1:00 pm">1:00 pm</option>
                                <option value="1:30 pm">1:30 pm</option>
                                <option value="2:00 pm">2:00 pm</option>
                                <option value="2:30 pm">2:30 pm</option>
                                <option value="3:00 pm">3:00 pm</option>
                                <option value="3:30 pm">3:30 pm</option>
                                <option value="4:00 pm">4:00 pm</option>
                                <option value="4:30 pm">4:30 pm</option>
                               
                               

                                
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Event End</label>
                            <select id="category" name="eventend" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="" value="<?php echo $row['event_end']?>"><?php echo $row['event_end']?></option>
                                <option value="9:30 Am">9:30 Am</option>
                                <option value="10:00 Am">10:00 Am</option>
                                <option value="10:30 Am">10:30 Am</option>
                                <option value="11:00 Am">11:00 Am</option>
                                <option value="11:30 Am">11:30 Am</option>
                                <option value="12:00 pm">12:00 pm</option>
                                <option value="12:30 pm">12:30 pm</option>
                                <option value="1:00 pm">1:00 pm</option>
                                <option value="1:30 pm">1:30 pm</option>
                                <option value="2:00 pm">2:00 pm</option>
                                <option value="2:30 pm">2:30 pm</option>
                                <option value="3:00 pm">3:00 pm</option>
                                <option value="3:30 pm">3:30 pm</option>
                                <option value="4:00 pm">4:00 pm</option>
                                <option value="4:30 pm">4:30 pm</option>
                                <option value="5:00 pm">5:00 pm</option>
                               

                                
                            </select>
                        </div>
                        <div class="">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Event Location</label>
                            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " ><?php echo $row['event_location']?></p>
                        </div>
                        <div class="">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Event Venue</label>
                            <input type="text" name="eventvenue" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['event_venue']?>" required="">
                        </div>
                         
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Requirements for joining</label>
                            <textarea id="description" name="joiningreq" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 "><?php echo $row['req_for_joining']?></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Event Description</label>
                            <textarea id="description" name="eventdiscription" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Write  detail here..."><?php echo $row['event_description']?></textarea>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  ">
                            Update Event
                        </button>
                        
                    </div>
                </form>
                <?php }?>
            </div>
          </section>

    </div>

    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</body>
</html>