<template>
    <Layout :can="can"/>

    <div class="m-3" v-for="(room, keyroom) in rooms" :key="keyroom">
        <h1 class="font-medium text-center text-xl mt-7 mb-5">{{ room.name_th }}</h1>

        <div class="overflow-auto rounded-lg shadow hidden md:block">

            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="w-5 p-3 font-semibold tracking-wide text-center">ลำดับ</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">วัน เดือน ปี ที่จอง</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">เวลา ที่จอง</th>
                    <th class="w-40 p-3 font-semibold tracking-wide text-left">หัวข้อการประชุม</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-center">ผู้เข้าร่วม</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-left">หน่วยงาน</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">เบอร์ติดต่อ</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">สถานะ</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">อุปกรณ์</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">อาหาร</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">วันที่บันทึกข้อมูล</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">จัดการ</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" v-for="(booking, key) in bookings" :key="key">
                <tr v-if="booking.meeting_room_id === room.id"
                    :class="{
                            'bg-white' : booking.status_locale === 'รออนุมัติ',
                            'bg-teal-100' : booking.status_locale === 'อนุมัติ',
                            'text-green-600' : booking.status_locale === 'ถูกแก้ไข',
                            'text-green-600' : booking.status_locale === 'ถูกยกเลิก',
                            'text-green-600' : booking.status_locale === 'ไม่อนุมัติ'
                        }"
                >
                    <td class="p-3 text-center align-text-top"> {{ ++key }} </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"> {{ booking.date_booked_text }} </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap">{{ booking.time_booked_text }}</td>
                    <td class="p-3 align-text-top">{{ booking.topic_text }}</td>
                    <td class="p-3 text-center align-text-top">{{ booking.attendee_text }}</td>
                    <td class="p-3 align-text-top">{{ booking.unit_name }}</td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap">{{ booking.user_tel }}</td>
                    <td class="p-3 align-text-top whitespace-nowrap">{{ booking.status_locale }}</td>
                    <td class="p-3 align-text-top">{{ booking.equipment_text }}</td>
                    <td class="p-3 align-text-top">{{ booking.food_text }}</td>
                    <td class="p-3 align-text-top whitespace-nowrap">{{ booking.update_at }}</td>
                    <td class="p-3 align-text-top whitespace-nowrap flex flex-col">
                        <ButtonComponent buttonText="อนุมัติ"
                                         @click="approveStatusUpdate"
                                         v-model="form.status"
                                         class="bg-teal-600 text-white"/>
                        <ButtonComponent buttonText="แก้ไข"
                                         @click="correctStatusUpdate"
                                         v-model="form.status"
                                         class="bg-amber-500 text-white"/>
                        <ButtonComponent buttonText="ไม่อนุมัติ"
                                         @click="cancelStatusUpdate"
                                         v-model="form.status"
                                         class="bg-red-500 text-white"/>
                        <ButtonComponent buttonText="ยกเลิก"
                                         @click="disapproveStatusUpdate"
                                         v-model="form.status"
                                         class="bg-orange-500 text-white"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
        <div class="bg-white space-y-3 p-4 rounded-lg shadow">
            <div class="flex items-center space-x-2 ">
                <div>
                    <a href="#" class="text-blue-500 font-bold hover:underline">#1000</a>
                </div>
                <div class="text-gray-500">10/10/2021</div>
                <div>
            <span
                class="p-1.5 text-xs font-medium uppercase tracking-wider text-green-800 bg-green-200 rounded-lg bg-opacity-50">Delivered</span>
                </div>
            </div>
            <div class=" text-gray-700">
                Kring New Fit office chair, mesh + PU, black
            </div>
            <div class=" font-medium text-black">
                $200.00
            </div>
        </div>
        <div class="bg-white space-y-3 p-4 rounded-lg shadow">
            <div class="flex items-center space-x-2 ">
                <div>
                    <a href="#" class="text-blue-500 font-bold hover:underline">#1001</a>
                </div>
                <div class="text-gray-500">10/10/2021</div>
                <div>
            <span
                class="p-1.5 text-xs font-medium uppercase tracking-wider text-yellow-800 bg-yellow-200 rounded-lg bg-opacity-50">Shipped</span>
                </div>
            </div>
            <div class=" text-gray-700">
                Kring New Fit office chair, mesh + PU, black
            </div>
            <div class=" font-medium text-black">
                $200.00
            </div>
        </div>
        <div class="bg-white space-y-3 p-4 rounded-lg shadow">
            <div class="flex items-center space-x-2 ">
                <div>
                    <a href="#" class="text-blue-500 font-bold hover:underline">#1002</a>
                </div>
                <div class="text-gray-500">10/10/2021</div>
                <div>
            <span
                class="p-1.5 text-xs font-medium uppercase tracking-wider text-gray-800 bg-gray-200 rounded-lg bg-opacity-50">Canceled</span>
                </div>
            </div>
            <div class=" text-gray-700">
                Kring New Fit office chair, mesh + PU, black
            </div>
            <div class=" font-medium text-black">
                $200.00
            </div>
        </div>
    </div>


</template>
<script setup>
import Layout from "../Layouts/Layout";
import ButtonComponent from "../Components/ButtonComponent";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps(['message', 'can', 'bookings', 'rooms']);
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
        title: 'สำเร็จ',
        text: 'จองห้องประชุม เสร็จสิ้น'
    })
}

const form = useForm({
    status: null
})
const approveStatusUpdate = () => {
    console.log(form.status = 2)
    // form.post(window.route('approveStore'))
}
const correctStatusUpdate = () => {
    console.log(form.status = 3)
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })
}
const cancelStatusUpdate = () => {
    console.log(form.status = 4)
}
const disapproveStatusUpdate = () => {
    console.log(form.status = 5)
}
</script>
