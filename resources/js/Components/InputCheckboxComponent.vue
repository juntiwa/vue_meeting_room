<template>
    <input type="checkbox"
           :value="modelValueCheck"
           @input="$emit('update:modelValueCheck', $event.target.value)"
           class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3 cursor-pointer"/>
</template>

<script>
export default {
    name: "InputCheckboxComponent",
    props: {
        modelValueCheck: Boolean,
    },
}
</script>

<style scoped>

</style>
