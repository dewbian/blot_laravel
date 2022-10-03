<template>

<div class="w-1/5 border-r-2 borde-solid border-gray-600 ">
    <div class = "p-2 border-b-2 border-gray-600 hover:bg-gray-300 cursor-pointer"
        v-for="sortedUser in usersWithoutSingedInuser"   
        :key = sortedUser.id
        @click = "updateChatWith(sortedUser.id)"
    >
        {{ sortedUser.name }} 
    </div>
</div>

</template>
<script>

    export default{
        mounted(){ 
            console.log ("ChatUserList vue mounted=====================");
            console.log ("뭐가 왔는가 props==>["+this.currentUser+"]");
        },
        props: {
            currentUser : {
            type: Number,
            required : true,
          }
        },
        data(){
            return{
                users: []
            }
        } ,
        methods:{
            updateChatWith(val){
                this.$emit( "updateChatWith_parent" , val );
            }
        },

        computed : {
            usersWithoutSingedInuser(){
                return this.users.filter(aa => aa.id !== this.currentUser);
            }

        },
        created(){

            axios.get('/api/users').then(res => { 
                //console.log(res);
                //res.data.users;
                this.users = res.data.users;
            }).catch(error => {
                console.log("에러발생");
            });

        },
    }


</script>