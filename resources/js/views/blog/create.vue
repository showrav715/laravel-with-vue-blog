<template>
    <main class="create-post">
        <div class="container">
            <h1>Create Posts!</h1>
            <!-- success message -->
            <div class="success-msg" v-if="success">
                <i class="fa fa-check"></i>
                Post created successfully
            </div>
            <!-- Contact Form -->
            <div class="contact-form">
                <form @submit.prevent="handleStore">
                    <!-- Title -->
                    <label for="title"><span>Title</span></label>
                    <input type="text" id="title" v-model="data.title" />
                    <span v-if="errors.title" class="error">{{
                        errors.title[0]
                    }}</span>
                    <br />

                    <!-- Image -->
                    <label for="image"><span>Image</span></label>
                    <input type="file" id="image" @input="getFile" />
                    <span v-if="errors.image" class="error">{{
                        errors.image[0]
                    }}</span>
                    <div class="preview">
                        <img :src="data.url" alt="" />
                    </div>
                    <br />

                    <!-- Drop down -->
                    <label for="categories"
                        ><span>Choose a category:</span></label
                    >

                    <select id="categories" v-model="data.category_id">
                        <option selected value="">Select option</option>
                        <option
                            v-for="category in categories"
                            :value="category.id"
                            :key="category"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <span v-if="errors.category_id" class="error">{{
                        errors.category_id[0]
                    }}</span>
                    <br />

                    <!-- Body-->
                    <label for="body"><span>Body</span></label>
                    <textarea id="body" v-model="data.body"></textarea>
                    <span v-if="errors.body" class="error">{{
                        errors.body[0]
                    }}</span>
                    <!-- Button -->
                    <input class="add-post-btn" type="submit" value="Submit" />
                </form>
            </div>
        </div>
    </main>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import axios from "axios";

const categories = ref([]);
const errors = ref([]);
const success = ref(false);

const data = reactive({
    title: "",
    image: "",
    category_id: "",
    body: "",
    url: "",
});

const getFile = (e) => {
    data.image = e.target.files[0];
    const reader = new FileReader();
    reader.onloadend = () => {
        data.url = reader.result;
    };
    reader.readAsDataURL(e.target.files[0]);
};

const handleStore = () => {
    axios
        .post("/api/blog/store", data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((res) => {
            success.value = true;
            errors.value = "";
            data.title = "";
            data.image = "";
            data.category_id = "";
            data.body = "";
            data.url = "";
        })
        .catch((err) => {
            success.value = false;
            errors.value = err.response.data.errors;
        });
};

onMounted(() => {
    handleGetData();
});

const handleGetData = () => {
    axios
        .get("/api/categories")
        .then((res) => {
            categories.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
};
</script>

<style scoped>
.create-post {
    background-color: #fff;
    padding: 0 3vw;
}
.container input,
textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 20px;
    font-size: 16px;
}
h1 {
    text-align: center;
    padding: 60px 0 50px 0;
}

.add-post-btn {
    background-color: black;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
}

.add-post-btn:hover {
    transform: translateY(-4px);
}

.preview img {
    max-width: 100%;
    max-height: 120px;
}
</style>
