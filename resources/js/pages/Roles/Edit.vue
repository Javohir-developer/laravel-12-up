<template>
    <AdminLayout title="Edit Role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Role: {{ role.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <form @submit.prevent="submit" class="max-w-xl">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                                <input type="text" id="name" v-model="form.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <span v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</span>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div v-for="permission in permissions" :key="permission.id" class="flex items-center">
                                        <input :id="'perm_' + permission.id" :value="permission.name" v-model="form.permissions" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label :for="'perm_' + permission.id" class="ml-2 block text-sm text-gray-900">
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <Link :href="route('roles.index')" class="text-gray-600 mr-4 hover:underline">Cancel</Link>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-50" :disabled="form.processing">
                                    Update Role
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    role: Object,
    permissions: Array,
});

// Assuming permissions on the role object is an array of objects
const rolePermissionNames = props.role.permissions.map(p => p.name);

const form = useForm({
    name: props.role.name,
    permissions: rolePermissionNames,
});

const submit = () => {
    form.put(route('roles.update', props.role.id));
};
</script>
