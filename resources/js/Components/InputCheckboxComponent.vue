<template>
    <input type="checkbox"
           :value="modelValue"
           @input="$emit('update:modelValue', $event.target.value)"
           class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3 cursor-pointer"/>
</template>

<script>
export default {
    name: "InputCheckboxComponent",
    props: {
        modelValue: String,
    },
}
</script>

<style scoped>

</style>
