<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">Calcular Notas</h1>

</div>

<!-- Content Row -->

<div class="row">

    <div class="col-12">

        <div class="card shadow mb-4">

            <div

                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary">Datos asignaturas</h6>

            </div>

            <!-- Card Body -->

            <div class="card-body">

                <!--<form action="./?sec=formulario" method="post">                   -->

                <form method="post">

                    <!--<input type="hidden" name="sec" value="iterativas01" />-->

                    <div class="mb-3">

                        <label for="texto">Datos a analizar:</label>
                        <?php if (isset($data["resultados"])){ ?>
                        <table border="1px solid">
                            <thead>
                            <th>Modulo</th>
                            <th>Media</th>
                            <th>nSuspensos</th>
                            <th>nAprobados</th>
                            <th>Mas Alta</th>
                            <th>Quien</th>
                            <th>Mas Baja</th>
                            <th>Quien</th>
                            </thead>
                            <tbody>
                            <?php }?>
                            <?php

                            foreach ($data["resultados"] as $asignatura =>$result) {
                                echo "<tr>";

                                echo "<td>" . $result['asignatura'] . "</td>";
                                echo "<td>" . $result['media'] . "</td>";
                                echo "<td>" . $result['numeroSuspensos'] . "</td>";
                                echo "<td>" . $result['numeroAprobados'] . "</td>";
                                echo "<td>" . $result['notaMasAlta'] . "</td>";
                                echo "<td>" . $result['quienNotaMasAlta'] . "</td>";
                                echo "<td>" . $result['notaMasBaja'] . "</td>";
                                echo "<td>" . $result['quienNotaMasBaja'] . "</td>";

                                echo "</tr>";

                            }
                            ?>
                            <textarea class="form-control" name="txt" id="txt" rows="10" placeholder="Inserte el json a analizar"><?php echo isset($data['input']['texto']) ? $data['input']['texto'] : ''; ?></textarea>

                            <p class="text-danger small"><?php echo isset($data['errores']['texto']) ? $data['errores']['texto'] : ''; ?></p>

                    </div>

                    <div class="mb-3">

                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>