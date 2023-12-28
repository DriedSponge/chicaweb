<script setup>
import Layout from "./Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
defineProps({
	user: Object,
	uploads: Object,
	logged_in: Boolean
});
defineOptions({ layout: Layout });
</script>

<template>
	<Head>
		<title>Home - Chica Bot</title>
	</Head>
	<div
		v-if="logged_in"
		class="flex w-full flex-col justify-center space-y-5"
	>
		<div
			v-for="upload in uploads"
			class="rounded-xl bg-base-300 shadow-xl"
		>
			<div class="flex items-center space-x-2 p-3">
				<img
					v-if="upload.server.server_icon != null"
					class="inline h-7 w-7 rounded-full object-fill shadow-xl"
					:alt="`The icon for ${upload.server.name}`"
					:src="`https://cdn.discordapp.com/icons/${upload.server.id}/${upload.server['server_icon']}.webp?size=240`"
				/>
				<span
					v-else
					class="h-7 w-7 items-center justify-center rounded-full bg-base-100 text-center text-xl font-extrabold"
				>
					<span>{{ upload.server.name.charAt(0) }}</span>
				</span>
				<p class="flex-1">
					{{ upload.server.name }}
					<span class="text-gray-600">
						&bull; Created by {{ upload.author.name }} {{ upload.created_at_distance }}</span
					>
				</p>
				<span class="flex-0"><i class="fa-solid fa-ellipsis"></i></span>
			</div>
			<div
				class="flex flex-row items-center justify-center overflow-hidden rounded-b-xl bg-base-200"
			>
				<img
					:src="upload.raw_url"
					class="object-cover"
				/>
			</div>
		</div>
	</div>
	<div
		v-else
		class="flex h-screen w-full"
	>
		<div
			class="card mx-auto my-auto max-w-96 flex-row bg-neutral text-lg text-neutral-content shadow-xl"
		>
			<div class="card-body items-center text-center">
				<h2 class="card-title">Login</h2>
				<p>Please login to view your feed.</p>
				<div class="card-actions">
					<a
						role="button"
						href="/auth/discord"
						class="btn btn-primary text-lg text-white"
					>
						<i class="fa-brands fa-discord"></i> Login With Discord
					</a>
				</div>
			</div>
		</div>
	</div>
</template>
<style lang="postcss"></style>
