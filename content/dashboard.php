<?php
include('.\process_dashboard.php');
include('.\conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f8;
            color: #333;
        }

        header {
            background-color: #006699;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
            padding: 20px;
        }

        .sidebar {
            background-color: #2d2d2d;
            color: white;
            width: 260px;
            padding-top: 30px;
            height: 100vh;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s ease;
        }

        .sidebar:hover {
            width: 300px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 18px 30px;
            margin: 8px 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 5px;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
        }

        .sidebar ul li a {
            color: #ddd;
            text-decoration: none;
            display: block;
        }

        .sidebar ul li:hover {
            background-color: #004d99;
            padding-left: 40px;
        }

        .sidebar ul li.active {
            background-color: #006699;
        }

        .main-section {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            font-size: 22px;
            font-weight: 600;
            color: #006699;
            margin-bottom: 25px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-card img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-card .info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-card .info h3 {
            color: #006699;
            margin-bottom: 5px;
        }

        .profile-card .info p {
            color: #777;
            margin-bottom: 10px;
        }

        .profile-card .edit-btn {
            background-color: #006699;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .profile-card .edit-btn:hover {
            background-color: #004d99;
        }

        .chart-container {
            margin-top: 35px;
            max-width: 850px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 16px;
        }

        table th, table td {
            padding: 18px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #006699;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            background-color: #006699;
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-section {
                margin-left: 0;
                width: 100%;
            }

            .profile-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .stats-card {
                flex-direction: column;
                gap: 10px;
            }

            .stats-item {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        User Dashboard
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul>
              <li class="active"><a href="#">Dashboard</a></li>
              <?php
              $sql = 'SELECT * FROM m13_dashboard WHERE m13_status = 1;';
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_array($result)) {
                  if ($row['m13_name'] == 'Home') {
              ?>
                  <li><a href="..\<?= $row['m13_url'] ?>"><?= $row['m13_name'] ?></a></li>
              <?php
                  }
                  if ($row['m13_name'] != 'Home') {
              ?>
                  <li><a href="<?= $row['m13_url'] ?>"><?= $row['m13_name'] ?></a></li>
              <?php
                  }
              }
              ?>           
            </ul>
        </aside>

        <main class="main-section">
            <div class="card">
                <div class="card-header">
                    Welcome, <?= $user_name ?>!
                </div>
                <div class="profile-card">
                    <img src="images\<?= $profile_photo_url ?>" alt="User Photo">
                    <div class="info">
                        <h3><?= $user_name ?></h3>
                        <p><?= $user_email ?></p>
                        <h4><?= $bio?></h4>
                        <h5> <?= $role?> </h5>
                        <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
                    </div>
                </div>
<!-- 
                <div class="chart-container">
                    <canvas id="activityChart"></canvas>
                </div> -->
                
                <div class="card">
                    <div class="card-header">Upcoming Events</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Volleyball League</td>
                                <td>2024-12-05</td>
                                <td>Stadium A</td>
                                <td>Registered</td>
                            </tr>
                            <tr>
                                <td>Volleyball Tournament</td>
                                <td>2024-12-10</td>
                                <td>Stadium B</td>
                                <td>Not Registered</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Company Name. All rights reserved.</p>
    </footer>

    <script>
        var ctx = document.getElementById('activityChart').getContext('2d');
        var activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Activity over Time',
                    data: [10, 20, 15, 30, 25, 40],
                    backgroundColor: 'rgba(0, 102, 153, 0.2)',
                    borderColor: 'rgba(0, 102, 153, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            }
        });
    </script>
</body>
</html>
