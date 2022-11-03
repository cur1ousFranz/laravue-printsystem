export function alert(string){
  Swal.fire({
    title: string,
    icon: 'success',
    timer: 3000,
    toast: true,
    position: 'top-right',
    timerProgressBar: true,
    showConfirmButton: false
  });
}

export default alert
