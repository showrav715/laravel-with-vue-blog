<template>
    <div id="create-categories">
        <div id="contact-us">
            <h1>Create New Category!</h1>
            <!-- success message -->
            <div class="success-msg" v-if="status" >
                <i class="fa fa-check"></i>
                Category created successfully
            </div>
            <div class="contact-form">
                <form @submit.prevent="handleStore">
                    <label for="name"><span>Name</span></label>
                    <input type="text" id="name" v-model="name" />
                    <span class="error" v-if="errors.name">{{
                        errors.name[0]
                    }}</span>

                    <input type="submit" value="Submit" />
                </form>
            </div>
            <div class="create-categories">
                <router-link :to="{ name: 'CategoryList' }"
                    >Categories List <span>&#8594;</span></router-link
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const name = ref('')
const errors = ref({});
const status = ref(false);

const handleStore = () => {
    axios
        .post("/api/categories/create", { name: name.value })
        .then((res) => {
            name.value = "";
            status.value = true;
            errors.value = {};
        })
        .catch((err) => {
            status.value = false;
            errors.value = err.response.data.errors;

        });
};
</script>

<style scoped>
#create-categories {
    background-color: #f3f4f6;
    height: 90vh;
    padding: 50px;
}

.success-msg{
    background-color: #4caf50;
    color: #fff;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.error{
    color: red;
    font-size: 18px;
    margin-bottom: 10px;
}
</style>
