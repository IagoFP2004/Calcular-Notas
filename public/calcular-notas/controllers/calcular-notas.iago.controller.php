<?php
declare(strict_types=1);

if(isset($_POST['txt']))
{
    $resultados = [];
    $json = json_decode($_POST['txt']);

    foreach ($json as $asignatura =>$alumnos) {

        $notaMedia=0;
        $numeroSuspensos=0;
        $numeroAprobados=0;
        $notaMasAlta=0;
        $quieNotaMasAlta=0;
        $notaMasBaja=10;
        $quienNotaMasBaja=0;
        $sumaNotas=0;
        $numAlumnos =0;


        foreach ($alumnos as $alumno =>$notas) {
            foreach ($notas as $nota) {

                //Sumamos las notas
                $sumaNotas+=$nota;
                $numAlumnos++;

                //Contamos el numero de aprobados y el numero de suspensos que tenemos
                if($nota < 5){
                    $numeroSuspensos++;
                }
                else if($nota >= 5 && $nota <= 10){
                    $numeroAprobados++;
                }

                //Cual es la nota mas alta y quien la saca
                if($nota>$notaMasAlta){
                    $notaMasAlta=$nota;
                    $quienNotaMasAlta=$alumno;

                }

                if($nota<$notaMasBaja) {
                    $notaMasBaja = $nota;
                    $quienNotaBaja = $alumno;
                }
            }
            $notaMedia = round($sumaNotas/$numAlumnos,2);
        }
        $resultados[$asignatura]=[
            'asignatura'=>$asignatura,
            'media' => $notaMedia,
            'numeroSuspensos' => $numeroSuspensos,
            'numeroAprobados' => $numeroAprobados,
            'notaMasAlta' => $notaMasAlta,
            'quienNotaMasAlta' => $quienNotaMasAlta,
            'notaMasBaja' => $notaMasBaja,
            'quienNotaMasBaja' => $quienNotaBaja,
        ];
    }


    $data["resultados"] = $resultados;
}



/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/calcular-notas.iago.view.php';
include 'views/templates/footer.php';