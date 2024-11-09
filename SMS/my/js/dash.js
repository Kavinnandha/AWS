fetch('dash_get_info.php')
    .then(response => response.json())
    .then(data => {
        
        const totalSessions = data.total_sessions;
        const totalAttendance = data.total_attendance;
        const attendancePercentage = data.attendance_percentage;
        const labels = data.labels; 
        const attend = data.attend;
        const missed = data.missed;
        Chart.register({
            id: 'centerTextPlugin',
            afterDraw: function(chart) {
                if (chart.config.type === 'doughnut') {
                    const ctx = chart.ctx;
                    const width = chart.width;
                    const height = chart.height;
                    ctx.restore();
                    const fontSize = (height / 100).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    const text = attendancePercentage + "%";
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2;
                    ctx.fillStyle = '#666';
                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }
        });
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Attended', 'Missed'],
                datasets: [{
                    label: 'Attendance Status',
                    data: [totalSessions - totalAttendance, totalAttendance],
                    backgroundColor: ['#4caf50', 'red'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    centerTextPlugin: true
                },
                cutout: '70%'
            }
        });
        const formattedLabels = labels.map(label => {
            const parts = label.split(' ');
            return parts.length > 1 ? parts : [label]; 
        });

        var ctxBar = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: formattedLabels, 
                datasets: [{
                    label: 'Classes Attended',
                    data: attend, 
                    backgroundColor: '#36a2eb', 
                    borderColor: '#36a2eb',
                    borderWidth: 1
                }, {
                    label: 'Classes Missed',
                    data: missed, 
                    backgroundColor: '#ff6384', 
                    borderColor: '#ff6384',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, 
                scales: {
                    x: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12 
                            },
                            callback: function(value) {
                                return this.getLabelForValue(value);
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12 
                            }
                        }
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));