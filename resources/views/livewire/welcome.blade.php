<div class="relative h-screen overflow-hidden">
    <!-- Background Image with Blur -->
    <div class="absolute inset-0 bg-cover bg-center backdrop-blur-lg"
        style="background-image: url('{{ asset('images/backgrounds/School-Building.jpg') }}');"></div>

    <!-- Content -->
    <div class="flex h-full relative z-10">
        <!-- Left Content -->
        <div class="flex-1 backdrop-blur bg-blue-500 bg-opacity-40 text-white p-8">
            <!-- Left Content -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <div class="container mx-auto text-center mt-8">
                    <h2 class="text-4xl font-bold mb-4">Officer</h2>
                    <button wire:click="redirectToLogin"
                        class="bg-white text-blue-500 rounded-full py-2 px-4 hover:bg-blue-500 hover:text-white hover:shadow-md transition duration-300 ease-in-out">Login
                        as Officer</button>

                        <p class="mt-4">Don't have an Account? <a href="{{ route('register') }}" class="text-white-800 hover:underline">Register here!</a></p>

                </div>
            </div>

        </div>

        <!-- Right Content -->
        <div class="flex-1 backdrop-blur bg-blue-200 bg-opacity-75 p-8">
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <div class="container mx-auto text-center mt-8">
                    <h2 class="text-4xl font-bold mb-4 text-blue-800">Admin</h2>
                    <button wire:click="redirectToAdmin"
                        class="bg-white text-blue-500 rounded-full py-2 px-4 hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">Login
                        as Admin</button>
                        <p class="mt-4">Are you an admin? <a href="#" class="text-white-800 hover:underline">Login Now!</a></p>
                </div>
            </div>
        </div>

        <!-- Middle Box for Logo -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div
                class="w-32 h-32 backdrop-blur bg-white bg-opacity-75 rounded-full flex items-center justify-center shadow-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="w-full h-full object-cover rounded-full shadow-xl">
            </div>
        </div>

    </div>
</div>
