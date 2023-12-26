<script setup>
import { Link } from "@inertiajs/vue3";
import Nav from "../components/Nav.vue";
</script>
<template>
	<div class="flex flex-row">
		<Nav></Nav>
		<main class="flex w-full flex-col">
			<div class="flex flex-col">
				<div class="container mx-auto max-w-5xl flex-1 px-3 xl:px-0">
					<slot></slot>
				</div>
			</div>
		</main>
	</div>
</template>
