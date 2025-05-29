<?php
$subjectsByType = [
    'physical_sciences' => [
        'Arabic' => 2,
        'French' => 4,
        'English' => 2,
        'Philosophy' => 2,
        'Mathematics' => 7,
        'Life and Earth Sciences' => 5,
        'Translation' => 4,
        'Islamic Education' => 2,
        'Sports' => 4,
        'Attendance and Behavior' => 1,
        'Physics' => 7
    ],
    'life_earth_sciences' => [
        'Arabic' => 2,
        'French' => 4,
        'English' => 2,
        'Philosophy' => 2,
        'Mathematics' => 7,
        'Life and Earth Sciences' => 7,
        'Tradition' => 4,
        'Islamic Education' => 2,
        'Sports' => 4,
        'Attendance and Behavior' => 1,
        'Physics' => 5
    ],
    'life_agricultural_sciences' => [
        'Arabic' => 2,
        'French' => 4,
        'English' => 2,
        'Philosophy' => 2,
        'Mathematics' => 7,
        'Life and Earth Sciences' => 5,
        'Botanical Sciences' => 5,
        'Tradition' => 4,
        'Social Studies' => 2,
        'Islamic Education' => 2,
        'Sports' => 4,
        'Attendance and Behavior' => 1,
        'Physics' => 5
    ],
    'mathematical_sciences_a' => [
        'Arabic' => 2,
        'French' => 4,
        'English' => 2,
        'Philosophy' => 2,
        'Mathematics' => 9,
        'Life and Earth Sciences' => 3,
        'Tradition' => 4,
        'Islamic Education' => 2,
        'Sports' => 4,
        'Attendance and Behavior' => 1,
        'Physics' => 7
    ],
    'mathematical_sciences_b' => [
        'Arabic' => 2,
        'French' => 4,
        'English' => 2,
        'Philosophy' => 2,
        'Mathematics' => 9,
        'Engineering Science' => 3,
        'Tradition' => 4,
        'Islamic Education' => 2,
        'Sports' => 4,
        'Attendance and Behavior' => 1,
        'Physics' => 7
    ]
];

$grades = [];
$totalWeightedSum = 0;
$totalCoefficients = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bacType = $_POST['bac_type'] ?? '';
    if (!isset($subjectsByType[$bacType])) {
        $error = "Invalid baccalaureate type selected.";
    } else {
        $subjects = $subjectsByType[$bacType];
        foreach ($subjects as $subject => $coefficient) {
            if (isset($_POST['grades'][$subject])) {
                $grade = floatval($_POST['grades'][$subject]);
                if ($grade >= 0 && $grade <= 20) {
                    $grades[$subject] = $grade;
                    $totalWeightedSum += $grade * $coefficient;
                    $totalCoefficients += $coefficient;
                } else {
                    $error = "All grades must be between 0 and 20.";
                    break;
                }
            } else {
                $error = "Missing grade for $subject.";
                break;
            }
        }

        if (!isset($error)) {
            $finalGrade = $totalWeightedSum / $totalCoefficients;

            if ($finalGrade < 10) {
                $status = "Failed";
                $statusClass = "text-red-500";
                $bgClass = "bg-red-100";
                $borderClass = "border-red-300";
            } elseif ($finalGrade < 12) {
                $status = "Passed";
                $statusClass = "text-yellow-500";
                $bgClass = "bg-yellow-100";
                $borderClass = "border-yellow-300";
            } else {
                $status = "Passed with Distinction";
                $statusClass = "text-green-500";
                $bgClass = "bg-green-100";
                $borderClass = "border-green-300";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baccalaureate Grade Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white bg-opacity-95 shadow-2xl rounded-3xl overflow-hidden backdrop-filter backdrop-blur-lg">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h1 class="text-3xl font-bold text-center">Baccalaureate Grade Result</h1>
            <p class="text-center mt-2 text-blue-100">Your final grade and subject performance</p>
        </div>

        <div class="p-8">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Error</p>
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php elseif (isset($finalGrade)): ?>
                <div id="result" class="space-y-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">Your Final Grade</p>
                            <p class="text-4xl font-bold <?= $statusClass ?>"><?= number_format($finalGrade, 2) ?><span class="text-xl text-gray-500">/20</span></p>
                        </div>
                        <div class="<?= $bgClass ?> <?= $borderClass ?> border rounded-full px-4 py-2">
                            <p class="<?= $statusClass ?> font-semibold"><?= htmlspecialchars($status) ?></p>
                        </div>
                    </div>

                    <div class="h-64">
                        <canvas id="gradesChart" data-grades='<?= json_encode($grades) ?>'></canvas>
                    </div>

                    <div class="bg-gray-100 rounded-lg p-4">
                        <h2 class="text-lg font-semibold mb-2">Subject Grades</h2>
                        <div class="space-y-2">
                            <?php foreach ($grades as $subject => $grade): ?>
                            <div class="flex items-center">
                                <span class="w-48 text-sm text-gray-600"><?= htmlspecialchars($subject) ?></span>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500" style="width: <?= ($grade / 20) * 100 ?>%"></div>
                                </div>
                                <span class="w-16 text-sm text-gray-600 text-right"><?= number_format($grade, 2) ?>/20</span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">No Data</p>
                    <p>No data submitted. Please go back and enter your grades.</p>
                </div>
            <?php endif; ?>

            <a href="index.php" class="mt-6 inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium py-2 px-4 rounded-lg hover:from-blue-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                Calculate Another Final Grade
            </a>
        </div>
    </div>
</body>
</html>