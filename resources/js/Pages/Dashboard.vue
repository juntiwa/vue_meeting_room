<template>
   Welcome ยินดีต้อนรับ <br>
    <a href="/formBookRoom">จองห้องประชุม</a>
</template>
<script setup>
const props = defineProps(['message']);
if (props.message === 'true') {
    const Toast = window.swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', window.swal.stopTimer)
            toast.addEventListener('mouseleave', window.swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: 'Signed in successfully',
        text: 'test'
    })
}
</script>
