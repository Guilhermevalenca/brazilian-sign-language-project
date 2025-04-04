export default class LoadingService {
    static show(status: string, refresh: () => any) {
        const { $swal } = useNuxtApp();
        $swal.fire({
            title: 'Carregando...',
            icon: 'info',
            didOpen: () => {
                $swal.showLoading();
            },
            didClose: () => {
                $swal.hideLoading();
            }
        });
        if (status === 'success') {
            $swal.close();
        } else if (status === 'error') {
            $swal.close();
            $swal.fire({
                icon: 'error',
                title: 'Algo deu errado',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Tente novamente',
                cancelButtonText: 'Voltar para a pagina inicial',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((res) => {
                if (res.isConfirmed) {
                    refresh();
                } else if (res.isDismissed) {
                    navigateTo('/');
                }
            });
        }
    }
}