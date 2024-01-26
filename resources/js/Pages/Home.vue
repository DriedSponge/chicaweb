<script setup>
import Layout from "./Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
defineProps({
	user: Object,
	uploads: Array,
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
			v-if="uploads.length === 0"
			class="rounded-lg bg-base-300 shadow-xl"
		>
			<h1 class="m-8 text-center text-2xl">There is no content to show you right now!</h1>
		</div>
		<div
			v-else
			v-for="upload in uploads"
			class="rounded-lg bg-base-300 shadow-xl"
		>
			<div class="flex items-center space-x-2 p-3">
				<img
					v-if="upload.server.server_icon != null"
					class="inline h-7 w-7 rounded-full object-fill shadow-xl"
					:alt="`The icon for ${upload.server.name}`"
					:src="`https://cdn.discordapp.com/icons/${upload.server.did}/${upload.server['server_icon']}.webp?size=240`"
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
				<div class="flex-0 space-x-2">
					<!--					<a class="btn btn-ghost btn-sm"><i class="fa-solid fa-share"></i></a>-->
					<!--					<a class="btn btn-ghost btn-sm"><i class="fa-solid fa-flag"></i></a>-->
					<div class="dropdown dropdown-end">
						<div
							tabindex="0"
							role="button"
							class=""
						>
							<a class="btn btn-ghost btn-sm">
								<i class="fa-solid fa-ellipsis"></i>
							</a>
						</div>
						<ul class="menu dropdown-content z-[1] w-52 rounded-box bg-base-100 p-2 shadow">
							<li>
								<a><i class="fa-solid fa-share"></i> Share</a>
							</li>
							<li>
								<a><i class="fa-solid fa-flag"></i> Report</a>
							</li>
							<li v-if="upload.deleteable">
								<a class="link-error"><i class="fa-solid fa-trash"></i> Delete</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div
				class="flex flex-row items-center justify-center overflow-hidden rounded-b-lg bg-base-200 p-3"
			>
				<img
					:src="upload.raw_url"
					class="object-cove rounded-lg"
				/>
			</div>
		</div>
	</div>
	<div
		v-else
		class="flex h-screen w-full"
	>
		<div
			class="card mx-auto my-auto max-w-96 flex-row bg-base-200 text-lg text-neutral-content shadow-xl"
		>
			<div class="card-body items-center text-center">
				<h2 class="card-title">Login</h2>
				<p>Please login to view your feed.</p>
				<div class="card-actions">
					<a
						role="button"
						href="/auth/discord"
						class="btn btn-info text-lg text-white"
					>
						<i class="fa-brands fa-discord"></i> Login With Discord
					</a>
				</div>
			</div>
		</div>
	</div>
</template>
<style lang="postcss"></style>
