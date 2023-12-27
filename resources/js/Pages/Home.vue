<script setup>
import Layout from "./Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
defineProps({
	user: Object,
	uploads: Object,
	logged_in: Boolean
});
</script>

<template>
	<Head>
		<title>Home</title>
	</Head>
	<Layout v-if="logged_in">
		<ul>
			<li v-for="upload in uploads">
				{{ upload }}
			</li>
		</ul>
	</Layout>
	<div
		v-if="!logged_in"
		class="flex h-screen w-full"
	>
		<div class="card mx-auto my-auto max-w-96 flex-row bg-neutral text-lg text-neutral-content">
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
