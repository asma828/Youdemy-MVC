<?php
session_start();

use classes\Category;
require_once '../classes/Database.php';
require_once '../classes/Category.php';

$CategoryModel = new Category();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$categoryObj = $CategoryModel->getCategoriesDetails($page);
$LigneParPage = $CategoryModel->CategoryPerPage;
$totalLignes = $CategoryModel->Nbr_Category();
$LignesSelectioner = ceil($totalLignes / $LigneParPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Categories</title>
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
        .category-gradient-1 { background: linear-gradient(45deg, #FF6B6B, #FF8E53); }
        .category-gradient-2 { background: linear-gradient(45deg, #4E65FF, #92EFFD); }
        .category-gradient-3 { background: linear-gradient(45deg, #45B649, #DCE35B); }
        .category-gradient-4 { background: linear-gradient(45deg, #834D9B, #D04ED6); }
        .category-gradient-5 { background: linear-gradient(45deg, #F7971E, #FFD200); }
        .category-gradient-6 { background: linear-gradient(45deg, #11998E, #38EF7D); }
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
                    <a href="./courses.php" class="text-gray-600 hover:text-blue-600 transition-colors">Cours</a>
                    <a href="./ListCategory.php" class="text-blue-600 font-medium">Categories</a>
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
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Catégories</h1>
                <p class="text-lg text-gray-600">Explorez nos différents domaines d'apprentissage et trouvez les cours qui vous correspondent</p>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Nos Catalogues</h2>
            <p class="text-gray-600">Explorez nos domaines d'apprentissage et commencez votre voyage éducatif</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            $gradients = ['category-gradient-1', 'category-gradient-2', 'category-gradient-3', 
                         'category-gradient-4', 'category-gradient-5', 'category-gradient-6'];
            $i = 0;
            foreach ($categoryObj as $category): 
                $gradientClass = $gradients[$i % count($gradients)];
            ?>
                <a href="courses.php?category_id=<?= $category->id_category ?>" 
                   class="block rounded-xl overflow-hidden shadow-lg card-hover">
                    <div class="<?= $gradientClass ?> p-8">
                        <div class="h-32 flex items-center justify-center">
                            <img src="../assets/img/ycd.png" alt="" class="h-24 w-24 object-contain">
                        </div>
                    </div>
                    <div class="bg-white p-6">
                        <h3 class="text-xl font-semibold text-center mb-2">
                            <?= htmlspecialchars($category->category_name) ?>
                        </h3>
                        <p class="text-gray-500 text-center">150 cours disponibles</p>
                    </div>
                </a>
            <?php 
                $i++;
            endforeach; 
            ?>
        </div>

        <!-- Pagination -->
        <?php if ($LignesSelectioner > 1): ?>
            <div class="flex justify-center mt-12">
                <nav class="inline-flex rounded-lg shadow">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page-1 ?>" 
                           class="px-3 py-2 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $LignesSelectioner; $i++): ?>
                        <a href="?page=<?= $i ?>" 
                           class="px-4 py-2 bg-white border border-gray-200 <?= ($page == $i) ? 'bg-blue-50 text-blue-600 font-medium' : 'hover:bg-gray-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $LignesSelectioner): ?>
                        <a href="?page=<?= $page+1 ?>" 
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