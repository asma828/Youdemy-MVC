<?php
namespace Dashboard\Admin;
use classes\Utilisateur;
use classes\Etudiant;
require_once '../classes/Utilisateur.php';
require_once '../classes/Database.php';
require_once '../classes/Enseignant.php';
require_once '../middlewares/AdminAccess.php';

$utilisateurModel = new Utilisateur("","","","");
$utilisateursObjEnseignant = $utilisateurModel->getAllUtilisateursEnseignant();
$utilisateursObjEtudiant = $utilisateurModel->getAllUtilisateursEtudiant();

session_start();
AdminAcess();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Utilisateurs</title>
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
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./UtilisateursPanel.php" class="flex items-center space-x-2 p-3 rounded-lg bg-blue-50 text-blue-600">
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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Gestion des Utilisateurs</h2>
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['utilisateur'])): ?>
                    <span class="font-medium"><?php echo $_SESSION['utilisateur']['nom']; ?></span>
                <?php else: ?>
                    <span class="font-medium">Admin User</span>
                <?php endif; ?>
                <a href="../actions/lougout.php" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <!-- Teachers Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h4 class="text-xl font-bold mb-4">Liste des Enseignants</h4>
            
            <?php if (isset($_SESSION['success_enseignant'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <?php echo $_SESSION['success_enseignant']; unset($_SESSION['success_enseignant']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_enseignant'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <?php echo $_SESSION['error_enseignant']; unset($_SESSION['error_enseignant']); ?>
                </div>
            <?php endif; ?>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Account</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($utilisateursObjEnseignant as $utilisateur): ?>
                            <?php if ($utilisateur->role === 'enseignant'): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $utilisateur->nom ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $utilisateur->email ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $utilisateur->role ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="../actions/activerEnseignant.php" method="post">
                                            <input type="hidden" name="id" value="<?= $utilisateur->id_utilisateur ?>">
                                            <?php if ($utilisateur->is_active != 0): ?>
                                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                            <?php else: ?>
                                                <select class="form-select w-32 mx-auto rounded border-gray-300" 
                                                        name="is_active" 
                                                        onchange="this.form.submit()">
                                                    <option value="0" selected>Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="../actions/DeleteEnseignant.php?utilisateurId=<?= $utilisateur->id_utilisateur ?>"
                                           onclick="return confirm('Etes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Students Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h4 class="text-xl font-bold mb-4">Liste des Étudiants</h4>

            <?php if (isset($_SESSION['success_etudiant'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <?php echo $_SESSION['success_etudiant']; unset($_SESSION['success_etudiant']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_etudiant'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <?php echo $_SESSION['error_etudiant']; unset($_SESSION['error_etudiant']); ?>
                </div>
            <?php endif; ?>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($utilisateursObjEtudiant as $utilisateur): ?>
                            <?php if ($utilisateur->role === 'etudiant'): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $utilisateur->nom ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $utilisateur->email ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $utilisateur->role ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <?php if ($utilisateur->is_baned == 1): ?>
                                            <a href="../actions/banUEtudiant.php?id=<?= $utilisateur->id_utilisateur ?>&action=0"
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Activate
                                            </a>
                                        <?php else: ?>
                                            <a href="../actions/banUEtudiant.php?id=<?= $utilisateur->id_utilisateur ?>&action=1"
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Ban
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="../actions/DeleteEtudiant.php?utilisateurId=<?= $utilisateur->id_utilisateur ?>"
                                           onclick="return confirm('Etes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Mobile sidebar toggle
        const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
        const sidebar = document.querySelector('aside');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('translate-x-0');
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
</body>
</html>