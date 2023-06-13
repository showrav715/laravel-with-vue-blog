<template>
    <div id="create-categories">
      <div id="contact-us">
        <h1>Update Category!</h1>
        <!-- success message -->
        <div class="success-msg" v-if="success">
          <i class="fa fa-check"></i>
          Category Update successfully
        </div>
        <div class="contact-form">
          <form @submit.prevent="handleUpdate">
            <label for="name"><span>Name</span></label>
            <input type="text" id="name" v-model="data.name" />
            <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
 
            <input type="submit" value="Submit" />
          </form>
        </div>
        <div class="create-categories">
          <div class="create-categories">
                <router-link :to="{ name: 'CategoryList' }"
                    >Categories List <span>&#8594;</span></router-link
                >
            </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
    import { reactive,onMounted,ref } from "vue";
    import axios from "axios";
    import { useRoute } from "vue-router";
   const data = reactive({
      
    });
    const errors = ref({});
    const success = ref(false);
    const router = useRoute();
    console.log(router.params.id);
    onMounted(()=>{
        getCategory()
    })

    const getCategory = async () =>{
     await axios.get(`/api/categories/${router.params.id}`).then(res=>{
        data.id = res.data.id
        data.name = res.data.name
      })
      .catch(err=>{
        console.log(err)
      })
    }


    const handleUpdate = () => {
    axios
        .put("/api/categories/"+router.params.id, { name: data.name })
        .then((res) => {
            success.value = true;
            errors.value = {};
        })
        .catch((err) => {
          success.value = false;
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

  </style>