<template>
    <main class="create-post">
        <div class="container">
            <h1>Update Posts!</h1>
            <!-- success message -->
            <div class="success-msg" v-if="success">
                <i class="fa fa-check"></i>
                Post created successfully...
            </div>
            <!-- Contact Form -->
            <div class="contact-form">
                <form @submit.prevent="handleUpdate">
                    <!-- Title -->
                    <label for="title"><span>Title</span></label>
                    <input type="text" id="title" v-model="post.title" />
                    <span v-if="errors.title" class="error">{{
                        errors.title[0]
                    }}</span>
                    <br />

                    <!-- Image -->
                    <label for="image"><span>Image</span></label>
                    <input type="file" @input="getFile" id="image" />
                    <span v-if="errors.image" class="error">{{
                        errors.image[0]
                    }}</span>
                    <div class="preview">
                        <img :src="post.url" alt="" />
                    </div>
                    <br />

                    <!-- Drop down -->
                    <label for="categories"
                        ><span>Choose a category:</span></label
                    >
                    <select id="categories" v-model="post.category_id">
                        <option
                            v-for="category in categories"
                            :value="category.id"
                            :key="category"
                            :selected="category.id == post.category_id"
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
                    <textarea id="body" v-model="post.body"></textarea>
                    <span v-if="errors.body" class="error">{{
                        errors.body[0]
                    }}</span>
                    <input class="add-post-btn" type="submit" value="Update" />
                </form>
            </div>
        </div>
    </main>
</template>

<script setup>
import axios from "axios";
import { ref, reactive, onMounted } from "vue";
import { useRoute } from "vue-router";
const post = reactive({
    id: "",
    title: "",
    url: "",
    category_id: "",
    body: "",
    image: "",
});
const errors = ref([]);
const success = ref(false);
const categories = ref([]);
const router = useRoute();

onMounted(() => {
    getBlog();
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

const getBlog = () => {
    axios
        .get("/api/blog/" + router.params.id)
        .then((res) => {
            post.id = res.data.id;
            post.title = res.data.title;
            post.url = res.data.image;
            post.category_id = res.data.category_id;
            post.body = res.data.body;
        })

        .catch((error) => {
            console.log(error);
        });
};

const getFile = (e) => {
    post.image = e.target.files[0];
    const reader = new FileReader();
    reader.onloadend = () => {
        post.url = reader.result;
    };
    reader.readAsDataURL(e.target.files[0]);
};

const handleUpdate = () => {

    const formdata = new FormData();
    formdata.append("title", post.title);
    formdata.append("image", post.image);
    formdata.append("category_id", post.category_id);
    formdata.append("body", post.body);
    formdata.append("_method", "PUT");



    axios
        .post("/api/blog/update/" + post.id, formdata, {
            headers: {
                "content-Type": "multipart/form-data",
            },
        })
        .then((res) => {
            console.log(res);
            success.value = true;
            errors.value = [];
        })
        .catch((err) => {
            success.value = false;
            errors.value = err.response.data.errors;
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
