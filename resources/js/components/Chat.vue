<template>
    <div class="flex h-full"> 
        <!-- 사용자리스트목록 -->
        <vue_ChatUserList        
            v-bind:currentUser="currentUser"   
            @updateChatWith_parent =  "updateChatWith"    
        /> 
        <div v-if="chatWith2">
            <vue_ChatArea
                v-bind:messages = "messages"            
            />
            <div>
                <input 
                    type="text" 
                    class="border-2 border-solid border-gray-600 w-full p-2" 
                    name="message" 
                    v-model = "message"                     
                    @keyup.enter = "sendMessage" />
                     
            </div>
        </div>
        <div v-else>
            어머어머 아직 누구한테 말할지 못 정하셨군요?
        </div>
    </div>
</template>
<script>
   import vue_ChatUserList from "./ChatUserList.vue";  
   import vue_ChatArea from "./ChatArea.vue";  
   
   export default{
        props: {
            currentUser : {
            type: Number,
            required : true,
            }, 
        },
        data(){
            return{
                chatWith    : 0,
                chatWith2    : 0,
                message     : '',
                messages    : [],
                
            }            
        },
        mounted(){
            console.log ("Chat vue mouted=====================");
            console.log ("뭐가 왔는가 props==>["+this.currentUser+"]");

        },
        components : {
            vue_ChatUserList,
            vue_ChatArea
        },
        methods:{
            updateChatWith(val){
                console.log("부모한테 잘 왔는디요????updateChatWith================>["+val+"]");
                this.chatWith2 = 1;     
                this.getMessages();           
            },

            getMessages(){

                axios.get('/api/messages', {
                    params : {
                        to : this.chatWith2,   
                        from : this.currentUser           
                    }
                }).then(res =>{
                    console.log( "가져온 메시지" + res);
                    this.messages = res.data.messages;
                })




                               // axios.get('/api/messages', {
                //     params: {
                //         to : this.chatWith,
                //         from : this.currentUser
                //     }
                // }).then(res =>{
                //    // console.log("thismessage===>["+ res +"]");
                //     this.message = res.data.messages;
                //    // console.log("thismessage===>["+this.message+"]");

                // })
            },

            
            sendMessage(){
                console.log("보내는 메시지는===>["+this.message+"]");
                if(this.message){
                    axios.post('/api/messages',{
                        text : this.message,
                        to : this.chatWith2,
                        from : this.currentUser
                    }); 
                    this.message = "";
                    this.getMessages();         
                }
            },

        }

    }


</script>