<template>
    <div class="flex h-full"> 
        <!-- 사용자리스트목록 -->
        <vue_ChatUserList        
            v-bind:currentUser="currentUser"   
            @updateChatWith_parent =  "updateChatWith"    
        /> 
        <div v-if="chatWith"> 
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
            대화 하고자 하는 회원을 클릭하세요
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
        data: function () {
            return {
                    chatWith    : 0, 
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
                console.log("현재 유저는 이사람입니다.================>["+this.currentUser +"]");
                this.chatWith = val;
                //this.chatWith = 1;     
                this.getMessages();           
            },

            getMessages(){

                axios.get('/api/messages', {
                    params : {
                        to : this.chatWith,   
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
                        to : this.chatWith,
                        from : this.currentUser
                    }); 
                    this.message = "";
                    this.getMessages();         
                }
            },

        }

    }


</script>