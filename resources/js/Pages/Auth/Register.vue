<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
</script>
<script >
    export default {
        data(){
            return{
                photo:'',
                form: useForm({
                    prefixname: '',
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    suffixname: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    photo:null,
                }),
            }
        },
        methods: {
            submit : function(){
                this.form.post(route('register'), {});
            },
            onFileInput(event) {           
                this.photo = URL.createObjectURL(event.target.files[0]);
            },
        }
    }
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" method="post" enctype="multipart/form-data">
            <div>
                <InputLabel for="photo" value="Photo" />
                <input type="file" @input="form.photo = $event.target.files[0]"  @change="onFileInput($event)"/>
                <img :src="photo" width="240" class="p-2">
                <InputError class="mt-2" :message="form.errors.photo" />
            </div>
            <div>
                <InputLabel for="name" value="Prefix" />
                <select id="prefixname" type="text" class="mt-1 block w-full" v-model="form.prefixname" required >
                    <option v-for="item in $inertia.page.props.prefixname" :value="item"> {{item}} </option>
                </select>
                <InputError class="mt-2" :message="form.errors.prefixname" />
            </div>

            <div>
                <InputLabel for="firstname" value="First Name" />
                <TextInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" required autofocus autocomplete="firstname"/>
                <InputError class="mt-2" :message="form.errors.firstname" />
            </div>

            <div>
                <InputLabel for="middlename" value="Middle Name" />
                <TextInput id="middlename" type="text" class="mt-1 block w-full" v-model="form.middlename" autocomplete="middlename"/>
                <InputError class="mt-2" :message="form.errors.middlename" />
            </div>

            <div>
                <InputLabel for="lastname" value="Last Name" />
                <TextInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required autocomplete="lastname"/>
                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>


            <div>
                <InputLabel for="suffixname" value="Suffix" />
                <TextInput id="suffixname" type="text" class="mt-1 block w-full" v-model="form.suffixname" autocomplete="suffixname"/>
                <InputError class="mt-2" :message="form.errors.suffixname" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required  autocomplete="new-password"/>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password"/>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                :href="route('login')"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                Already registered?
            </Link>

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </PrimaryButton>
        </div>
    </form>
</GuestLayout>
</template>
