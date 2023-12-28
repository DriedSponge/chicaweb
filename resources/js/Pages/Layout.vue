<script setup>
import { Link } from "@inertiajs/vue3";
import Nav from "../components/Nav.vue";
</script>
<template>
	<main class="mt-4 flex flex-row justify-center space-x-5">
		<div class="container max-w-4xl">
			<slot></slot>
		</div>
		<Nav v-if="$page.props.logged_in"></Nav>
	</main>
</template>
