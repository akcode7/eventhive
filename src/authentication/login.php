<?php
session_start();

include '../../src/config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM user_detail WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['password'] === md5($password)) {
              session_start();
              $_SESSION['loggedin'] = true;
              $_SESSION['email'] = $email;
              $_SESSION['username'] = $row['username'];
            
            header("location: ../../index.php");
            
          } else {
            echo ' <div id="toast-model" class=" flex absolute md:top-10 md:left-3 top-20 right-3 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert" style="z-index: 2;">
    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
    </svg>
    <span class="sr-only">Error icon</span>
</div>
    <div class="ms-3 text-sm font-normal">Wrong Password</div>
    <button onclick="cancelbookbtn()" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>';
    echo '  <script>
    function cancelbookbtn() {
       let element = document.getElementById("toast-model");
       element.classList.toggle("hidden");
    }
    </script>';
          }
      }
  } else {
    echo ' <div id="toast-model" class=" flex absolute md:top-10 md:left-3 top-20 right-3 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert" style="z-index: 2;">
    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
    </svg>
    <span class="sr-only">Error icon</span>
</div>
    <div class="ms-3 text-sm font-normal">Wrong Details</div>
    <button onclick="cancelbookbtn()" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>';
    echo '  <script>
    function cancelbookbtn() {
       let element = document.getElementById("toast-model");
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
    <link rel="stylesheet" href="../css/output.css">
    <script src="index.js"></script>
    <title>EventHive</title>
</head>
<body>

<section class="bg-white">
    <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
      <aside class="relative block h-16 lg:order-last lg:col-span-5 lg:h-full xl:col-span-6">
        <img
          alt=""
          src="https://images.unsplash.com/photo-1605106702734-205df224ecce?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
          class="absolute inset-0 h-full w-full object-cover"
        />
      </aside>
  
      <main
        class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6"
      >
        <div class="max-w-xl lg:max-w-3xl">
          <a class="block text-blue-600" href="#">
            <span class="sr-only">Home</span>
            <img src="../images/logo.png" alt="" class="w-12 md:w-28">
          </a>
  
          <h1 class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
            Welcome to EventHive 
          </h1>
  
          <form method="POST" class="mt-8 grid grid-cols-6 gap-6">
            <div class="col-span-6">
              <label for="Email" class="block text-sm font-medium text-gray-700"> Email </label>
  
              <input
                type="email"
                id="Email"
                name="email"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm border py-1" required
              />
            </div>
  
            <div class="col-span-6">
              <label for="Password" class="block text-sm font-medium text-gray-700"> Password </label>
  
              <input
                type="password"
                id="Password"
                name="password"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm border py-1" required
              />
            </div>

            <div class="col-span-3">
            <input class="cursor-pointer mx-2 border border-gray-300 rounded bg-gray-50" type="checkbox" onclick="viewpass()">Show Password
            </div>

            <div class="col-span-3">
            <input
                id="remember"
                name="re_member_me"
                type="checkbox"
                class="mx-2 border border-gray-300 rounded bg-gray-50 cursor-pointer"
              
              />Remember Me
            </div>
  
            <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
              <button
                class="inline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
              >
                Login
              </button>
  
              <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                Don't have an account?
                <a href="signup.php" class="text-gray-700 underline">Sign Up</a>.
              </p>
            </div>
          </form>
        </div>
      </main>
    </div>
  </section>



  <script>
    let p = document.getElementById("Password");
    function viewpass() {
     
      if (p.type === "password") {
        p.type = "text";
      } else {
        p.type = "password";
      }
    }
  </script>
</body>
</html>