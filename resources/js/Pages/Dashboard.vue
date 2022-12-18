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
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">จัดห้อง</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">อาหาร</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-left">วันที่บันทึกข้อมูล</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" v-for="(booking, key) in bookings" :key="key">
                <tr v-if="booking.meeting_room_id === room.id"
                    @click="modalData(booking)"
                    class="cursor-pointer hover:bg-slate-100"
                    :class="{
                            'bg-white' : booking.status_locale === 'รออนุมัติ',
                            'bg-teal-100' : booking.status_locale === 'อนุมัติ',
                            'text-green-600' : booking.status_locale === 'ถูกแก้ไข',
                            'text-green-600' : booking.status_locale === 'ถูกยกเลิก',
                            'text-green-600' : booking.status_locale === 'ไม่อนุมัติ'
                        }"
                >
                    <td class="p-3 text-center align-text-top"> {{ ++key }}</td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"> {{ booking.date }}</td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap">{{ booking.time }}</td>
                    <td class="p-3 align-text-top">{{ booking.data_all.topic }}</td>
                    <td class="p-3 text-center align-text-top">{{ booking.data_all.attendees }}</td>
                    <td class="p-3 align-text-top">{{ booking.unit_name }}</td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap">{{ booking.data_all.users.tel }}</td>
                    <td class="p-3 align-text-top whitespace-nowrap">{{ booking.status_locale }}</td>
                    <td class="p-3 align-text-top">{{ booking.equipment_text }}</td>
                    <td class="p-3 align-text-top">{{ booking.data_all.set_room.type_table }}</td>
                    <td class="p-3 align-text-top">{{ booking.food_text }}</td>
                    <td class="p-3 align-text-top whitespace-nowrap">{{ booking.create_at }}</td>

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

function modalData(booking) {
    swal.fire({
        icon: 'info',
        html: '<h1 class="text-3xl font-medium"> ข้อมูลเพิ่มเติม </h1>' +
            '<div class="text-right">' + booking.create_at_text +
            '<br/>' + '</div> <div class="text-left">' +
            '<br/>' + booking.datetime_booked_text +
            '<br/>' + booking.medicineroom_text + booking.set_room_text +
            '<br/>' + booking.topic_text +
            '<br/>' + booking.description_text +
            '<br/>' + booking.purpose_text +
            '<br/>' + booking.equipment_text +
            '<br/>' + booking.food_text +
            '<br/>' + booking.requester_text +
            '</div>',
        showConfirmButton: true,
        showDenyButton: true,
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonText: 'อนุมัติ',
        cancelButtonText: 'ยกเลิกการจอง',
        denyButtonText: 'ไม่อนุมัติ',
        confirmButtonColor: '#0d9488',
        cancelButtonColor: '#f59e06',
        denyButtonColor: '#ef4444',
        customClass: 'swal-wide',

    }).then((result) => {
        if (result.isConfirmed) {
            swal.fire({
                    title: 'Deleted!',
                    text: "You won't be able to revert this!",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }
            )
        }
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
