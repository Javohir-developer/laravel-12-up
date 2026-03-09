<template>
    <AdminLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="flex justify-between mb-4">
                            <h3 class="text-lg font-bold">All Users</h3>
                            <Link :href="route('users.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Create New User
                            </Link>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                    <td class="px-6 py-4">
                                        <span v-for="role in user.roles" :key="role.id" class="inline-block bg-green-100 text-green-800 text-xs px-2 rounded-full font-semibold tracking-wide mr-1 mb-1">
                                            {{ role.name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                        <Link :href="route('users.edit', user.id)" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 px-3 py-1 rounded">Edit</Link>
                                        <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-900 border border-red-600 px-3 py-1 rounded">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    users: Array,
});

const form = useForm({});

const deleteUser = (id) => {
    if (confirm('Are you sure you want to delete this user?')) {
        form.delete(route('users.destroy', id));
    }
};
</script>
