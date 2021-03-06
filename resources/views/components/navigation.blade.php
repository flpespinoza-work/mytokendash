<sidebar :class="{ '-translate-x-72': !sidebarOpen }" id="sidebar"
class="absolute top-0 left-0 z-40 flex-shrink-0 inline-block h-screen max-h-full py-4 overflow-y-scroll transition-transform duration-200 ease-in-out transform bg-white border-r w-72 border-gray-light lg:static lg:left-auto lg:top-auto lg:translate-x-0 lg:overflow-y-auto no-scrollbar">
    <div class="flex items-center px-6 pr-3 mb-10">
        <button class="mr-4 text-gray-500 outline-none lg:hidden hover:text-gray-400"
        aria-controls="sidebar" aria-expanded="false" @click="sidebarOpen = !sidebarOpen">
            <span class="sr-only">Close sidebar</span>
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"></path>
            </svg>
        </button>
        <a class="block pl-1 text-center" href="/">
            <x-logo class="h-7"/>
        </a>
    </div>
    <div>
        @foreach($menuSidebar as $menuGroup)
            @include('components.menugroup', [ 'menuGroup' => $menuGroup ])
        @endforeach
    </div>
</sidebar>
