const RUTA_BUSQUEDA = "/news/buscar"

const inputBarraDeBusqueda = document.getElementById("autoComplete");

const botonBusqueda = document.getElementById("botonBusqueda");

document.addEventListener("DOMContentLoaded",()=>{
  botonBusqueda.addEventListener("click",()=>{
    Swal.fire({
      title: "Buscar noticias por titulo",
      html: '<input type="text" placeholder="Buscar..." id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" class="contenido__titulo-inputbuscar" autocapitalize="off" maxlength="2048" tabindex="1">'
    })
  
    const search = new autoComplete({
      selector: '#autoComplete',
      placeHolder: 'Buscar una noticia',
      data:{
          src: async(query)=> {
              try {
                  const source = await fetch(`${RUTA_BUSQUEDA}?busqueda=${query}`);
                  const data = await source.json();
                  return data;
              } catch (error) {
                  console.error(error);
              }
          },
          keys: ["newsTitle"],
      },
      debounce: 250,
      resultsList: {
          element: (list, data) => {
              if (!data.results.length) {
                const message = document.createElement('div');
                message.setAttribute('class', 'card-busqueda-noticias__noresult');
                message.textContent = `No se han encontrado noticias para "${data.query}"`;
                list.prepend(message);
              }
          },
          noResults: true,
      },
      resultItem: {
          tag: 'li',
          class: 'autoComplete_result',
          element: (item, data) => {
            const itemHtml = `
              <div class="card-busqueda-noticias">
                  <div class="card-busqueda-noticias__contenedor-imagen-noticias">
                      <img class="card-busqueda-noticias__contenedor-imagen-noticias--image" src="${data.value.newsImageUrl}">
                  </div>
                  <div class="card-busqueda-noticias__info">
                    <a href='${data.key === 'newsUrl' ? data.match : data.value.newsUrl}' target="_blank"><p class="card-busqueda-noticias__info--titulo"> ${data.key === 'newsTitle' ? data.match : data.value.newsTitle}</p></a>
                      <div class="card-busqueda-noticias__details">
                          <p class="card-busqueda-noticias__details--date">${
                            data.key === 'newsDate' ? data.match : data.value.newsDate
                          }</p>
                      </div>
                  </div>
              </div>      
            `;
            item.innerHTML = itemHtml;
            item.addEventListener('click', () => {
              window.open(data.value.newsUrl);
            });
          },
          highlight: true,
          selected: 'autoComplete_selected',
        }
    })
  })
})




