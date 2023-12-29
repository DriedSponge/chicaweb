<script setup>
import Layout from "./Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
defineProps({
	servers: Object
});
defineOptions({ layout: Layout });
</script>

<template>
	<Head>
		<title>My Servers</title>
	</Head>
	<div class="flex flex-col space-y-3">
		<div
			v-for="server in servers"
			class="max-w-3/4 flex max-h-32 flex-row items-center space-x-3 rounded-xl bg-base-300 p-3 shadow-xl hover:cursor-pointer"
		>
			<div class="h-full">
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
			</div>
			<p class="text-right text-xl font-extrabold">{{ server.name }}</p>
		</div>
	</div>
</template>
<style lang="postcss"></style>
