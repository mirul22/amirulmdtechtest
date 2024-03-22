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
        <Label for="price">Price:</Label>
        <Input type="number" placeholder="Enter price" v-model="formData.price" class="input" />
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
        <Input type="file" accept="image/*" @change="handleFileChange" />
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
import { Textarea } from '@/Components/ui/textarea';
import { useToast } from '@/Components/ui/toast/use-toast';

const { toast } = useToast();

const formData = ref({
  title: '',
  content: '',
  category_id: '',
  status: '',
  image: null,
  price: '',
});

let categories = ref([]);

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/categories'); 
    if (response.data.status) {
      categories.value = response.data.items.categories;
    } else {
      toast({
        title: 'Uh oh! Something went wrong.',
        description: response.data.message,
        variant: 'destructive'
      });
    }
  } catch (error) {
    toast({
      title: 'Uh oh! Something went wrong.',
      description: 'Error fetching categories:', error,
      variant: 'destructive'
    });
  }
};

const submitForm = async () => {
  try {
    const formDataToSend = new FormData();

    Object.keys(formData.value).forEach((key) => {
      formDataToSend.append(key, formData.value[key]);
    });

    const response = await axios.post('/api/courses', formData.value, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    toast({
      title: 'Course created successfully!',
      description: 'Course has been created successfully.',
    });
    router.push({ name: 'dashboard' });
  } catch (error) {
    toast({
      title: 'Uh oh! Something went wrong.',
      description: 'Error creating course: ' + error.response.data.message,
      variant: 'destructive'
    });
  }
};

onMounted(() => {
  fetchCategories();
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  formData.value.image = file;
};

</script>
