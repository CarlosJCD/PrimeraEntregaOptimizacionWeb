import { desplegarAlertaSweetAlertDeExito } from "./alertas.js";

(()=>{
    const imagenesSidebar = document.getElementsByClassName("feed__imagen");

    const feedsSidebar = document.getElementsByClassName("feed");

    const botonRecargarFeeds = document.getElementById("recargarNoticias");

    document.addEventListener("DOMContentLoaded",()=>{
        Array.from(imagenesSidebar).forEach(imagen =>{
            imagen.addEventListener("error",(evento)=>{
                evento.target.src = "https://cdn-icons-png.flaticon.com/512/124/124033.png";
            })
        })
        
        
        botonRecargarFeeds.addEventListener("click",(evento)=>{
            evento.preventDefault();
            
            Swal.fire({
                title: "Cargando Feeds",
                text: "Por favor, espere mientras se carga la información de los feeds",
                showCancelButton: false,
                showConfirmButton: false,
                willOpen: recargarDatosFeeds,
                didOpen: () => { Swal.showLoading() }
            })   
        
            
        })
        
        Array.from(feedsSidebar).forEach(feed =>{
            const feedId = feed.dataset.id;
            feed.addEventListener("click",() => {
                let href = window.location.href;
                if(href.includes("feeds")) href = href.replace("feeds","");

                const url = new URL(href);
                url.searchParams.set("feedId", parseInt(feedId));
                url.searchParams.delete("page");
                url.searchParams.delete("categoriaId");
                window.location.href = url.href;
            })
        })
    })

    async function recargarDatosFeeds(){
        const URL_RECARGAR_NOTICIAS = "/news/update";

        const resultado = await fetch(URL_RECARGAR_NOTICIAS, {
            method: "POST",
        })

        const respuesta = await resultado.json();

        if(respuesta.ok){
            desplegarAlertaSweetAlertDeExito("Noticias Actualizadas Con Éxito");
        }
    }
})()

