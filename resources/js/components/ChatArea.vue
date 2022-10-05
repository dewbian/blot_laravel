<template>    
<div>
    <div>=================================</div>
    <div v-for = "message in messages"  
    :key = "message.id"
    > 
    <div class="pb-2 text-base text-gray-500">{{message.from.name}} {{message.created_at}}</div> 
    <div class="pl-5 ">{{message.text}}</div> 
    <div>----------------------------------------------------</div> 
    </div>
</div>    
</template>
<script>
    export default{
        mounted(){
            console.log("chatAreavue mounted=======================");
            console.log(this.messages);
        },
        props :{ 
            messages : { 
                type : Array,
                required : true,
            }
        },
        data() {
 
        }

    }
</script>