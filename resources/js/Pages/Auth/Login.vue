<template>
    <div class="container flex flex-col m-3">
        เข้าสู่ระบบ
        <label for="login">ชื่อผู้ใช้งาน</label>
        <InputTextComponent name="login" id="login" v-model="form.login"/>

        <label for="password">รหัสผ่าน</label>
        <InputTextComponent type="password" name="password" id="password" v-model="form.password"/>
        <a :href="forgetPassword" target="_blank" class="text-right text-blue-600 hover:text-rose-600 cursor-pointer">ลืมรหัสผ่าน ?</a>

        <ButtonComponent @click="login" buttonText="Test" class="bg-blue-400 hover:bg-blue-500 text-white"/>
    </div>

</template>

<script setup>
import InputTextComponent from "../../Components/InputTextComponent";
import ButtonComponent from "../../Components/ButtonComponent";
import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    login: null,
    password: null,
})

const forgetPassword = import.meta.env.VITE_FORGET_PASSWORD

const login = () => {
    form.post(window.route('loginStore'))
}

</script>

<style scoped>

</style>
