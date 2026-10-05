<!DOCTYPE html>
<html>
<head>
    <title>PHP Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        form {
            margin-bottom: 20px;
        }
        input, select {
            padding: 5px;
            margin: 5px;
        }
        .result {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: darkblue;
        }
    </style>
</head>
<body>

<h2>Simple PHP Calculator</h2>
<form method="post" action="">
    <input type="number" name="num1" required placeholder="Enter first number">
    
    <select name="operator" required>
        <option value="+">+</option>
        <option value="-">−</option>
        <option value="*">×</option>
        <option value="/">÷</option>
    </select>
    
    <input type="number" name="num2" required placeholder="Enter second number">
    <input type="submit" name="calculate" value="Calculate">
</form>

<?php
if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operator = $_POST['operator'];
    $result = "";

    switch ($operator) {
        case "+":
            $result = $num1 + $num2;
            break;
        case "-":
            $result = $num1 - $num2;
            break;
        case "*":
            $result = $num1 * $num2;
            break;
        case "/":
            if ($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = "Error! Division by zero.";
            }
            break;
        default:
            $result = "Invalid operator selected.";
    }

    echo "<div class='result'>Result: $result</div>";
}
?>

</body>
</html>
