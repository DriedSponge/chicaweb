<script setup>
import Layout from "./Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
defineProps({
	server: Object,
	joined: Boolean,
	canEdit: Boolean
});
defineOptions({ layout: Layout });
</script>
<template>
	<Head>
		<title>Server</title>
	</Head>
	<div class="flex flex-col space-y-3">{{ joined }}{{ canEdit }}</div>
</template>
<style lang="postcss"></style>
