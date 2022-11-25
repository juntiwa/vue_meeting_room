<template>
    <button type="submit" class="my-3 px-2 py-1.5 rounded disabled:bg-slate-500 disabled:text-slate-100"> {{buttonText}}</button>
</template>

<script>
export default {
    name: "ButtonComponent",
    props: {
        buttonText: {
            type: String,
            default: () => "Submit",
        }
    }
}
</script>

<style scoped>

</style>
