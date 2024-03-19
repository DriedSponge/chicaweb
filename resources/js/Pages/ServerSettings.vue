<script setup>
import Layout from "./Layout.vue";
import { Head } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "laravel-precognition-vue-inertia";
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
function submit() {
	form.submit();
}
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
				@submit.prevent="
					form.put(route('server.settings.save', { server_id: usePage().props.server.did }))
				"
			>
				<div class="form-control">
					<label class="label cursor-pointer">
						<span class="label-text font-extrabold"
							>Private Server - If this is enabled, only members of your discord server can see
							post.</span
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
					>
						Delete Server
					</button>
				</div>
			</form>
		</div>
	</div>
	{{ server }}
</template>
<style lang="postcss"></style>
