<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #616a6b ;
        }

        .calculator {
            background-color:#fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .display {
            width: 240px;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #eee;
            text-align: right;
            font-size: 24px;
            border-radius: 5px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 60px);
            grid-gap: 10px;
        }

        button, input[type="submit"] {
            padding: 20px;
            font-size: 18px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #e0e0e0;
            transition: background-color 0.2s ease;
        }

        button:hover, input[type="submit"]:hover {
            background-color: #34495e;
        }

        .operator {
            background-color: #f9a825;
        }

        .operator:hover {
            background-color: #f57f17;
        }

        .equal {
            background-color: #4caf50;
            grid-column: span 4;
        }

        .equal:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

    <?php
    // Initializing variables
    $display = "";
    $expression = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['display'])) {
            $expression = $_POST['display']; 
        }

        if (isset($_POST['digit'])) {
            $expression .= $_POST['digit'];
        }

        if (isset($_POST['operator'])) {
            $expression .= " " . $_POST['operator'] . " ";
        }

        //functionalities for percentage, square root, and logarithm
        if (isset($_POST['special'])) {
            $operator = $_POST['special'];

            switch ($operator) {
                case 'sqrt':
                    $result = sqrt(floatval($expression));
                    $display = $result;
                    $expression = ""; 
                    break;
                case 'log':
                    if (floatval($expression) > 0) {
                        $result = log(floatval($expression)); 
                        $display = $result;
                    } else {
                        $display = "Error: Logarithm requires positive number.";
                    }
                    $expression = "";
                    break;
                case 'percent':
                    $result = floatval($expression) / 100;
                    $display = $result;
                    $expression = "";
                    break;
            }
        }

        if (isset($_POST['equal'])) {
            try {
                $result = eval("return $expression;");
                $display = $result;
                $expression = "";
            } catch (Exception $e) {
                $display = "Error";
            }
        }

        if (isset($_POST['clear'])) {
            $expression = "";
            $display = "";
        }
    }
    ?>

    <div class="calculator">
        <form method="post">
            <!-- Display Screen -->
            <input type="text" class="display" name="display" value="<?php echo htmlspecialchars($expression . $display); ?>" disabled>
            <input type="hidden" name="display" value="<?php echo htmlspecialchars($expression); ?>">
            
            <div class="buttons">
                <!-- Digits -->
                <button type="submit" name="digit" value="1">1</button>
                <button type="submit" name="digit" value="2">2</button>
                <button type="submit" name="digit" value="3">3</button>

                <button type="submit" name="operator" value="+">+</button>

                <button type="submit" name="digit" value="4">4</button>
                <button type="submit" name="digit" value="5">5</button>
                <button type="submit" name="digit" value="6">6</button>

                <button type="submit" name="operator" value="-">-</button>

                <button type="submit" name="digit" value="7">7</button>
                <button type="submit" name="digit" value="8">8</button>
                <button type="submit" name="digit" value="9">9</button>

                <button type="submit" name="operator" value="*">×</button>

                <button type="submit" name="digit" value="0">0</button>
                <button type="submit" name="operator" value="/">÷</button>
                <button type="submit" name="clear" value="C">C</button>

                <!-- Special operations -->
                <button type="submit" name="special" value="sqrt">√</button>
                <button type="submit" name="special" value="log">Log</button>
                <button type="submit" name="special" value="percent">%</button>

                <!-- Equal button -->
                <input type="submit" class="equal" name="equal" value="=">
            </div>
        </form>
    </div>

</body>
</html>
