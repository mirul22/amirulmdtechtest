<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button'

const { userName } = usePage().props;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
    <div class="text-2xl font-extrabold mb-2">Welcome {{ userName }}</div>
    <Button variant="secondary">Create New Course</Button>
</div>

                    <div class="text-gray-500 text-md">Here are your latest courses!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
