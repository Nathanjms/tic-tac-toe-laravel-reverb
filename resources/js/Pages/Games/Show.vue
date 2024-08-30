<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        Testing!
        {{ $page.props }}
    </AuthenticatedLayout>
</template>
