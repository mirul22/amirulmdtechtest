<template>
  <div>
    <h2 class="text-2xl font-semibold mb-4">Create New Course</h2>
    <form @submit.prevent="submitForm" class="max-w-md">
      <div class="mb-4">
        <Label for="title">Title:</Label>
        <Input type="text" placeholder="Enter title" v-model="formData.title" class="input" />
      </div>
      <div class="mb-4">
        <Label for="content">Content:</Label>
        <Textarea type="text" placeholder="Enter content" v-model="formData.content" />
      </div>
      <div class="mb-4">
        <Label for="category">Category:</Label>
        <Select v-model="formData.category_id">
          <SelectTrigger>
            <SelectValue placeholder="Select category" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectItem :value="category.id.toString()" v-for="category in categories" :key="category.id">
                {{ category.name }}
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
      </div>
      <div class="mb-4">
        <Label for="status">Status:</Label>
        <Select v-model="formData.status">
          <SelectTrigger>
            <SelectValue placeholder="Select Status" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectItem value="active">
                Active
              </SelectItem>
              <SelectItem value="inactive">
                Inactive
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
      </div>
      <div className="mb-4">
        <Label htmlFor="image">Image</Label>
        <Input type="file" v-model="formData.image" accept="image/*" />
      </div>
      <Button type="submit" variant="secondary" class="btn">Create Course</Button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import { 
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from '@/Components/ui/select';
import { Textarea } from '@/Components/ui/textarea'

const formData = ref({
  title: '',
  content: '',
  category_id: '',
  status: '',
  image: ''
});

let categories = ref([]);

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/categories'); 
    categories.value = response.data; 
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
};

const submitForm = async () => {
  try {
    const response = await axios.post('/api/courses', formData.value, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    console.log('Course created:', response.data);
  } catch (error) {
    console.error('Error creating course:', error);
  }
};

onMounted(() => {
  fetchCategories();
});
</script>
