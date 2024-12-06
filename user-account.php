<?php
include 'src/config/session-config.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>EventHive - User Account</title>
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
<div class="container mx-auto px-5 py-8">
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
        <div>
            <div class="rounded-lg bg-gray-50 p-4">
                <?php 

                    if (isset($_SESSION['username'])) {
                        
                        $sessionUserName = $_SESSION['username'];
                    
                        $query = "SELECT * FROM `user_detail` WHERE username = '$sessionUserName'";
                        $result = mysqli_query($conn, $query); 

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        
                ?>
                <div class="flex justify-between">
                    
                    <div class="bg-cover bg-center rounded-xl w-40 h-32 shadow-lg" style="background-image: url('<?php echo $row['img']?>');"></div>
                <div>
                <a href="edit-profile.php"> <button class=" text-white bg-indigo-600 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center  ">
                        Edit Profile
                    </button></a>
                </div>
                
            </div>
           
 
                <h1 class="font-bold text-3xl pt-3 text-gray-800"><?php echo $row['name']?></h1>
                <span class="font-bold text-lg text-indigo-600">@</span><span class="text-lg text-indigo-600 font-bold"><?php echo $row['username']?></span>
                <p class="text-lg font-semibold py-2"><?php echo $row['email']?></p>
                <p class="text-lg font-semibold pb-2 text-indigo-600"><i class="fa fa-map-marker pr-2" style="font-size:20px;color:black"></i><?php echo $row['location']?></p>
                <h1 class="font-bold text-xl py-2 text-gray-900">Course</h1>
                <p class="text-lg font-semibold pb-1 text-gray-600"><?php echo $row['course']?> </p>
                <h1 class="font-bold text-xl py-2 text-gray-900">Branch</h1>
                <p class="text-lg font-semibold pb-1 text-gray-600"><?php echo $row['branch']?></p>
                <h1 class="font-bold text-xl py-2 text-gray-900">Year</h1>
                <p class="text-lg font-semibold pb-1 text-gray-600"><?php echo $row['year']?> Year</p>
            </div>

            <div class="rounded-lg bg-gray-50 p-4 mt-4">
                <h1 class="font-bold text-3xl pb-5">Skills</h1>
                <div class="flex flex-wrap">
                    <?php 
                    $skills = explode(", ", $row['skills']);
                    foreach ($skills as $skill) {
                  echo '<span class="bg-indigo-800 text-lg text-white font-medium me-2 px-4 py-2 rounded-lg mb-2">' . htmlspecialchars($skill) . '</span>';
                 } ?>
                
                   
                </div>

            </div>
            

        </div>
        <div class="lg:col-span-2">
            <div class="rounded-lg bg-gray-50 p-4">
                <h1 class="font-bold text-3xl pt-3 pb-2">General Information</h1>
               
                <h1 class="font-bold text-2xl pt-1 pb-2">About Me</h1>
                <p class="text-base font-normal pt-1 pb-2"><?php echo $row['about_me']?></p>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8 ">
                   <div>
                    <h1 class="font-bold text-lg pt-1">College/University</h1>
                    <p class="text-base font-normal pt-1 pb-3"><?php echo $row['institution']?></p>
                    
                    <a href="event-venue.php" class="text-white bg-indigo-600 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center  ">
                        Create Event
                    </a>
                   </div>
                   <div>
                    <h1 class="font-bold text-lg pt-1">Expertise</h1>
                    <p class="text-base font-normal pt-1 pb-2"><?php echo $row['expertise']?></p>
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