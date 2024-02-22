<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class View
{

    /**
     * Muestra la página de inicio.
     * @return void
     */
    public function initView()
    {
?>
        <div class="main-container__content">

            <div class="main-container__content__title">
                <h1 class="animate-character">APP POKEMON</h1>
            </div>
            <div class="main-container__content__subtitle">
                <h2 class="text txt-white">POKEMON WORLD</h2>
            </div>
        </div>

    <?php
        // Llamada al segundo método
        $this->showInfo();
    }

    /**
     * Muestra la información principal de la aplicación mediante botones.
     */
    public function showInfo()
    {
    ?>
        <div class="main-container__base">
            <div class="main-container__base-title">
                <h1 class="black-text">POKEMON Options</h1>
            </div>
            <div class="main-container__content__btn">
                <a href="index.php?controller=All&action=request" class="btn-base">Pokemon</a>
                <a href="index.php?controller=All&action=select" class="btn-base">More pokemon</a>
                <a href="index.php?controller=All&action=requestId" class="btn-base">Cargar Pokemon</a>
            </div>
        </div>
    <?php
    }


    /**
     * Método para mostrar VALORES DE UN ARRAY ASOCIATIVO
     * @param array $cards Array con la información de las cards.
     */

    public function mostrarCard($card)
    {
        //var_dump($card);
        if ($card == null) {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'No se han encontrado resultados';
            echo '</div>';
            return;
        }
    ?>
        <div class="fluid-container">
            <p class="black-text center">Dame cosas</p>
            <p class='whitexl'>
                <?= $card['value'] ?>
            </p>
        </div>
        <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a>
    <?php
    }
    public function showSelect($res)
    {
        /**
         * Metodo que MUESTRA UN FORMUALRIO para seleccionar algo
         * @param $res array con la info para cargar el select
         * @return post con la categoria seleccionada
         */
        //var_dump($res);
    ?>
        <h5 class="animate-character mt-2">select</h5>
        <div class="form-container"> <!-- fondo semioscuro-->
            <form class="form center" action="index.php?controller=all&action=procesarSelect" method="post">
                <!-- <div class="form-group">
                    <label for=" identificador">Identificador</label>
                    <input type="text" name="identificador" class="form-control" id="identificador" placeholder="" value="">
                </div> -->
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" class="form-select">
                        <!--hago un foreach para recorrer el array y mostrar los valores en el select-->
                        <?php
                        // foreach ($res as $key => $value) { si quiero que el value sea el indice
                        // foreach ($res as $value) {  //si quiero que el value sea el valor
                        //     echo '<option value="' . $value . '">' . $value . '</option>';
                        // }
                        //quiero cargar un select con los valores de un array. selecciono lo que quiero mostrar
                        // Extraer los nombres de los Pokémon(para mostrarlos) y sus urls(para obtener el id)
                        $pokemonData = $res['results'];
                        foreach ($pokemonData as $pokemon) {
                            $name = $pokemon['name'];
                            $url = $pokemon['url'];
                            // Dividir la URL en partes usando la barra como delimitador
                            $url_parts = explode("/", $url);
                            // Obtener el último elemento del array que contiene el ID
                            $id_part = $url_parts[6];
                            //asi mando id_part como value y name como texto para recuprarlo en el controlador procesarselect
                            echo '<option value="' . $id_part . '">Pokemon: ' . $name . ' - Id: ' . $id_part . '</option>';
                        }
                        ?>

                    </select>

                </div>
                <button type="submit" class="btn btn-primary mt-2">Cargar Datos</button>
            </form>
            <!-- <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a> -->
        </div>
    <?php
    }
    /**
     * Metodo que   MUESTRA UN FORMULARIO SIN PARAMETROS para que pueda buscar por tema O METER UN VALOR
     * 
     */
    public function showSearch()
    {
        //si tengo un camp persistente lo recupero
        $identificador = isset($_POST['identificador']) ? $_POST['identificador'] : '';
    ?>
        <h5 class="animate-character mt-2">Search</h5>
        <div class="form-container">
            <!--- OPCION DE SEARCH -->
            <!-- <form class="form" action="index.php?controller=all&action=search" method="post">
                <div class="form-group">
                    <label for="tipo">Busqueda</label>
                    <input required type="search" name="search" class="">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form> -->
            <form class="form" action="index.php?controller=all&action=requestId" method="post">
                <div class="form-group">
                    <label for="tipo">Número a cargar</label>
                    <!--le pongo un value para que sea PERSISTENTE-->
                    <input required type="text" name="identificador" class="form-control" value="<?= $identificador ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Actualizar lista</button>
            </form>
            <a href="index.php?controller=All&action=requestId" class="btn btn-primary">Back</a>
        </div>
    <?php
    }
    /**
     * Metodo que muestra las cards
     * @param array $data array con dos props, total y results, dentro de results hay un array con la info de cada card
     * 
     */
    public function mostrarCards($data, $dataIndex, $totalData)
    {
    ?>
        <div class="container mt-4 ml-12">
            <div class="rowleft row">

                <?php if (isset($data['total']) && isset($data['result']) && is_array($data['result'])) :
                    $results = $data['result'];
                    $totalData = $data['total'];

                    if (!empty($totalData) && !empty($results)) :
                        foreach ($results as $index => $result) :
                ?>
                            <div class="col-md-6 mb-6 center" style="display: <?= ($dataIndex == $index ? 'block' : 'none') ?>">
                                <div class="card cardm">
                                    <div class="card-body">
                                        <h5 class="card-title whitexl"><?= $result['value'] ?></h5>
                                    </div> <!-- Fin card-body -->
                                </div> <!-- Fin card -->
                            </div> <!-- Fin col-md-6 -->
                        <?php endforeach; ?>

                        <!-- Actualizo las variables de sesión -->
                        <?php $_SESSION['dataIndex'] = $dataIndex; ?>
                        <?php $_SESSION['totalData'] = $totalData; ?>

                        <!-- Botones para paginar -->
                        <div class="buttons-container mt-3 d-flex justify-content-around">
                            <?php if ($dataIndex > 0) : ?>
                                <form method="post" action="index.php?controller=All&action=mostrarCards">
                                    <input type="hidden" name="dataIndex" value="<?= ($dataIndex - 1) ?>">
                                    <input type="hidden" name="totalData" value="<?= $totalData ?>">
                                    <button type="submit" name="accion" value="anterior" class="btn btn-primary">Anterior</button>
                                </form>
                            <?php endif; ?>

                            <?php if ($dataIndex < $totalData - 1) : ?>
                                <form method="post" action="index.php?controller=All&action=mostrarCards">
                                    <input type="hidden" name="dataIndex" value="<?= ($dataIndex + 1) ?>">
                                    <input type="hidden" name="totalData" value="<?= $totalData ?>">
                                    <button type="submit" name="accion" value="siguiente" class="btn btn-primary">Siguiente</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                No se han encontrado resultados
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            Ha ocurrido un error al cargar los datos
                        </div>
                    </div>
                <?php endif; ?>
            </div> <!-- Fin row -->
            <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a>
        </div> <!-- Fin container -->
    <?php
    }



    /**
     * Metodo que muestra la informacion de uun  
     * @param Recibe un array bidemensional, con la info en el indice 0
     * 
     */
    public function showArray($res)
    {
        var_dump($res);
        // die();
    ?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All </h1>
            <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary mb-3 ">Back</a>

            <table class="table--bs-table-bg table-striped table-hover table-custom">

                <thead class="table border">
                    <tr>
                        <th scope="col center">HABILIDADES</th>
                        <th scope="col center">PELICULAS</th>
                        <th scope="col center">NAME</th>
                        <th scope="col center">IMAGENES</th>
                        <th scope="col center">VERSIONES</th>
                        <th scope="col center">PUNTUACION</th>
                        <th scope="col center">TIPOS</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($res as $pokemon) {
                    ?>

                        <tr class="--bs-table-active-bg">
                            <td class="center"><?php
                                                //verifico que es un array antes de recorrerlo
                                                if (is_array($pokemon['abilities'])) {
                                                    foreach ($pokemon['abilities'] as $ability) {
                                                        echo $ability . ', ';
                                                    }
                                                } else {
                                                    echo $pokemon['abilities'];
                                                }
                                                ?>
                            </td>
                            <td class="center"><?=  //implode me convierte un array en un string , con el separador que yo quiera, en este caso una coma
                                                is_array($pokemon['movies']) ? implode(', ', $pokemon['movies']) : $pokemon['movies']
                                                ?></td>
                            <td class="center"><?= $pokemon['name'] ?></td>
                            <td class="center"><?= implode(', ', $pokemon['images']) ?></td>
                            <td class="center"><?= implode(', ', $pokemon['versions']) ?></td>
                            <td class="center"><?= $pokemon['score'] ?></td>
                            <td class="center"><?= implode(', ', $pokemon['types']) ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    /**
     * Metodo para mostrar elementos de un array 
     */
    public function showMultiCard($card)
    {
    ?>
        <div class="form-container">
            <!-- <h2>Aqui lo tienes: </h2> -->
            <?php
            foreach ($card['forms'] as $pok) {
                $name = $pok['name'];
            }
            echo '<h2>Nombre: ' . $name . '</h2>';

            echo '<img src="' . $card['sprites']['front_default'] . '">';
            ?>
            <!-- <img src="<?= $card //['sprites']['front_default'] 
                            ?>" alt="Pokemon Image"> -->
        </div>
        <a href="index.php?controller=All&action=requestId" class="btn btn-primary mb-3 ">Back</a>
<?php
    }


    function mensajeCheck($message)
    {
        echo '<nav class="navbar bg-success rounded m-2">
                    <div class="container-fluid">
                        <p>
                            ' . $message . '
                        </p>
                    </div>
                </nav>';
    }
    function mensajeError($message)
    {
        echo '<nav class="navbar bg-body-tertiary bg-danger rounded m-2">
                    <div class="container-fluid">
                        <p>
                            ' . $message . '
                        </p>
                    </div>
                </nav>';
    }
}
