<style>
    /* menu starts */
    .menu {
            transition: transform 0.3s ease;
            transform: translateX(100%);
        }
        .menu.active {
            transform: translateX(0);
        }
        .overlay {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(31, 41, 55, 0.5); /* gray-800 with opacity */
            transition: transform 0.7s ease, opacity 0.3s ease;
            transform: translateX(100%);
            opacity: 0;
        }
        .overlay.active {
            transform: translateX(0);
            opacity: 1;
        }
        .scrollbar_hide::-webkit-scrollbar {
            display: none; 
        }
        /* menu ends */
</style>

<!-- Header starts -->
<header class="py-1 shadow-md mb-6">
    <div class="container mx-auto px-2 md:pl-2 md:pr-6 my-1">
        <nav class="flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="src/images/logo.png" alt="Logo" class="w-12 md:w-20 logo">
            </a>
            <div class="flex space-x-4 md:space-x-10">
                <ul class="xl:flex space-x-5 mt-1.5 items-center hidden">
                    <a href="index.php"><li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer">HOME</li></a>
                    <a href="your-events.php"><li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer">YOUR EVENTS</li></a>
                    <a href="joined-events.php"><li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer">JOINED EVENTS</li></a>
                    <a href="event-requests.php"><li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer">EVENT REQUESTS</li></a>
                    <a href="user-account.php"><li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer">ACCOUNT</li>
                    <a href="event-venue.php" class="hidden md:block text-center w-40 bg-indigo-800 text-xs text-white px-2 py-2 rounded" data-key="nav-contact">CREATE EVENT</a>
                </ul>
                <button id="hamburger" class=" focus:outline-none">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>  
    </div>
</header>
    <!-- mobile -->
    <div id="overlay" class="overlay z-[60]"></div>
    <div id="menu" class="menu fixed top-0 right-0 w-4/5 md:w-2/5 h-full bg-white shadow-lg z-[100] overflow-y-scroll scrollbar_hide">
        <div class="flex justify-end p-4 absolute right-0">
            <button id="close" class="focus:outline-none">
                <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="p-4 mt-14 md:mt-20">
            <div class="flex flex-col space-y-6 p-5 text-base">
                <ul class="space-y-5">
                   <a href="index.php"> <li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer mb-2">HOME</li></a>
                   <a href="your-events.php"> <li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer mb-2">YOUR EVENTS</li></a>
                   <a href="joined-events.php"> <li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer mb-2">JOINED EVENTS</li></a>
                   <a href="event-requests.php"> <li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer mb-2">EVENT REQUESTS</li></a>
                   <a href="user-account.php"> <li class="text-[15px] font-extrabold text-black hover:text-indigo-600 cursor-pointer mb-4">ACCOUNT</li></a>
                    <a href="event-venue.php" class="text-center w-40 bg-indigo-800 text-xs text-white px-2 py-2 rounded mb-2" data-key="nav-contact">CREATE EVENT</a>
                </ul>
            </div>
        </nav>
    </div>
    <!-- mobile ends -->

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
    </script>