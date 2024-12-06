<?php
include 'src/config/session-config.php';
include 'src/config/db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$featureImg='';
$sql = mysqli_query($conn, "SELECT `img` FROM `user_detail` WHERE username = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'");
while($row = mysqli_fetch_assoc($sql)){
    $featureImg = $row['img'];
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data
    $location = $_POST['location'];
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    $about = $_POST['about'];
    $expertise = $_POST['expertise'];
    $github = $_POST['github'];
    $linkedin = $_POST['linkedin'];
    $institution = $_POST['institution'];

    // Process skills
    if (isset($_POST['skills'])) {
        $skill_op = $_POST['skills'];   
        foreach ($skill_op as $option) {
            $skills[] = $option; 
        }
        $user_skills = implode(", ", $skills);
    } else {
        $user_skills = "No skills selected";
    }

    // Get the existing image path from the database
    $existingImage = isset($featureImg) && !empty($featureImg) ? $featureImg : NULL;

    // Handle image upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Get the uploaded image details
        $imageTmpName = $_FILES['profile_picture']['tmp_name'];
        $imageName = $_FILES['profile_picture']['name'];
        $imageSize = $_FILES['profile_picture']['size'];
        $imageError = $_FILES['profile_picture']['error'];

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
            // Check file size (5MB max)
            if ($imageSize < 5000000) {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($imageTmpName, $targetFile)) {
                    $imagePath = $targetFile;  // Save the new image path
                } else {
                    echo "Error uploading image.";
                    $imagePath = $existingImage; // Retain the existing image if upload fails
                }
            } else {
                echo "File is too large. Max size is 5MB.";
                $imagePath = $existingImage; // Retain the existing image if size is too large
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, GIF allowed.";
            $imagePath = $existingImage; // Retain the existing image if the file type is invalid
        }
    } else {
        // If no new image was uploaded, use the existing image
        $imagePath = $existingImage;
    }

    // SQL query for updating user details
    $sql = "UPDATE `user_detail` SET 
                `location` = ?, 
                `course` = ?, 
                `branch` = ?, 
                `year` = ?, 
                `about_me` = ?, 
                `expertise` = ?, 
                `github` = ?, 
                `linkedin` = ?, 
                `institution` = ?, 
                `skills` = ?, 
                `img` = ? 
            WHERE email = '$email'";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters (make sure types match the data you are binding)
    $stmt->bind_param("sssisssssss", 
        $location, 
        $course, 
        $branch, 
        $year, 
        $about, 
        $expertise,  
        $github, 
        $linkedin, 
        $institution, 
        $user_skills, 
        $imagePath
    );

    // Execute the statement
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo '
        <div id="model-popup" class="absolute top-28">
            <div tabindex="-1" class="flex item-center items-baseline overflow-y-auto overflow-x-hidden fixed z-50 justify-center md:items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full top-0 mx-auto">
                    <div class="relative bg-white rounded-lg shadow py-8 w-full mx-auto ">
                        <p onclick="cancelbookbtn()" class="absolute top-3 end-2.5 text-gray-800 bg-transparent cursor-pointer hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center ">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </p>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256" style="fill:#000000;">
                                <g fill="#43ff28" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path></g></g>
                            </svg>
                            <h3 class="mb-5 text-2xl font-medium text-green-400 ">Successfully Updated</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        echo '  
        <script>
        function cancelbookbtn() {
           let element = document.getElementById("model-popup");
           element.classList.toggle("hidden");
        }
        setTimeout(function() {
            window.location.href = "user-account.php";
        }, 2000);  // 2000 milliseconds = 2 seconds

        </script>';
    } else {
        echo "Update error.";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/output.css">
    <!-- SCRIPT -->
    <script src="index.js"></script>
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
    <title>EventHive - Edit Profile</title>
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
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Edit Profile</h2>

                           
                <?php 
                // include 'src/config/db_connect.php';

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
                <form method="POST"  enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                       
                        <div class="w-full">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Your Name</label>
                            <input type="text" name="name" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['name']?> " placeholder="Your Name" required="">
                        </div>
                        <div class="w-full">
                            <label for="location" class="block mb-2 text-sm font-medium text-gray-900 ">Location</label>
                            <input type="text" name="location" id="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['location']?> " placeholder="eg. Lucknow" required="">
                        </div>
                        
                        <div>
                            <label for="course" class="block mb-2 text-sm font-medium text-gray-900 ">Course</label>
                            <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="" value="<?php echo $row['course']?> "><?php echo $row['course']?> </option>
                                <option value="Bachelor of Technology">Bachelor of Technology</option>
                                <option value="Bachelor of Computer Application ">Bachelor of Computer Application</option>
                                <option value="Bachelor of Business Administration">Bachelor of Business Administration </option>
                                <option value="Master of Business Administration">Master of Business Administration</option>
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Branch</label>
                            <select id="category" name="branch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="" value="<?php echo $row['branch']?> "><?php echo $row['branch']?> </option>
                                <option value="Computer Science Engineering">Computer Science Engineering</option>
                                <option value="Cloud Computing and Machine Learning">Cloud Computing and Machine Learning</option>
                                <option value="Artificial Inteligence">Artificial Inteligence </option>
                                <option value="Iot & Blockchain">Iot & Blockchain</option>
                                <option value="Data Science">Data Science</option>
                                <option value="CyberSecurity">CyberSecurity</option>
                                <option value="Human Resource">Human Resource </option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div>
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-900 ">Year</label>
                            <select id="year" name="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="" value="<?php echo $row['year']?> "><?php echo $row['year']?></option>
                                <option value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                
                            </select>
                        </div>
                        <div>
                            <label for="institute" class="block mb-2 text-sm font-medium text-gray-900 ">Institute</label>
                            <select id="institute" name="institution" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                <option selected="" value="<?php echo $row['institution']?> "><?php echo $row['institution']?> </option>
                                <option value="Babu Banarasi Das University" name="institution">Babu Banarasi Das University</option>
                                <option value="2nd" >BBD Institute of Management</option>
                                <option value="3rd" >BBDNIIT</option>
                               
                                
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="expertise" class="block mb-2 text-sm font-medium text-gray-900 ">Expertise</label>
                            <input type="text" name="expertise" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['expertise']?> " placeholder="Full-Stack Developer" required="">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="github" class="block mb-2 text-sm font-medium text-gray-900 ">Github</label>
                            <input type="text" name="github" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['github']?> " placeholder="eg. github.com/username" >
                        </div>
                        <div class="sm:col-span-2">
                            <label for="linkedin" class="block mb-2 text-sm font-medium text-gray-900 ">LinkedIn</label>
                            <input type="text" name="linkedin" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="<?php echo $row['linkedin']?> " placeholder="eg. linkedin.com/username" >
                        </div>
                        <h3 class="mb-1 font-semibold text-gray-900">Skills</h3>
                       <div class="sm:col-span-2 overflow-scroll h-48">
                       <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex mt-2 ">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                                <div class="flex items-center ps-3">
                                    <input id="vue-checkbox-list" name="skills[]" value="Vue JS" type="checkbox" value="Vue Js" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                    <label for="vue-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">Vue JS</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                                <div class="flex items-center ps-3">
                                    <input id="react-checkbox-list" name="skills[]" type="checkbox" value="React" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                    <label for="react-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">React</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                                <div class="flex items-center ps-3">
                                    <input id="angular-checkbox-list" name="skills[]" type="checkbox" value="Angular" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                                    <label for="angular-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">Angular</label>
                                </div>
                            </li>
                            <li class="w-full ">
                                <div class="flex items-center ps-3">
                                    <input id="laravel-checkbox-list" name="skills[]" type="checkbox" value="Laravel" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                                    <label for="laravel-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">Laravel</label>
                                </div>
                            </li>
                    </ul>
                    <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex mt-2">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                            <div class="flex items-center ps-3">
                                <input id="html-checkbox-list" name="skills[]" type="checkbox" value="HTML" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                <label for="html-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">HTML</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                            <div class="flex items-center ps-3">
                                <input id="css-checkbox-list" name="skills[]" type="checkbox" value="CSS" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                <label for="css-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">CSS</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                            <div class="flex items-center ps-3">
                                <input id="java-checkbox-list" name="skills[]" type="checkbox" value="Java" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                                <label for="java-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">Java</label>
                            </div>
                        </li>
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="python-checkbox-list" name="skills[]" type="checkbox" value="Python" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                                <label for="python-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">Python</label>
                            </div>
                        </li>
                </ul>

                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex mt-2">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                        <div class="flex items-center ps-3">
                            <input id="javascript-checkbox-list" name="skills[]" type="checkbox" value="Javascript" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                            <label for="javascript-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">Javascript</label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                        <div class="flex items-center ps-3">
                            <input id="php-checkbox-list" name="skills[]" type="checkbox" value="PHP" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                            <label for="php-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">PHP</label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                        <div class="flex items-center ps-3">
                            <input id="wordpress-checkbox-list" name="skills[]" type="checkbox" value="Wordpress" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                            <label for="wordpress-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">Wordpress</label>
                        </div>
                    </li>
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="machinelearning-checkbox-list" name="skills[]" type="checkbox" value="Machine Learning" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                            <label for="machinelearning-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">Machine Learning</label>
                        </div>
                    </li>
            </ul>

            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex mt-2">
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                    <div class="flex items-center ps-3">
                        <input id="svelte-checkbox-list" name="skills[]" type="checkbox" value="Svelte" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                        <label for="svelte-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">Svelte</label>
                    </div>
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                    <div class="flex items-center ps-3">
                        <input id="leadership-checkbox-list" name="skills[]" type="checkbox" value="Leader Ship" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                        <label for="leadership-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">Leader Ship</label>
                    </div>
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                    <div class="flex items-center ps-3">
                        <input id="communication-checkbox-list" name="skills[]" type="checkbox" value="Communication" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                        <label for="communication-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">Communication</label>
                    </div>
                </li>
                <li class="w-full ">
                    <div class="flex items-center ps-3">
                        <input id="nlp-checkbox-list" name="skills[]" type="checkbox" value="NLP" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 ">
                        <label for="nlp-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">NLP</label>
                    </div>
                </li>
        </ul>


                        </div>
                         
                        <div class="sm:col-span-2">
                            <label for="about" class="block mb-2 text-sm font-medium text-gray-900 ">About</label>
                            <textarea id="about" rows="3" name="about" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Write something about yourself..."><?php echo $row['about_me']?></textarea>
                        </div>
                        <!-- <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload Profile Picture</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file" name="profile_picture" value="" accept="image/*">
                        </div> -->

                        <div>
    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload Profile Picture</label>
    
    <!-- Display the existing image if available -->
    <?php 
    $featureImg=$row['img'];
    if(!empty($row['img'])): ?>
        <img src="<?php echo $row['img']; ?>" alt="Profile Image" class="w-32 h-32 mb-3 rounded-full object-cover" />
    <?php endif; ?>

    <!-- File input to allow user to upload a new image -->
    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
           id="file_input" type="file" name="profile_picture" accept="image/*">
</div>



                        
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  ">
                            Update Profile
                        </button>
                      
                    </div>
                </form>

                <?php
  }}}
  ?>
            </div>
          </section>

    </div>

    <script>
        // Menu
    const hamburger = document.getElementById('hamburger');
    const menu = document.getElementById('menu');
    const close = document.getElementById('close');
    const overlay = document.getElementById('overlay');

    hamburger.addEventListener('click', () => {
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    close.addEventListener('click', () => {
        menu.classList.remove('active');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        menu.classList.remove('active');
        overlay.classList.remove('active');
    });
    // subMenus
    document.querySelectorAll('.dropdown-toggle').forEach(container => {
        const dropdownArrow = container.querySelector('.dropdown-arrow');
        const childMenu = container.nextElementSibling; 

        // Toggle dropdown on SVG
        dropdownArrow.addEventListener('click', (event) => {
            event.stopPropagation(); 
            childMenu.classList.toggle('hidden');
            dropdownArrow.classList.toggle('rotate-180');
        });
    });

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>