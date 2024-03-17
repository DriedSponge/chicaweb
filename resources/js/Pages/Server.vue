<script setup>
import Layout from "./Layout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
defineProps({
	server: Object,
	joined: Boolean,
	canEdit: Boolean
});
defineOptions({ layout: Layout });
</script>
<template>
	<Head>
		<title>{{server.name}}</title>
	</Head>
	<div class="flex flex-col">
        <div
            class="max-w-1/2 flex flex-col items-center rounded-xl bg-base-300 p-3 shadow-xl space-y-3"
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
            <p class="text-2xl font-extrabold">{{server.name}}</p>
            <div class="flex flex-row space-x-2">
                <div class="stat bg-base-200 shadow-xl rounded-lg">
                    <div class="stat-title text-center">Total Posts</div>
                    <div class="stat-value">{{server.totalPosts}}</div>
                </div>
                <div class="stat shadow-xl bg-base-200 shadow-xl rounded-lg">
                    <div class="stat-title  text-center">Contributors</div>
                    <div class="stat-value">{{server.totalUsers}}</div>
                    <div class="stat-actions">
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<style lang="postcss"></style>
