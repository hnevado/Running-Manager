<x-app-layout>

    <div>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
    
            @include('dashboard/navigation')
           
            <div class="flex flex-col flex-1 overflow-hidden">
                @include('dashboard/header')
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container px-6 py-8 mx-auto">
                        <h3 class="text-3xl font-medium text-gray-700">@yield('pageTitle')</h3>
    
                        <div class="mt-4">
                            <div class="flex flex-wrap -mx-6">
                                @yield('stats')
                            </div>
                        </div>
    
                        <div class="mt-8">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

</x-app-layout>