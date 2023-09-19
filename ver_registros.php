<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

function lerRegistros() {
    if (file_exists('alunos.txt')) {
        $registros = [];
        $linhas = file('alunos.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($linhas as $linha) {
            list($nome, $ra, $placa) = explode('|', $linha);
            $registros[] = ['Nome' => $nome, 'R.A.' => $ra, 'Placa' => $placa];
        }
        return $registros;
    } else {
        return [];
    }
}

$alunos = lerRegistros();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registros Cadastrados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            padding: 30px;
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table-container {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .table-container th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registros Cadastrados</h1>
        <div class="table-container">
            <table>
                <tr>
                    <th>Nome Completo</th>
                    <th>Registro Acadêmico (R.A.)</th>
                    <th>Placa do Carro ou Moto</th>
                </tr>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= $aluno['Nome'] ?></td>
                    <td><?= $aluno['R.A.'] ?></td>
                    <td><?= $aluno['Placa'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <a class="btn-primary" href="index.php">Voltar</a>
    </div>
</body>
</html>
