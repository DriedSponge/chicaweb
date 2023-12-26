<template>
	<nav class="sticky left-0 top-0 z-10 h-screen w-1/6 bg-base-200">
		<div class="flex-1">
			<a class="btn btn-ghost text-xl">Chica Web</a>
		</div>
		<ul class="menu bg-base-200 text-left text-lg font-bold">
			<li>
				<Link
					class="hover:cursor tooltip tooltip-right text-left"
					data-tip="Home"
					href="/"
					:class="{ active: $page.props.route === 'home' }"
				>
					<i class="fa-solid fa-house"></i> Home
				</Link>
			</li>
			<li>
				<Link
					class="tooltip tooltip-right text-left"
					data-tip="View The Servers You're In"
					href="/servers"
					:class="{ active: $page.props.route === 'servers' }"
				>
					<i class="fa-brands fa-discord"></i> My Servers
				</Link>
			</li>
			<li>
				<a
					class="tooltip tooltip-right text-left"
					data-tip="View Your Profile"
				>
					My Profile
				</a>
			</li>
			<li v-if="$page.props.logged_in">
				<a
					class="tooltip tooltip-right text-left"
					data-tip="Stats"
				>
					<i class="fa-solid fa-right-from-bracket"></i> Logout
				</a>
			</li>
		</ul>
	</nav>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
