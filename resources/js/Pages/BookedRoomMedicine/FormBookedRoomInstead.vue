<template>
    <div class="m-3">
        <Layout :can="can"/>
        <h1> Form Booked Intead </h1>
    </div>
</template>

<script setup>
import Layout from "../../Layouts/Layout";

defineProps(['can'])
</script>
