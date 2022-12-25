<template>
    <label :for="name" class="flex flex-col">
        {{ label }}
        <input :type="type"
               :name="name"
               :id="name"
               :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value)"
               class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3"/>
    </label>
</template>

<script setup>
defineProps(['modelValue', 'label', 'name', 'type', 'modelValue']);

</script>
