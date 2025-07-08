import type { SweetAlertOptions } from 'sweetalert2';

export default class LoadingService {
  static show() {
    const { $swal } = useNuxtApp();
    $swal.fire({
      title: 'Carregando...',
      icon: 'info',
      didOpen: () => {
        $swal.showLoading();
      },
      didClose: () => {
        $swal.hideLoading();
      },
    });
  }

  static loaded(status: string, refresh: () => any, isHomePage: boolean = false) {
    const { $swal } = useNuxtApp();
    if (status === 'success') {
      $swal.close();
    } else if (status === 'error') {
      $swal.close();

      const configSwal: SweetAlertOptions = {
        icon: 'error',
        title: 'Algo deu errado',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Tente novamente',
        cancelButtonText: 'Voltar para a pagina inicial',
        allowOutsideClick: false,
        allowEscapeKey: false,
      };
      if (isHomePage) {
        configSwal.showCancelButton = false;
      }
      setTimeout(() => {
        $swal.fire(configSwal).then((res) => {
          if (res.isConfirmed) {
            refresh();
          } else if (res.isDismissed) {
            navigateTo('/');
          }
        });
      }, 300);
    }
  }
}
