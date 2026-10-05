<?php
// parallel_series.php
// Generates parallel number pairs preserving the difference between the first two numbers.

// Initialize variables
$a_input = $b_input = $occ_input = "";
$error = "";
$pairs = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Read and sanitize input
    $a_input = trim($_POST['number_one'] ?? "");
    $b_input = trim($_POST['number_two'] ?? "");
    $occ_input = trim($_POST['occurrences'] ?? "");

    // Validate presence
    if ($a_input === "" || $b_input === "" || $occ_input === "") {
        $error = "All fields are required.";
    } else {
        // Accept integers or floats; use filter to allow negative and decimal numbers safely
        if (!is_numeric($a_input) || !is_numeric($b_input)) {
            $error = "Number One and Number Two must be numeric.";
        } elseif (!ctype_digit($occ_input) || intval($occ_input) <= 0) {
            // occurrences must be a positive integer
            $error = "Number of occurrences must be a positive integer.";
        } else {
            // Convert to numbers
            $a = floatval($a_input);
            $b = floatval($b_input);
            $occ = intval($occ_input);

            // Calculate difference (step)
            $d = $b - $a;

            // Generate pairs preserving the difference d
            for ($k = 0; $k < $occ; $k++) {
                $x = $a + $k * $d;
                $y = $b + $k * $d;
                // Store numeric values; keep floats with sensible formatting later
                $pairs[] = ['left' => $x, 'right' => $y];
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Parallel Number Series (Fixed Difference)</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
    :root { --accent: #0b6efd; --muted: #666; --card-bg: #fff; --bg: #f3f6fb; }
    body {
        font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: var(--bg);
        margin: 0;
        padding: 36px;
        color: #222;
    }
    .wrap {
        max-width: 880px;
        margin: 0 auto;
    }
    .card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(15,23,42,0.06);
        padding: 22px;
    }
    h1 {
        margin: 0 0 12px 0;
        font-size: 20px;
    }
    p.lead {
        margin: 0 0 18px 0;
        color: var(--muted);
        font-size: 14px;
    }
    form.grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        align-items: end;
    }
    label { font-size: 13px; color: #333; display:block; margin-bottom:6px; }
    .field {
        display: flex; flex-direction: column;
    }
    input[type="text"], input[type="number"] {
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #d7dde6;
        font-size: 15px;
        outline: none;
    }
    input[type="number"]:focus, input[type="text"]:focus { box-shadow: 0 0 0 3px rgba(11,110,253,0.08); border-color: var(--accent); }
    .full { grid-column: 1 / -1; display:flex; gap:10px; }
    button {
        background: var(--accent);
        color: white;
        border: none;
        padding: 10px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
    }
    .meta {
        margin-top: 16px;
        color: var(--muted);
        font-size: 13px;
    }

    /* Results table */
    .results {
        margin-top: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
        font-size: 15px;
    }
    th, td {
        padding: 10px 12px;
        border-bottom: 1px solid #eef2f7;
        text-align: center;
    }
    th {
        background: linear-gradient(90deg, var(--accent), #0a58d5);
        color: white;
        font-weight: 600;
    }
    td.left { text-align: right; }
    td.sep { width: 8px; color: var(--muted); font-weight: 700; }
    .error {
        margin-top: 12px;
        color: #a61b1b;
        background: #fff1f0;
        border: 1px solid #fccaca;
        padding: 10px;
        border-radius: 8px;
    }
    .summary {
        margin-top: 12px;
        font-size: 14px;
        color: #333;
    }
    @media (max-width: 640px) {
        form.grid { grid-template-columns: 1fr; }
    }
</style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Parallel Number Series — fixed difference</h1>
        <p class="lead">Enter two starting numbers; the difference between them is used as the step. Each pair keeps the same distance. Example: if Number One = 2 and Number Two = 5, step = 3; pairs → (2,5), (5,8), (8,11), ...</p>

        <?php if ($error): ?>
            <div class="error" role="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" class="grid" novalidate>
            <div class="field">
                <label for="number_one">Number One (first value)</label>
                <input id="number_one" name="number_one" type="text" inputmode="decimal"
                       value="<?php echo htmlspecialchars($a_input); ?>" required>
            </div>

            <div class="field">
                <label for="number_two">Number Two (second value)</label>
                <input id="number_two" name="number_two" type="text" inputmode="decimal"
                       value="<?php echo htmlspecialchars($b_input); ?>" required>
            </div>

            <div class="field">
                <label for="occurrences">Number of occurrences (pairs)</label>
                <input id="occurrences" name="occurrences" type="number" min="1" step="1"
                       value="<?php echo htmlspecialchars($occ_input); ?>" required>
            </div>

            <div class="field">
                <label>&nbsp;</label>
                <div style="display:flex; gap:10px;">
                    <button type="submit">Generate</button>
                    <button type="reset" onclick="location.href=location.pathname">Reset</button>
                </div>
            </div>

            <div class="full">
                <div class="meta">
                    The program computes <code>d = NumberTwo − NumberOne</code> and outputs pairs <code>(a + k·d, b + k·d)</code>.
                </div>
            </div>
        </form>

        <?php if (!empty($pairs)): ?>
            <div class="results">
                <div class="summary">
                    Input: Number One = <strong><?php echo htmlspecialchars($a_input); ?></strong>,
                    Number Two = <strong><?php echo htmlspecialchars($b_input); ?></strong>,
                    Occurrences = <strong><?php echo htmlspecialchars($occ_input); ?></strong>.
                    Calculated difference (step) = <strong><?php
                        // show d with trimmed trailing zeros
                        $d_fmt = rtrim(rtrim(number_format($d, 10, '.', ''), '0'), '.');
                        echo htmlspecialchars($d_fmt);
                    ?></strong>.
                </div>

                <table aria-label="Parallel series table">
                    <thead>
                        <tr>
                            <th>Series A</th>
                            <th></th>
                            <th>Series B</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Helper to format numbers: show integer without .0, otherwise trim trailing zeros
                    function fmt_num($n) {
                        if (is_nan($n) || is_infinite($n)) return (string)$n;
                        if (intval($n) == $n) return (string)intval($n);
                        // otherwise format up to 10 decimal places and trim
                        $s = number_format($n, 10, '.', '');
                        return rtrim(rtrim($s, '0'), '.');
                    }
                    foreach ($pairs as $p): ?>
                        <tr>
                            <td class="left"><?php echo htmlspecialchars(fmt_num($p['left'])); ?></td>
                            <td class="sep">→</td>
                            <td class="right"><?php echo htmlspecialchars(fmt_num($p['right'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
