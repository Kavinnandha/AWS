<?php include $_SERVER['DOCUMENT_ROOT'] . '/SMS/master/config.php'; ?>
<?php include 'leaderboard_details.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills Matrix Leaderboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <link rel="stylesheet" href="css/lead.css">
</head>
<body>
    <div class="dashboard-complex-container">
        <div class="row g-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        Skills Matrix And Leaderboard
                    </h1>
                    <div class="d-flex gap-3">
                        <div class="complex-skill-legend">
                            <span class="complex-legend-dot" style="background-color: var(--chart-complex-color)"></span>
                            <span>Current Skills</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="complex-card complex-stats-card">
                    <div class="complex-stats-title">Most Question Solved In</div>
                    <div class="complex-stats-value">Fundamentals</div>
                    <div class="complex-stats-trend complex-trend-up">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 4L12 8L4 8L8 4Z" fill="currentColor"/>
                        </svg>
                        90% Proficiency
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="complex-card complex-stats-card">
                    <div class="complex-stats-title">Average Skill Level</div>
                    <div class="complex-stats-value">44.2%</div>
                    <div class="complex-stats-trend">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8L13 8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Baseline Established
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="complex-card complex-stats-card">
                    <div class="complex-stats-title">Areas to Improve</div>
                    <div class="complex-stats-value">Network Exp.</div>
                    <div class="complex-stats-trend complex-trend-down">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 12L4 8L12 8L8 12Z" fill="currentColor"/>
                        </svg>
                        25% Proficiency
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                  <div class="complex-card p-4">
                      <div class="complex-chart-container">
                      <h1 class="h3 mb-0">
                          Skills Matrix  
                      </h1>
                          <canvas id="skillsRadarChart"></canvas>
                          <div class="complex-chart-tooltip"></div>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="complex-card p-4">
                  <div class="complex-chart-container">
                  <h1 class="h3 mb-0" id="questionCount">Loading...</h1>
                  <p class="subtitle">Scored Increased This Week</p>
                <canvas id="scoreChart" class="daily"></canvas>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="table table-responsive mt-4">
        
        <?php echo $lms_report_data; ?>
    </div>
    <script src="js/skill.js"></script>
    <script src="js/skill-stat.js"></script>
</body>
</html>
