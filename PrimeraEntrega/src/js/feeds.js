import { desplegarAlertaSweetAlertDeExito, desplegarAlertaEnlaceErroneo } from "./alertas.js";

const RUTA_POST_ACTUALIZAR_FEEDS = "/feeds/update";

const formFeedsUrls = document.getElementById("feeds");
const textAreaFeedsURLs = document.getElementById("feedsURLs");


formFeedsUrls.addEventListener("submit", (evento)=>{
    evento.preventDefault();

    Swal.fire({
        title: "Cargando Feeds",
        text: "Por favor, espere mientras se carga la información de los feeds",
        showCancelButton: false,
        showConfirmButton: false,
        willOpen: enviarURLs,
        didOpen: () => { Swal.showLoading() }
    });
    
})


async function enviarURLs() {
    let feedsUrls = obtenerFeedsUrlsDelFormulario();

    const resultado = await fetch(RUTA_POST_ACTUALIZAR_FEEDS, {
        method: "POST",
        body: JSON.stringify({ "feedsUrls": feedsUrls })
    })
    
    const respuesta = await resultado.json();

    if(respuesta.ok){
        desplegarAlertaSweetAlertDeExito("Feeds Cargadas Con Éxito");
    } else {
        desplegarAlertaEnlaceErroneo(respuesta);
    }
}

function obtenerFeedsUrlsDelFormulario() {
    let feedsUrls = textAreaFeedsURLs.value.trim();
    feedsUrls = feedsUrls.split("\n");
    feedsUrls = feedsUrls.filter(feedsUrl => feedsUrl !== "");
    return feedsUrls;
}
