<template>
    <input type="radio"
           :value="modelValue"
           @input="$emit('update:modelValue', $event.target.value)"
           class="py-1.5 px-1 mt-2 mb-3 hover:scale-125 disabled:scale-0"/>
</template>

<script>
export default {
    name: "InputRadioComponent",
    props: {
        modelValue: String,
    },
}
</script>

<style scoped>

</style>
