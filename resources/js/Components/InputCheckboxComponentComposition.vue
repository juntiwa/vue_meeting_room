<template>
    <label for="date" class="flex flex-col">
        วัน
        <a-date-picker class="date"
                       name="date"
                       id="date"
                       :value="modelValue"
                       @input="$emit('update:modelValue', $event.target.value)"
                       format="DD/MM/YYYY"
                       :disabled-date="disabledDate"
        />
    </label>

    <label for="start_time" class="flex flex-col">
        เวลาเริ่ม
        <a-time-picker name="start_time"
                       id="start_time"
                       :value="modelValue"
                       @input="$emit('update:modelValue', $event.target.value)"
                       :disabledHours="disabledHours"
                       class="time"
                       format="HH:mm"/>

    </label>

    <label for="end_time" class="flex flex-col">
        เวลาสิ้นสุด
        <a-time-picker name="end_time"
                       id="end_time"
                       :value="modelValue"
                       @input="$emit('update:modelValue', $event.target.value)"
                       class="time"
                       format="HH:mm"/>

    </label>
</template>

<script setup lang="ts">
import dayjs, {Dayjs} from "dayjs";

defineProps(['modelValue']);
const disabledDate = (current: Dayjs) => {
    return current && current < dayjs().endOf('day').add(-1, 'day');
};

const disabledHours = () => {
    const hours = [];

    let current = Dayjs;

    const currentHour = dayjs().hour();
    for (let i = currentHour - 1; i >= 0; i--) {
        hours.push(i);
    }
    for (let i = 18; i <= 24; i++) {
        hours.push(i);
    }
    return hours;
};
</script>
