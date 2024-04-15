export function desplegarAlertaSweetAlertDeExito(mensaje) {
    Swal.fire({
        title: mensaje,
        confirmButtonText: "Ir a las noticias",
        icon: "success",
    }).then((result) => { if (result.isConfirmed) window.location.href = "/"; });
}

export function desplegarAlertaEnlaceErroneo(respuesta) {
    Swal.fire({
        title: "Enlace Invalido",
        text: `Hubo un error con el enlace  "${respuesta.feedErronea}", por favor asegúrese de ingresar un enlace por linea, que no tenga espacios en medio y que sea un enlace rss valido`,
        confirmButtonText: "Ok",
        icon: "error"
    });
}