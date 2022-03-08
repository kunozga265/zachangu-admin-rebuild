<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Employers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-12 sm:px-20 bg-white border-b border-gray-200">
                        <div>
                            <inertia-link  :href="route('employer.new')">
                                <jet-button>
                                    + New Employer
                                </jet-button>
                            </inertia-link>
                            <jet-section-border />
                        </div>
                        <div class="grid grid-cols-1">
                            <div
                                v-for="employer in $page.props.employers.data"
                                :key="employer.id"
                            >
                                <inertia-link
                                    class="cursor-pointer m-2 p-2"
                                    :href="route('employer.show',{'id':employer.id})"
                                >
                                    <div class="text-xl text-gray-800 font-bold ">
                                        {{employer.name}}
                                    </div>
                                    <div class=" text-gray-400">
                                        {{employer.address}}
                                    </div>
                                    <div class="font-semibold">
                                        {{employer.employeesCount}} {{employer.employeesCount==1?'Employee':'Employees'}}
                                    </div>
                                </inertia-link>
                                 <jet-section-border />
                            </div>

                            <div   v-if="($page.props.employers).length==0" class="m-2 p-6">
                                <div>No Employers found.</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </app-layout>

</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import JetButton from '@/Jetstream/Button'

export default {
    name: "Index",
    props:[

    ],
    components:{
        JetSectionBorder,
        JetButton,
        AppLayout,

    },
    methods: {
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

    }



}
</script>

<style scoped>

</style>
