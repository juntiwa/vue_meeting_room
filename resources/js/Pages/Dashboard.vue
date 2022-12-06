<template>
   Welcome ยินดีต้อนรับ <br>
    <ButtonComponent type="button"
                     class="bg-rose-500 hover:bg-rose-600 text-white"
                     @click="$inertia.delete(route('loginDestroy'))"
                     buttonText="logout"/> <br>
    <a href="/formBookRoom">จองห้องประชุม</a>
</template>
<script setup>
import ButtonComponent from "../Components/ButtonComponent";
const props = defineProps(['message']);
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
