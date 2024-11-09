fetch('lead_api.php')
    .then(response => response.json())
    .then(weekData => {
        const differences = [];
        for (let i = 1; i < weekData.length; i++) {
            differences.push(weekData[i].count - weekData[i-1].count);
        }

        const labels = weekData.map(day => {
            const date = new Date(day.date);
            return date.toLocaleDateString('en-US', { weekday: 'short' });
        });

        const totalQuestions = weekData[weekData.length - 1].count;
        document.getElementById('questionCount').textContent = `Score Increased This Week : ${totalQuestions}`;

        const ctx = document.getElementById('scoreChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Questions Answered',
                    data: differences,
                    fill: true,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgb(59, 130, 246)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                return `score increased by ${value > 0 ? '+' : ''}${value}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value > 0 ? '+' + value : value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        document.getElementById('questionCount').textContent = 'Error loading data';
    });