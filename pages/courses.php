<?php
session_start();

use Classes\AfficherListeCoursModel;
use classes\Tag;
require_once '../classes/AfficherListeCoursModel.php';
require_once '../classes/Database.php';
require_once '../classes/Tag.php';
$courseModel = new AfficherListeCoursModel();
$TagModel = new Tag();

// Get current page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Get search term
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get courses
$listCoursObj = $courseModel->afficherCours($page, $search);

// Calculate pagination
$LigneParPage = AfficherListeCoursModel::$coursePerPage;
$totalLignes = $courseModel->Nbr_Cours();
$LignesSelectioner = ceil($totalLignes / $LigneParPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Liste Des Cours</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #3B82F6, #2563EB);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="../index.php" class="flex items-center space-x-2">
                    <i class="fas fa-book-reader text-2xl text-blue-600"></i>
                    <span class="text-xl font-bold gradient-text">YouDemy</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../index.php" class="text-gray-600 hover:text-blue-600 transition-colors">Accueil</a>
                    <a href="./courses.php" class="text-blue-600 font-medium">Cours</a>
                    <a href="./ListCategory.php" class="text-gray-600 hover:text-blue-600 transition-colors">Categories</a>
                </div>

                <!-- Auth Section -->
                <?php if (isset($_SESSION['utilisateur'])): ?>
                    <div class="relative group">
                        <button class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium flex items-center space-x-2">
                            <span><?php echo $_SESSION['utilisateur']['nom']; ?></span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl hidden group-hover:block">
                            <?php if ($_SESSION['utilisateur']['role'] == 'etudiant'): ?>
                                <a href="./mesCours.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mes Cours</a>
                            <?php endif; ?>
                            <a href="../actions/lougout.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="./seConnecter.php" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
                        Se connecter
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="hero-gradient py-20">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Découvrez nos cours</h1>
                <p class="text-lg text-gray-600">Explorez notre catalogue de cours et commencez votre apprentissage dès aujourd'hui</p>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <div class="container mx-auto px-4 -mt-8 mb-12">
        <div class="max-w-2xl mx-auto">
            <form action="" method="GET" class="relative">
                <input type="text" name="search" 
                       value="<?= htmlspecialchars($search) ?>" 
                       class="w-full px-4 py-3 pl-12 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-lg"
                       placeholder="Rechercher un cours">
                <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                <button type="submit" class="absolute right-2 top-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($listCoursObj)): ?>
                <?php foreach ($listCoursObj as $cours): ?>
                    <a href="./CourseDetails.php?id=<?= $cours->id_cour ?>" 
                       class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                        <div class="relative h-48">
                            <img class="w-full h-full object-cover" 
                                 src="<?= htmlspecialchars($cours->imgPrincipale_cours) ?>" 
                                 alt="<?= htmlspecialchars($cours->titre_cour) ?>">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($cours->titre_cour) ?></h3>
                            <div class="flex justify-between items-center mt-4 text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    <span><?= htmlspecialchars($cours->id_enseignant) ?></span>
                                </div>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    <?= htmlspecialchars($cours->category_id) ?>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-lg shadow-md p-8 max-w-lg mx-auto">
                        <h3 class="text-2xl font-bold text-blue-600 mb-4">Aucun cours disponible</h3>
                        <p class="text-gray-600">Nous n'avons trouvé aucun cours correspondant à votre recherche.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($LignesSelectioner > 1): ?>
            <div class="flex justify-center mt-12">
                <nav class="inline-flex rounded-lg shadow">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>" 
                           class="px-3 py-2 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $LignesSelectioner; $i++): ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" 
                           class="px-4 py-2 bg-white border border-gray-200 <?= ($page == $i) ? 'bg-blue-50 text-blue-600 font-medium' : 'hover:bg-gray-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $LignesSelectioner): ?>
                        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>" 
                           class="px-3 py-2 bg-white border border-gray-200 rounded-r-lg hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-2xl font-bold mb-4">YouDemy</h2>
                    <p class="text-gray-400">YouDemy est une plateforme de formation en ligne qui propose des cours et des formations dans divers domaines. Nous offrons des ressources éducatives et des outils pour vous aider à améliorer vos compétences et à atteindre vos objectifs.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                    <div class="flex space-x-2">
                        <input type="email" placeholder="Votre adresse e-mail" 
                               class="flex-1 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            S'inscrire
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>Copyright © YouDemy. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>