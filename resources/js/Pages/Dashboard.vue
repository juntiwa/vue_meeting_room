<template>
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
    <ListBookedRoom :bookings="bookings" :rooms="rooms"/>


</template>
<script setup>
import {Link} from '@inertiajs/inertia-vue3'
import ButtonComponent from "../Components/ButtonComponent";
import ListBookedRoom from "./BookedRoomMedicine/ListBookedRoom";

const props = defineProps(['message', 'can', 'bookings','rooms']);
if (props.message === 'true') {
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
        icon: 'success',
        title: 'Signed in successfully',
        text: 'test'
    })
}
</script>
