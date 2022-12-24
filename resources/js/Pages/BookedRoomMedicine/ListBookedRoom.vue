<template>
    <div class="m-3">
        <Layout :can="can"/>
        <div v-for="(room, keyroom) in rooms" :key="keyroom">
            <div v-if="room.can_view_list_booked_room">
                <h1 class="font-medium text-center text-xl mt-7 mb-5">{{ room.room_name }}</h1>
                <div class="overflow-auto rounded-lg shadow hidden md:block">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="w-5 p-3 font-semibold tracking-wide text-center">ลำดับ</th>
                            <th class="w-24 p-3 font-semibold tracking-wide text-center">วัน เดือน ปี ที่จอง</th>
                            <th class="w-24 p-3 font-semibold tracking-wide text-center">เวลา ที่จอง</th>
                            <th class="w-40 p-3 font-semibold tracking-wide text-left">หัวข้อการประชุม</th>
                            <th class="w-12 p-3 font-semibold tracking-wide text-center">ผู้เข้าร่วม</th>
                            <th class="w-24 p-3 font-semibold tracking-wide text-left">หน่วยงาน</th>
                            <th class="w-24 p-3 font-semibold tracking-wide text-center">เบอร์ติดต่อ</th>
                            <th class="w-20 p-3 font-semibold tracking-wide text-left">สถานะ</th>
                            <th class="w-20 p-3 font-semibold tracking-wide text-left">อุปกรณ์</th>
                            <th class="w-20 p-3 font-semibold tracking-wide text-left">จัดห้อง</th>
                            <th class="w-20 p-3 font-semibold tracking-wide text-left">อาหาร</th>
                            <th class="w-20 p-3 font-semibold tracking-wide text-center">แก้ไข</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" v-for="(booking, key) in bookings" :key="key">
                        <tr v-if="booking.meeting_room_id === room.room_id"
                            class="cursor-pointer hover:bg-slate-100"
                        >
                            <td class="p-3 text-center align-text-top" @click="modalData(booking,room)"> {{
                                    ++key
                                }}
                            </td>
                            <td class="p-3 text-center align-text-top whitespace-nowrap"
                                @click="modalData(booking,room)">
                                {{ booking.date }}
                            </td>
                            <td class="p-3 text-center align-text-top whitespace-nowrap"
                                @click="modalData(booking,room)">
                                {{ booking.time }}
                            </td>
                            <td class="p-3 align-text-top" @click="modalData(booking,room)">{{
                                    booking.data_all.topic
                                }}
                            </td>
                            <td class="p-3 text-center align-text-top" @click="modalData(booking,room)">
                                {{ booking.data_all.attendees }}
                            </td>
                            <td class="p-3 align-text-top" @click="modalData(booking,room)">
                                {{ booking.data_all.users.unit.name_th }}
                            </td>
                            <td class="p-3 text-center align-text-top whitespace-nowrap"
                                @click="modalData(booking,room)">
                                {{ booking.data_all.users.tel }}
                            </td>
                            <td class="p-3 align-text-top whitespace-nowrap"
                                :class="{
                            'text-amber-500' : booking.status_locale === 'รออนุมัติ' || booking.status_locale === 'ถูกแก้ไข',
                            'text-teal-600' : booking.status_locale === 'อนุมัติ',
                            'text-rose-600' : booking.status_locale === 'ถูกยกเลิก' || booking.status_locale === 'ไม่อนุมัติ',
                            }"
                                @click="modalData(booking,room)">
                                {{ booking.status_locale }}
                            </td>
                            <td class="p-3 align-top"
                                :class="{
                                'align-text-top': booking.equipment_text
                            }"
                                @click="modalData(booking,room)">
                                <svg v-if="!booking.equipment_text" xmlns="http://www.w3.org/2000/svg" width="40"
                                     height="40" viewBox="0 0 24 24">
                                    <path class="fill-red-500"
                                          d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/>
                                </svg>
                                <p v-if="booking.equipment_text">{{ booking.equipment_text }}</p>
                            </td>
                            <td class="p-3 align-top"
                                :class="{
                                'align-text-top': booking.set_room_text
                            }"
                                @click="modalData(booking,room)">
                                <svg v-if="!booking.set_room_text" xmlns="http://www.w3.org/2000/svg" width="40"
                                     height="40"
                                     viewBox="0 0 24 24">
                                    <path class="fill-red-500"
                                          d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/>
                                </svg>
                                <p v-if="booking.set_room_text">{{ booking.set_room_text }}</p>
                            </td>
                            <td class="p-3 align-top"
                                :class="{
                                'align-text-top': booking.food_text
                            }"
                                @click="modalData(booking,room)">
                                <svg v-if="!booking.food_text" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                     viewBox="0 0 24 24">
                                    <path class="fill-red-500"
                                          d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/>
                                </svg>
                                <p v-if="booking.food_text">{{ booking.food_text }}</p>
                            </td>

                            <td class="p-3"
                                :class="{
                                    'cursor-not-allowed': !booking.can_edit
                                }"
                                @click="edit">

                                <svg v-if="booking.can_edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" class="fill-emerald-600 hover:fill-amber-500 block m-auto">
                                    <path
                                        d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zm-3-3 1.587 1.585-1.59 1.584-1.586-1.585 1.589-1.584zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zm-2 4h16v2H4z"></path>
                                </svg>

                                <svg v-if="!booking.can_edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" class="fill-red-500 cursor-not-allowed block m-auto">
                                    <path d="M7 10h10v4H7z"></path>
                                    <path
                                        d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                                </svg>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
    </div>


