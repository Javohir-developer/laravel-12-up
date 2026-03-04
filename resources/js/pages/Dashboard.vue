<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

const stats = [
    { name: 'Total Users', value: '420', change: '+12%', changeType: 'positive', icon: 'svg-users' },
    { name: 'Active Sessions', value: '18', change: '-2%', changeType: 'negative', icon: 'svg-activity' },
    { name: 'Total Movies', value: '1,284', change: '+8%', changeType: 'positive', icon: 'svg-movies' },
    { name: 'Revenue', value: '$84,230', change: '+24%', changeType: 'positive', icon: 'svg-money' },
];
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            Dashboard Overview
        </template>

        <div class="py-4">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 sm:p-10 mb-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">Welcome back, Admin! 👋</h2>
                    <p class="text-indigo-100 max-w-xl text-lg">
                        Here is what's happening with your projects today. You have 3 new notifications waiting to be reviewed.
                    </p>
                </div>
                <!-- Decorative element -->
                <div class="absolute right-0 top-0 w-64 h-full hidden md:block opacity-10 pointer-events-none">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#ffffff" d="M42.7,-73.4C55.9,-65.7,67.7,-54.6,76.5,-41.4C85.3,-28.3,91.1,-14.1,88.4,-1.5C85.7,11.2,74.5,22.4,65.3,34.7C56.1,47.1,48.9,60.6,37.6,68.9C26.3,77.2,11,80.3,-2.8,85.1C-16.7,89.9,-29.1,76.4,-39.7,66.7C-50.3,57,-59.1,51.1,-65.5,42.7C-71.9,34.3,-75.8,23.3,-76.3,12C-76.8,0.7,-73.8,-11,-67.9,-20.9C-62,-30.9,-53.2,-39.2,-43.3,-46.8C-33.3,-54.4,-22.1,-61.4,-8.6,-66.9C5,-72.4,18.4,-76.3,29.3,-81.1L42.7,-73.4Z" transform="translate(100 100)" />
                    </svg>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div v-for="stat in stats" :key="stat.name" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-500">{{ stat.name }}</h3>
                        <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <!-- Just simple geometric placeholder irons -->
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-3xl font-bold text-gray-900">{{ stat.value }}</span>
                        <span 
                            :class="[
                                stat.changeType === 'positive' ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50',
                                'text-xs font-semibold px-2 py-1 rounded-full'
                            ]"
                        >
                            {{ stat.change }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Recent Activity</h3>
                        <button class="text-sm text-indigo-600 font-medium hover:text-indigo-700">View all</button>
                    </div>
                    <div class="space-y-6">
                        <div v-for="i in 4" :key="i" class="flex p-4 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center border-2 border-white shadow-sm">
                                <span class="text-slate-500 font-medium">U{{i}}</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">User registered</p>
                                <p class="text-sm text-gray-500">A new user account was created in the system</p>
                            </div>
                            <div class="text-xs text-gray-400 font-medium">{{ i }}h ago</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                    <div class="space-y-4">
                        <button class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-700 group transition-all text-left">
                            <span class="font-medium text-gray-700 group-hover:text-indigo-700">Add New Movie</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                        <button class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-700 group transition-all text-left">
                            <span class="font-medium text-gray-700 group-hover:text-indigo-700">Manage Users</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </button>
                        <button class="w-full flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-700 group transition-all text-left">
                            <span class="font-medium text-gray-700 group-hover:text-indigo-700">System Settings</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
