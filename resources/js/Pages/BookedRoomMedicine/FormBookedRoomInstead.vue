<template>
    <Layout :can="can"/>
    <div class="m-3">
        ระบบจองห้องประชุม

        <section id="condition" class="flex flex-col">
            กรอกข้อมูลการขอใช้งานห้องประชุม
            <div id="date_time" class="flex flex-row gap-2 mb-3">
                <label for="date" class="flex flex-col">
                    วัน
                    <a-date-picker class="date"
                                   name="date"
                                   id="date"
                                   v-model:value="form.date"
                                   format="DD/MM/YYYY"
                                   :disabled-date="disabledDate"
                                   placeholder="เลือกวันที่ต้องการ"
                    />
                </label>
                <label for="start_time" class="flex flex-col">
                    เวลาเริ่ม
                    <a-time-picker name="start_time"
                                   id="start_time"
                                   v-model:value="form.start_time"
                                   :disabledHours="disabledHours"
                                   :disabledMinutes="disabledMinutes"
                                   :hideDisabledOptions="true"
                                   :disabled="form.date === null"
                                   class="time"
                                   placeholder="เลือกเวลาที่ต้องการ"
                                   format="HH:mm"/>
                </label>
                <label for="end_time" class="flex flex-col">
                    เวลาสิ้นสุด
                    <a-time-picker name="end_time"
                                   id="end_time"
                                   v-model:value="form.end_time"
                                   :disabledHours="disabledHours"
                                   :disabledMinutes="disabledMinutes"
                                   :hideDisabledOptions="true"
                                   :disabled="form.date === null"
                                   class="time"
                                   placeholder="เลือกเวลาที่ต้องการ"
                                   format="HH:mm"/>
                </label>
            </div>
            <p :class="{
                'text-teal-600': statusMessageCalculateTime,
                'text-rose-600': !statusMessageCalculateTime,
            }">{{ messageCalculateTime }}</p>


            <InputTextComponent label="จำนวนผู้เข้าร่วม"
                                type="number"
                                name="attendees"
                                class="w-fit"
                                v-model="form.attendees"
            />

            {{ messageAttendeesInvalid }}

            <InputCheckboxComponent
                label="ต้องการให้จัดห้องประชุม (ในการจัดห้องประชุมจะต้องเผื่อเวลา 30 นาที โดยระบบจะเพิ่มอัตโนมัติ
                และระบบจะแสดงเฉพาะห้องที่สามารถเปลี่ยนแปลงรูปแบบโต๊ะได้เท่านั้น)"
                name="setRoomStatus"
                v-model="form.set_room.status"/>


            <ButtonComponent @click="checkCondition"
                             class="bg-amber-300 hover:bg-amber-400 w-fit"
                             :disabled="conditionIncompleted"
                             buttonText="ตรวจสอบเงื่อนไข"/>
        </section>
        <section id="room" v-show="result.length !== 0">
            เลือกห้องประชุมที่ต้องการจอง
            <div v-for="room in result" :key="room.id">
                <label :for="'room' + room.id"
                       :class="{
                  'text-rose-600 cursor-not-allowed': !room.available,
                  'cursor-pointer': room.available,
                }">
                    <InputRadioComponent type="radio"
                                         name="meeting_room_id"
                                         :id="'room' + room.id"
                                         v-model="form.meeting_room_id"
                                         :value="room.id"
                                         :disabled="!room.available"/>
                    {{ room.status }}
                </label>
            </div>

        </section>
        <section id="detail" v-show="form.meeting_room_id !== null"
                 class="flex flex-col w-1/2">
            กรอกรายละเอียดการขอใช้งานห้องประชุม
            <label>ประเภทหน่วยงาน</label>
            <select v-model="form.unit_level" class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3">
                <option value="">เลือกประเภทหน่วยงาน</option>
                <option v-for="level in unitLevel" :value="level.id">
                    {{ level.name_th }}
                </option>
            </select>

            <label>ชื่อหน่วยงาน</label>
            <select v-model="form.unit_id" class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3">
                <option value="">เลือกหน่วยงาน</option>

                <option v-if="form.unit_level === 1" v-for="inner in inners" :value="inner.id">
                    {{ inner.name_th }}
                </option>
                <option v-if="form.unit_level === 2" v-for="outter in outters" :value="outter.id">
                    {{ outter.name_th }}
                </option>
                <option v-if="form.unit_level === 3" v-for="company in company" :value="company.id">
                    {{ company.name_th }}
                </option>
            </select>
            <label for="topic">หัวเรื่อง</label>
            <InputTextComponent name="topic" id="topic" v-model="form.topic"/>

            <label for="description">รายละเอียด</label>
            <TextareaComponent name="description" id="description" v-model="form.description"/>

            <div id="purpose">
                วัตถุประสงค์
                <div v-for="purpose in purposes" :key="purpose.id">
                    <label :for="'purpose' + purpose.id" class="cursor-pointer">
                        <InputRadioComponent name="purpose_id"
                                             :id="'purpose' + purpose.id"
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
                :disabled="detailIncomplete"
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
import Layout from "../../Layouts/Layout";

