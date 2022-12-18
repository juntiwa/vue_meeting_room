<template>
    <div class="m-3">
        <Layout :can="can"/>
        <div v-for="(room, keyroom) in rooms" :key="keyroom">
            <h1 class="font-medium text-center text-xl mt-7 mb-5">{{ room.name_th }}</h1>
            <div class="overflow-auto rounded-lg shadow hidden md:block">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="w-5 p-3 font-semibold tracking-wide text-center">ลำดับ</th>
                        <th class="w-24 p-3 font-semibold tracking-wide text-center">วัน เดือน ปี ที่จอง</th>
                        <th class="w-24 p-3 font-semibold tracking-wide text-center">เวลา ที่จอง</th>
                        <th class="w-40 p-3 font-semibold tracking-wide text-left">หัวข้อการประชุม</th>
                        <th class="w-20 p-3 font-semibold tracking-wide text-center">ผู้เข้าร่วม</th>
                        <th class="w-24 p-3 font-semibold tracking-wide text-left">หน่วยงาน</th>
                        <th class="w-24 p-3 font-semibold tracking-wide text-center">เบอร์ติดต่อ</th>
                        <th class="w-24 p-3 font-semibold tracking-wide text-center">สถานะ</th>
                        <th class="w-20 p-3 font-semibold tracking-wide text-left">อุปกรณ์</th>
                        <th class="w-20 p-3 font-semibold tracking-wide text-left">อาหาร</th>
                        <th class="w-20 p-3 font-semibold tracking-wide text-left">แบบสอบถาม</th>
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
                        <td class="p-3 text-center align-text-top"> {{ ++key }}</td>
                        <td class="p-3 text-center align-text-top whitespace-nowrap"> {{
                                booking.date_booked_text
                            }}
                        </td>
                        <td class="p-3 text-center align-text-top whitespace-nowrap">{{ booking.time_booked_text }}</td>
                        <td class="p-3 align-text-top">{{ booking.topic_text }}</td>
                        <td class="p-3 text-center align-text-top">{{ booking.attendee_text }}</td>
                        <td class="p-3 align-text-top">ภายใน {{ booking.unit_name }}</td>
                        <td class="p-3 text-center align-text-top whitespace-nowrap">{{ booking.user_tel }}</td>
                        <td class="p-3 align-text-top whitespace-nowrap">{{ booking.status_locale }}</td>
                        <td class="p-3 align-text-top">{{ booking.equipment_text }}</td>
                        <td class="p-3 align-text-top">{{ booking.food_text }}</td>
                        <td class="p-3 align-text-top">รอบันทึก</td>
                        <td class="p-3 align-text-top whitespace-nowrap">
                            <ButtonComponent buttonText="ทดสอบ" class="bg-rose-500 text-white"/>
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
    </div>


</template>

<script setup>
import Layout from "../../Layouts/Layout";
import ButtonComponent from "../../Components/ButtonComponent";

defineProps(['message', 'can', 'bookings', 'rooms']);
</script>

