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

    <div
        class="p-2 border"
        v-for="(booking, key) in bookings"
        :key="key"
    >
        <p>{{ booking.medicineroom_text }} {{ booking.duration_text }} </p>
        <p>{{ booking.attendee_text }} {{ booking.purpose_text }}</p>
        <p>{{ booking.set_room_text }}</p>
        <p>{{ booking.topic_text }} </p>
        <p>{{ booking.description_text }} </p>
        <p> </p>
        <p>{{ booking.equipment_text }} </p>
        <p>{{ booking.food_text }} </p>

    </div>
</template>
<script setup>
import {Link} from '@inertiajs/inertia-vue3'
import ButtonComponent from "../Components/ButtonComponent";

const props = defineProps(['message', 'can', 'bookings']);
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
