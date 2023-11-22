<script setup>
import Layout from "./Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Test from "./Test.vue";
defineProps({
	user: Object,
	servers: Object,
	logged_in: Boolean
});
</script>

<template>
	<Head>
		<title>Home</title>
	</Head>
	<Layout>
		<h1 class="mt-10 text-center text-5xl font-black text-white">
			<span v-if="!logged_in">Welcome!</span>
			<span v-else>Select A Server</span>
		</h1>
		<p v-if="logged_in">You are logged in!</p>
		<div v-if="logged_in">
			<strong class="text-white">Your Servers</strong>
			<ul class="list-inside list-disc text-white">
				<li
					:class="{ 'text-red-500': server['pivot']['is_owner'] }"
					v-for="server in servers"
				>
					{{ server.name }}
				</li>
			</ul>
		</div>
		<a
			v-if="logged_in"
			class="underline"
			href="/logout"
			>Logout</a
		>
		<a
			v-else
			class="bg-blurple hover:text-blurple rounded-lg px-3 py-2 text-center text-xl font-bold tracking-wide text-white shadow-sm transition duration-300 ease-in-out hover:bg-white hover:shadow-xl"
			href="/auth/discord"
			><i class="fa-brands fa-discord"></i> Login With Discord</a
		>
	</Layout>
</template>
<style lang="postcss"></style>
