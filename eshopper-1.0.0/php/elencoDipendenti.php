<?php
include("sessioni.php");
include("connection.php");


if (isset($_GET["idDipendente"])) {
    $sql = "DELETE FROM dipendente WHERE id=$_GET[idDipendente]";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Dipendenti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        #divProfilo {
            border: 3px solid black;
            padding: 5px;
            margin: 10px;
        }
    </style>
    <script>
        function change(id) {
            var richiesta = window.confirm("vuoi cancellarmi?");
            if (richiesta) {
                window.location.replace('elencoDipendenti.php?idDipendente=' + id);
            }
        }

        function filtra() {
            var cognome = document.getElementById("cognome").value;
            var reparto = document.getElementById("reparto").value;
            var qualifica = document.getElementById("qualifica").value;
            var livello = document.getElementById("livello").value;
            var annoP = document.getElementById("annoP").value;

            let sql = "Select * from dipendente join reparto on codiceR = reparto.codice where ";
            let i = false;
            if (cognome != "null") {
                i = true;
                sql += "cognome like '" + cognome + "'";
            }
            if (reparto != "null") {
                sql += and(i);
                sql += "denominazione like '" + reparto + "' ";
                i = true;
            }
            if (qualifica != "null") {
                sql += and(i);
                sql += "qualifica like '" + qualifica + "' ";
                i = true;
            }
            if (livello != "null") {
                sql += and(i);
                sql += "livello <= " + livello + " ";
                i = true;
            }
            if (annoP != "null") {
                sql += and(i);
                sql += "annoP = " + annoP + " ";
                i = true;
            }
            window.location.replace("elencoDipendenti.php?sql=" + sql);
        }

        function annulla() {
            window.location.replace("elencoDipendenti.php?");
        }

        function and(i) {
            if (i == true) {
                return " AND ";
            } else
                return "";
        }
    </script>


</head>

<body>


    <?php
    if (isset($_SESSION["username"])) {


        echo "Benvenuto  $_SESSION[username] <br>";
        $rigaFiltri = "<select id='cognome'>
        <option value='null'></option >";
        $sql = "SELECT distinct cognome FROM dipendente";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rigaFiltri .= "<option>$row[cognome]</option >";
        }
        $rigaFiltri .= "</select>";
        echo "Cognome: " . $rigaFiltri;

        $rigaFiltri = "<select id='reparto' ><option value='null'></option >";
        $sql = "SELECT distinct codiceR, denominazione FROM dipendente join reparto on codiceR = reparto.codice";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rigaFiltri .= "<option>$row[denominazione]</option >";
        }
        $rigaFiltri .= "</select>";
        echo "Reparto: " . $rigaFiltri;

        $rigaFiltri = "<select id='qualifica'><option value='null'></option >";
        $sql = "SELECT distinct qualifica FROM dipendente";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rigaFiltri .= "<option>$row[qualifica]</option >";
        }
        $rigaFiltri .= "</select>";
        echo "Qualifica: " . $rigaFiltri;

        $rigaFiltri = "<select id='livello'><option value='null'></option >";
        $sql = "SELECT distinct livello FROM dipendente";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rigaFiltri .= "<option>$row[livello]</option >";
        }
        $rigaFiltri .= "</select>";
        echo "Livello: " . $rigaFiltri;

        $rigaFiltri = "<select id='annoP'><option value='null'></option >";
        $sql = "SELECT distinct annoP FROM dipendente";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rigaFiltri .= "<option>$row[annoP]</option >";
        }
        $rigaFiltri .= "</select>";
        echo "AnnoP: " . $rigaFiltri;

        echo "<input type='button' value='filtra' onclick='filtra()' />";
        echo "<input type='button' value='annulla filtro' onclick='annulla()' />";

        // $var="";
        // if (isset($_GET["zonaFiltro"] ))
        //     $var = $_GET["zonaFiltro"];      

        // if ($var == "") {
        //     $sql = "SELECT * FROM casa";
        // } else
        //     $sql = "SELECT * FROM casa where zona like '%$_GET[zonaFiltro]%'";

        // $result = $conn->query($sql);
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title m-b-0">Elenco Dipendenti</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th> </th>
                                    <th scope="col">Cognome</th>
                                    <th scope="col">Qualifica</th>
                                    <th scope="col">Livello</th>
                                    <th scope="col">Anno Promozione</th>
                                    <th scope="col">Codice Reparto</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody class="customtable">
                                <?php
                                if (isset($_SESSION["username"])) {
                                    $stringa = "";
                                    $sql = "SELECT * FROM dipendente";
                                    if (isset($_GET["sql"])) {
                                        $sql = $_GET["sql"];
                                        echo $sql;
                                    }
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        $stringa .= "
                            <tr>
                                <th>$row[id]</th>
                                <td>$row[cognome]</td>
                                <td>$row[qualifica]</td>
                                <td>$row[livello]</td>
                                <td>$row[annoP]</td>
                                <td>$row[codiceR]</td>
                                <td><input type='button' value='Cancella dipendente' onclick='change($row[id])' /></td>
                            </tr>";
                                    }
                                    echo $stringa;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <bottom>
        <a href='../inserimentoDipendente.html'>Inserisci dipendente</a> <br>
        <a href='sessioniDestroy.php'>Log out</a>
    </bottom>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>



</html>