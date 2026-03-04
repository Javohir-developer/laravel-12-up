<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);

const page = usePage();
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar Navigation -->
        <aside 
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full'
            ]"
        >
            <div class="flex items-center justify-center h-20 border-b border-slate-800">
                <Link :href="route('dashboard')" class="flex items-center space-x-2">
                    <ApplicationLogo class="w-10 h-10 text-indigo-500 fill-current" />
                    <span class="text-xl font-bold tracking-wider text-white">ADMIN</span>
                </Link>
            </div>
            
            <div class="px-4 py-6">
                <nav class="space-y-2">
                    <Link
                        :href="route('dashboard')"
                        :class="[
                            'flex items-center px-4 py-3 rounded-xl transition-all duration-200',
                            route().current('dashboard') 
                                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' 
                                : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        ]"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="font-medium">Dashboard</span>
                    </Link>
                    
                    <Link
                        href="/movie/index"
                        :class="[
                            'flex items-center px-4 py-3 rounded-xl transition-all duration-200',
                            $page.url.startsWith('/movie/index') 
                                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' 
                                : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        ]"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                        <span class="font-medium">Movies</span>
                    </Link>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-full p-4 border-t border-slate-800">
                <Link
                    :href="route('profile.edit')"
                    class="flex items-center px-4 py-3 text-slate-300 transition-colors rounded-xl hover:bg-slate-800 hover:text-white"
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-medium">Settings</span>
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-100 shadow-sm z-30 h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <button 
                        @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 mr-4 text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <h1 v-if="$slots.header" class="text-2xl font-bold text-gray-800 hidden sm:block">
                        <slot name="header" />
                    </h1>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="p-2 text-gray-400 transition-colors rounded-full hover:bg-gray-100 hover:text-gray-500 relative">
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative ms-3 border-l pl-4 border-gray-200">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="flex items-center space-x-3 text-sm transition-colors focus:outline-none rounded-full py-1 pr-2 pl-1 hover:bg-gray-50">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="hidden md:flex flex-col items-start px-1 leading-tight">
                                        <span class="font-semibold text-gray-800">{{ $page.props.auth.user.name }}</span>
                                        <span class="text-xs text-gray-500">Administrator</span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm">Signed in as</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $page.props.auth.user.email }}</p>
                                </div>
                                <div class="py-1">
                                    <DropdownLink :href="route('profile.edit')">
                                        Your Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                        Sign out
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                <!-- Mobile Screen Overlay -->
                <div 
                    v-if="sidebarOpen" 
                    @click="sidebarOpen = false" 
                    class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden"
                ></div>

                <div class="max-w-7xl mx-auto">
                    <!-- Dashboard Header Title for Mobile -->
                    <h1 v-if="$slots.header" class="text-2xl font-bold text-gray-800 mb-6 sm:hidden block">
                        <slot name="header" />
                    </h1>
                    
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
