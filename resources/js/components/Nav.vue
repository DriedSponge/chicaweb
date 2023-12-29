<template>
	<div class="sticky top-3 h-auto flex-shrink self-start shadow-xl">
		<div class="flex flex-col space-y-4 rounded-lg bg-base-300 p-4">
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
			<div class="divider">Browse</div>
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
				<li v-if="$page.props.user.admin">
					<Link class="btn btn-neutral w-full"><i class="fa-solid fa-shield"></i> Admin</Link>
				</li>
			</ul>
			<div class="divider">Account</div>
			<ul class="flex flex-row justify-between space-x-2">
				<li
					class="tooltip tooltip-top w-full"
					data-tip="Profile"
				>
					<Link class="btn btn-neutral w-full"><i class="fa-solid fa-user"></i></Link>
				</li>
				<li
					class="tooltip tooltip-top w-full"
					data-tip="Settings"
				>
					<Link class="btn btn-neutral w-full"><i class="fa-solid fa-cog"></i></Link>
				</li>
				<li
					class="tooltip tooltip-top w-full"
					data-tip="Logout"
				>
					<Link
						:href="route('logout')"
						class="btn btn-neutral w-full"
						><i class="fa-solid fa-right-from-bracket"></i
					></Link>
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
	@apply hover:btn-primary;
}
.btn-neutral.active {
	@apply btn-primary;
}
</style>
