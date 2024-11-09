document.addEventListener('DOMContentLoaded', async function () {
    try {
        const response = await fetch('api.php');
        const data = await response.json();

        const chartData = {};
        Object.keys(data).forEach(course => {
            if (course !== 'Rank' && course !== 'Total Score') {
                const category = course.startsWith('L') ? 'Placement Course' : course;
                const score = parseFloat(data[course]) || 0;
                chartData[category] = score;
            }
        });

        const ctx = document.getElementById('skillsRadarChart').getContext('2d');


        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 204, 102, 0.3)');
        gradient.addColorStop(1, 'rgba(0, 204, 102, 0.05)');

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: Object.keys(chartData),
                datasets: [{
                    label: 'Skill Points', 
                    data: Object.values(chartData),
                    backgroundColor: gradient,
                    borderColor: '#00cc66',
                    borderWidth: 2,
                    pointBackgroundColor: '#00cc66',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#00cc66',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            circular: true
                        },
                        pointLabels: {
                            color: '#4a4a4a',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            display: false,
                            backdropColor: 'transparent'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
            
        });
    } catch (error) {
        console.error('Failed to load data:', error);
    }
});
