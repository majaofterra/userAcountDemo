<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head :title="$inertia.page.props.user.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{$inertia.page.props.user.name}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="inline-flex p-2">
                        <img v-if="$inertia.page.props.user.photo" :src="$inertia.page.props.user.photo" width="250" height="250" >
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                    	<div v-for="data,key in $inertia.page.props.user">
                           <small>{{key}} : </small>{{data}}
                       </div>
                   </div>
               </div>
           </div>
       </div>
       
   </AuthenticatedLayout>
</template>

