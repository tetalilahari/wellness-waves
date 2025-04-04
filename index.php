
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoTrack Waste Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-4 md:p-6 max-w-7xl">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2">EcoTrack Waste Management System</h1>
            <p class="text-gray-600">Monitor, manage, and optimize your waste collection and recycling efforts</p>
        </header>

        <?php
        // Check if user is logged in
        if(isset($_SESSION['user_id'])) {
            include 'includes/navbar.php';
            
            // Determine which tab to display
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
            
            // Include the appropriate content based on the tab
            switch($tab) {
                case 'dashboard':
                    include 'includes/dashboard.php';
                    break;
                case 'schedule':
                    include 'includes/collection_schedule.php';
                    break;
                case 'reporting':
                    include 'includes/waste_reporting.php';
                    break;
                case 'recycling':
                    include 'includes/recycling_guide.php';
                    break;
                default:
                    include 'includes/dashboard.php';
            }
        } else {
            // If not logged in, show login form
            include 'includes/login.php';
        }
        ?>
    </div>
    
    <div id="toast-container" class="fixed top-4 right-4 z-50"></div>
    
    <script src="js/main.js"></script>
</body>
</html>
