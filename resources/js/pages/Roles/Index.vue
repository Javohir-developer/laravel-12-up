<template>
    <AdminLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="flex justify-between mb-4">
                            <h3 class="text-lg font-bold">All Roles</h3>
                            <Link :href="route('roles.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Create New Role
                            </Link>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="role in roles" :key="role.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ role.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ role.name }}</td>
                                    <td class="px-6 py-4">
                                        <span v-for="perm in role.permissions" :key="perm.id" class="inline-block bg-blue-100 text-blue-800 text-xs px-2 rounded-full uppercase font-semibold tracking-wide mr-1 mb-1">
                                            {{ perm.name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <Link :href="route('roles.edit', role.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                                        <button @click="destroy(role.id)" class="text-red-600 hover:text-red-900">Delete</button>
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
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue'; // Update if using a different main layout

const props = defineProps({
    roles: Array,
});

const destroy = (id) => {
    if (confirm('Are you sure you want to delete this role?')) {
        router.delete(route('roles.destroy', id));
    }
};
</script>
