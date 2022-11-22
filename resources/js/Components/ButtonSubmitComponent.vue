<template>
    <button type="submit" class="my-3 px-2 py-1.5 rounded w-full"> {{buttonText}}</button>
</template>

<script>
export default {
    name: "ButtonSubmitComponent",
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
