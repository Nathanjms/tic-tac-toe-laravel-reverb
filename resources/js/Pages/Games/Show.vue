<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed } from "vue";
import { useGameState, gameStates } from "@/Composables/useGameState";

const props = defineProps(["game"]);

// Crosses are -1, noughts are 1
const boardState = ref([0, 0, 0, 0, 0, 0, 0, 0, 0]);

const gameState = useGameState();

const isXTurn = computed(
    () => boardState.value.reduce((carry, value) => carry + value, 0) === 0
);

const lines = [
    // rows
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    // columns
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    // diagonals
    [0, 4, 8],
    [2, 4, 6],
];

const fillSquare = (index) => {
    boardState.value[index] = isXTurn.value ? -1 : 1;

    // Check for a win;
    const winningLine = lines
        .map((line) =>
            line.reduce((carry, index) => carry + boardState.value[index], 0)
        )
        .find((sum) => Math.abs(sum) === 3);

    if (winningLine === -3) {
        alert("X wins!");
        resetBoard();
        return;
    }

    if (winningLine === 3) {
        alert("O wins!");
        resetBoard();
        return;
    }

    if (boardState.value.every((square) => square !== 0)) {
        alert("Draw!");
        resetBoard();
        return;
    }
};

const resetBoard = () => {
    boardState.value = [0, 0, 0, 0, 0, 0, 0, 0, 0];

    gameState.change(gameStates.InProgress);
};

Echo.join(`game.${props.game.id}`).here((users) => {});
</script>

<template>
    <AuthenticatedLayout>
        <menu class="grid grid-cols-3 gap-1.5 w-0 min-w-fit mx-auto mt-12">
            <li
                v-for="(square, index) in boardState"
                :key="square"
                class="bg-gray-300 size-32 grid place-items-center text-4xl"
            >
                <button
                    v-if="square === 0"
                    @click="() => fillSquare(index)"
                    class="place-self-stretch bg-gray-200 hover:bg-gray-300 transition-colors"
                ></button>
                <span v-else>{{ square === -1 ? "X" : "O" }}</span>
            </li>
        </menu>

        <ul class="max-w-sm mx-auto mt-6 space-y-2 flex justify-between">
            <li class="flex items-center">
                <span class="px-1.5 font-bold rounded bg-gray-200">X</span>
                <span>{{ game.player_one?.name }}</span>
                <span class="bg-red-500 size-2 rounded-full"></span>
            </li>
            <li v-if="game.player_two" class="flex items-center">
                <span class="p-1.5 font-bold rounded bg-gray-200">O</span>
                <span>{{ game.player_two?.name }}</span>
                <span class="bg-red-500 size-2 rounded-full"></span>
            </li>
            <li v-else>
                <span>Waiting for player 2</span>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>
