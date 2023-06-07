<template>
    Dashboard

    {{ user.name }}
    {{ user.email }}
</template>


<script setup>
import axios from "axios";
import { onMounted,reactive,ref } from "vue";

const user = reactive({});
onMounted(() => {
    axios.get("/api/user").then((response) => {
        console.log(response.data);
        user.name = response.data.name;
        user.email = response.data.email;
        
    });
});

</script>