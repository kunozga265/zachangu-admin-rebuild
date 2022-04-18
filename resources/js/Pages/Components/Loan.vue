<template>
        <div>
            <inertia-link
                class="cursor-pointer"
                :href="route('loan.show',{code:loan.code})"
            >
                <div class="p-1 md:p-4">
                    <div class="text-2xl sm:text-3xl md:text-4xl text-gray-800 font-bold ">MK{{ loan.amount }}</div>
                    <div class=" flex justify-start">
                        <alert-circle :fill-color="getStatusColor(loan.progress)"/>
                        <span class="ml-2 text-gray-600 text-xs sm:text-sm md:text-base">{{getStatus(loan.progress)}}</span>
                    </div>
<!--                    <span class="text-gray-400">Created on: {{(loan.created_at).substr(0,10)}}</span>-->
                </div>
            </inertia-link>
            <jet-section-border/>
        </div>
</template>

<script>
    import AlertCircle from 'vue-material-design-icons/AlertCircle.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        props:[
            'loan'
        ],
        components: {
            AlertCircle,
            JetSectionBorder
        },

        methods:{
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
                    case '5':
                        return 'Defaulted';
                        break;
                    case '6':
                        return 'Over Due';
                        break;
                    case '7':
                        return 'Rejected';
                        break;
                    default:
                        return '-';
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
                    default:
                        return '#EF4444';
                        break;
                }
            },
        }
    }
</script>
