<?php session_start();

use Classes\CourseModel;
require_once '../classes/CourseModel.php';
require_once '../middlewares/AccessEnseignant.php';

AccessEnseignant();

$CourseModel = new CourseModel();
$coursesObj = $CourseModel->getAllEnseignantCourses($_SESSION['utilisateur']['id_utilisateur']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Enseignant Dashboard</title>
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
                <a href="./StatistiquesPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./CoursesPanel.php" class="flex items-center space-x-2 p-3 rounded-lg bg-blue-50 text-blue-600">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Cours</span>
                </a>
                <a href="./InscriptionPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-list-ol"></i>
                    <span>Inscriptions</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-8">
        <!-- Header with Session Info -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Gestion des Cours</h2>
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

        <!-- Action Bar -->
        <div class="flex justify-between items-center mb-8">
            <span class="text-gray-600">Gérez vos cours efficacement</span>
            <a href="../pages/AjouterCours__form.php" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-plus-circle mr-2"></i>Ajouter un nouveau cours
            </a>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Courses Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h4 class="text-xl font-bold mb-4">Liste des Cours</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre du cours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($coursesObj as $course): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4"><?= $course->id_cour; ?></td>
                                    <td class="px-6 py-4"><?= $course->titre_cour; ?></td>
                                    <td class="px-6 py-4"><?= substr($course->description_cours, 0, 50); ?>...</td>
                                    <td class="px-6 py-4"><?= $course->category_id; ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="../pages/ModifierCours__form.php?id=<?= $course->id_cour; ?>" 
                                           class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../actions/SupprimerCours_action.php?id=<?= $course->id_cour; ?>" 
                                           class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                           onclick="return confirm('Voulez-vous vraiment supprimer ce cours ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>