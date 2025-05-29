<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baccalaureate Grade Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white bg-opacity-95 shadow-2xl rounded-3xl overflow-hidden backdrop-filter backdrop-blur-lg">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h1 class="text-3xl font-bold text-center">Baccalaureate Grade Calculator</h1>
            <p class="text-center mt-2 text-blue-100">Select your baccalaureate type and enter your grades</p>
        </div>

        <div class="p-8">
            <form action="result.php" method="POST" class="space-y-6">
                <div>
                    <label for="bac_type" class="block text-sm font-medium text-gray-700">Select your baccalaureate type:</label>
                    <select id="bac_type" name="bac_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select a type</option>
                        <option value="physical_sciences">Physical Sciences</option>
                        <option value="life_earth_sciences">Life and Earth Sciences</option>
                        <option value="life_agricultural_sciences">Life and Agricultural Sciences</option>
                        <option value="mathematical_sciences_a">Mathematical Sciences (A)</option>
                        <option value="mathematical_sciences_b">Mathematical Sciences (B)</option>
                    </select>
                </div>

                <div id="grades_container" class="space-y-4">
                    <!-- Grades will be dynamically added here by JavaScript -->
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium py-2 px-4 rounded-lg hover:from-blue-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                    Calculate Final Grade
                </button>
            </form>
        </div>
    </div>
</body>
</html>