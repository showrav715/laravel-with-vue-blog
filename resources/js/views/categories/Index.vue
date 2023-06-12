<template>
    <div class="categories-list">
        <h1>Categories List</h1>
        <!-- success message -->
        <div class="success-msg" style="display: none">
            <i class="fa fa-check"></i>
            Deleted successfully
        </div>
        <div class="item" v-for="item in data.categories" :key="item.id">
            <span>{{ item.id }}</span>
            <p>{{item.name}}</p>
            <div>
                <router-link class="btn" :to="{name:'EditCategory' , params:{id:item.id}}">Edit</router-link>
            </div>
            <input type="button" value="Delete" @click="handleDelete(item.id)" class="btn delete" />
        </div>
        <div class="index-categories">
            <router-link :to="{ name : 'createCategory'}"
                >Create Categories<span>&#8594;</span></router-link
            >
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import { onMounted,reactive } from 'vue';

const data = reactive({
    'categories': []
})

onMounted(()=>{
    handleGetData()
})

const handleGetData = ()=>{
    axios.get('/api/categories').then(res=>{
        data.categories = res.data
    })
    .catch(err=>{
        console.log(err)
    })
}

const handleDelete= (id)=>{
    axios.delete('/api/categories/'+id)
    .then((res)=>{
        alert('Deleted successfully')
        handleGetData()
    })
    .catch((err)=>{
        console.log(err)
    })

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
.btn{
    padding: 9px 13px;
    background-color: #494949;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    margin: 0 5px;
}

.delete{
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
