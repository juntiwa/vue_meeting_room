<template>
    <Layout :can="can"/>
    <div class="m-3">
        Form Request Equipment
        <section id="date_time" class="flex flex-col mb-3 w-1/3">
            <div class="flex flex-row gap-4 mb-3">
                <label for="start_date" class="flex flex-col">
                    วันเริ่มต้น
                    <a-date-picker class="date"
                                   name="start_date"
                                   id="start_date"
                                   v-model:value="form.date_start"
                                   format="DD/MM/YYYY"
                                   placeholder="เลือกวันที่ต้องการ"
                    />
                </label>
                <label for="end_date" class="flex flex-col">
                    วันสิ้นสุด
                    <a-date-picker class="date"
                                   name="end_date"
                                   id="end_date"
                                   v-model:value="form.date_end"
                                   format="DD/MM/YYYY"
                                   placeholder="เลือกวันที่ต้องการ"
                    />
                </label>
            </div>
            <div class="flex flex-row gap-4 mb-3">
                <label for="start_time" class="flex flex-col">
                    เวลาเริ่ม
                    <a-time-picker name="start_time"
                                   id="start_time"
                                   v-model:value="form.start_time"
                                   :disabledHours="disabledHours"
                                   :hideDisabledOptions="true"
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
                                   :hideDisabledOptions="true"
                                   class="time"
                                   placeholder="เลือกเวลาที่ต้องการ"
                                   format="HH:mm"/>
                </label>
            </div>

        </section>
        <section id="unit" class="flex flex-col gap-2 mb-3 w-1/3">
            <label>ประเภทหน่วยงาน</label>
            <select v-model="form.unit_level" class="bg-white border border-slate-500 rounded py-1.5 px-1 mb-3">
                <option value="">เลือกประเภทหน่วยงาน</option>
                <option v-for="level in unitLevel" :value="level.id">
                    {{ level.name_th }}
                </option>
            </select>

            <label>ชื่อหน่วยงาน</label>
            <select v-model="form.unit_id" class="bg-white border border-slate-500 rounded py-1.5 px-1 mb-3">
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
        </section>
        <section id="contact" class="flex flex-row gap-2 mb-3 w-1/3">
            <InputTextComponent label="ชื่อ - สกุล ผู้ยืม"
                                name="full_name"
                                v-model="form.full_name"
            />
            <InputTextComponent label="เบอร์ติดต่อ"
                                name="tel"
                                v-model="form.tel"
            />
        </section>
        <section id="detail" class="flex flex-col gap-2 mb-3 w-1/3">
            สถานที่
            <div class="flex flex-row gap-4">
                <InputTextComponent label="ตึก"
                                    name="building"
                                    v-model="form.building"/>
                <InputTextComponent type="number" label="ชั้น"
                                    name="floor"
                                    v-model="form.floor"/>
                <InputTextComponent label="ห้อง"
                                    name="room"
                                    v-model="form.room"/>
            </div>

        </section>
        <section id="equipment" class="flex flex-col w-1/3">
            อุปกรณ์ที่ต้องการ
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
        </section>
        <ButtonComponent
            @click="save"
            class="bg-teal-600 hover:bg-teal-700 text-white"
            :disabled="formIncompleted"
            buttonText="บันทึกข้อมูล"/>
    </div>
</template>

<script setup>
import Layout from "../../Layouts/Layout";
import {useForm} from "@inertiajs/inertia-vue3";
import InputTextComponent from "../../Components/InputTextComponent";
import ButtonComponent from "../../Components/ButtonComponent";
import {computed, watch} from "vue";
import dayjs from "dayjs";

const props = defineProps(['can', 'unitLevel', 'inners', 'outters', 'company'])

const form = useForm({
    start_date: null,
    end_date: null,
    date_start: null,
    date_end: null,
    start_time: null,
    end_time: null,
    unit_level: "",
    unit_id: "",
    full_name: null,
    tel: null,
    building: null,
    floor: null,
    room: null,
    equipment: {
        lcdprojector: '0',
        visualizer: '0',
        other: null,
    }
})

const disabledHours = () => {
    const hours = [];
    for (let i = 0; i <= 5; i++) {
        hours.push(i);
    }
    for (let i = 21; i <= 24; i++) {
        hours.push(i);
    }
    return hours;
};

const formIncompleted = computed(() => {
    return !form.start_date || !form.end_date || !form.start_time || !form.end_time ||
        !form.unit_level || !form.unit_id || !form.full_name || !form.tel || !form.building || !form.floor || !form.room ||
        (!form.equipment.other && form.equipment.lcdprojector <= 0 && form.equipment.visualizer <= 0)
})

const save = () => {
    form.post(window.route("formRequestEquipmentStore"));
};

watch(
    () => [form.start_date, form.end_date, form.start_time, form.end_time],
    (val) => {
        if (val) {
            form.start_date = dayjs(form.date_start).format('YYYY-MM-DD') + 'T' + dayjs(form.start_time).format('HH:mm');
            form.end_date = dayjs(form.date_end).format('YYYY-MM-DD') + 'T' + dayjs(form.end_time).format('HH:mm');
        }
    }
)

watch(
    () => [form.equipment.lcdprojector, form.equipment.visualizer],
    (val) => {
        if (val[0] === '') {
            form.equipment.lcdprojector = '0';
        }
        if (val[1] === '') {
            form.equipment.visualizer = '0';
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

#start_date, #end_date, #start_time, #end_time {
    font-size: 1.125rem; /* 18px */
    line-height: 1.75rem; /* 28px */
    width: 200px;
    padding: 5px 3px;
}
</style>
