i<script setup>
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
	import InputError from '@/Components/InputError.vue';
	import InputLabel from '@/Components/InputLabel.vue';
	import PrimaryButton from '@/Components/PrimaryButton.vue';
	import TextInput from '@/Components/TextInput.vue';
	import { Head, Link, useForm} from '@inertiajs/vue3';
	import { computed } from 'vue'

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
					photo:null,
				}),
			}
		},
		methods: {
			submit : function(hash){
				this.form.post(route('users.store',hash), {});
			},
			onFileInput(event) {    	   
				this.photo = URL.createObjectURL(event.target.files[0]);
			},
		}
	}
</script>

<template>
	<Head :title="'Create user'" />

	<AuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create a User</h2>
		</template>

		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 text-gray-900 dark:text-gray-100">

						<form @submit.prevent="submit()" >
							<div>
								<InputLabel for="photo" value="Photo" />
								<input type="file" @input="form.photo = $event.target.files[0]"  @change="onFileInput($event)"/>
								<img :src="photo" width="240" class="p-2">
								<InputError class="mt-2" :message="form.errors.photo" />
							</div>
							<div>
								<InputLabel for="name" value="Prefix" />
								<select id="prefixname" class="mt-1 block w-full" v-model="form.prefixname" required>
									<option v-for="item in $inertia.page.props.prefixname" :value="item" > 
										{{item}} 
									</option>
								</select>
								<InputError class="mt-2" :message="form.errors.prefixname" />
							</div>

							<div>
								<InputLabel for="firstname" value="First Name" />
								<TextInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" required autofocus autocomplete="firstname" />
								<InputError class="mt-2" :message="form.errors.firstname" />
							</div>

							<div>
								<InputLabel for="middlename" value="Middle Name" />
								<TextInput id="middlename" type="text" class="mt-1 block w-full" v-model="form.middlename" autocomplete="middlename" />
								<InputError class="mt-2" :message="form.errors.middlename" />
							</div>

							<div>
								<InputLabel for="lastname" value="Last Name" />
								<TextInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required autocomplete="lastname" />
								<InputError class="mt-2" :message="form.errors.lastname" />
							</div>

							<div>
								<InputLabel for="suffixname" value="Suffix" />
								<TextInput id="suffixname" type="text" class="mt-1 block w-full" v-model="form.suffixname" autocomplete="suffixname" />
								<InputError class="mt-2" :message="form.errors.suffixname" />
							</div>

							<div class="mt-4">
								<InputLabel for="email" value="Email" />
								<TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="email" />
								<InputError class="mt-2" :message="form.errors.email" />
							</div>

							<div class="mt-4">
								<InputLabel for="password" value="password" />
								<TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="password" />
								<InputError class="mt-2" :message="form.errors.password" />
							</div>

							<div class="flex items-center justify-end mt-4">
								<PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
									Save
								</PrimaryButton>

							</div>
						</form>

					</div>
				</div>

			</div>
		</div>
	</AuthenticatedLayout>
</template>

