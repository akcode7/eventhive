<?php include 'src/config/db_connect.php';?>
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
    <title>EventHive - Event Venue</title>
</head>
<style>
    *{
        margin:0;
        padding:0;
        font-family: "ZCOOL XiaoWei", sans-serif;
        }
     .events-venu{

        background-repeat: no-repeat;
        background-position: center;
        padding: 20px 0px;
        background-size: cover;
    }
</style>
<body>
    <!-- Header starts -->
    <?php include 'src/component/header.php';?>
    <!-- Header ends -->
    <div class="container mx-auto max-w-6xl">

        <div class="grid grid-cols-6 gap-4 p-5">
            <?php
                $sql = mysqli_query($conn, "SELECT * FROM `places`");
                while($row = mysqli_fetch_assoc($sql)){
            ?>
            
            <div class="col-span-3 xl:col-span-2 h-48 rounded-lg my-2 overflow-hidden events-venu relative" style="background-image: url('<?php echo $row['place_img']?>'); background-size: cover; background-position: center;">
                <p class="font-semibold text-black text-center bg-white text-sm mx-3 py-2 rounded-lg"><?php echo $row['name']?></p>
                <a href="create-events.php?location=<?php echo $row['name']?>" class="absolute bottom-0 right-0 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300  font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 mx-1 align-bottom">Create Event</a>
            </div>
           <?php }?>
        </div>
    </div>
</body>
</html>