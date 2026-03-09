<template>
    <AdminLayout title="Edit User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User: {{ user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <form @submit.prevent="submit" class="max-w-3xl">
                            
                            <!-- BASIC INFO SECTION -->
                            <div class="mb-8 p-4 border rounded bg-gray-50">
                                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Basic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" id="name" v-model="form.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="email" v-model="form.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ROLES SECTION -->
                            <div class="mb-8 p-4 border rounded bg-gray-50">
                                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Assign Roles</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div v-for="r in roles" :key="r.id" class="flex items-center">
                                        <input :id="'role_' + r.id" :value="r.name" v-model="form.roles" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label :for="'role_' + r.id" class="ml-2 block text-sm font-medium text-gray-900">
                                            {{ r.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- DIRECT PERMISSIONS SECTION -->
                            <div class="mb-8 p-4 border rounded bg-gray-50">
                                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Assign Direct Permissions</h3>
                                <p class="text-xs text-gray-500 mb-4">You can assign specific permissions to this user individually, regardless of their role.</p>
                                
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div v-for="p in permissions" :key="p.id" class="flex items-center">
                                        <input :id="'perm_' + p.id" :value="p.name" v-model="form.permissions" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <label :for="'perm_' + p.id" class="ml-2 block text-sm text-gray-900">
                                            {{ p.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <Link :href="route('users.index')" class="text-gray-600 mr-4 hover:underline">Cancel</Link>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-50" :disabled="form.processing">
                                    Save Changes
                                </button>
                            </div>
                        </form>

                        <div v-if="successMessage" class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ successMessage }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    user: Object,
    roles: Array,
    permissions: Array,
});

const page = usePage();
const successMessage = computed(() => page.props.flash?.success);

const userRoleNames = props.user.roles.map(r => r.name);
const userPermissionNames = props.user.permissions.map(p => p.name);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    roles: userRoleNames,
    permissions: userPermissionNames,
});

const submit = () => {
    form.put(route('users.update', props.user.id));
};
</script>
