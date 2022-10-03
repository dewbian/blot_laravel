<template>    
<div>
    <div>누구랑 이야기 하니??????</div>
    <div v-for = "message in messages"  
    :key = "message.id"
    > 
    <div>{{message.from.name}} {{message.created_at}}</div> 
    <div>{{message.text}}</div> 
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