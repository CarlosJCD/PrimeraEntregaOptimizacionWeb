const RUTA_POST_ACTUALIZAR_FEEDS = "/feeds/update";

const formFeedsUrls = document.getElementById("feeds");
const textAreaFeedsURLs = document.getElementById("feedsURLs");


formFeedsUrls.addEventListener("submit", async (evento)=>{
    evento.preventDefault();

    Swal.fire({
        title: "Cargando Feeds",
        text: "Por favor, espere mientras se carga la información de los feeds",
        showCancelButton: false,
        showConfirmButton: false,
        willOpen: enviarURLs,
        didOpen: () => { Swal.showLoading() }
    })    
    
})


async function enviarURLs() {
    let feedsUrls = obtenerFeedsUrlsDelFormulario();

    const resultado = await fetch(RUTA_POST_ACTUALIZAR_FEEDS, {
        method: "POST",
        body: JSON.stringify({ "feedsUrls": feedsUrls })
    })
    
    const respuesta = await resultado.json();

    if(respuesta.ok){
        desplegarAlertaSweetAlertDeExito();
    } else {
        desplegarAlertaSweetAlertDeError(respuesta);
    }
}

function obtenerFeedsUrlsDelFormulario() {
    const feedsUrls = textAreaFeedsURLs.value.trim();
    feedsUrls = feedsUrls.split("\n");
    feedsUrls = feedsUrls.filter(feedsUrl => feedsUrl !== "");
    return feedsUrls;
}

function desplegarAlertaSweetAlertDeExito() {
    Swal.fire({
        title: "Feeds cargadas exitosamente",
        confirmButtonText: "Ir a las noticias",
        icon: "success",
    }).then((result) => { if (result.isConfirmed) window.location.href = "/"; });
}

function desplegarAlertaSweetAlertDeError(respuesta) {
    Swal.fire({
        title: "Enlace Invalido",
        text: `Hubo un error con el enlace  "${respuesta.feedErronea}", por favor asegúrese de ingresar un enlace por linea, que no tenga espacios en medio y que sea un enlace rss valido`,
        confirmButtonText: "Ok",
        icon: "error"
    });
}
