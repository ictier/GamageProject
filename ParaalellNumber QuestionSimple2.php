<?php
$series = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST["number_one"];
    $b = $_POST["number_two"];
    $occ = $_POST["occurrences"];

    // Step (difference)
    $d = $b - $a;

    // Generate series using difference
    for ($i = 0; $i < $occ; $i++) {
        $series[] = $a + $i * $d;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Number Series Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background: white;
            width: 350px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .output {
            margin-top: 15px;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Number Series Generator</h2>

    <form method="post">
        <input type="number" name="number_one" placeholder="Enter Number One" required>
        <input type="number" name="number_two" placeholder="Enter Number Two" required>
        <input type="number" name="occurrences" placeholder="How many numbers?" required>
        <button type="submit">Generate</button>
    </form>

    <?php if (!empty($series)): ?>
        <div class="output">
            <strong>Difference (Step):</strong> <?php echo $d; ?><br><br>
            <strong>Series:</strong><br>
            <?php echo implode(", ", $series); ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
