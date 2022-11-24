<template>
    <div class="m-3">
        ระบบจองห้องประชุม
        <section id="condition" class="flex flex-col">
            <label for="start"> วันเวลาเริ่ม
                <InputTextComponent type="datetime-local" name="start" id="start" class="w-1/6"
                                    v-model="form.start_date"/>
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

            <label for="set_room[status]"
                   class="cursor-pointer">

                <input type="checkbox" name="set_room[status]" id="set_room[status]"
                       v-model="form.set_room.status"/>
                ต้องการให้จัดห้องประชุม (ในการจัดห้องประชุมจะต้องเผื่อเวลา 30 นาที โดยระบบจะเพิ่มอัตโนมัติ
                และระบบจะแสดงเฉพาะห้องที่สามารถเปลี่ยนแปลงรูปแบบโต๊ะได้เท่านั้น)
            </label>

            {{messageCalculateTime}} {{messageAttendeesInvalid}}
            <ButtonComponent @click="checkCondition"
                             class="bg-amber-300 hover:bg-amber-400 w-fit"
                             buttonText="ตรวจสอบเงื่อนไข"/>
        </section>
        <section id="room" v-show="result.length !== 0" v-for="room in result" :key="room.id">
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
        </section>
        <section id="detail" v-show="form.meeting_room_id !== null" class="flex flex-col w-1/2">
            <label for="topic">หัวเรื่อง</label>
            <InputTextComponent name="topic" id="topic" v-model="form.topic"/>

            <label for="description">รายละเอียด</label>
            <TextareaComponent name="description" id="description" v-model="form.description"/>

            <div id="purpose">
                วัตถุประสงค์
                <div v-for="purpose in purposes" :key="purpose.id">
                    <label :for="purpose.id">
                        <InputRadioComponent name="purpose_id"
                                             :id="purpose.id"
                                             :value="purpose.id"
                                             v-model="form.purpose_id"/>
                        {{ purpose.name_th }}
                    </label>
                </div>
            </div>

            <div id="type_room" v-show="form.set_room.status === true">
                รูปแบบโต๊ะที่ต้องการ
                <label for="u_shape">
                    <InputRadioComponent name="set_room[type_table]"
                                         id="u_shape"
                                         value="u_shape"
                                         v-model="form.set_room.type_table"/>
                    รูปตัว U (U_shape)
                </label>
                <label for="classroom">
                    <InputRadioComponent name="set_room[type_table]"
                                         id="classroom"
                                         value="classroom"
                                         v-model="form.set_room.type_table"/>
                    แบบ Classroom หรือ Lecture
                </label>
                <label for="groups">
                    <InputRadioComponent name="set_room[type_table]"
                                         id="groups"
                                         value="groups"
                                         v-model="form.set_room.type_table"/>
                    แบบกลุ่ม
                    <div v-show="form.set_room.type_table === 'groups'">
                        จำนวน
                        <InputTextComponent type="number"
                                            name="set_room[number_group]"
                                            id="number_group"
                                            v-model="form.set_room.number_group"/>
                        กลุ่ม กลุ่มละ
                        <InputTextComponent type="number"
                                            name="set_room[each_group]"
                                            id="each_group"
                                            v-model="form.set_room.each_group"/>
                        คน

                    </div>
                </label>
            </div>

            <div id="equipment" class="flex flex-col">
                อุปกรณ์ที่ต้องการ
                <label for="computer"
                >เครื่องคอมพิวเตอร์
                    <InputTextComponent
                        type="number"
                        name="equipment[computer]"
                        id="computer"
                        v-model="form.equipment.computer"
                    />
                </label>
                <label for="lcdprojector"
                >เครื่อง LCD Projector
                    <InputTextComponent
                        type="number"
                        name="equipment[lcdprojector]"
                        id="lcdprojector"
                        v-model="form.equipment.lcdprojector"
                    />
                </label>
                <label for="visualizer"
                >เครื่อง Visualizer
                    <InputTextComponent
                        type="number"
                        name="equipment[visualizer]"
                        id="visualizer"
                        v-model="form.equipment.visualizer"
                    />
                </label>
                <label for="sound"
                >ระบบเสียง
                    <InputTextComponent
                        type="number"
                        name="equipment[sound]"
                        id="sound"
                        v-model="form.equipment.sound"
                    />
                </label>
                <label for="other"
                >อุปกรณ์อื่น ๆ (ถ้ามี)
                    <InputTextComponent
                        type="text"
                        name="equipment[other]"
                        id="input_other"
                        placeholder="โปรดระบุ"
                        v-model="form.equipment.other"
                    />
                </label>
                <label for="notebook">
                    <input type="checkbox"
                           name="equipment[notebook]"
                           id="notebook"
                           v-model="form.equipment.notebook">
                    นำโน้ตบุ๊คมาเอง
                </label>
            </div>

            <div id="food" class="flex flex-col">
                <label for="food[status]">
                    <input type="checkbox"
                           name="food[status]" id="food[status]"
                           v-model="form.food.status">
                    ต้องการอาหารกลางวัน อาหารว่าง หรือเครื่องดื่ม
                </label>
                <div v-show="form.food.status === true">
                    <label for="food[lunch]"> อาหารกลางวัน
                        <InputTextComponent type="number"
                                            name="food[lunch]" id="food[lunch]"
                                            v-model="form.food.lunch"/>
                    </label>
                    <label for="food[snack]"> อาหารว่าง
                        <InputTextComponent type="number"
                                            name="food[snack]" id="food[snack]"
                                            v-model="form.food.snack"/>
                    </label>
                    <label for="food[drink]"> เครื่องดื่ม
                        <InputTextComponent type="number"
                                            name="food[drink]" id="food[drink]"
                                            v-model="form.food.drink"/>
                    </label>

                    <label for="food[note]"> หมายเหตุ(ถ้ามี)
                        <InputTextComponent type="text"
                                            name="food[note]" id="food[note]"
                                            v-model="form.food.note" placeholder="แพ้อาหารทะเล เป็นต้น"/>
                    </label>

                </div>
            </div>

            <ButtonComponent
                @click="save"
                class="bg-teal-600 hover:bg-teal-700 text-white"
                buttonText="บันทึกข้อมูล"/>
        </section>
    </div>

