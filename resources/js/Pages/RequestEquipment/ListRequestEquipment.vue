<template>
    <Layout :can="can"/>
    <div class="m-3">
        <div class="overflow-auto rounded-lg shadow hidden md:block">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="w-5 p-3 font-semibold tracking-wide text-center">ลำดับ</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">วัน</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">เวลา</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">หน่วยวานที่ขอ</th>
                    <th class="w-40 p-3 font-semibold tracking-wide text-left">ชื่อผู้ขอ</th>
                    <th class="w-12 p-3 font-semibold tracking-wide text-center">เบอร์ติดต่อ</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-left">สถานที่</th>
                    <th class="w-24 p-3 font-semibold tracking-wide text-center">อุปกรณ์ที่ต้องการ</th>
                    <th class="w-20 p-3 font-semibold tracking-wide text-center">แก้ไข</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" v-for="(requestEquipment, key) in requestEquipments" :key="key">
                <tr class="cursor-pointer hover:bg-slate-100">
                    <td class="p-3 text-center align-text-top" @click="modalData(requestEquipment)"> {{
                            ++key
                        }}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.date }}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.time }}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.unit_text}}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.all.full_name }}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.all.tel }}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.all.place }}
                    </td>
                    <td class="p-3 text-center align-text-top whitespace-nowrap"
                        @click="modalData(requestEquipment)">
                        {{ requestEquipment.equipment_text }}
                    </td>



                </tr>
                </tbody>
            </table>
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
import Layout from "../../Layouts/Layout"
import $ from "jquery";

defineProps(['can','requestEquipments'])

function modalData(requestEquipment) {
    console.log('modal ok')
}
</script>
