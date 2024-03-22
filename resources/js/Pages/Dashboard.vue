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
            <Button @click="redirectToCourses" variant="secondary">Create New Course</Button>
          </div>
          <div class="text-gray-500 text-md">Here are your latest courses!</div>

          <!-- Table to display courses -->
          <table class="min-w-full divide-y divide-gray-200 mt-4">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="course in courses" :key="course.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ truncateText(course.title, 30) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ truncateText(course.content, 50) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Badge class="p-3" variant="secondary">{{ course.status }}</Badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <Button class="mr-3" @click="editCourse(course)" variant="outline">Edit</Button>
                  <Button @click="deleteCourse(course)" variant="destructive">Delete</Button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import axios from 'axios';
import { useToast } from '@/Components/ui/toast/use-toast';
import { Badge } from "@/Components/ui/badge";

const { toast } = useToast();
const { userName } = usePage().props;

const redirectToCourses = () => {
  window.location.href = '/course';
};

const courses = ref([]);
const errorMessage = ref('');

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
    toast({
        title: 'Uh oh! Something went wrong.',
        description: error.response.data.message,
        variant: 'destructive'
      });
  }
};

const editCourse = (course) => {
  console.log('Editing course:', course);
};

const deleteCourse = async (course) => {
  try {
    const response = await axios.delete(`/api/courses/${course.id}`);
    toast({
        title: 'Success!',
        description: 'Course deleted successfully.',
    });
    await fetchCourses();
  } catch (error) {
    toast({
        title: 'Uh oh! Something went wrong.',
        description: error.response.data.message,
        variant: 'destructive'
    });
  }
};

const truncateText = (text, maxLength) => {
  if (text.length > maxLength) {
    return text.slice(0, maxLength) + '...';
  }
  return text;
};
</script>
