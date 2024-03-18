<script setup>
import Layout from "./Layout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
defineProps({
	server: Object,
	perms: Object
});
defineOptions({ layout: Layout });
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
							v-if="server.private"
							class="fa-solid fa-lock"
						></i>
					</p>
					<div class="space-x-2">
						<div class="btn btn-sm pointer-events-none">
							Posts
							<div class="badge badge-primary">{{ server.totalPosts }}</div>
						</div>
						<div class="btn btn-sm pointer-events-none">
							Contributors
							<div class="badge badge-primary">{{ server.totalUsers }}</div>
						</div>
						<button
							class="btn btn-sm"
							v-if="perms.canLeave"
						>
							Leave
						</button>
						<Link
							:href="route('server.settings', server.did)"
							class="btn btn-sm"
							v-if="perms.canEdit"
						>
							Settings
						</Link>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{ server }}
</template>
<style lang="postcss"></style>
