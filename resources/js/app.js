import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import Swal from 'sweetalert2';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();

// SweetAlert2
const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000, //3 detik
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.addEventListener('alert',({detail:{type,message}})=>{
    Toast.fire({
        icon:type,
        title:message
    }).then( () => {
        location.reload();
    })
});