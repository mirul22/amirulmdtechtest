<template>
    <Head title="Welcome" />
    
    <div class="max-w-6xl mx-auto px-4">
        <body>
            <nav class="relative px-4 py-4 flex justify-between items-center bg-white">
                <a class="text-3xl font-bold leading-none" href="#">
                    <ApplicationLogo
                        class="block h-9 w-auto fill-current text-gray-800"
                    />
                </a>
                <div class="lg:hidden">
                    <button class="navbar-burger flex items-center text-blue-600 p-3">
                        <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Mobile menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg>
                    </button>
                </div>
                <ul v-if="canLogin" class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
                    <li> 
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="text-sm text-gray-400 hover:text-gray-500"
                        >
                        Dashboard
                        </Link>
                    </li>
                </ul>
                <template v-if="!$page.props.auth.user">
                    <Link
                        :href="route('login')"
                        class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-gray-50 hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="hidden lg:inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-sm text-white font-bold rounded-xl transition duration-200"
                    >
                        Register
                    </Link>
                </template>
            </nav>
            <div class="navbar-menu relative z-50 hidden">
                <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
                <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
                    <div class="flex items-center mb-8">
                        <a class="mr-auto text-3xl font-bold leading-none" href="#">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800"
                            />
                        </a>
                        <button class="navbar-close">
                            <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <ul v-if="canLogin" class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
                            <li> 
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard')"
                                    class="text-sm text-gray-400 hover:text-gray-500"
                                >
                                Dashboard
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <div class="py-6 text-center">
                            <template v-if="!$page.props.auth.user">
                                <Link
                                    :href="route('login')"
                                    class="lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-gray-50 hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
                                >
                                    Log in
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="lg:inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-sm text-white font-bold rounded-xl transition duration-200"
                                >
                                    Register
                                </Link>
                            </template>
                        </div>
                        <p class="my-4 text-xs text-center text-gray-400">
                            <span>Copyright © 2024</span>
                        </p>
                    </div>
                </nav>
            </div>

            <div class="mt-8">
                <div v-for="course in courses" :key="course.id" class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <img :src="course.image" alt="Course Image" class="w-full h-32 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">{{ course.title }}</h3>
                            <Badge class="p-3" variant="secondary">{{ course.category_name }}</Badge>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ course.content }}</p>
                        <p class="text-md text-gray-800 font-weight-bold mt-2">RM {{ course.price }}</p>
                    </div>
                </div>
            </div>
        </body>
    </div>
</template>

<script setup lang="ts">

import { ref, onMounted } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import axios from 'axios';
import { Badge } from "@/Components/ui/badge";


defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

// Burger menus
document.addEventListener('DOMContentLoaded', function() {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
});

const { userName } = usePage().props;
const courses = ref([]);

onMounted(async () => {
  await fetchCourses();
});

const fetchCourses = async () => {
  try {
    const response = await axios.get('/api/courses');

    if (response.data.status) {
      courses.value = response.data.items;
    } else {
      errorMessage.value = response.data.message;
      toast({
        title: 'Uh oh! Something went wrong.',
        description: response.data.message,
        variant: 'destructive'
      });
    }
  } catch (error) {
    console.error('Error fetching courses:', error);
  }
};

</script>