const props = defineProps(['messageError', 'can', 'params']);
const form = useForm({
    date: ref(dayjs('2023-01-04')),
    start_time: null,
    end_time: null,
    start_date: null,
    end_date: null,
    attendees: "24",
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
    },

    unit_level: "",
    unit_id: ""
})
const result = ref([]);
const purposes = ref([]);
const unitLevel = ref([]);
const inners = ref([]);
const outters = ref([]);
const company = ref([]);
const statusMessageCalculateTime = ref(null);
const messageCalculateTime = ref(null);
const messageAttendeesInvalid = ref(null)

const disabledDate = function (current) {
    // Can not select days before today
    return current < dayjs().endOf('day').add(-1, 'day');
};
const disabledHours = () => {
    const hours = [];
    let date = dayjs(form.date).format('DD/MM/YYYY')
    let now = dayjs().format('DD/MM/YYYY')
    if (date === now) {
        const currentHour = dayjs().hour();
        for (let i = currentHour - 1; i >= 0; i--) {
            hours.push(i);
        }
        for (let i = 18; i <= 24; i++) {
            hours.push(i);
        }
        return hours;
    } else {
        for (let i = 0; i <= 5; i++) {
            hours.push(i);
        }
        for (let i = 17; i <= 24; i++) {
            hours.push(i);
        }
        return hours;
    }
};
const disabledMinutes = () => {
    let minutes = [];
    let date = dayjs(form.date).format('DD/MM/YYYY')
    let now = dayjs().format('DD/MM/YYYY')
    if (date === now) {
        const currentMinute = dayjs().minute();
        for (let i = currentMinute - 1; i >= 0; i--) {
            minutes.push(i);
        }
        return minutes;
    }
}

const checkCondition = () => {
    result.value = [];
    form.meeting_room_id = null;
    window.axios
        .post(window.route("formBookRoomInsteadCheckCondition"), form)
        .then((res) => {
            // console.log(res.data);
            result.value = [...res.data.result];
            purposes.value = [...res.data.purposes];
            unitLevel.value = [...res.data.unitLevel];
            inners.value = [...res.data.inners];
            outters.value = [...res.data.outters];
            company.value = [...res.data.company];
        })
        .catch((err) => console.log(err));
};
const save = () => {
    form.post(window.route("formBookRoomInsteadStore"));
};

const conditionIncompleted = computed(() => {
    return !form.date || !form.start_time || !form.end_time || !form.attendees || !(form.attendees >= 3)
})
const detailIncomplete = computed(() => {
    /**
     * ตรวจสอบเงื่อนไข ถ้าสถานะจัดห้อง = true
     * ตรวจสอบ type_table = groups หรือไม่ ถ้าใช่ ห้ามเว้นว่าง หัวเรื่อง วัตถุประสงค์ รูปแบบห้อง จำนวนกลุ่ม และจำนวนคนต่อกลุ่ม
     * ถ้าไม่ใช่ ห้ามเว้นว่าง หัวเรื่อง วัตถุประสงค์ และรูปแบบห้อง
     *
     * สถานะการจัดห้อง != true
     * ห้ามเว้นว่าง หัวเรื่อง และ วัตถุประสงค์
     */
    if (form.set_room.status === true) {
        if (form.set_room.type_table === 'groups') {
            return !form.topic || !form.purpose_id || !form.set_room.type_table || !(form.set_room.each_group > 0) || !(form.set_room.number_group > 0)
        } else {
            return !form.topic || !form.purpose_id || !form.set_room.type_table
        }
    } else {
        return !form.topic || !form.purpose_id
    }

})