</template>

<script setup>
import Layout from "../../Layouts/Layout";
import {useForm} from "@inertiajs/inertia-vue3";
import $ from "jquery";

const props = defineProps(['message', 'can', 'bookings', 'rooms']);

function modalData(booking, room) {

    const form = useForm({
        id: booking.data_all.id,
        status: null,
        reason: null
    })
    swal.fire({
        icon: 'info',
        html: booking.data_popup,
        showConfirmButton: booking.can_approved ? true : false,
        showDenyButton: booking.can_disapproved ? true : false,
        showCancelButton: booking.can_canceled ? true : false,
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
            form.status = 2
            form.put(window.route('formBookedRoomUpdate'))
            swal.fire({
                    title: 'สำเร็จ !',
                    text: "อนุมัติการจองสำเร็จ",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }
            )
        }
        if (result.isDenied) {
            swal.fire({
                    title: 'กรอกข้อมูล',
                    text: "กรอกเหตุผลกรณีไม่อนุมัติการจอง",
                    icon: 'question',
                    html: '<input type="text" id="reason" class="bg-white w-full border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3"/>',
                    preConfirm: () => {
                        if (document.getElementById('reason').value) {
                            form.status = 5
                            form.reason = $('#reason').val()
                            console.log(form)
                            form.put(window.route('formBookedRoomUpdate'))

                            swal.fire({
                                    title: 'สำเร็จ !',
                                    text: "ไม่อนุมัติการจองสำเร็จ",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }
                            )
                        } else {
                            swal.showValidationMessage('กรุณากรอกข้อมูล')
                        }
                    },
                    showConfirmButton: true,
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'บันทึก',
                }
            )
        }
        if (result.dismiss === swal.DismissReason.cancel) {
            swal.fire({
                    title: 'กรอกข้อมูล',
                    text: "กรอกเหตุผลกรณียกเลิกการจอง",
                    icon: 'question',
                    html: '<input type="text" id="reason" v-model="form.reason" class="bg-white w-full border border-slate-500 rounded py-1.5 px-1 mt-2 mb-3"/>',
                    preConfirm: () => {
                        if (document.getElementById('reason').value) {
                            form.status = 4
                            form.reason = $('#reason').val()
                            console.log(form)
                            form.put(window.route('formBookedRoomUpdate'))

                            swal.fire({
                                    title: 'สำเร็จ !',
                                    text: "ยกเลิกการจองสำเร็จ",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }
                            )
                        } else {
                            swal.showValidationMessage('กรุณากรอกข้อมูล')
                        }
                    },
                    showConfirmButton: true,
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'บันทึก',
                }
            )
        }
    })
}

</script>

