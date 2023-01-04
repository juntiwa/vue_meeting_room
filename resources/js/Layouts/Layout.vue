<template>
    <div class="flex items-center justify-between px-3 sticky top-0 bg-slate-100 w-full h-fit">
        <div>
            Welcome ยินดีต้อนรับ
            <Link href="/" class="text-violet-600 hover:text-teal-600">
                หน้าหลัก
            </Link>

            <Link v-if="$page.props.can.booked_room_instead_case" href="/formBookRoomInstead" class="text-violet-600 hover:text-teal-600">
                จองแทน
            </Link>

            <Link v-if="$page.props.can.booked_room_case" href="/formBookRoom" class="text-violet-600 hover:text-teal-600">
                จองห้องประชุม
            </Link>

            <Link v-if="$page.props.can.view_list_booked_rooms_case" href="/listBookedRoom" class="text-violet-600 hover:text-teal-600">
                รายการจองห้องประชุมทั้งหมด
            </Link>

            <Link v-if="$page.props.can.booked_room_instead_case" href="/formRequestEquipment" class="text-violet-600 hover:text-teal-600">
                ขอใช้งานอุปกรณ์
            </Link>
        </div>
        <div>
            {{ user }}
            <ButtonComponent type="button"
                             class="bg-rose-500 hover:bg-rose-600 text-white"
                             @click="$inertia.delete(route('loginDestroy'))"
                             buttonText="logout"/>
        </div>

        <slot/>
    </div>
</template>

<script setup>
import {Link, usePage} from '@inertiajs/inertia-vue3'
import ButtonComponent from "../Components/ButtonComponent";
import {computed} from "vue";

const user = computed(() => usePage().props.value.auth.user.full_name)
</script>

<style scoped>

</style>
