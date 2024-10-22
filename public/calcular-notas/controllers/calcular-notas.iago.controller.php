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

function checkErrors(string $texto) : array
{
   
    $errors = [];

    if(empty($texto)) {
        $errors['texto'][] = "El campo esta vacio inserte un json";
    }
    return $errors;
}

/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/calcular-notas.iago.view.php';
include 'views/templates/footer.php';