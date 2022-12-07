<template>
    <div class="container flex flex-col m-3">
        ลงทะเบียนใช้งาน
        <label for="sap_id">รหัสพนักงาน</label>
        <InputTextComponent name="sap_id" id="sap_id" v-model="form.sap_id" disabled/>

        <label for="login">ชื่อผู้ใช้งาน</label>
        <InputTextComponent name="login" id="login" v-model="form.login" disabled/>

        <label for="full_name">ชื่อ สกุล</label>
        <InputTextComponent name="full_name" id="full_name" v-model="form.full_name" disabled/>

        <div v-if="props.sirirajUser.division_name === 'ภ.อายุรศาสตร์'" class="flex flex-col">
            <label for="unit_id">หน่วยงาน</label>
            <select name="unit_id"
                    id="unit_id"
                    v-model="form.unit_id"
                    class="bg-white border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3 w-full">
                <option value="" selected>-- เลือกหน่วยงานที่คุณสังกัด --</option>
                <option value="1">ทดสอบเลือกหน่วยงาน</option>
            </select>

            <label for="tel">เบอร์โต๊ะทำงาน</label>
            <InputTextComponent name="tel" id="tel" v-model="form.tel"/>

            <label for="phone">เบอร์มือถือ</label>
            <InputTextComponent name="phone" id="phone" v-model="form.phone"/>
        </div>


        <ButtonComponent @click="register" buttonText="ลงทะเบียน"/>
    </div>
</template>

<script setup>
import InputTextComponent from "../../Components/InputTextComponent";
import ButtonComponent from "../../Components/ButtonComponent";
import {useForm} from '@inertiajs/inertia-vue3';

const props = defineProps(['sirirajUser']);

const form = useForm({
    sap_id: props.sirirajUser.org_id,
    login: props.sirirajUser.login,
    full_name: props.sirirajUser.full_name,
    unit_id: "",
    tel: null,
    phone: null,
})

const register = () => {
    form.post(window.route('registerStore'))
    // console.log('ok')
}
</script>

<style scoped>

</style>
