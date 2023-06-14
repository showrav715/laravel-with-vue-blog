<template>
    <div class="categories-list">
        <h1>Posts List</h1>
        <!-- success message -->
        <div class="success-msg" v-if="success">
        <i class="fa fa-check"></i>
        Post deleted successfully
      </div>
        <!-- <div class="success-msg" v-if="editSuccess">
        <i class="fa fa-check"></i>
        Post edited successfully
      </div> -->
        <div class="item" v-for="post in posts" :key="post.id">
            <span>{{ post.id }}</span>
            <p><img :src="post.image" alt="" /></p>
            <p>{{ post.title }}</p>

            <div>
                <router-link
                    class="edit-link btn"
                    :to="{ name: 'EditBlog', params: { id: post.id } }"
                    >Edit</router-link
                >
            </div>
            <input type="button" @click="handleDelete(post.id)" value="Delete" class="delete btn" />
        </div>
        <div class="index-categories">
            <router-link :to="{ name: 'createBlog' }"
                >Create post<span>&#8594;</span></router-link
            >
        </div>
    </div>
</template>
<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
const posts = ref([]);
const success = ref(false);
onMounted(() => {
    getBlogs();
});

const getBlogs = () => {
    axios
        .get("/api/blogs")
        .then((response) => {
            posts.value = response.data.data;
        })
        .catch((error) => {
           posts.value = [];
        });
};

const handleDelete = (id) => {
    axios.delete("/api/blog/" + id).then((response) => {
        getBlogs();
        success.value = true;
    });
}

</script>

<style scoped>
.categories-list {
    min-height: 100vh;
    background: #fff;
}

.categories-list h1 {
    font-weight: 300;
    padding: 50px 0 30px 0;
    text-align: center;
}

.btn {
    padding: 9px 13px;
    background-color: #494949;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    margin: 0 5px;
}

.delete {
    background-color: #f44336;
}

.categories-list .item {
    display: flex;
    justify-content: right;
    align-items: center;
    max-width: 300px;
    margin: 0 auto !important;
}

.categories-list .item p {
    font-size: 16px;
}

.categories-list .item p,
.categories-list .item div,
.categories-list .item {
    margin: 15px 8px;
}

.categories ul li {
    list-style: none;
    background-color: #494949;
    margin: 20px 5px;

    border-radius: 15px;
}

.categories ul {
    display: flex;
    justify-content: center;
}

.categories a {
    color: white;
    padding: 10px 20px;
    display: inline-block;
}

.create-categories a,
.index-categories a {
    all: revert;
    margin: 20px 0;
    display: inline-block;
    text-decoration: none;
}

.create-categories a span,
.index-categories a span {
    font-size: 22px;
}

.index-categories {
    text-align: center;
}
</style>
