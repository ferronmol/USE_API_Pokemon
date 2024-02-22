<?php
class Service
{
    /******************  G E T *************************************
     * Metodo que pide al servidor la información sin parametros
     * 
     */

    public function request()
    {
        $url = "https://pokeapi.co/api/v2/versions/";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $url);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta, espera un array
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        // Verificar errores
        if ($res === false) {
            echo "Error en la solicitud: " . curl_error($conexion);
            return false;
        }

        // Verificar el código de estado HTTP
        $httpCode = curl_getinfo($conexion, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            echo "Error en la respuesta del servidor (código $httpCode)";
            return false;
        }

        // Cerrar la conexión
        curl_close($conexion);

        // Devolver la respuesta que es un JSON
        return $res;
    }

    /******************  G E T *************************************
     * Metodo que pide al servidor la info para cargar un select
     * @return Array  con la info para cargar un select
     */
    public function requestListSelect()
    {
        $urlmiservicio = "https://api.chucknorris.io/jokes/categories";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {
            // return $res sin el true  si queiro un objeto
            $resArray =  json_decode($res, true);
            curl_close($conexion);
            return $resArray;
        }
    }
    /******************  G E T *************************************
     * Metodo que pide al servidor la info  de una categoria PASANDOLE UN PARAMETRO
     * @param $categoria categoria de la que se quiere la info
     * @return Array con la info de la categoria
     */
    public function requestCategory($info)
    {
        // var_dump($info);
        $url = "https://pokeapi.co/api/v2/pokemon/" . $info . "/";

        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $url);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true); //
        $res = curl_exec($conexion);
        if ($res) {
            // return $res SIN TRUE  si queiro un objeto
            $resArray =  json_decode($res, true);
            curl_close($conexion);
            return $resArray;
        }
    }

    /**
     * Metodo que pide al servidor la info dede un tema seleccionado
     * @param $search tema que se quiere buscar
     * @return 
     */
    public function requestSearch($search)
    {
        //var_dump($search); //OK
        $url = "https://api.chucknorris.io/jokes/search?query=" . $search;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $url);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {
            // return $res sin el true  si queiro un objeto
            $res =  json_decode($res, true);
            curl_close($conexion);
            return $res;
        }
    }



    /*********** G  E   T *************************************
     * Metodo que pide al servidor la información CONCRETA LIMITADA 
     * @param $identificador 
     * @return Array bidemensional 
     */
    public function requestId($identificador)
    {
        //var_dump($identificador);
        //codificamos el identificador para que no de problemas en la url
        // $url = "https://pokeapi.co/api/v2/pokemon/" . $identificador . "/";
        // Verificamos que el identificador no sea mayor a 40
        if ($identificador > 40) {
            echo "Error: El número de Pokémon a cargar no puede ser mayor a 40.";
            return null;
        }
        $url = "https://pokeapi.co/api/v2/pokemon/?limit=" . $identificador;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $url);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res === false) {
            echo "Error en la solicitud: " . curl_error($conexion);
            curl_close($conexion);
            return null;
        }
        // return $res sin el true  si queiro un objeto
        $resArray =  json_decode($res, true);
        if ($resArray === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error al decodificar JSON: ' . json_last_error_msg();
            curl_close($conexion);
            return null;
        }

        // Cerrar la conexión cURL
        curl_close($conexion);

        // Devolver el resultado
        //var_dump($resArray);
        return $resArray;
    }

    /*********** D E L E T E *************************************
     * Metodo que pide al servidor que borre un vuelo
     * @param $idVuelo identificador del vuelo
     * @return void
     */
    public function deleteFlight($idVuelo)
    {
        $urlmiservicio = "http://localhost/_servWeb/serviciosVuelos/Flight.php?id=" . $idVuelo;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, "DELETE");
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {

            $resArray =  json_decode($res, true); //array asociativo
            // return $res; si queiro un objeto
            // $res = json_decode($res); //objeto
            curl_close($conexion);
            return $resArray;
        }
    }
}
