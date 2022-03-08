<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.employer.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-12 sm:px-20 bg-white border-b border-gray-200">
                        <div>
                            <inertia-link  :href="route('employee.new',{id:$page.props.employer.id})">
                                <jet-button>
                                    + New Employee
                                </jet-button>
                            </inertia-link>

                            <a :href="$page.props.publicPath + $page.props.employer.letter" target="_blank">
                                <jet-secondary-button>
                                    Agreement Letter
                                </jet-secondary-button>
                            </a>

                            <jet-section-border />
                        </div>
                        <div class="grid grid-cols-1">
                            <employee
                                v-for="employee in $page.props.employees"
                                :key="employee.id"
                                :employee="employee"
                          />

                            <div   v-if="($page.props.employees).length==0" class="m-2 p-6">
                                <div>No Employees found.</div>
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
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import Employee from './Partials/Employee'

export default {
    name: "Show",
    props:[

    ],
    components:{
        JetSectionBorder,
        JetButton,
        JetSecondaryButton,
        AppLayout,
        Employee

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