</template>

<script setup>
import InputTextComponent from "../../Components/InputTextComponent";
import InputCheckboxComponent from "../../Components/InputCheckboxComponent";
import InputRadioComponent from "../../Components/InputRadioComponent";
import TextareaComponent from "../../Components/TextareaComponent";
import ButtonComponent from "../../Components/ButtonComponent";
import {useForm} from "@inertiajs/inertia-vue3";
import {computed, ref, watch} from "vue";
import dayjs from "dayjs";

const form = useForm({
    start_date: null,
    end_date: null,
    attendees: null,
    set_room: {
        status: false,
        type_table: null,
        number_group: '0',
        each_group: '0',
    },
    meeting_room_id: null,
    topic: null,
    description: null,
    purpose_id: null,
    equipment: {
        computer: '0',
        lcdprojector: '0',
        visualizer: '0',
        sound: '0',
        other: null,
        notebook: false
    },
    food: {
        status: false,
        lunch: '0',
        snack: '0',
        drink: '0',
        note: null
    }
})
const result = ref([]);
const purposes = ref([]);
const checkCondition = () => {
    window.axios
        .post(window.route("formBookRoomCheckCondition"), form)
        .then((res) => {
            console.log(res.data);
            result.value = [...res.data.result];
            purposes.value = [...res.data.purposes];
        })
        .catch((err) => console.log(err));
}
const save = () => {
    form.post(window.route("formBookRoomStore"));
    // console.log('save button')
};

const messageCalculateTime = ref(null);
watch(
    () => [form.end_date, form.start_date],
    (val) => {
        if (val) {
            const end = dayjs(form.end_date);
            const diffTime = end.diff(form.start_date, "minute", true);
            const Hours = Math.floor(diffTime / 60);
            const Minute = diffTime % 60;
            if (Hours > 0) {
                messageCalculateTime.value = "เวลาใช้งานจำนวน " + Hours + " ชั่วโมง " + Minute + " นาที";
            } else if (Hours === 0) {
                messageCalculateTime.value = "เวลาใช้งานจำนวน " + Minute + " นาที";
            } else {
                messageCalculateTime.value = "กรุณาตรวจสอบเวลาอีกครั้ง";
            }
        }
    }
)

const messageAttendeesInvalid = ref(null)
watch(
    () => form.attendees,
    (val) => {
        if (val < 3 || val > 200) {
            messageAttendeesInvalid.value = 'กรุณาระบุจำนวนมากกว่า 3 หรือ น้อยกว่า 200'
        }else{
            messageAttendeesInvalid.value = null
        }
    }
)

const conditionInCompleted = computed(() => {
    return !form.start_date || !form.end_date
})
</script>
