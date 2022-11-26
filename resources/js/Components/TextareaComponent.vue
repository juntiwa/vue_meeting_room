<template>
    <textarea :value="modelValue"
              @input="$emit('update:modelValue', $event.target.value)"
              class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3 h-24"></textarea>
</template>

<script>
export default {
    name: "TextareaComponent",
    props: {
        modelValue: String,
    },
}
</script>

<style scoped>

</style>
