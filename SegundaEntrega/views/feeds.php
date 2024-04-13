<div class="contenido__titulo">
    <h1 class="contenido__titulo-texto">REGISTRO FEEDS</h1>
</div>

<div class="feeds">

    <form id="feeds" class="feeds__form">

        <label for="feedsURLs" class="feeds__label">Añade un enlace por línea:</label>

        <textarea name="feedsURLs" id="feedsURLs" cols="100" rows="10" class="feeds__textarea"><?php
            foreach ($urls as $url){
                echo trim($url) . "\n";
            }
        ?></textarea>

        <input type="submit" value="Guardar Cambios" id="botonSubmit" class="feeds__btn">

    </form>
</div>
