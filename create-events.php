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
    <div class="container">
        <section class="bg-white">
            <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Edit Event</h2>
                <form action="#">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Event Name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="" placeholder="Type event name" required="">
                        </div>
                        <div class="w-full">
                            <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 ">Event Type</label>
                            <input type="text" name="brand" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="" placeholder="E.g Collab" required="">
                        </div>
                        <div class="w-full">
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 ">Event Date</label>
                            <input type="date" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="" placeholder="select Date" required="">
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Event Start</label>
                            <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
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
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Event End</label>
                            <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
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
                        <p class="w-full">Request to be approved by 1 host to make your listing visible to public</p>
                        <div>
                            <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900 ">Event Approver</label>
                            <input type="number" name="item-weight" id="item-weight" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="" placeholder="Eg. ankitsharma" required="">
                        </div> 
                       
                        
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Requirements for joining</label>
                            <textarea id="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Write a product description here...">You should have react knowledge and a laptop </textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Event Description</label>
                            <textarea id="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Write a product description here...">DevFest is a series of global developer conferences
                                 hosted by Google Developer Groups (GDGs) around 
                                the world. These events bring together developers to learn about the latest technologies from Google and other industry leaders, 
                                network with peers, and collaborate on projects.</textarea>
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
</body>
</html>