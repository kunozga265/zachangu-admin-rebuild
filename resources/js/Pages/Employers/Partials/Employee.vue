<template>
    <div>
        <div
            @click="dialog=true"
            class="cursor-pointer m-2 p-2">

            <div class="text-xl text-gray-800 font-bold ">
                {{employee.firstName}} {{employee.lastName}}
            </div>
            <div class=" text-gray-400">
                {{employee.position}}
            </div>
            <div class="text-gray-400">
                Contract valid until {{employee.contractDuration}}
            </div>
        </div>
        <jet-section-border />

        <jet-dialog-modal :show="dialog" @close="closeModal">
            <template #title>
                Employee Profile
            </template>

            <template #content class="p-6 md:p-12">
                <!-- Personal Information -->
                <div >
                    <div class="flex items-center justify-start">
                        <div class="mt-0 p-1 h-6 w-6 rounded-full text-white text-center text-xs bg-gray-800 ">1</div>
                        <span class="text-xl ml-4">Personal Information</span>
                    </div>
                    <div class="mt-4 mx-2 p-6  border-l-2 border-gray-200">

                        <div class="text-lg text-gray-400">Basic Information</div>

                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="my-4 md:col-span-2 flex items-center justify-center">
                                <img class="max-w-fit md:max-w-sm" :src="url(employee.photo)" alt="Photo">
                                <!--                                        <div class="text-sm text-gray-400">Photo</div>-->

                            </div>
                            <div class="mt-4" >
                                <div>{{employee.firstName}}</div>
                                <div class="text-sm text-gray-400">First Name</div>
                            </div>
                            <div class="mt-4 md:ml-4" >
                                <div>{{employee.middleName}}</div>
                                <div class="text-sm text-gray-400">Middle Name</div>
                            </div>
                            <div class="mt-4 ">
                                <div>{{employee.lastName}}</div>
                                <div class="text-sm text-gray-400">Last Name</div>
                            </div>
                            <div class="mt-4 md:ml-4">
                                <div>+265 {{employee.phoneNumberMobile}}</div>
                                <div class="text-sm text-gray-400">Phone Number Mobile</div>
                            </div>
                            <div class="mt-4">
                                <div>+265 {{employee.phoneNumberWork}}</div>
                                <div class="text-sm text-gray-400">Phone Number Work</div>
                            </div>

                            <div class="mt-4 md:ml-4">
                                <div>{{employee.email}}</div>
                                <div class="text-sm text-gray-400">Email</div>
                            </div>
                        </div>

                        <div class="mt-6 text-lg text-gray-400">Residential Address</div>

                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="mt-4 md:col-span-2">
                                <div>{{computePhysicalAddress}}</div>
                                <div class="text-sm text-gray-400">Physical Address</div>
                            </div>
                        </div>

                        <div class="mt-6 text-lg text-gray-400">Identification</div>

                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="mt-4 ">
                                <div>{{employee.nationalId}}</div>
                                <div class="mt-2 text-sm text-gray-400">National Id</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Workplace Information -->
                <div class="mt-6">
                    <div class="flex items-center justify-start">
                        <div class="mt-0 p-1 h-6 w-6 rounded-full text-white text-center text-xs bg-gray-800 ">2</div>
                        <span class="text-xl ml-4">Workplace Information</span>
                    </div>
                    <div class="mt-4 mx-2 p-6  border-l-2 border-gray-200">

                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <div>{{employee.position}}</div>
                                <div class="text-sm text-gray-400">Position</div>
                            </div>
                        </div>

                        <div class="mt-6 text-lg text-gray-400">Work Address</div>

                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="mt-4 md:col-span-2">
                                <div>{{computeWorkAddress}}</div>
                                <div class="text-sm text-gray-400">Work Address</div>
                            </div>
                        </div>

                        <div class="mt-6 text-lg text-gray-400">Contract Details</div>

                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="mt-4">
                                <div>{{employee.contractDuration}}</div>
                                <div class="text-sm text-gray-400">Contract Expiry Date</div>
                            </div>
                        </div>

                    </div>
                </div>

            </template>

            <template #footer>
                <jet-button-secondary @click.native="closeModal">
                    Close
                </jet-button-secondary>
            </template>
        </jet-dialog-modal>


    </div>
</template>

<script>

import JetSectionBorder from '@/Jetstream/SectionBorder'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButtonSecondary from '@/Jetstream/SecondaryButton'


export default {
    name: "Employee",
    props:[
        'employee'
    ],
    components:{
        JetSectionBorder,
        JetDialogModal,
        JetButtonSecondary,

    },
    data() {
        return {
            dialog:false,
        }
    },
    computed:{
        computePhysicalAddress(){
            let box=(this.employee.physicalAddress.box).length!==0?'P. O. Box '+this.employee.physicalAddress.box:'';
            return this.employee.physicalAddress.name+' '+ box + ' '+ this.employee.physicalAddress.location;
        },
        computeWorkAddress(){
            let box=(this.employee.workAddress.box).length!==0?'P. O. Box '+this.employee.workAddress.box:'';
            return /*this.workAddressName+' '+*/ box + ' '+ this.employee.workAddress.location;
        },
    },
    methods: {
        url(path){
            return this.$page.props.publicPath+path
        },
        getStatus(progress){
            switch (progress){
                case '0':
                    return 'Finish the applying process';
                    break;
                case '1':
                    return 'Waiting for guarantor to approve';
                    break;
                case '2':
                    return 'Waiting for employer to approve';
                    break;
                case '3':
                    return 'Active';
                    break;
                case '4':
                    return 'Closed';
                    break;
                default:
                    return 'Nothing';
                    break;
            }
        },
        getStatusColor(progress){
            switch (progress){
                case '0':
                    return '#FBBF24';
                    break;
                case '1':
                    return '#FBBF24';
                    break;
                case '2':
                    return '#FBBF24';
                    break;
                case '3':
                    return '#4ADE80';
                    break;
                case '4':
                    return '#EF4444';
                    break;
                default:
                    break;
            }
        },
        closeModal() {
            this.dialog = false
        },

    }



}
</script>

<style scoped>

</style>
