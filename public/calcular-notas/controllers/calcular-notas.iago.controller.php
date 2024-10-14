<?php
declare(strict_types=1);
$data = [];
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

                var_dump($sumaNotas);

                //Contamos el numero de aprobados y el numero de suspensos que tenemos
                if($notas < 5){
                    $numeroSuspensos++;
                }
                else if($notas >= 5 && $notas <= 10){
                    $numeroAprobados++;
                }

                //Cual es la nota mas alta y quien la saca
                if($notas>$notaMasAlta){
                    $notaMasAlta=$notas;
                    $quienNotaMasAlta=$alumno;

                }

                if($notas<$notaMasBaja){
                    $notaMasBaja=$notas;
                    $quienNotaBaja=$alumno;
                }
                $notaMedia = $sumaNotas/$numAlumnos;
            }
        }
    }

    $resultados[$asignatura]=[
        'asignatura'=>$asignatura,
        'media' => $notaMedia,
        'numeroSuspensos' => $numeroSuspensos,
        'numeroAprobados' => $numeroAprobados,
        'notaMasAlta' => $notaMasAlta,
        'quienNotaMasAlta' => $quienNotaMasAlta,
        'notaMasBaja' => $notaMasBaja,
        'quienNotaMasBaja' => $quienNotaMasBaja,
    ];

}



/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/calcular_notas.iago.view.php';
include 'views/templates/footer.php';