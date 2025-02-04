<?php
use classes\Inscription;

require_once '../classes/Inscription.php';
require_once '../classes/Database.php';
require_once '../middlewares/AccessEnseignant.php';

session_start();
AccessEnseignant();

$inscriptionModel = new Inscription("","");
$enseignantInscriptions = $inscriptionModel->getEnseignantInscriptions($_SESSION['utilisateur']['id_enseignant']);

if (isset($_GET['id_cour'])) {
    $id_cour = $_GET['id_cour'];
    $EtudinatCourseInscrit = $inscriptionModel->CourseEtudiantInscite($id_cour);
}
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
                <a href="./CoursesPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Cours</span>
                </a>
                <a href="./InscriptionPanel.php" class="flex items-center space-x-2 p-3 rounded-lg bg-blue-50 text-blue-600">
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
            <h2 class="text-2xl font-bold">Liste des Inscriptions</h2>
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

        <!-- Inscriptions Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h4 class="text-xl font-bold mb-4">Liste D'inscription</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Cours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre du Cours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date d'inscription</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nbr d'inscription</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($enseignantInscriptions as $inscription): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4"><?= $inscription['id_cour'] ?></td>
                                    <td class="px-6 py-4"><?= $inscription['titre_cour'] ?></td>
                                    <td class="px-6 py-4"><?= $inscription['first_insc_date'] ?></td>
                                    <td class="px-6 py-4">
                                        <a href="?id_cour=<?= $inscription['id_cour'] ?>" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <?= $inscription['total_etudiants'] ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Student List Section -->
        <?php if (isset($_GET['id_cour'])): ?>
            <div class="mt-8 bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-xl font-bold">
                            Liste des étudiants inscrits au
                            <span class="text-blue-600">
                                <?= $EtudinatCourseInscrit[0]['titre_cour'] ?>
                            </span>
                        </h4>
                        <button onclick="window.location.href = window.location.href.split('?')[0]"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Étudiant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($EtudinatCourseInscrit as $etd): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4"><?= $etd['id_etudiant'] ?></td>
                                        <td class="px-6 py-4"><?= $etd['nom'] ?></td>
                                        <td class="px-6 py-4"><?= $etd['email'] ?></td>
                                        <td class="px-6 py-4"><?= $etd['date_insc'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>