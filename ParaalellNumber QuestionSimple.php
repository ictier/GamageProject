<?php
$series = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST["number_one"];
    $b = $_POST["number_two"];
    $occ = $_POST["occurrences"];

    // Step (difference)
    $d = $b - $a;

    // Generate series only using the difference
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
        body { font-family: Arial; padding: 20px; }
        input { padding: 8px; margin: 5px; width: 200px; }
        button { padding: 8px 15px; }
        .output { margin-top: 20px; font-size: 18px; }
    </style>
</head>
<body>

<h2>Number Series Generator (Using Difference)</h2>

<form method="post">
    <label>Number One:</label><br>
    <input type="number" name="number_one" required><br>

    <label>Number Two:</label><br>
    <input type="number" name="number_two" required><br>

    <label>Occurrences:</label><br>
    <input type="number" name="occurrences" required><br><br>

    <button type="submit">Generate</button>
</form>

<?php if (!empty($series)): ?>
    <div class="output">
        <strong>Difference (Step):</strong> <?php echo $d; ?><br><br>
        <strong>Series:</strong><br>
        <?php echo implode(", ", $series); ?>
    </div>
<?php endif; ?>

</body>
</html>
