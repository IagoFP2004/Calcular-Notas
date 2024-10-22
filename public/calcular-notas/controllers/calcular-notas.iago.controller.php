<?php
declare(strict_types=1);
$data = [];
if (isset($_POST['texto'])){
    $data['errors']= checkErrors($_POST["texto"]);
    $data['input']['texto'] = filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($data['errors'])){
            $resultados = [];
            $json = json_decode($_POST['texto'], true); // true para obtener arrays asociativos

            foreach ($json as $asignatura => $alumnos) {

// Inicializamos las variables para cada asignatura
                $notaMedia = 0;
                $numeroSuspensos = 0;
                $notaMasAlta = 0;
                $quienNotaMasAlta = '';
                $notaMasBaja = 10;
                $quienNotaMasBaja = '';
                $sumaNotas = 0;
                $numAlumnos = 0;

                foreach ($alumnos as $alumno => $notas) {
                    $alumnosA = $alumno;
                    $notaMediaAlumno=array_sum($notas)/count($notas);

                    if($notaMediaAlumno < 5){
                        $numeroSuspensos ++;
                    }

                    foreach ($notas as $nota) {

// Sumamos las notas
                        $sumaNotas += $nota;
                        $numAlumnos++;

// Nota más alta y quién la sacó
                        if ($nota > $notaMasAlta) {
                            $notaMasAlta = $nota;
                            $quienNotaMasAlta = $alumno;
                        }

// Nota más baja y quién la sacó
                        if ($nota < $notaMasBaja) {
                            $notaMasBaja = $nota;
                            $quienNotaMasBaja = $alumno;
                        }
                    }
                }

// Calculamos la media después de sumar todas las notas de los alumnos
                if ($numAlumnos > 0) {
                    $notaMedia = round($sumaNotas / $numAlumnos, 2);
                }

// Guardamos los resultados de esta asignatura
                $resultados[$asignatura] = [
                    'asignatura' => $asignatura,
                    'media' => $notaMedia,
                    'numeroSuspensos' => $numeroSuspensos,
                    'numeroAprobados' => count($alumnos)-$numeroSuspensos,
                    'notaMasAlta' => $notaMasAlta,
                    'quienNotaMasAlta' => $quienNotaMasAlta,
                    'notaMasBaja' => $notaMasBaja,
                    'quienNotaMasBaja' => $quienNotaMasBaja,
                ];
            }

            $data["resultados"] = $resultados;
            $data["listas"]=listaAlumnos($alumnos);
        }
}

function listaAlumnos(array $alumnos) :array
{
    $json = json_decode($_POST['texto'], true);
    $alumnosSuspensos = [];
    foreach ($json as $asignatura =>$alumnos){

        foreach ($alumnos as $alumno =>$notas){
            $mediaAsignaturaAlumno = round(array_sum($notas)/count($notas),2);

            if(!isset($alumnosSuspensos[$alumno])){
                $alumnosSuspensos[$alumno]=0;
            }
            if($mediaAsignaturaAlumno<5){
                $alumnosSuspensos[$alumno]++;
            }

        }


    }

    return $alumnosSuspensos;
}
/*
 * Funcion que comprueba que los datos introducidos al programa son correctos
 * */
function checkErrors(string $texto) : array
{
   //Array donde guardaremos los erroers
    $errors = [];
    //Si el texto esta vacio mostraremos un mensaje de error
    if(empty($texto)) {
        $errors['texto'][] = "El campo esta vacio inserte un json para que se pueda procear";
    }else{
        $json = json_decode($_POST['texto'], true);
        if (!is_array($json)) {//SI el json no es un array mostraremos un mensaje de error
            $errors['texto'][] = "El JSON no contiene un array válido";
        }else{
            foreach ($json as $asignaturas  =>$alumnos){//Accedemos a las asignaturas y a todos los alumnos con sus notas

                foreach ($alumnos as $alumno =>$notas){// Accedemos al nombre del alumno
                    if(!is_string($alumno)){//Si el nombre del alumno no es un string mostramos un mensaje de error
                        $errors['texto'][] = "El nombre del alumno $alumno en la asignatura $asignaturas no es valido";
                    }else{
                        foreach ($notas as $nota){//Accedemos a las notas por individual del alumno
                            if(!is_numeric($nota) || $nota < 0 || $nota > 10){//Si la nota no es un numero o no cumple con el formato habitual de puntuacion muestra un mensaje de erros
                                $errors['texto'][] = "La nota $nota del alumno $alumno en la asignatura $asignaturas no es valida";
                            }
                        }
                    }
                }

            }
        }
    }
    return $errors;
}

/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/calcular-notas.iago.view.php';
include 'views/templates/footer.php';