<form id="feeds">
    <label for="feedsURLs"></label>
    <textarea name="feedsURLs" id="feedsURLs" cols="100" rows="10"><?php
        foreach ($urls as $url){
            echo trim($url) . "\n";
        }
    ?></textarea>
    <input type="submit" value="Guardar Cambios" id="botonSubmit">
</form>

<a href="/"><button>Noticias</button></a>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/build/js/feeds.js"></script>