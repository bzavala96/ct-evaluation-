<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

class Generic extends Controller
{
    public function index()
    {
        //$notas = App\Models\Nota::all();
        $aletorio = $this->generar_string_aleatorio();
        $data1 = $this->clasificar_arreglo_aleatorio($aletorio);
        $data2 = $this->cargar_personas();
        $params = array(
            'arregloAleatorio'=>implode("",$aletorio),
            'numeros' => implode("", $data1['numeros']),
            'letras' => implode("", $data1['letras']),
            'letrasOrdenadas' => implode("", $data1['letrasOrdenadas']),
            'suma' => $data1['suma'],
            'totalPersonas' => $data2['totalPersonas'],
            'totalMujeres' => $data2['totalMujeres'],
            'paises' => $data2['paises'],
        );

        switch (Route::currentRouteName()) 
        {
            case 'question-1.1':
                $resultado ="ARREGLO GENERADO: ";
                $resultado .= $params['arregloAleatorio'];
                break;
            case 'question-1.2':
                $resultado ="ARREGLO GENERADO: ";
                $resultado .= $params['arregloAleatorio'];
                $resultado .="  NUMEROS: ";
                $resultado .= $params['numeros'];
                $resultado .="  LETRAS: ";
                $resultado .= $params['letras'];
                break;
            case 'question-1.3':
                $resultado ="ARREGLO GENERADO: ";
                $resultado .= $params['arregloAleatorio'];
                $resultado .="  NUMEROS: ";
                $resultado .= $params['numeros'];
                $resultado .="  LETRAS: ";
                $resultado .= $params['letras'];
                $resultado .="  SUMA: ";
                $resultado .= $params['suma'];
                break;
            case 'question-1.4':
                $resultado ="ARREGLO GENERADO: ";
                $resultado .= $params['arregloAleatorio'];
                $resultado .="  NUMEROS: ";
                $resultado .= $params['numeros'];
                $resultado .="  LETRAS: ";
                $resultado .= $params['letras'];
                $resultado .="  ORDENADO: ";
                $resultado .= $params['letrasOrdenadas'];
                # code...
                break;
            case 'question-1.5':
                $resultado ="PERSONAS: ";
                $resultado .= $params['totalPersonas'];
                break;
            case 'question-1.6':
                $resultado ="TOTAL PERSONAS FEMENINAS: ";
                $resultado .= $params['totalMujeres'];
                break;    
            case 'question-1.7':
                $resultado = "";
                foreach ($params['paises'] as $key => $value) {
                    $resultado .= $key."(".$value.") , ";
                }
                break; 
            default:
                # code...
                break;
        }
        return $resultado;
    }

    //--------------------------------------------------------------------
    //FASE 1
    //Bloque 1: Manejo de estructuras básico
    //--------------------------------------------------------------------
    //1)Genera un arreglo de 100 elementos aleatorios entre string y números.
    public function generar_string_aleatorio()
    {
        $caracteres = "abcdefghijklmnopqrstuvwxyz0123456789";
        $arregloString = str_split($caracteres);
        $longitud = count($arregloString)-1;
        $arregloAleatorio = array();
        $longitud_arreglo = 100;
        for ($i=0; $i < $longitud_arreglo; $i++) { 
            $indiceArreglo = rand(0, $longitud);
            $caracter = $arregloString[$indiceArreglo];//$cadena[5]
            array_push($arregloAleatorio, $caracter);
        }        
        return $arregloAleatorio;
    }
    //2) El arreglo anterior clasificarlo en 2 arreglos obteniendo sus elementos strings y sus elementos numéricos.
    public function clasificar_arreglo_aleatorio($arregloAleatorio)
    {
        $arregloString = array();
        $arregloNumeros = array();
        foreach($arregloAleatorio as $caracter){
            if(is_numeric($caracter)){
                array_push($arregloNumeros, (int) $caracter);
            }else{
                array_push($arregloString, $caracter);
            }
        }

        //3) Del arreglo numérico obtener la suma de todos sus valores.
        $suma = array_sum($arregloNumeros);
        //4) Del arreglo de strings ordenar las cadenas alfabéticamente.
        $arregloOrdenado = $arregloString;
        sort($arregloOrdenado);

        return array('numeros'=> $arregloNumeros, 'letras'=>$arregloString, 'letrasOrdenadas'=>$arregloOrdenado, 'suma'=>$suma);
    }

    //Bloque 2: Manejo de estructuras intermedio con uso de datos externos

    public function cargar_personas()
    {
    //5) Cargue las personas del archivo json y almacenarlas en un arreglo. 
    $jsonPersonas = file_get_contents('http://developers.ctdesarrollo.org/triofrio/json-dbs/persons.json');
    $personas = json_decode($jsonPersonas, true);
    //6) Determinar cuántas de esas personas son del género femenino.
    $mujeres = array();
    $mujeres = array_filter($personas, function($x){ return $x['gender'] === 'f'; });
    //7) Agrupar los resultados por país y obtener la cantidad de personas por cada uno.
    $grupoPersonasPorCiudad = $this->group_by('country',$personas);
    $paises = array();
    foreach ($grupoPersonasPorCiudad as $key => $value) {
        $paises[$key] = count($value);        
    }
    return array('totalPersonas'=> count($personas), 'totalMujeres'=> count($mujeres), 'paises'=> $paises);
    }

    function group_by($key, $data) {
        $result = array();
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
        return $result;
    }
}