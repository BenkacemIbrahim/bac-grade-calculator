const subjectsByType = {
    'physical_sciences': {
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
    'life_earth_sciences': {
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
    'life_agricultural_sciences': {
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
    'mathematical_sciences_a': {
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
    'mathematical_sciences_b': {
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

document.addEventListener('DOMContentLoaded', function () {
    const bacTypeSelect = document.getElementById('bac_type');
    const gradesContainer = document.getElementById('grades_container');

    if (bacTypeSelect && gradesContainer) {
        bacTypeSelect.addEventListener('change', function () {
            const bacType = this.value;
            gradesContainer.innerHTML = '';

            if (bacType && subjectsByType[bacType]) {
                for (const subject in subjectsByType[bacType]) {
                    const div = document.createElement('div');
                    div.className = 'mb-4';
                    div.innerHTML = `
                        <label for="grades[${subject}]" class="block text-sm font-medium text-gray-700">${subject}</label>
                        <input type="number" name="grades[${subject}]" min="0" max="20" step="0.01" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="Enter grade (0-20)">
                    `;
                    gradesContainer.appendChild(div);
                }
            }
        });
    }

    const gradesChartCanvas = document.getElementById('gradesChart');
    if (gradesChartCanvas) {
        const grades = JSON.parse(gradesChartCanvas.dataset.grades);
        const labels = Object.keys(grades);
        const data = Object.values(grades);

        new Chart(gradesChartCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Subject Grades',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20
                    }
                }
            }
        });
    }
});