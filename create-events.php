<?php

include 'src/config/session-config.php';
include 'src/config/db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$slug = isset($_GET['location']) ? trim($_GET['location'], '/') : '';

if (empty($slug)) {
    echo "error: Event id is missing";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data
    $eventlocation = $_POST['eventlocation'];
    $username = $_SESSION['username'];
    $eventid = "EHive" . rand(1111111, 9999999);
    $eventname = $_POST['eventname'];
    $event_type = $_POST['eventtype'];
    $event_date = $_POST['eventdate'];
    $eventvenue = $_POST['eventvenue'];
    $eventstart = $_POST['eventstart'];
    $eventend = $_POST['eventend'];
    $eventapprover = $_POST['eventapprover'];
    $joiningreq = $_POST['joiningreq'];
    $eventdiscription = $_POST['eventdiscription'];
    $eventstatus = "Unapproved";
    
    // Handle image upload
    if (isset($_FILES['event_img']) && $_FILES['event_img']['error'] === UPLOAD_ERR_OK) {
        // Get the uploaded image details
        $imageTmpName = $_FILES['event_img']['tmp_name'];
        $imageName = $_FILES['event_img']['name'];
        $imageSize = $_FILES['event_img']['size'];
        $imageError = $_FILES['event_img']['error'];
        
        // Generate a unique name for the uploaded image
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $newImageName = uniqid('', true) . '.' . $imageExt;
        
        // Set the target directory
        $targetDir = 'src/upload/';
        $targetFile = $targetDir . $newImageName;

        // Allowed image extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate the file type
        if (in_array($imageExt, $allowedExtensions)) {
            
            if ($imageSize < 5000000) {
                if (move_uploaded_file($imageTmpName, $targetFile)) {
                    $eventimg = $targetFile; 
                } else {
                    echo "Error uploading image.";
                    $eventimg = NULL; 
                }
            } else {
                echo "File is too large. Max size is 5MB.";
                $eventimg = NULL; 
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, GIF allowed.";
            $eventimg = NULL; 
        }
    } else {
        $eventimg = NULL;
    }

    $sql = "INSERT INTO `event_detail` 
            (`event_id`, `user_name`, `event_name`, `event_type`, `event_location`, `event_venue`, `event_date`, `event_start`, `event_end`, `event_approver`, `req_for_joining`, `event_description`, `event_status`, `event_img`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssssssssssssss", $eventid, $username, $eventname, $event_type, $eventlocation, $eventvenue, $event_date, $eventstart, $eventend, $eventapprover, $joiningreq, $eventdiscription, $eventstatus, $eventimg);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("location: your-events.php");
    } else {
        echo "Insert error.";
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
    <title>EventHive - Create Event</title>
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
    <div class="container mx-auto max-w-6xl">
        <section class="bg-white">
            <div class="max-w-2xl px-4 py-8 mx-auto lg:py-6">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Create Event</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        <div class="sm:col-span-2">
                            <label for="eventname" class="block mb-2 text-sm font-medium text-gray-900 ">Event Name</label>
                            <input type="text" name="eventname" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "  placeholder="Type event name" required="">
                        </div>
                        <div class="w-full">
                            <label for="eventtype" class="block mb-2 text-sm font-medium text-gray-900 ">Event Type</label>
                            <input type="text" name="eventtype" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="E.g Collab" required="">
                        </div>
                        <div class="w-full">
                            <label for="eventdate" class="block mb-2 text-sm font-medium text-gray-900 ">Event Date</label>
                            <input type="date" name="eventdate" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "  placeholder="select Date" required="">
                        </div>
                        <div>
                            <label for="eventstart" class="block mb-2 text-sm font-medium text-gray-900 ">Event Start</label>
                            <select id="eventstart" name="eventstart" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="">Select Time</option>
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
                            <label for="eventend" class="block mb-2 text-sm font-medium text-gray-900 ">Event End</label>
                            <select id="eventend" name="eventend" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="">Select Time</option>
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
                            <label for="eventlocation" class="block mb-2 text-sm font-medium text-gray-900 ">Event Location</label>
                            <input type="text" name="eventlocation" id="eventlocation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "  value="<?php echo $slug?>"  required>
                        </div>
                        <div class="">
                            <label for="eventvenue" class="block mb-2 text-sm font-medium text-gray-900 ">Event Venue</label>
                            <input type="text" name="eventvenue" id="eventvenue" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "  placeholder="Type event venue" required="">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900 ">Event Approver</label>
                            <input type="text" name="eventapprover" id="eventapprover" oninput="load_data(this.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="" placeholder="Write username of approver" required="">
                            <div id="suggestions-container" class="mt-2"></div> <!-- Container for suggestions -->
                            <p class="text-sm font-semibold text-gray-600">*Request to be approved by 1 host to make your listing visible to public</p>

                        </div> 
                       
                        
                        <div class="sm:col-span-2">
                            <label for="joiningreq" class="block mb-2 text-sm font-medium text-gray-900 ">Requirements for joining</label>
                            <textarea id="joiningreq" name="joiningreq" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Write requirements here..."></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="eventdiscription" class="block mb-2 text-sm font-medium text-gray-900 ">Event Description</label>
                            <textarea id="eventdiscription" name="eventdiscription" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Write a Event description here..."></textarea>
                        </div>
                        <div>
                            <!-- File input to allow user to upload a new image -->
                            <input class="block w-full text-sm text-gray-900 cursor-pointer focus:outline-none" 
                                id="file_input" type="file" name="event_img" accept="image/*">
                        </div>

                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  ">
                            Create Event
                        </button>
                        
                    </div>
                </form>
            </div>
          </section>
    </div>
    <script>
      function load_data(search = '') {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "src/search/search.php?search=" + search, true);
        xhr.onload = function() {
            document.getElementById('suggestions-container').innerHTML = xhr.responseText;
        }
        xhr.send();
    }

    //  handle click
    function selectSuggestion(username) {
        document.getElementById('eventapprover').value = username;
        document.getElementById('suggestions-container').innerHTML = '';
    }


    </script>
</body>
</html>