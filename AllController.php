<?php
if (!isset($_SESSION)) {
    session_start();
}
/**
 * Controlador de la página de vuelos.
 * @class VuelosController
 * @brief Controlador de la página de vuelos.
 */
class AllController
{
    private $View; //objeto de la clase Login_formview
    private $Service; //objeto de la clase VuelosService
    /**
     * Constructor de la clase Controller.
     * 
     */
    public function __construct()
    {
        $this->View = new View();
        $this->Service = new Service();
        $this->Service = new Service();
    }
    /**
     * Muestra la página de inicio 
     */
    public function mostrarInicio()
    {

        $this->View->initView(); //muestra la página de inicio 
    }
    /**
     * Pide al servidor el GET de una url y muestra la respuesta
     */
    public function request()
    {

        $results = json_decode($this->Service->request(), true); //pido al servicio que me de un random, true para que me devuelva un array asociativo
        //var_dump($results);

        $this->View->mostrarCard($results);
    }
    /**
     * pedir al servidor que me mande una lista para cargar un select 
     * 
     */

    public function select()
    {
        $res = $this->Service->requestListSelect(); //$res es un array con la info para cargar un select
        $this->View->showSelect($res); //muestra la vista con el select
        //RECUPERO VALORES POR EL NAME en el form de la vista METODO showSelect
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $selectSeleccionado = $_POST['tipo'];
            //var_dump($categoria);
            //mando a categoria para que el servicio monte la url
            $res = $this->Service->requestCategory($selectSeleccionado);
            //var_dump($res);
            $this->View->mostrarCard($res);
        }
    }
    /**
     * Metodo que pide al servidor la info dede un tema seleccionado
     * 
     */
    public function search()
    {
        $this->View->showSearch(); //muestra la vista para que el usuario introduzca el tema

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $search = $_POST['search'];
            //mando la categoria para que el servicio monte la url
            $res = $this->Service->requestSearch($search);
            //lo guardo en la sesion
            $_SESSION['search_result'] = $res;
            header('Location: index.php?controller=All&action=mostrarCards');
        }
    }
    /**
     * Muestra las cards con la info de la busqueda usando la sesion
     * @param $data array con la info de la busqueda
     * @param $dataIndex indice de la info de la busqueda
     * @param $totalData total de la info de la busqueda
     */
    public function mostrarCards($data = null, $dataIndex = 0, $totalData = 0)
    {
        // Obtener la respuesta de la sesión
        $data = $data ?? (isset($_SESSION['search_result']) ? $_SESSION['search_result'] : null);

        // Recuperar información de la sesión
        $dataIndex = isset($_SESSION['dataIndex']) ? (int)$_SESSION['dataIndex'] : 0;
        $totalData = isset($_SESSION['totalData']) ? (int)$_SESSION['totalData'] : 0;

        // Actualizar índice de datos si se hace clic en Anterior o Siguiente
        if (isset($_POST['accion']) && $_POST['accion'] == 'anterior' && $dataIndex > 0) {
            $dataIndex--;
        } elseif (isset($_POST['accion']) && $_POST['accion'] == 'siguiente' && $dataIndex < $totalData - 1) {
            $dataIndex++;
        }

        // Guardar información en la sesión
        $_SESSION['dataIndex'] = $dataIndex;
        $_SESSION['totalData'] = $totalData;
        $_SESSION['search_result'] = $data;



        // Redirigir a la vista
        $this->View->mostrarCards($data, $dataIndex, $totalData);
    }


    /**
     * Recibe el identificador del form y se lo manda al servicio
     * Manda a la vista la respuesta del servicio
     */
    public function requestId()

    {
        //le muestro el formulario para que introduzca el identificador
        $this->View->showSearch();

        //RECUPERO VALORES POR EL NAME en el form de la vista METODO showSearch
        if (isset($_POST['identificador'])) {
            $identificador = $_POST['identificador'];
        }
        //var_dump($identificador); //ok

        // Envía el identificador al servicio para procesar la información 
        if (isset($identificador)) {
            $res = $this->Service->requestId($identificador);
        } else {
            $res = null;
        }
        // Muestra el resultado en la vista correspondiente, quiero cargar un select con esto
        $this->View->showSelect($res);
    }

    /**
     * Metodo para realizar acciones de prrocesamiento de datos desde post
     * 
     */
    public function procesarselect()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $selectSeleccionado = $_POST['tipo'];
            //var_dump($selectSeleccionado);

            //tengo un valor sobre el que hacer otra peticion
            $res = $this->Service->requestCategory($selectSeleccionado);
            //var_dump($res);
            $this->View->showMultiCard($res);
        }
    }
}
