<?php
include '../config/db_connect.php';

$search = $_GET['search'];

if ($search == '') {
    echo '';  // If no search term, don't return anything
} else {
    // Query to search for usernames based on the search term
    $query = "SELECT `username` FROM `user_detail` WHERE `username` LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="relative rounded-md my-2">
                    <h2 class="py-1 px-3 rounded-md">No username found</h2>
              </div>';
    } else {
        // Loop through the results and generate a list of clickable suggestions
        while ($data = mysqli_fetch_assoc($result)) {
            echo '<div class="suggestion-item bg-gray-100 p-2 mb-1 rounded cursor-pointer hover:bg-gray-200" onclick="selectSuggestion(\'' . $data['username'] . '\')">' . $data['username'] . '</div>';
        }
    }
}
?>
