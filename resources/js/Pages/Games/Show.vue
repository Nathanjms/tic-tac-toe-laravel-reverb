<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed } from "vue";

// Crosses are -1, noughts are 1
const boardState = ref([0, 0, 0, 0, 0, 0, 0, 0, 0]);

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
        return;
    }

    if (winningLine === 3) {
        alert("O wins!");
        return;
    }

    if (boardState.value.every((square) => square !== 0)) {
        alert("Draw!");
        return;
    }
};
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
    </AuthenticatedLayout>
</template>
