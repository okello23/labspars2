<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab SPARS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .spider-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7f2 100%);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .spider-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }

        .assessment-table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .assessment-table th {
            background: linear-gradient(135deg, #4f6df5 0%, #3a56e6 100%);
            color: white;
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }

        .spider-chart-container {
            position: relative;
            height: 400px;
            margin-top: -20px;
        }

        .score-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .section-title {
            position: relative;
            padding-left: 20px;
        }

        .section-title::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 24px;
            border-radius: 4px;
        }

        .stock-title::before {
            background: #4f6df5;
        }

        .storage-title::before {
            background: #10b981;
        }

        .ordering-title::before {
            background: #f59e0b;
        }

        .equipment-title::before {
            background: #ef4444;
        }

        .info-title::before {
            background: #8b5cf6;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Lab SPARS Dashboard</h1>
                <p class="text-gray-600">Comprehensive assessment of laboratory performance</p>
            </div>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <div class="bg-white rounded-xl px-4 py-2 shadow-sm">
                    <p class="text-sm text-gray-500">Last Assessment</p>
                    <p class="font-medium">May 11, 2025</p>
                </div>
                <div class="bg-indigo-500 text-white rounded-xl px-4 py-2 shadow-sm">
                    <p class="text-sm">Overall Score</p>
                    <p class="font-bold text-xl">82%</p>
                </div>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-flask text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Facilities</p>
                        <p class="font-bold">856</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Completed</p>
                        <p class="font-bold">624</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-tasks text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">In Progress</p>
                        <p class="font-bold">128</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pending</p>
                        <p class="font-bold">104</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Avg. Score</p>
                        <p class="font-bold">82%</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Assessment Table -->
            <div class="spider-card p-6">
                <h2 class="text-xl font-bold mb-6 text-gray-800">Lab SPARS Assessment Scores</h2>

                <div class="overflow-x-auto">
                    <table class="w-full assessment-table">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 text-left">Assessment Area</th>
                                <th class="py-3 px-4 text-center">Score</th>
                                <th class="py-3 px-4 text-center">%</th>
                                <th class="py-3 px-4 text-center">Spider Score</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <!-- Stock Management -->
                            <tr>
                                <td class="py-4 px-4 border-b">
                                    <h3 class="font-bold section-title stock-title">Stock Management</h3>
                                    <p class="text-sm text-gray-600 mt-1">7 indicators</p>
                                </td>
                                <td class="py-4 px-4 border-b text-center font-bold">6/7</td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="text-blue-600 font-bold">86%</span>
                                </td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="score-badge bg-blue-100 text-blue-800">4.3</span>
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td colspan="4" class="px-4 py-2 text-sm text-gray-600">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Availability of reagents
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Stock card availability
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Correct filling
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Physical count match
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            AMC calculated
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            ELMIS/EMR updated
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                            Inventory accuracy
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Storage Areas & Lab Facilities Management -->
                            <tr>
                                <td class="py-4 px-4 border-b">
                                    <h3 class="font-bold section-title storage-title">Storage & Lab Facilities</h3>
                                    <p class="text-sm text-gray-600 mt-1">5 indicators</p>
                                </td>
                                <td class="py-4 px-4 border-b text-center font-bold">4/5</td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="text-green-600 font-bold">80%</span>
                                </td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="score-badge bg-green-100 text-green-800">4.0</span>
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td colspan="4" class="px-4 py-2 text-sm text-gray-600">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Cleanliness
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Hygiene
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Storage system
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Storage conditions
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                            Storage practices
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Ordering -->
                            <tr>
                                <td class="py-4 px-4 border-b">
                                    <h3 class="font-bold section-title ordering-title">Ordering</h3>
                                    <p class="text-sm text-gray-600 mt-1">3 indicators</p>
                                </td>
                                <td class="py-4 px-4 border-b text-center font-bold">2/3</td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="text-yellow-600 font-bold">67%</span>
                                </td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="score-badge bg-yellow-100 text-yellow-800">3.3</span>
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td colspan="4" class="px-4 py-2 text-sm text-gray-600">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Reorder level calculations
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Adherence to procedures
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                            Annual procurement plan
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Laboratory Equipment -->
                            <tr>
                                <td class="py-4 px-4 border-b">
                                    <h3 class="font-bold section-title equipment-title">Laboratory Equipment</h3>
                                    <p class="text-sm text-gray-600 mt-1">4 indicators</p>
                                </td>
                                <td class="py-4 px-4 border-b text-center font-bold">3/4</td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="text-red-600 font-bold">75%</span>
                                </td>
                                <td class="py-4 px-4 border-b text-center">
                                    <span class="score-badge bg-red-100 text-red-800">3.8</span>
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td colspan="4" class="px-4 py-2 text-sm text-gray-600">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Equipment inventory
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Management plan
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Functionality
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                            Utilization
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Laboratory Information systems -->
                            <tr>
                                <td class="py-4 px-4">
                                    <h3 class="font-bold section-title info-title">Information Systems</h3>
                                    <p class="text-sm text-gray-600 mt-1">6 indicators</p>
                                </td>
                                <td class="py-4 px-4 text-center font-bold">5/6</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-purple-600 font-bold">83%</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="score-badge bg-purple-100 text-purple-800">4.2</span>
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td colspan="4" class="px-4 py-2 text-sm text-gray-600">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Data collection tools
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            HMIS 105 reports
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Timeliness
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Completeness
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            Data usage
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                            Report filing
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">Total Spider Graph Score</p>
                        <p class="text-2xl font-bold">19.6 / 25</p>
                    </div>
                    <div class="bg-indigo-500 text-white px-4 py-2 rounded-lg">
                        <p class="font-medium">Overall Compliance: 78%</p>
                    </div>
                </div>
            </div>

            <!-- Spider Graph -->
            <div class="spider-card p-6">
                <h2 class="text-xl font-bold mb-2 text-gray-800">SPARS Spider Graph</h2>
                <p class="text-gray-600 mb-6">Visual representation of assessment scores</p>

                <div class="spider-chart-container">
                    <canvas id="spiderChart"></canvas>
                </div>

                <div class="mt-8">
                    <h3 class="font-bold mb-3">Assessment Areas</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                            <span>Stock Management</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <span>Storage & Facilities</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                            <span>Ordering</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                            <span>Equipment</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-purple-500 mr-2"></div>
                            <span>Information Systems</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Assessment Areas -->
        <div class="spider-card p-6 mt-8">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Lab SPARS Key Assessment Areas</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Stock Management</h3>
                            <p class="text-gray-600 mt-2">Ensuring proper inventory control and management of
                                laboratory reagents and supplies.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-warehouse text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Storage & Facilities</h3>
                            <p class="text-gray-600 mt-2">Maintaining proper storage conditions and laboratory
                                facilities to preserve reagent integrity.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-clipboard-list text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Ordering Procedures</h3>
                            <p class="text-gray-600 mt-2">Systematic approach to inventory replenishment and
                                procurement planning.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-red-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-microscope text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Equipment Management</h3>
                            <p class="text-gray-600 mt-2">Ensuring laboratory equipment is functional, maintained, and
                                properly utilized.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-purple-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-database text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Information Systems</h3>
                            <p class="text-gray-600 mt-2">Proper documentation, reporting, and utilization of
                                laboratory data.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-chart-pie text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Performance Analysis</h3>
                            <p class="text-gray-600 mt-2">Comprehensive evaluation of laboratory performance across all
                                assessment areas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Spider Graph Data
        const spiderData = {
            labels: [
                'Stock Management',
                'Storage & Facilities',
                'Ordering',
                'Equipment',
                'Information Systems'
            ],
            datasets: [{
                label: 'SPARS Assessment',
                data: [4.3, 4.0, 3.3, 3.8, 4.2],
                fill: true,
                backgroundColor: 'rgba(79, 109, 245, 0.2)',
                borderColor: 'rgb(79, 109, 245)',
                pointBackgroundColor: [
                    'rgb(79, 109, 245)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(139, 92, 246)'
                ],
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(79, 109, 245)'
            }]
        };

        // Spider Graph Configuration
        const spiderConfig = {
            type: 'radar',
            data: spiderData,
            options: {
                elements: {
                    line: {
                        borderWidth: 2
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        pointLabels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#4b5563'
                        },
                        ticks: {
                            display: true,
                            backdropColor: 'transparent',
                            stepSize: 1,
                            max: 5
                        },
                        suggestedMin: 0
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.formattedValue;
                            }
                        }
                    }
                }
            }
        };

        // Render the spider graph
        window.onload = function() {
            const spiderCtx = document.getElementById('spiderChart').getContext('2d');
            new Chart(spiderCtx, spiderConfig);
        };
    </script>
</body>

</html>
