<script setup>
import { getAuthUser } from '~/lib/user';

    const user = reactive({
        id: "",
        name: "",
        firstname: "",
        email: "",
        type: "",
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
    })
</script>

<template>
    <div>
        <p>nom : {{ user.name }}</p>
        <p>prénom : {{ user.firstname }}</p>
        <p>email : {{ user.email }}</p>
        <p>type : {{ user.type }}</p>
    </div>
</template>