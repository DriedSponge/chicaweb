<script setup>
import Layout from "./Layout.vue";
import { Head } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "laravel-precognition-vue-inertia";
import { ref } from "vue";
defineProps({
	server: Object
});
defineOptions({ layout: Layout });
const form = useForm(
	"put",
	route("server.settings.save", { server_id: usePage().props.server.did }),
	{
		private: usePage().props.server.private
	}
);
const deleteForm = useForm(
	"delete",
	route("server.delete", { server_id: usePage().props.server.did }),
	{
		server_name: null
	}
);
function submit() {
	form.submit();
}
let deleteModal = ref(null);
</script>

<template>
	<Head>
		<title>{{ server.name }}</title>
	</Head>
	<div class="flex flex-col">
		<div class="max-w-1/2 flex flex-col space-y-3 rounded-xl bg-base-300 p-3 shadow-xl">
			<div class="flex h-full flex-row items-center space-x-4">
				<img
					v-if="server.server_icon != null"
					class="h-24 w-24 rounded-full object-fill shadow-xl"
					:alt="`The icon for ${server.name}`"
					:src="`https://cdn.discordapp.com/icons/${server.did}/${server['server_icon']}.webp?size=240`"
				/>
				<div
					v-else
					class="flex h-24 w-24 items-center justify-center rounded-full bg-base-200 text-center text-5xl font-extrabold"
				>
					<span>{{ server.name.charAt(0) }}</span>
				</div>
				<div class="space-y-2">
					<p class="text-2xl font-extrabold">
						{{ server.name }}
						<i
							v-if="form.private"
							class="fa-solid fa-lock"
						></i>
					</p>
				</div>
			</div>
			<form
				class="w-full space-y-3"
				@submit.prevent="form.submit()"
			>
				<div class="form-control">
					<label class="label cursor-pointer">
						<span class="label-text font-extrabold"
							>Private Server - If this is enabled, only members of your discord server can see
							posts.</span
						>
						<input
							type="checkbox"
							class="toggle"
							@change="form.validate('private')"
							v-model="form.private"
						/>
					</label>
					<p
						v-if="form.errors.private"
						class="text-red-500"
					>
						{{ form.errors.private }}
					</p>
				</div>
				<div class="space-x-3">
					<button
						class="btn btn-primary btn-sm"
						type="submit"
						:disabled="form.processing || !form.isDirty"
					>
						<i
							class="fa-solid fa-floppy-disk"
							v-show="!form.processing"
						></i>
						<i
							v-show="form.processing"
							class="fa-solid fa-spinner fa-spin"
						></i>

						Save
					</button>
					<button
						class="btn btn-error btn-sm"
						type="button"
						@click="deleteModal.showModal()"
					>
						<i class="fa-solid fa-trash"></i> Delete Server
					</button>
				</div>
			</form>
		</div>
	</div>
	<dialog
		ref="deleteModal"
		class="modal"
	>
		<div class="modal-box space-y-3 bg-base-300">
			<h2 class="text-xl">
				Delete <span class="font-bold">{{ server.name }}?</span>
			</h2>
			<p class="py-4 font-bold">
				Are you sure you want to delete this server? Please note the following:
			</p>
			<ol class="list-inside list-decimal space-y-2">
				<li>
					All posts associated with the server will be
					<span class="font-bold">permanently deleted.</span> We delete all data instantly, it is
					impossible to recover.
				</li>
				<li>The discord bot will automatically leave the server.</li>
				<li>The server will be recreated if the bot is used again in the discord server.</li>
			</ol>
			<form @submit.prevent="deleteForm.submit()">
				<label class="form-control w-full">
					<div class="label">
						<span class="label-text">Please type "{{ server.name }}" to confirm.</span>
					</div>
					<input
						type="text"
						placeholder="Type here"
						class="input input-bordered w-full"
						:class="{ 'input-error': deleteForm.errors.server_name }"
						v-model="deleteForm.server_name"
						@change="deleteForm.validate('server_name')"
					/>
					<div
						class="label"
						v-show="deleteForm.errors.server_name"
					>
						<span class="label-text-alt text-red-500">{{ deleteForm.errors.server_name }}</span>
					</div>
				</label>
				<div class="modal-action">
					<form method="dialog">
						<button
							@click="
								() => {
									deleteForm.reset();
									deleteForm.forgetError('server_name');
								}
							"
							class="btn btn-neutral"
						>
							Cancel
						</button>
					</form>
					<button
						:disabled="!deleteForm.isDirty || deleteForm.hasErrors"
						class="btn btn-error"
						type="submit"
					>
						<i class="fa-solid fa-trash"></i> Delete
					</button>
				</div>
			</form>
		</div>
	</dialog>
</template>
<style lang="postcss"></style>
