
<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EcoTrack Waste Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-4 md:p-6 max-w-7xl">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold tracking-tight mb-2">EcoTrack Admin Dashboard</h1>
                <p class="text-gray-600">Manage reports and issue resolution</p>
            </div>
            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </header>

        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900">Complaint Summary</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Resolved Issues</h4>
                                <div class="mt-1 text-3xl font-semibold text-gray-900" id="completed-count">0</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">In Progress</h4>
                                <div class="mt-1 text-3xl font-semibold text-gray-900" id="in-progress-count">0</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-amber-100 rounded-md p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Pending</h4>
                                <div class="mt-1 text-3xl font-semibold text-gray-900" id="pending-count">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Complaint Management</h3>
                    <p class="mt-1 text-sm text-gray-500">View and update status of all reported issues</p>
                </div>
                <div class="relative">
                    <input type="text" id="search-reports" placeholder="Search reports..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Reported</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="reports-table-body">
                        <!-- Table rows will be loaded by JavaScript -->
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Loading reports...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                <nav class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between">
                        <button type="button" id="prev-page" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" disabled>
                            Previous
                        </button>
                        <span class="text-sm text-gray-700" id="pagination-info">
                            Page <span id="current-page">1</span> of <span id="total-pages">1</span>
                        </span>
                        <button type="button" id="next-page" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" disabled>
                            Next
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Report Detail Modal -->
    <div id="report-detail-modal" class="fixed inset-0 z-10 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Report Details
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Issue Type</h4>
                                    <p class="mt-1 text-sm text-gray-900" id="detail-issue-type"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                    <p class="mt-1 text-sm text-gray-900" id="detail-description"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Location</h4>
                                    <p class="mt-1 text-sm text-gray-900" id="detail-location"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Reported By</h4>
                                    <p class="mt-1 text-sm text-gray-900" id="detail-reported-by"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Date Reported</h4>
                                    <p class="mt-1 text-sm text-gray-900" id="detail-date"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Current Status</h4>
                                    <p class="mt-1" id="detail-status"></p>
                                </div>
                                <div id="detail-images" class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Images</h4>
                                    <div class="grid grid-cols-2 gap-2" id="detail-images-container"></div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Update Status</h4>
                                <div class="flex space-x-2">
                                    <input type="hidden" id="detail-report-id">
                                    <button type="button" class="update-status-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500" data-status="pending">
                                        Mark as Pending
                                    </button>
                                    <button type="button" class="update-status-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-status="in-progress">
                                        Mark as In Progress
                                    </button>
                                    <button type="button" class="update-status-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" data-status="completed">
                                        Mark as Completed
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="close-detail-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="toast-container" class="fixed top-4 right-4 z-50"></div>
    
    <script src="js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let allReports = [];
        let currentPage = 1;
        const reportsPerPage = 10;
        let filteredReports = [];
        
        // Initial load of all reports
        loadReports();
        
        // Handle search input
        const searchInput = document.getElementById('search-reports');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterReports(searchTerm);
        });
        
        // Handle pagination
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        
        prevPageBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderReportsTable();
                updatePaginationUI();
            }
        });
        
        nextPageBtn.addEventListener('click', function() {
            const totalPages = Math.ceil((filteredReports.length || allReports.length) / reportsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderReportsTable();
                updatePaginationUI();
            }
        });
        
        // Handle status update buttons
        document.body.addEventListener('click', function(e) {
            if (e.target.classList.contains('update-status-btn') || e.target.closest('.update-status-btn')) {
                const btn = e.target.classList.contains('update-status-btn') ? e.target : e.target.closest('.update-status-btn');
                const reportId = document.getElementById('detail-report-id').value;
                const status = btn.getAttribute('data-status');
                
                updateReportStatus(reportId, status);
            }
        });
        
        // Handle view details buttons
        document.body.addEventListener('click', function(e) {
            if (e.target.classList.contains('view-details-btn') || e.target.closest('.view-details-btn')) {
                const btn = e.target.classList.contains('view-details-btn') ? e.target : e.target.closest('.view-details-btn');
                const reportId = btn.getAttribute('data-id');
                
                showReportDetails(reportId);
            }
        });
        
        // Close detail modal
        document.getElementById('close-detail-modal').addEventListener('click', function() {
            document.getElementById('report-detail-modal').classList.add('hidden');
        });
        
        function loadReports() {
            // In a real app, this would be an AJAX call to the server
            fetch('api/reports.php?action=get_all_reports')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        allReports = data.reports;
                        filteredReports = [...allReports];
                        updateCounters();
                        renderReportsTable();
                        updatePaginationUI();
                    } else {
                        showToast(data.message || 'Error loading reports', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while loading reports', 'error');
                });
        }
        
        function filterReports(searchTerm) {
            if (!searchTerm) {
                filteredReports = [...allReports];
            } else {
                filteredReports = allReports.filter(report => {
                    return (
                        report.type.toLowerCase().includes(searchTerm) ||
                        report.location.toLowerCase().includes(searchTerm) ||
                        report.reportedBy.toLowerCase().includes(searchTerm) ||
                        report.status.toLowerCase().includes(searchTerm)
                    );
                });
            }
            
            currentPage = 1;
            renderReportsTable();
            updatePaginationUI();
        }
        
        function renderReportsTable() {
            const tableBody = document.getElementById('reports-table-body');
            const reports = filteredReports.length ? filteredReports : allReports;
            
            if (reports.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No reports found.
                        </td>
                    </tr>
                `;
                return;
            }
            
            // Calculate pagination
            const startIndex = (currentPage - 1) * reportsPerPage;
            const endIndex = Math.min(startIndex + reportsPerPage, reports.length);
            const displayedReports = reports.slice(startIndex, endIndex);
            
            // Render table rows
            tableBody.innerHTML = displayedReports.map(report => {
                const formattedType = report.type.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                let statusClass = '';
                
                switch (report.status) {
                    case 'completed':
                        statusClass = 'bg-green-100 text-green-800';
                        break;
                    case 'in-progress':
                        statusClass = 'bg-blue-100 text-blue-800';
                        break;
                    default:
                        statusClass = 'bg-amber-100 text-amber-800';
                }
                
                const formattedStatus = report.status.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                
                return `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${formattedType}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${report.location}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${report.date}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${report.reportedBy}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                                ${formattedStatus}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" class="view-details-btn text-blue-600 hover:text-blue-900" data-id="${report.id}">
                                View Details
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }
        
        function updatePaginationUI() {
            const totalReports = filteredReports.length || allReports.length;
            const totalPages = Math.ceil(totalReports / reportsPerPage);
            
            document.getElementById('current-page').textContent = currentPage;
            document.getElementById('total-pages').textContent = totalPages;
            
            // Update button states
            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = currentPage === totalPages;
        }
        
        function updateCounters() {
            const pendingCount = allReports.filter(report => report.status === 'pending').length;
            const inProgressCount = allReports.filter(report => report.status === 'in-progress').length;
            const completedCount = allReports.filter(report => report.status === 'completed').length;
            
            document.getElementById('pending-count').textContent = pendingCount;
            document.getElementById('in-progress-count').textContent = inProgressCount;
            document.getElementById('completed-count').textContent = completedCount;
        }
        
        function showReportDetails(reportId) {
            const report = allReports.find(r => r.id == reportId);
            
            if (!report) {
                showToast('Report not found', 'error');
                return;
            }
            
            // Format issue type
            const formattedType = report.type.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            
            // Set values in modal
            document.getElementById('detail-report-id').value = report.id;
            document.getElementById('detail-issue-type').textContent = formattedType;
            document.getElementById('detail-description').textContent = report.description || 'No description provided';
            document.getElementById('detail-location').textContent = report.location;
            document.getElementById('detail-reported-by').textContent = report.reportedBy;
            document.getElementById('detail-date').textContent = report.date;
            
            // Set status with appropriate styling
            let statusClass = '';
            switch (report.status) {
                case 'completed':
                    statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                    break;
                case 'in-progress':
                    statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                    break;
                default:
                    statusClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800';
            }
            
            const formattedStatus = report.status.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            document.getElementById('detail-status').innerHTML = `<span class="${statusClass}">${formattedStatus}</span>`;
            
            // Display images if any
            const imagesContainer = document.getElementById('detail-images-container');
            const imagesSection = document.getElementById('detail-images');
            
            if (report.images && report.images.length > 0) {
                imagesSection.classList.remove('hidden');
                imagesContainer.innerHTML = report.images.map(image => `
                    <div class="relative h-24 bg-gray-100 rounded-md overflow-hidden">
                        <img src="${image}" alt="Report Image" class="w-full h-full object-cover">
                    </div>
                `).join('');
            } else {
                imagesSection.classList.add('hidden');
            }
            
            // Show modal
            document.getElementById('report-detail-modal').classList.remove('hidden');
        }
        
        function updateReportStatus(reportId, status) {
            // In a real app, this would be an AJAX call to the server
            const formData = new FormData();
            formData.append('report_id', reportId);
            formData.append('status', status);
            
            fetch('api/reports.php?action=update_report_status', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update local data
                    const reportIndex = allReports.findIndex(r => r.id == reportId);
                    if (reportIndex !== -1) {
                        allReports[reportIndex].status = status;
                        
                        // Update filtered reports if applicable
                        const filteredIndex = filteredReports.findIndex(r => r.id == reportId);
                        if (filteredIndex !== -1) {
                            filteredReports[filteredIndex].status = status;
                        }
                    }
                    
                    // Update UI
                    const formattedStatus = status.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    showToast(`Report status updated to ${formattedStatus}`, 'success');
                    
                    // Close modal
                    document.getElementById('report-detail-modal').classList.add('hidden');
                    
                    // Refresh table and counters
                    updateCounters();
                    renderReportsTable();
                } else {
                    showToast(data.message || 'Error updating report status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while updating report status', 'error');
            });
        }
    });
    </script>
</body>
</html>
