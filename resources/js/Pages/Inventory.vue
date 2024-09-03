<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CategoriesModal from "@/Components/CategoriesModal.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const products = ref([]);
const showAddProductModal = ref(false);
const showCategoriesModal = ref(false);
const showEditProductModal = ref(false);
const listedCategories = ref([]);
const searchQuery = ref('');

const newProduct = ref({
    name: '',
    brand: '',
    price: 0,
    category: '',
    stock: 0,
    sold: 0,
    status: '',
    expDate: '',
    image: null,
});

const editProduct = ref({
    id: null,
    name: '',
    brand: '',
    price: 0,
    category: '',
    stock: 0,
    sold: 0,
    status: '',
    expDate: '',
    image: null,
});

const fetchProducts = async () => {
    try {
        const response = await axios.get('/api/products');
        products.value = response.data;
    } catch (error) {
        console.error("Error fetching products:", error);
    }
};

const fetchListedCategories = async () => {
    try {
        const response = await axios.get('/api/categories');
        listedCategories.value = response.data.filter(category => category.status === 'listed');
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
};

const addProduct = async () => {
    try {
        const formData = new FormData();
        for (const key in newProduct.value) {
            formData.append(key, newProduct.value[key]);
        }
        const response = await axios.post('/api/products', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        products.value.push(response.data.product);
        showAddProductModal.value = false;
        resetNewProduct();
    } catch (error) {
        console.error("Error adding product:", error);
    }
};

const validateProduct = (product) => {
    if (!product.name || !product.brand || !product.price || !product.category || !product.stock || !product.sold || !product.status || !product.expDate) {
        return false;
    }
    return true;
};

const updateProduct = async () => {
    if (!validateProduct(editProduct.value)) {
        console.error("Validation error: Missing required fields");
        return;
    }

    try {
        const formData = new FormData();
        for (const key in editProduct.value) {
            if (editProduct.value[key] !== null) {
                formData.append(key, editProduct.value[key]);
            }
        }

        if (editProduct.value.image && typeof editProduct.value.image !== 'string') {
            formData.append('image', editProduct.value.image);
        }

        console.log([...formData.entries()]); // Debugging line

        const response = await axios.post(`/api/products/${editProduct.value.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-HTTP-Method-Override': 'PUT',
            }
        });

        const index = products.value.findIndex(product => product.id === editProduct.value.id);
        products.value[index] = response.data.product;
        showEditProductModal.value = false;
        resetEditProduct();
    } catch (error) {
        if (error.response && error.response.data) {
            console.error("Validation errors:", error.response.data);
        } else {
            console.error("Error updating product:", error);
        }
    }
};


const deleteProduct = async (id) => {
    if (confirm("Are you sure you want to delete this product?")) {
        try {
            await axios.delete(`/api/products/${id}`);
            products.value = products.value.filter(product => product.id !== id);
        } catch (error) {
            console.error("Error deleting product:", error);
        }
    }
};

const editProductDetails = (product) => {
    editProduct.value = { ...product };
    showEditProductModal.value = true;
};

const resetNewProduct = () => {
    newProduct.value = {
        name: '',
        brand: '',
        price: 0,
        category: '',
        stock: 0,
        sold: 0,
        status: '',
        expDate: '',
        image: null,
    };
};

const resetEditProduct = () => {
    editProduct.value = {
        id: null,
        name: '',
        brand: '',
        price: 0,
        category: '',
        stock: 0,
        sold: 0,
        status: '',
        expDate: '',
        image: null,
    };
};

const filteredProducts = computed(() => {
    if (!searchQuery.value) {
        return products.value;
    }
    return products.value.filter(product => {
        const searchTerm = searchQuery.value.toLowerCase();
        return (
            product.name.toLowerCase().includes(searchTerm) ||
            product.category.toLowerCase().includes(searchTerm) ||
            product.status.toLowerCase().includes(searchTerm)
        );
    });
});

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        newProduct.value.image = file;
    }
};

const handleEditImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        editProduct.value.image = file;
    }
};


fetchProducts();
fetchListedCategories();
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-semibold">List of Products</h2>
                            <div class="relative w-64">
                                <font-awesome-icon
                                    :icon="['fas', 'magnifying-glass']"
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"
                                />
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Search products..."
                                    class="pl-10 pr-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-300 w-full h-10"
                                />
                            </div>
                        </div>
                        <div class="overflow-auto" style="max-height: 430px;">
                            <table class="min-w-full bg-white dark:bg-gray-800 text-xs">
                                <thead>
                                <tr>
                                    <th class="px-2 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">ID No.</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Image</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left align-middle">Name</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left align-middle">Brand</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Price (PHP)</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Category</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Stock</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Sold</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Status</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Exp. Date</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="filteredProducts.length === 0">
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700" colspan="10">No products available.</td>
                                </tr>
                                <tr v-for="product in filteredProducts" :key="product.id">
                                    <td class="px-2 py-4 border-b border-gray-200 dark:border-gray-700">{{ product.id }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                        <img :src="'/storage/' + product.image" alt="Product Image" class="w-12 h-12 object-cover"/>
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-left align-middle">{{ product.name }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-left align-middle">{{ product.brand }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ product.price }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ product.category }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ product.stock }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ product.sold }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                            <span :class="{
                                                'bg-red-500 text-white py-1 px-3 rounded-full': product.status === 'Unlisted',
                                                'bg-green-500 text-white py-1 px-3 rounded-full': product.status === 'Listed',
                                                'bg-gray-500 text-white py-1 px-3 rounded-full': product.status === 'Out of Stock',
                                            }">{{ product.status }}</span>
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ product.expDate }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex space-x-4">
                                            <button @click="editProductDetails(product)" class="bg-yellow-500 text-white py-2 px-3 rounded-full">
                                                <font-awesome-icon icon="fa-solid fa-pen" size="sm"/>
                                            </button>
                                            <button @click="deleteProduct(product.id)" class="bg-red-500 text-white py-2 px-3 rounded-full">
                                                <font-awesome-icon :icon="['fas', 'trash-can']" size="sm" />
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-4 mr-5 space-x-4">
                    <button @click="showAddProductModal = true" class="bg-blue-500 text-white py-2 px-4 rounded">+ Add Product</button>
                    <button @click="showCategoriesModal = true" class="bg-gray-500 text-white py-2 px-4 rounded">Categories</button>
                </div>
            </div>
        </div>

        <div v-if="showAddProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold mb-4">Add Product</h3>
                <form @submit.prevent="addProduct">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" id="name" v-model="newProduct.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                        <input type="text" id="brand" v-model="newProduct.brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" id="price" v-model="newProduct.price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category" v-model="newProduct.category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option v-for="category in listedCategories" :key="category.id" :value="category.name">{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" id="stock" v-model="newProduct.stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="sold" class="block text-sm font-medium text-gray-700">Sold</label>
                        <input type="number" id="sold" v-model="newProduct.sold" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" v-model="newProduct.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Listed">Listed</option>
                            <option value="Unlisted">Unlisted</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="expDate" class="block text-sm font-medium text-gray-700">Exp. Date</label>
                        <input type="date" id="expDate" v-model="newProduct.expDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" id="image" @change="handleImageUpload" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button @click="showAddProductModal = false" class="bg-gray-500 text-white py-2 px-4 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="showEditProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold mb-4">Edit Product</h3>
                <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" id="name" v-model="editProduct.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                        <input type="text" id="brand" v-model="editProduct.brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" id="price" v-model="editProduct.price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category" v-model="editProduct.category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option v-for="category in listedCategories" :key="category.id" :value="category.name">{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" id="stock" v-model="editProduct.stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="sold" class="block text-sm font-medium text-gray-700">Sold</label>
                        <input type="number" id="sold" v-model="editProduct.sold" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" v-model="editProduct.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Listed">Listed</option>
                            <option value="Unlisted">Unlisted</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="expDate" class="block text-sm font-medium text-gray-700">Exp. Date</label>
                        <input type="date" id="expDate" v-model="editProduct.expDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" id="image" @change="handleEditImageUpload" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button @click="showEditProductModal = false" class="bg-gray-500 text-white py-2 px-4 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <CategoriesModal v-if="showCategoriesModal" @close-categories-modal="showCategoriesModal = false" />
    </AuthenticatedLayout>
</template>


<style scoped>
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.relative {
    position: relative;
}

.absolute {
    position: absolute;
}

.left-3 {
    left: 0.75rem; /* 3 * 0.25rem (1rem = 16px) */
}

.top-1 {
    top: 50%;
}

.transform {
    transform: translateY(-50%);
}

.text-gray-500 {
    color: #6B7280;
}

.pl-10 {
    padding-left: 2.5rem; /* 10 * 0.25rem */
}

.pr-4 {
    padding-right: 1rem; /* 4 * 0.25rem */
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.border {
    border-width: 1px;
}

.rounded-md {
    border-radius: 0.375rem; /* 6px */
}

.w-full {
    width: 100%;
}

.h-10 {
    height: 2.5rem; /* 10 * 0.25rem */
}

</style>