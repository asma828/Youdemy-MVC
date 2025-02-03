<?php
use classes\StatistiqueGlobal;

require_once '../middlewares/AdminAccess.php';
require_once '../classes/StatistiqueGlobal.php';
require_once '../classes/Database.php';
session_start();
AdminAcess();

$statistiqueModel = new StatistiqueGlobal();
$TotalCourses = $statistiqueModel->Nombre_total_cours();
$totalUtilisateurs = $statistiqueModel->Nombre_total_utilisateurs();
$totalInscriptions = $statistiqueModel->Nombre_total_Inscriptions();
$totalCategories = $statistiqueModel->Nombre_total_Categories();
$totalTags = $statistiqueModel->Nombre_total_Tags();
$repartitionParCategorie = $statistiqueModel->repartitionParCategorie();
$CoursPlusEtudinat = $statistiqueModel->CoursPlusEtudinat();
$TopTreeEnseignants = $statistiqueModel->TopTreeEnseignants();

if (isset($_GET['category_id'])) {
    $categoryCourses = $statistiqueModel->CategoryCourses($_GET['category_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/img/ycd.png" rel="icon">
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg">
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2 mb-8">
                <i class="fas fa-book-reader text-blue-600 text-2xl"></i>
                <h1 class="text-2xl font-bold">YouDemy</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="./StatistiquesPanel.php" class="flex items-center space-x-2 p-3 rounded-lg bg-blue-50 text-blue-600">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./UtilisateursPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="./CoursesPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Cours</span>
                </a>
                <a href="./TagsPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-tags"></i>
                    <span>Tags</span>
                </a>
                <a href="./CategoryPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-list"></i>
                    <span>Categories</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-8">
        <!-- Header with Session Info -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Dashboard Overview</h2>
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['utilisateur'])): ?>
                    <span class="font-medium"><?php echo $_SESSION['utilisateur']['nom']; ?></span>
                <?php else: ?>
                    <span class="font-medium">Admin User</span>
                <?php endif; ?>
                <a href="../actions/lougout.php" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
            <!-- Users Stats -->
            <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-blue-500">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold"><?php echo $totalUtilisateurs; ?></p>
                        <p class="text-gray-600 text-sm">Utilisateurs Total</p>
                    </div>
                </div>
            </div>

            <!-- Courses Stats -->
            <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-green-500">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold"><?php echo $TotalCourses; ?></p>
                        <p class="text-gray-600 text-sm">Cours Total</p>
                    </div>
                </div>
            </div>

            <!-- More stats cards... -->
            <!-- Similar structure for Inscriptions, Categories, and Tags -->
        </div>

        <!-- Most Popular Course Section -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            <h4 class="text-xl font-bold mb-4">
                <span class="text-blue-600"><?php echo $CoursPlusEtudinat['titre_cour']; ?></span> 
                est le cours le plus étudiants: 
                <span class="text-blue-600"><?php echo $CoursPlusEtudinat['total']; ?></span>
            </h4>
        </div>

        <!-- Category Distribution Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h4 class="text-xl font-bold mb-4">Répartition par catégorie</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">nom de category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">nombre de courses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($repartitionParCategorie as $category): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><?php echo $category['category_name']; ?></td>
                                <td class="px-6 py-4">
                                    <a href="?category_id=<?php echo $category['id_category']; ?>" 
                                       class="text-blue-600 hover:text-blue-800">
                                        <?php echo $category['totalCour']; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Teachers Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-xl font-bold mb-4">Top 3 Enseignants</h4>
            <div class="space-y-4">
                <?php foreach ($TopTreeEnseignants as $index => $enseignant): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 rounded-full <?php echo $index === 0 ? 'bg-yellow-100 text-yellow-600' : ($index === 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-600'); ?>">
                                <i class="fas fa-award"></i>
                            </div>
                            <span class="font-medium"><?php echo $enseignant['nom']; ?></span>
                        </div>
                        <span class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                            Nombre de cours : <?php echo $enseignant['topTree']; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Category Courses Modal (if category_id is set) -->
    <?php if (isset($categoryCourses)): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg max-w-2xl w-full mx-4">
                <h3 class="text-xl font-bold mb-4">Courses in Category</h3>
                <div class="max-h-96 overflow-y-auto">
                    <!-- Display category courses here -->
                    <?php foreach ($categoryCourses as $course): ?>
                        <div class="p-4 border-b hover:bg-gray-50">
                            <h4 class="font-medium"><?php echo $course['title']; ?></h4>
                            <!-- Add more course details as needed -->
                        </div>
                    <?php endforeach; ?>
                </div>
                <button onclick="window.location.href='StatistiquesPanel.php'" 
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Close
                </button>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>