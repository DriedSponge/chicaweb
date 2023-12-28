<template>
	<div class="sticky top-3 h-auto flex-shrink self-start shadow-xl">
		<div class="flex flex-col space-y-3 rounded-xl bg-base-300 p-4">
			<div class="flex items-center space-x-3">
				<img
					alt="Your profile picture!"
					:src="$page.props.user.avatar"
					class="h-12 w-12 rounded-full"
				/>
				<p>
					Welcome <span class="font-bold">{{ $page.props.user.name }}</span
					>!
				</p>
			</div>
			<hr />
			<ul class="space-y-3">
				<li>
					<Link
						:href="route('home')"
						class="btn btn-neutral w-full"
						:class="{ active: route().current() === 'home' }"
						><i class="fa-solid fa-home"></i> Home
					</Link>
				</li>
				<li>
					<Link
						:href="route('servers')"
						class="btn btn-neutral w-full"
						:class="{ active: route().current() === 'servers' }"
						><i class="fa-brands fa-discord"></i> Servers</Link
					>
				</li>
			</ul>
			<hr />
			<ul class="space-y-3">
				<li>
					<Link class="btn btn-neutral w-full"><i class="fa-solid fa-user"></i> Profile</Link>
				</li>
				<li>
					<Link class="btn btn-neutral w-full"><i class="fa-solid fa-cog"></i> Settings</Link>
				</li>
				<li>
					<Link
						:href="route('logout')"
						class="btn btn-neutral w-full"
						><i class="fa-solid fa-right-from-bracket"></i> Logout</Link
					>
				</li>
			</ul>
		</div>
	</div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<style lang="postcss" scoped>
.btn-neutral {
	@apply hover:btn-primary hover:text-white;
}
.btn-neutral.active {
	@apply btn-primary text-white;
}
</style>
