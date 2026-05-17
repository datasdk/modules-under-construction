<template>
  <section>


    <Loading v-if="loading"/>


    <div v-else>
   
        <div class="content-header">

            <h1>
                Under omstrukturering
                <small>
                    Her kan du lukke appen ned under ombygning, så brugerne ikke kan få adgang.
                    Angiv venligst en "access-key" som kan bruges til at tilgå systemet gennem administratorer.
                </small>
            </h1>

        </div>


        <table class="table">

            <tr>
                <th colspan="2">Under ombyning</th>
            </tr>
            <tr>
                <td width="150">Tilgængelig</td>
                <td>
                    
                    <div class="pb-5">

                        <div>
                            <label>
                            <input type="radio" value="0" v-model="input.under_construction"> Offentligt tilgængelig
                            </label>
                        </div>
     
                        Appen er offentlig tilgængelig for brugere og administratorer

                    </div>

                     
                    <div>

                        <div>
                           <label>
                            <input type="radio" value="1" v-model="input.under_construction"> Under ombygning
                            </label> 
                        </div>
                           
                        Appen lukkes ned og adgang nægtes for brugere og administratore. Der bliver vist en besked i appen, som angives herunder.

                    </div>
                     

                </td>
            </tr>
        </table>


        <table class="table">

            <tr>
                <th colspan="2">Adgang</th>
            </tr>
            <tr>
                <td colspan="2">
                    For at give adgang til appen til andre, bedes du dele dette link
                </td>
            </tr>

            <tr>
                <td width="150">

                    Adgangskode

                </td>
                <td>
                      
                    <input type="text" v-model="input.access_key" class="form-control" >
 
                </td>
            </tr>

            <tr>
                <td width="150">

                    Link

                </td>
                <td>
                               
                    <input type="text" readonly :value="accessLink" class="form-control" onfocus="this.select()">
                     
                </td>
            </tr>            
    
        </table>


        <table class="table">

            <tr>
                <th colspan="2">Besked</th>
            </tr>
            <tr>
                <td colspan="2">Denne velkomstbesked vises til de brugere, som bliver nægtet adgang til appen og adminsystemet</td>
            </tr>
            <tr>
                <td width="150">

                    Title

                </td>

                <td>

                    <TextField
                        name="title"
                        v-model="input.title"
                    />

                </td>
            </tr>

            <tr>
                <td >

                    Besked

                </td>

                <td>

                    <TextArea
                        name="description"
                        v-model="input.description"
                    />

                </td>
            </tr>

        </table>

          
        <v-btn color="primary" @click="submit()" :loading="submitLoading">Opdater indstillinger</v-btn> 


    </div>
 


  </section>
</template>

<script>

import TableEdit from "@/Mixins/TableEdit"


export default {

    mixins: [TableEdit],

    data(){

        return {

            loading: false,

            input: {
                under_construction: 0,
                access_key: this.getRandomString,
                title: undefined,
                description: undefined,
            }
        }

    },

    computed:{

        accessLink(){

            return window.location.protocol + "//" + window.location.host + "/" + this.input.access_key;

        },


        getRandomString(){
            
            return Math.random().toString(36).substring(2,20+2);

        }

    },

    methods:{   


        async get(){


            this.loading = true


            await axios.get(route("api.settings.under_construction.index")).then((res)=>{
                 
                let data = res.data.data

                if(!data.access_key){

                    data.access_key = this.getRandomString

                }                

                this.input = data
                
                
            }).catch((res)=>{

                console.log(res)

            }).then(()=>{

                this.loading = false

            })


        },
        
  
        // create and update
        create(){
            
            return axios.post(route("api.settings.under_construction.store"),this.input).then((res)=>{
                
                console.log(res)
         
                if(res.data.data.has_changed && res.data.data.under_construction){

                    alert("Appen er nu lukket ned, du bedes logge ind igen")

                    location.href = this.accessLink

                } 
                            

            })


        }


    },


    mounted(){
        
        

        this.get()

    }

}
</script>

<style>

</style>