<template>
    ระบบจองห้องประชุม
    <div>
        <label for="start"> วันเวลาเริ่ม
            <InputTextComponent type="datetime-local" name="start" id="start" class="w-1/6" v-model="form.start"/>
        </label>

        <label for="end"> วันเวลาสิ้นสุด
            <InputTextComponent type="datetime-local" name="end" id="end" class="w-1/6" v-model="form.end"/>
        </label>

        <label for="attendees"> จำนวนผู้เข้าร่วม
            <InputTextComponent type="number" name="attendees" id="attendees" class="w-36" v-model="form.attendees"/>
        </label>

        <label for="set_room" class="cursor-pointer">
            <InputCheckboxComponent name="set_room" id="set_room" /> ต้องการให้จัดห้องประชุม (ในการจัดห้องประชุมจะต้องเผื่อเวลา 30 นาที โดยระบบจะเพิ่มอัตโนมัติ)
        </label>
    </div>
</template>

<script setup>
import InputTextComponent from "../../Components/InputTextComponent";
import {useForm} from "@inertiajs/inertia-vue3";
import InputCheckboxComponent from "../../Components/InputCheckboxComponent";

const form = useForm({
    start: null,
    end: null,
    attendees: null,
    set_room: null,
})
</script>
