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

<?php

if (isset($_POST['skills'])) {
    $skill_op = $_POST['skills']; 
    
   
    foreach ($skill_op as $option) {
        $skills[] = $option; 
    }
    
    
    $user_skills = implode("", $skills);
} else {
   
    $user_skills = "No skills selected";
}

echo $user_skills;
?>

<form method="post">
                  <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex mt-2 ">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r ">
                                <div class="flex items-center ps-3">
                                    <input id="vue-checkbox-list" name="skills[]" value="Vue JS" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
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

                    <button type="submit">this </button>

</form>
   
</body>
</html>