watch(
    () => props.messageError,
    (val) => {
        // console.log(props.messageError)
        if (props.messageError === 'true') {
            const Toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', swal.stopTimer)
                    toast.addEventListener('mouseleave', swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'ไม่สำเร็จ',
                text: 'กรุณาเลือกเวลาจองใหม่อีกครั้ง เนื่องจากมีเวลาที่เลือกถูกเลือกเเล้ว'
            })
        }
    }
)

watch(
    () => [form.start_time, form.end_time],
    (val) => {
        if (val) {
            let end = dayjs(form.end_time);
            let diffTimeMinute = end.diff(form.start_time, "minute", true);
            let Hours = end.diff(form.start_time, "hour", false);
            let Minute = Math.round(diffTimeMinute % 60);
            // console.log(Minute)
            if (Hours > 0) {
                statusMessageCalculateTime.value = true
                messageCalculateTime.value = "เวลาใช้งานจำนวน " + Hours + " ชั่วโมง " + Minute + " นาที";
                if (Minute === 0) {
                    messageCalculateTime.value = "เวลาใช้งานจำนวน " + Hours + " ชั่วโมง ";
                }

                if (Minute === 60) {
                    messageCalculateTime.value = "เวลาใช้งานจำนวน " + (Hours + 1) + " ชั่วโมง ";
                }
            } else if (Hours === 0) {
                statusMessageCalculateTime.value = true
                if (Minute === 60) {
                    messageCalculateTime.value = "เวลาใช้งานจำนวน " + (Hours + 1) + " ชั่วโมง ";
                } else if (Minute < 30) {
                    statusMessageCalculateTime.value = false
                    messageCalculateTime.value = "กรุณาระบุเวลา มากกว่า 30 นาที";
                } else {
                    messageCalculateTime.value = "เวลาใช้งานจำนวน " + Minute + " นาที";
                }
            } else {
                statusMessageCalculateTime.value = false
                if (form.end_time === null) {
                    messageCalculateTime.value = "กรุณาระบุเวลาสิ้นสุด";
                } else {
                    messageCalculateTime.value = "กรุณาตรวจสอบเวลาอีกครั้ง";
                }
            }
        }
    }
)

watch(
    () => form.attendees,
    (val) => {
        if (val < 3 || val > 200) {
            messageAttendeesInvalid.value = 'กรุณาระบุจำนวนมากกว่า 3 หรือ น้อยกว่า 200'
        } else {
            messageAttendeesInvalid.value = null
        }
    }
)

watch(
    () => [form.date, form.start_time, form.end_time, form.attendees, form.set_room.status, !form.set_room.status],
    (val) => {
        if (val) {
            result.value = [];
            form.meeting_room_id = null;
        }
    }
)

watch(
    () => [form.date, form.start_time, form.end_time],
    (val) => {
        if (val) {
            form.start_date = dayjs(form.date).format('YYYY-MM-DD') + 'T' + dayjs(form.start_time).format('HH:mm');
            form.end_date = dayjs(form.date).format('YYYY-MM-DD') + 'T' + dayjs(form.end_time).format('HH:mm');
            // console.log(form.end_date)
        }
    }
)

watch(
    () => !form.set_room.status,
    (val) => {
        if (val) {
            form.set_room.type_table = null;
            form.set_room.number_group = '0';
            form.set_room.each_group = '0';
        }
    }
)

watch(
    () => form.set_room.type_table !== 'groups',
    (val) => {
        if (val) {
            form.set_room.number_group = '0';
            form.set_room.each_group = '0';
        }
    }
)

watch(
    () => !form.food.status,
    (val) => {
        if (val) {
            form.food.lunch = '0';
            form.food.snack = '0';
            form.food.drink = '0';
            form.food.note = null;
        }
    }
)

</script>

<style>
.date {
    height: auto;
    border: #64748b solid 1px;
    border-radius: 0.25rem;
    margin-top: 9px;
}

.time {
    height: auto;
    border: #64748b solid 1px;
    border-radius: 0.25rem;
    margin-top: 9px;
}

#date, #start_time, #end_time {
    font-size: 1.125rem; /* 18px */
    line-height: 1.75rem; /* 28px */
    width: 200px;
    padding: 5px 3px;
}
</style>
