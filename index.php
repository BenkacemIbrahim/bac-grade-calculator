<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baccalaureate Grade Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1501290741922-b56c0d0884af?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div
        class="w-full max-w-2xl bg-white bg-opacity-95 shadow-2xl rounded-3xl overflow-hidden backdrop-filter backdrop-blur-lg">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h1 class="text-3xl font-bold text-center">Baccalaureate Grade Calculator</h1>
            <p class="text-center mt-2 text-blue-100">Select your baccalaureate type and enter your grades</p>
        </div>

        <div class="p-8">
            <form method="POST" action="result.php" class="space-y-6">
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Select your baccalaureate type:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex-1">
                            <input type="radio" name="bac_type" value="physical_sciences" class="hidden" required>
                            <div
                                class="border border-gray-300 rounded-lg p-4 text-center cursor-pointer transition duration-200 bac-type-btn">
                                Physical Sciences
                            </div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="bac_type" value="life_earth_sciences" class="hidden" required>
                            <div
                                class="border border-gray-300 rounded-lg p-4 text-center cursor-pointer transition duration-200 bac-type-btn">
                                Life and Earth Sciences
                            </div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="bac_type" value="life_agricultural_sciences" class="hidden"
                                required>
                            <div
                                class="border border-gray-300 rounded-lg p-4 text-center cursor-pointer transition duration-200 bac-type-btn">
                                Life and Agricultural Sciences
                            </div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="bac_type" value="mathematical_sciences_a" class="hidden" required>
                            <div
                                class="border border-gray-300 rounded-lg p-4 text-center cursor-pointer transition duration-200 bac-type-btn">
                                Mathematical Sciences (A)
                            </div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="bac_type" value="mathematical_sciences_b" class="hidden" required>
                            <div
                                class="border border-gray-300 rounded-lg p-4 text-center cursor-pointer transition duration-200 bac-type-btn">
                                Mathematical Sciences (B)
                            </div>
                        </label>
                    </div>
                </div>

                <div id="subjectsContainer" class="hidden space-y-6">
                    <!-- Subject inputs will uploade here -->
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-medium py-3 px-4 rounded-lg hover:from-green-600 hover:to-green-700 transition duration-300 transform hover:scale-105">
                    Calculate Final Grade
                </button>
            </form>
        </div>
    </div>

    <script>
        const bacTypeButtons = document.querySelectorAll('.bac-type-btn');
        const subjectsContainer = document.getElementById('subjectsContainer');
        const subjectsByType = {
            physical_sciences: {
                'Arabic': 2,
                'French': 4,
                'English': 2,
                'Philosophy': 2,
                'Mathematics': 7,
                'Life and Earth Sciences': 5,
                'Translation': 4,
                'Islamic Education': 2,
                'Sports': 4,
                'Attendance and Behavior': 1,
                'Physics': 7
            },
            life_earth_sciences: {
                'Arabic': 2,
                'French': 4,
                'English': 2,
                'Philosophy': 2,
                'Mathematics': 7,
                'Life and Earth Sciences': 7,
                'Tradition': 4,
                'Islamic Education': 2,
                'Sports': 4,
                'Attendance and Behavior': 1,
                'Physics': 5
            },
            life_agricultural_sciences: {
                'Arabic': 2,
                'French': 4,
                'English': 2,
                'Philosophy': 2,
                'Mathematics': 7,
                'Life and Earth Sciences': 5,
                'Botanical Sciences': 5,
                'Tradition': 4,
                'Social Studies': 2,
                'Islamic Education': 2,
                'Sports': 4,
                'Attendance and Behavior': 1,
                'Physics': 5
            },
            mathematical_sciences_a: {
                'Arabic': 2,
                'French': 4,
                'English': 2,
                'Philosophy': 2,
                'Mathematics': 9,
                'Life and Earth Sciences': 3,
                'Tradition': 4,
                'Islamic Education': 2,
                'Sports': 4,
                'Attendance and Behavior': 1,
                'Physics': 7
            },
            mathematical_sciences_b: {
                'Arabic': 2,
                'French': 4,
                'English': 2,
                'Philosophy': 2,
                'Mathematics': 9,
                'Engineering Science': 3,
                'Tradition': 4,
                'Islamic Education': 2,
                'Sports': 4,
                'Attendance and Behavior': 1,
                'Physics': 7
            }
        };

        function createSubjectInputs(subjects) {
            subjectsContainer.innerHTML = '';
            for (const [subject, coefficient] of Object.entries(subjects)) {
                const inputHtml = `
            <div class="relative">
                <label for="${subject}" class="block text-gray-700 font-medium mb-2">${subject} (Coefficient: ${coefficient})</label>
                <div class="relative">
                    <input type="text" name="grades[${subject}]" id="${subject}" 
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200" 
                        placeholder="Enter grade (0-20)" required
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').slice(0, 4);">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-600 font-medium">/20</span>
                    </div>
                </div>
            </div>
        `;
                subjectsContainer.insertAdjacentHTML('beforeend', inputHtml);
            }
            subjectsContainer.classList.remove('hidden');
        }

        bacTypeButtons.forEach(button => {
            button.addEventListener('click', () => {
                bacTypeButtons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white'));
                button.classList.add('bg-blue-500', 'text-white');
                const bacType = button.closest('label').querySelector('input[name="bac_type"]').value;
                createSubjectInputs(subjectsByType[bacType]);
            });
        });
    </script>
</body>

</html>