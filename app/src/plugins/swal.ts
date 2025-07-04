import Swal from 'sweetalert2';

export default defineNuxtPlugin((nuxtApp) => {
    const mixin = Swal.mixin({
        customClass: {
            // container: '',
            // popup: '',
            // header: '',
            // title: '',
            // closeButton: '',
            // confirmButton: '',
            // denyButton: '',
            // cancelButton: '',
            // footer: '',
        },
    });
    nuxtApp.hooks.hook('app:created', () => {
        mixin.fire({
            didOpen: () => {
                mixin.showLoading();
            },
            didClose: () => {
                mixin.hideLoading();
            }
        });
    });
    nuxtApp.hooks.hook('app:mounted', () => {
        mixin.close();
    });

    nuxtApp.vueApp.config.globalProperties.$swal = mixin;

    return {
        provide: {
            swal: mixin,
        }
    }
})
