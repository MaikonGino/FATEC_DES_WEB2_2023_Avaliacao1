<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

function cadastrarAluno($nome, $ra, $placa) {
    $registro = "$nome|$ra|$placa" . PHP_EOL;
    file_put_contents('alunos.txt', $registro, FILE_APPEND);
    $_SESSION['registro_criado'] = true;
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $ra = $_POST['ra'];
    $placa = $_POST['placa'];
    cadastrarAluno($nome, $ra, $placa);
}
$alunos = lerRegistros();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Alunos</title>
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn-primary {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Alunos</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label for="ra">Registro Acadêmico (R.A.):</label>
                <input type="text" name="ra" required>
            </div>

            <div class="form-group">
                <label for="placa">Placa do Carro ou Moto:</label>
                <input type="text" name="placa" required>
            </div>

            <button class="btn-primary" type="submit">Cadastrar</button>
            <div class="button-container">
            <?php if (isset($_SESSION['registro_criado']) && $_SESSION['registro_criado'] === true): ?>
            </p>Cadastrado com Sucesso</p>
            <?php unset($_SESSION['registro_criado']); ?>
            <?php endif; ?>

        </form>
    </div>

    <div class="table-container"></div>
    <a class="btn-secondary" href="ver_registros.php"><button class="btn-primary" type="submit">Ver Registros</button></a>
    <a href="logout.php"><button class="btn-primary" type="submit">Sair</button></a>
</div>
   

</body>
</html>
