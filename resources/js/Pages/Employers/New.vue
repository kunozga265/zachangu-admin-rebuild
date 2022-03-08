<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Employer
            </h2>
        </template>

        <form @submit.prevent="submit">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-12 sm:px-20 bg-white border-b border-gray-200">

                            <jet-validation-errors class="mb-4" />

                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div class="" >
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required  autocomplete="Name" />
                                </div>
                                <div class="mt-4 md:ml-4 md:mt-0">
                                    <jet-label for="email" value="Email" />
                                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                                </div>
                                <div class="mt-4" >
                                    <jet-label for="address" value="Address" />
                                    <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" required  autocomplete="Address" />
                                </div>
                                <div class="mt-4 md:ml-4">
                                    <jet-label for="Letter" value="Upload agreement letter" />
                                    <input id="Letter" type="file" @input="letterUpload($event.target.files[0])" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required/>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full h-20"></div>
            <div class="fixed bottom-0 h-20 p-6 bg-white shadow w-full flex items-center">
                <div v-if="validation" class="w-full flex items-center justify-center">
                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save Employer
                    </jet-button>
                </div>
                <div v-else>
                    <div class="text-red-500">{{errorMessage}}</div>
                    <div class="text-sm text-gray-400">{{errorSection}}</div>
                </div>

            </div>
        </form>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default {

        components: {
            AppLayout,
            JetLabel,
            JetButton,
            JetInput,
            JetSectionBorder,
            JetValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
                    //Personal Information
                    name:'',
                    email: '',
                    address: '',
                    letter: '',
                }),

                errorMessage:'',
                errorSection:'',
            }
        },
        created(){

        },
        computed:{
            // user(){
            //     $page.props.user
            // },
            validation:function () {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

                if ((this.form.name).length===0){
                    this.errorSection='Name Section';
                    this.errorMessage='Enter name';
                    return false;
                }
                else if ( !pattern.test(this.form.email ||  (this.form.email).length===0 )){
                    this.errorSection='Email Section';
                    this.errorMessage='Enter a valid e-mail';
                    return false;
                }
                else if ((this.form.address).length===0){
                    this.errorSection='Address Section';
                    this.errorMessage='Enter address';
                    return false;
                }

                else if(this.form.letter===""){
                    this.errorSection='Agreement Letter Section';
                    this.errorMessage='Upload the letter';
                    return false;
                }
                else
                    return true
            },
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,

                    }))
                    .post(this.route('employer.store'))
            },
            letterUpload(file){
                const reader=new FileReader();
                if (file){
                    reader.readAsDataURL(file);
                    reader.onload=(e)=>{
                        axios.post(this.$page.props.publicPath+"api/file-upload",{
                            name:this.form.name,
                            type:"letter",
                            file:e.target.result
                        }).then(res=>{
                            this.form.letter= res.data.new_file
                        }).catch(function(res){
                            console.log(res.message)
                           // this.form.errors.push(res.data.message)
                        })
                    };
                }
            },
        }


    }
</script>
