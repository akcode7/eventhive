<?php
include 'src/config/session-config.php';
include 'src/config/db_connect.php';

$slug = isset($_GET['id']) ? trim($_GET['id'], '/') : '';
if (empty($slug)) {
    // header("Location: ../");
    echo "error: Event id is missing";
    exit();
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
        <title>EventHive - Event Participants</title>
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
        <h1 class="py-3 text-bold text-2xl text-center">All participants</h1>
        <div class="flex justify-center items-center mx-auto pt-8">
            <ul class="max-w-2xl divide-y divide-gray-200 shadow-lg border p-5 w-full rounded-md">
                <?php
             
                if (isset($slug) && !empty($slug)) {
                 
                    $sql = mysqli_query($conn, "
                        SELECT user_detail.name, user_detail.username, user_detail.img
                        FROM user_detail
                        INNER JOIN joined_events 
                        ON user_detail.username = joined_events.user_name
                        WHERE joined_events.event_id = '$slug'
                    ");

                    
                    if (mysqli_num_rows($sql) > 0) {
                    
                        while ($row = mysqli_fetch_assoc($sql)) {
                ?>
                            <li class="pb-3 sm:pb-4 pt-3">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-10 md:w-14 rounded-md" src="<?php echo $row['img']; ?>" alt="User image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            <?php echo $row['name']; ?>
                                        </p>
                                        <a href="user-page.php?user=<?php echo $row['username']; ?>" class="text-sm text-gray-500 truncate">
                                            @<?php echo $row['username']; ?>
                                        </a>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                        <a href="user-page.php?user=<?php echo $row['username']; ?>" class="hover:underline text-lg font-bold text-indigo-700 px-2 cursor-pointer">View Profile</a>
                                    </div>
                                </div>
                            </li>
                    <?php
                        }
                    } else {
                        echo "<li>No users have joined this event yet.</li>"; 
                    }
                } else {
                    echo "<li>Event not found or invalid event ID.</li>";
                }
                ?>
            </ul>

        </div>

    </div>
   
</body>
</html>