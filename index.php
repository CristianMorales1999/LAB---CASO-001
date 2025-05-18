<?php
require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Desplegable</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <nav class="menu">
        <!--Contenedor de Mneu-->
        <section class="menu__container">
            <!--Logo-->
            <h1 class="menu__logo">Cristian M.</h1>
            <!--Links del menu-->
            <ul class="menu__links">
                <?php foreach ($menu as $seccion => $opciones) { ?>
                    <!--Item de Menu-->
                    <li class="menu__item menu__item--show">
                        <!--Link del opciones de Menu-->
                        <a href="#" class="menu__link">
                            <?php echo $seccion ?>
                            <img src="assets/arrow.svg" class="menu__arrow" alt="Flecha">
                        </a>

                        <?php if (is_array($opciones)) { ?>
                            <!--Submenu-->
                            <ul class="menu__nesting">
                                <?php foreach ($opciones as $opcion) { ?>
                                    <!--Item de Submenu-->
                                    <li class="menu__inside">
                                        <a href="#" class="menu__link menu__link--inside"><?php echo $opcion ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
            <!--Boton de Menu-->
            <div class="menu__hamburguer">
                <img src="assets/menu.svg" class="menu__img" alt="Menu">
            </div>
        </section>
    </nav>
    <script src="js/script.js"></script>
</body>

</html>