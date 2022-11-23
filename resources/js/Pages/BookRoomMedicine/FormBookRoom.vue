<template>
    ระบบจองห้องประชุม
    <div>
        <label for="start"> วันเวลาเริ่ม
            <InputTextComponent type="datetime-local" name="start" id="start" class="w-1/6" v-model="form.start_date"/>
        </label>

        <label for="end"> วันเวลาสิ้นสุด
            <InputTextComponent type="datetime-local"
                                name="end" id="end"
                                class="w-1/6"
                                v-model="form.end_date"/>
        </label>

        <label for="attendees"> จำนวนผู้เข้าร่วม
            <InputTextComponent type="number"
                                name="attendees" id="attendees"
                                class="w-36"
                                v-model="form.attendees"/>
        </label>

        <label for="set_room" class="cursor-pointer">

            <InputCheckboxComponent type="checkbox" name="set_room" id="set_room"
                                    v-model="form.set_room.status"/>
            ต้องการให้จัดห้องประชุม (ในการจัดห้องประชุมจะต้องเผื่อเวลา 30 นาที โดยระบบจะเพิ่มอัตโนมัติ)
        </label>

        <ButtonSubmitComponent @click="checkCondition" class="bg-amber-300 hover:bg-amber-400"
                               buttonText="ตรวจสอบเงื่อนไข"/>
    </div>
    <div v-show="result.length !== 0" v-for="room in result" :key="room.id">
        <label :for="room.id"
               :class="{
                  'text-rose-600 cursor-not-allowed': !room.available,
                  'cursor-pointer': room.available,
                }">
            <InputRadioComponent type="radio"
                                 name="meeting_room_id"
                                 :id="room.id"
                                 v-model="form.meeting_room_id"
                                 :value="room.id"
                                 :disabled="!room.available"/>
            {{ room.status }}
        </label>
    </div>
    <div v-show="form.meeting_room_id !== null">
        <label for="topic">หัวเรื่อง</label>
        <InputTextComponent name="topic" id="topic" v-model="form.topic"/>

        <label for="description">รายละเอียด</label>
        <TextareaComponent name="description" id="description" v-model="form.description"/>

        วัตถุประสงค์
        <div v-for="purpose in purpose" :key="purpose.id">
            <label :for="purpose.id">
                <InputRadioComponent name="purpose"
                                     :id="purpose.id"
                                     :value="purpose.id"
                                     v-model="form.purpose_id"/>
            </label>
        </div>

    </div>
</template>

<script setup>
import InputTextComponent from "../../Components/InputTextComponent";
import InputCheckboxComponent from "../../Components/InputCheckboxComponent";
import ButtonSubmitComponent from "../../Components/ButtonComponent";
import InputRadioComponent from "../../Components/InputRadioComponent";
import TextareaComponent from "../../Components/TextareaComponent";
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";

const form = useForm({
    start_date: null,
    end_date: null,
    attendees: null,
    set_room: {
        status: false,
    },
    meeting_room_id: null,
    topic: null,
    description: null,
    purpose_id: null,
})

const result = ref([]);
const purpose = ref([]);
const checkCondition = () => {
    window.axios
        .post(window.route("formBookRoomCheckCondition"), form)
        .then((res) => {
            console.log(res.data);
            result.value = [...res.data.result];
            result.value = [...res.data.result];
        })
        .catch((err) => console.log(err));
}

const save = () => {
    form.post(window.route("department.booking-room.store"));
    // console.log('save button')
};
</script>
