<template>
    <label :for="name" class="cursor-pointer">
        <input type="checkbox"
               :name="name"
               :id="name"
               :checked="modelValue"
               @change="$emit('update:modelValue', !modelValue)"
               class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3 cursor-pointer
                 hover:scale-125 disabled:scale-100"/>
        {{ label }}
    </label>
</template>

<script setup>
defineProps(['modelValue', 'label', 'name']);
defineEmits(['update:modelValue'])
</script>
