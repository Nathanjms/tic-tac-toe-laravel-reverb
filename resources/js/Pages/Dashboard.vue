<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const props = defineProps(["games"]);

const games = ref(props.games.data);

Echo.private("lobby")
    .listen("GameJoined", (e) => {
        console.log(e);
        games.value = games.value.filter((game) => game.id !== e.game.id);
    })
    .listen("GameCreated", (e) => {
        console.log(e);

        if (e.game.player_one_id !== page.props.auth.user.id) {
            // Add to the FRONT of the list:
            games.value.unshift(e.game);
        } else {
            console.log("I am player one");
        }
    });
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-4 px-6"
                >
                    <Link
                        :href="route('games.store')"
                        as="button"
                        method="post"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        >Create Game</Link
                    >
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-4 px-6"
                >
                    <ul class="divide-y divide-gray-200">
                        <li
                            class="py-3 px-2 flex justify-between items-center"
                            v-for="game in games"
                            :key="game.id"
                        >
                            <span class="flex flex-col">
                                <span>{{ game.player_one.name }}</span>
                                <span class="text-gray-500 text-xs">{{
                                    game.human_timestamp
                                }}</span>
                            </span>
                            <Link
                                method="post"
                                as="button"
                                :href="route('games.join', game.id)"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                >Join game</Link
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
