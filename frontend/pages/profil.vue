<script setup>
import { getAuthUser } from '~/lib/user';
import { ref } from 'vue'
import { getProfilePic, uploadPic } from '~/lib/file';

    const selectedFile = ref(null);
    const profilePic = ref(null);
    const user = reactive({
        id: "",
        name: "",
        firstname: "",
        email: "",
        type: "",
        photo_path: "",
        created_at: "",
        updated_at: "",
    });

    async function fecthUserInfo(){
        const response = await getAuthUser();
        // console.log(response);
        if(response.status === 200){
            user.id = response.data.id;
            user.name = response.data.name;
            user.firstname = response.data.firstname;
            user.email = response.data.email;
            user.type = response.data.type;
            user.created_at = response.data.created_at;
            user.updated_at = response.data.updated_at;
        }
    }

    onMounted(() => {
        fecthUserInfo();
        fetchAuthProfilePic();
    })

    function handleClick(){
        const input = document.getElementById('profil_pic');
        input.click();
    }

    function handleChange(event){
        selectedFile.value = event.target.files[0];
    }

    async function handlePicSubmit(){
        const response = await uploadPic(selectedFile.value);
        if(response.status === 200){
            console.log("Image uploaded successfully");
        } else {
            console.error("Image upload failed", response);
        }
    }

    async function fetchAuthProfilePic(){
        const response = await getProfilePic();
        if(response.status === 200){
            profilePic.value = response.data;
            console.log(profilePic.value);
        } else {
            console.error("Failed to fetch profile picture", response);
        }
    }

</script>

<template>
    <div>
        <p>nom : {{ user.name }}</p>
        <p>prénom : {{ user.firstname }}</p>
        <p>email : {{ user.email }}</p>
        <p>type : {{ user.type }}</p>
    </div>

    <form method="POST" @submit.prevent="handlePicSubmit">
        <button @click="handleClick" class="bg-blue-500 text-white px-2 py-1">Charger une image</button>
        <input @change="handleChange" type="file" name="profile_pic" id="profil_pic" class="hidden">
        <button class="bg-green-500 text-white px-2 py-1 space-x-px">Envoyer</button>
    </form>
    <div>
    <img
      v-if="profilePic"
      :src="profilePic"
      alt="Profile Picture"
      class="rounded-full w-32 h-32 object-cover"
    />
    <p v-else>Loading profile picture...</p>
  </div>
</template>