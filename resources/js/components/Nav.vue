<template>
	<nav class="sticky left-0 top-0 z-10 h-screen w-36 bg-base-200 shadow-xl">
		<div class="flex h-full flex-col">
			<div class="flex-0">
				<a class="btn btn-ghost text-2xl">Chica Bot</a>
			</div>
			<ul class="flex-0 menu bg-base-200 text-left text-lg font-bold">
				<li>
					<Link
						class="tooltip tooltip-right text-left"
						data-tip="Home"
						href="/"
						:class="{ active: $page.props.route === 'home' }"
					>
						<div
							class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-2xl font-extrabold"
						>
							<i class="fa-solid fa-home"></i>
						</div>
					</Link>
				</li>
				<li>
					<Link
						class="tooltip tooltip-right text-left"
						data-tip="Your Servers"
						href="/servers"
						:class="{ active: $page.props.route === 'servers' }"
					>
						<div
							class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-5xl font-extrabold"
						>
							<i class="fa-brands fa-discord"></i>
						</div>
					</Link>
				</li>
				<li>
					<Link
						class="tooltip tooltip-right text-left"
						data-tip="Your Profile"
						href="/"
						:class="{ active: $page.props.route === `/profile/${$page.props.user.id}` }"
					>
						<div
							class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-2xl font-extrabold"
						>
							<img
								:src="$page.props.user.avatar"
								alt="Your Avatar"
								class="h-24 w-24 rounded-full object-cover"
							/>
						</div>
					</Link>
				</li>
				<li>
					<Link
						class="tooltip tooltip-right text-left"
						data-tip="Settings"
						href="/settings"
						:class="{ active: $page.props.route === `settings` }"
					>
						<div
							class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-2xl font-extrabold"
						>
							<div
								class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-5xl font-extrabold"
							>
								<i class="fa-solid fa-cog"></i>
							</div>
						</div>
					</Link>
				</li>
				<li>
					<Link
						class="tooltip tooltip-right text-left"
						data-tip="Admin"
						href="/admin"
						:class="{ active: $page.props.route === `admin` }"
					>
						<div
							class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-2xl font-extrabold"
						>
							<div
								class="flex h-24 w-24 flex-row items-center justify-center rounded-full bg-base-300 text-5xl font-extrabold"
							>
								<i class="fa-solid fa-shield"></i>
							</div>
						</div>
					</Link>
				</li>
			</ul>
		</div>
	</nav>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
