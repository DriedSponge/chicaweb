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
		<h1>
			Welcome <span v-if="logged_in">{{ user.name }}</span>
		</h1>
		<p v-if="logged_in">You are logged in!</p>
		<div v-if="logged_in">
			<strong>Your Servers</strong>
			<ul class="list-inside list-disc">
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
			v-if="!logged_in"
			class="underline"
			href="/auth/discord"
			>Login</a
		>
	</Layout>
</template>
