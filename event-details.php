
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
    <title>EventHive</title>
</head>
<body>
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
    <div class="container p-5">
        <img
    alt=""
    src="https://images.unsplash.com/photo-1605721911519-3dfeb3be25e7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
    class="h-64 w-full object-cover sm:h-80 lg:h-96 rounded-xl"
     />
        <h1 class="bg-yellow-400 text-black py-3 text-3xl font-bold rounded-lg my-2 px-2"><?php echo $row['event_name']?></h1>
        <p class="mt-2 max-w-sm text-lg text-gray-700 font-semibold">
        <?php echo $row['event_discription']?>
          </p>
          <h1 class="text-black text-2xl font-bold rounded-lg my-2"><?php echo $row['event_type']?></h1>
          <p class="mt-2 max-w-sm text-lg text-gray-700 font-semibold">
           Web Development project contribution
          </p>
          <h1 class="text-black text-2xl font-bold rounded-lg my-2">Hosts</h1>
          <div class="flex items-center gap-4 p-2 border-2  border-yellow-400 mt-2 rounded-xl">
            <img class="w-10 h-10 rounded-full" src="src/images/university.png" alt="">
            <div class="font-medium text-black">
                <div>Ankit Sharma</div>
                <div class="text-sm text-gray-500">B.Tech</div>
            </div>
         </div>

         <div class="flex items-center gap-4 p-2 border-2  border-yellow-400 mt-2 rounded-xl ">
            <img class="w-10 h-10 rounded-full" src="src/images/university.png" alt="">
            <div class="font-medium text-black">
                <div>Vishal Singh</div>
                <div class="text-sm text-gray-500">B.Tech</div>
            </div>
         </div>

         <h1 class="text-black text-2xl font-bold rounded-lg my-2">Event Date</h1>
         <p class=" text-lg text-gray-700 font-semibold"><?php echo $row['event_date']?></p>
         <p class=" text-lg text-gray-700 font-semibold"> <?php echo $row['event_start']?></p>
         <h1 class="text-black text-2xl font-bold rounded-lg my-2">Event Location</h1>
         <p class=" text-lg text-gray-700 font-semibold"><?php echo $row['location']?></p>
         

         <h1 class="text-black text-2xl font-bold rounded-lg my-2">Before You Join</h1>
         <p class=" text-lg text-gray-700 font-semibold">You should have react knowledge and a laptop</p>

         <button  class=" text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300  font-medium rounded-lg text-sm px-3 py-2 me-2 my-4 ">Join Event</button>
    </div>

    <?php
  }}}
  ?>
</body>
</html>