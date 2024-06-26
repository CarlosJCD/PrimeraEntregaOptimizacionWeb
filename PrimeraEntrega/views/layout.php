<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/build/css/app.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    <title> <?php echo $title ?> </title>
</head>

<body class="contenedor">

    <aside class="sidebar">

        <h4 class="sidebar__titulo"><a href="/">LectorRSS</a></h4>

        <div class="sidebar__feeds">

            <h5 class="sidebar__titulo-feeds"> FEEDS </h5>

            <div class="lista-feeds">
                <?php foreach ($feeds as $feed): ?>
                    <div class="feed <?= $feedId == $feed["id"] ? "feed--active" : "" ?>" data-id = "<?= $feed["id"] ?>" >
                        <div class="feed__contenedor-imagen">
                            <img class="feed__imagen" src="<?= $feed["feedImageUrl"] ?>" alt="" width="12" height="12">
                        </div>
                        <p class="feed__nombre"><?= $feed["feedName"] ?></p>
                        <span class="feed__cantidad-noticias"><?= $feed["total"] ?></span>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="sidebar__botones">

                <a href="" class="sidebar__boton">
                    <div class="sidebar__boton-icono" id="recargarNoticias" >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H352c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32s-32 14.3-32 32v35.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V432c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H160c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg>
                    </div>
                    <p class="sidebar__boton-texto"> Recargar <br> Noticias</p>
                </a>

                <a href="/feeds" class="sidebar__boton">
                    <div class="sidebar__boton-icono">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                    </div>
                    <p class="sidebar__boton-texto"> Editar <br> Feeds</p>
                </a>

            </div>
        </div>
    </aside>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="contenido">
        <?php echo $contenido; ?>
    </div>
    <script src="/build/js/layout.js" type="module"></script>
</body>

</html>