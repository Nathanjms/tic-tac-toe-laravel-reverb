<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed } from "vue";

const boardState = ref([0, 0, 0, 0, 0, 0, 0, 0, 0]);

const isXTurn = computed(
    () => boardState.value.reduce((carry, value) => carry + value, 0) === 0
);

const fillSquare = (index) => {
    boardState.value[index] = isXTurn.value ? -1 : 1;
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
