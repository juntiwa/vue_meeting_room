<template>
    <div class="container flex flex-col m-3 w-1/2">
        เข้าสู่ระบบ
        <p v-if="$page.props.flash.sirirajUser">
            {{ $page.props.flash.sirirajUser }}
        </p>

        <InputTextComponent label="ชื่อผู้ใช้งาน"
                            type="text"
                            name="login"
                            v-model="form.login"/>

        <InputTextComponent label="รหัสผ่าน"
                            type="password"
                            name="password"
                            v-model="form.password"/>

        <a :href="forgetPassword" target="_blank" class="text-right text-blue-600 hover:text-rose-600 cursor-pointer">ลืมรหัสผ่าน
            ?</a>

        <ButtonComponent @click="login" buttonText="เข้าสู่ระบบ" class="bg-blue-400 hover:bg-blue-500 text-white"/>
    </div>

</template>

<script setup>
import InputTextComponent from "../../Components/InputTextComponent";
import ButtonComponent from "../../Components/ButtonComponent";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import {computed, watch} from "vue";

const form = useForm({
    login: null,
    password: null,
})

const forgetPassword = import.meta.env.VITE_FORGET_PASSWORD

const login = () => {
    form.post(window.route('loginStore'))
}

const replyCode = computed(() => usePage().props.value.flash.replyCode)
watch(
    () => replyCode.value,
    (val) => {
        if (val === '2') {
            swal.fire({
                icon: 'error',
                title: 'รหัสผ่านหมดอายุ',
                confirmButtonText: 'รีเซ็ตรหัสผ่าน',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(forgetPassword, '_blank'); //เปิดหน้า รีเซ็ตรหัสผ่าน ในแท็ปใหม่
                    location.reload(); // reload หน้า login เพื่อให้ค่่า replyCode หายไป
                }
            })
        }
    }
)

</script>

<style scoped>

</style>
