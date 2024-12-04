
<?php
session_start();

if (isset($_SESSION['email'])) {
    // Session already exists, user is identified
    $email = $_SESSION['email'];
   
} else {
    // No session exists, user needs to log in or register
    header("location: ../authentication/login.php"); // Replace 'login.php' with the actual login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/output.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>EventHive</title>
</head>
<body>
<!-- Header starts -->
<?php include 'src/component/header.php';?>
<!-- Header ends -->
<div class="container mx-auto px-5 py-10">
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
        <div>
            <div class="rounded-lg bg-gray-50 p-4">
                <?php include 'src/config/db_connect.php';

                    // Check if the user is logged in
                    if (isset($_SESSION['username'])) {
                        // Get the user ID from the session
                        $sessionUserName = $_SESSION['username'];
                    
                        // Query to select user data based on user_id from the session
                        $query = "SELECT * FROM `user_detail` WHERE username = '$sessionUserName'";
                        $result = mysqli_query($conn, $query); // Assuming you have a database connection stored in $conn

                        // Check if there are any rows returned from the query
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        
                ?>
                <div class="flex justify-between">
                    <img class="rounded w-40 h-32" src="<?php echo $row['img']?>" alt="Extra large avatar">
                <div>
                <a href="edit-profile.php"> <button class=" text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center  ">
                        Edit Profile
                    </button></a>
                </div>
                
            </div>
           
 
                <h1 class="font-bold text-3xl pt-3"><?php echo $row['name']?></h1>
                <span class="font-bold text-lg">@</span><span class="font-medium text-lg"><?php echo $row['username']?></span>
                <p class="text-lg font-semibold pt-1"><?php echo $row['email']?></p>
                <p class="text-lg font-semibold pt-1"><i class="fa fa-map-marker pr-2" style="font-size:20px;color:black"></i><?php echo $row['location']?></p>
                <h1 class="font-bold text-xl pt-1">Course</h1>
                <p class="text-lg font-semibold pt-1"><?php echo $row['course']?> </p>
                <h1 class="font-bold text-xl pt-1">Branch</h1>
                <p class="text-lg font-semibold pt-1"><?php echo $row['branch']?></p>
                <h1 class="font-bold text-xl pt-1">Year</h1>
                <p class="text-lg font-semibold pt-1"><?php echo $row['year']?> Year</p>
            </div>

            <div class="rounded-lg bg-gray-50 p-4 mt-4">
                <h1 class="font-bold text-3xl pb-5">Skills</h1>
                <div class="flex flex-wrap">
                    <?php 
                    $skills = explode(", ", $row['skills']);
                    foreach ($skills as $skill) {
                  echo '<span class="bg-green-500 text-lg text-green-800 font-medium me-2 px-4 py-2 rounded-lg mb-2">' . htmlspecialchars($skill) . '</span>';
                 } ?>
                
                   
                </div>

            </div>
            

        </div>
        <div class="lg:col-span-2">
            <div class="rounded-lg bg-gray-50 p-4">
                <h1 class="font-bold text-3xl pt-3">General Information</h1>
               
                <h1 class="font-bold text-2xl pt-1">About Me</h1>
                <p class="text-base font-normal pt-1"><?php echo $row['about_me']?></p>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8 ">
                   <div>
                    <h1 class="font-bold text-lg pt-1">College/University</h1>
                    <p class="text-base font-normal pt-1"><?php echo $row['institution']?></p>
                    <h1 class="font-bold text-lg pt-1">Join Date</h1>
                    <p class="text-base font-normal pt-1"><?php echo $row['joining_date']?></p>
                    <h1 class="font-bold text-lg pt-1 pb-2">Events Organised</h1>
                    <a href="event-venue.php" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center  ">
                        Create Event
                    </a>
                   </div>
                   <div>
                    <h1 class="font-bold text-lg pt-1">Expertise</h1>
                    <p class="text-base font-normal pt-1"><?php echo $row['expertise']?></p>
                    <h1 class="font-bold text-lg pt-1 pb-2">Social Media</h1>
                    <div class="flex flex-wrap">
                        <a href="https://<?php echo $row['github']?>"><button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">GitHub</button></a>
                        <a href="https://<?php echo $row['linkedin']?>"><button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">LinkedIn</button></a>
                    </div>
                   </div>
                </div>
            </div>
        </div>
    <?php
  }}}
  ?>
      </div>
    </div>

  
</body>
</html>