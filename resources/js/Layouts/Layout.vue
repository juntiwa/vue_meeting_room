<template>
    <div class="m-3">
        Welcome ยินดีต้อนรับ {{ $page.props.auth.user.full_name }} <br>
        <ButtonComponent type="button"
                         class="bg-rose-500 hover:bg-rose-600 text-white"
                         @click="$inertia.delete(route('loginDestroy'))"
                         buttonText="logout"/>
        <br>
        <Link v-if="can.booked_room_instead_case" href="/formBookRoomInstead">
            จองแทน
        </Link>
        <Link v-if="can.booked_room_case" href="/formBookRoom">
            จองห้องประชุม
        </Link>
        <Link href="/listBookedRoom">
            รายการจองห้องประชุมทั้งหมด
        </Link>

        <p class="text-lg pt-5">
            รายการจองห้องประชุมที่รอการอนุมัติ
        </p>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/inertia-vue3'
import ButtonComponent from "../Components/ButtonComponent";

const props = defineProps(['can']);
</script>

<style scoped>

</style>
