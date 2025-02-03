<?php
session_start();

use Classes\CourseModel;
use classes\Etudiant;
require_once '../classes/CourseModel.php';
require_once '../classes/Etudiant.php';
require_once '../middlewares/ConnectionAccess.php';

$id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
$courseModel = new CourseModel();
$Mycourses = $courseModel->MyCourses($id_utilisateur);
$etudiantModel = new Etudiant("","","");
$utilisateurData = $etudiantModel->SelectedEtudiant($_SESSION['utilisateur']['id_utilisateur']);

if ($utilisateurData['is_baned'] == 1) {
    $_SESSION['Banned'] = "Vous avez été banni par l'administrateur. Contacter l'administrateur pour plus d'informations.";
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Mes Cours</title>
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
                    <span class="text-xl font-bold gradient-text">Youdemy</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../index.php" class="text-gray-600 hover:text-blue-600 transition-colors">Accueil</a>
                    <a href="./courses.php" class="text-gray-600 hover:text-blue-600 transition-colors">Cours</a>
                    <a href="./ListCategory.php" class="text-gray-600 hover:text-blue-600 transition-colors">Categories</a>
                </div>

                <!-- User Menu -->
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
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="hero-gradient py-16">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Mes Cours</h1>
                <p class="text-lg text-gray-600">Continuez votre apprentissage et suivez votre progression</p>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <?php if (empty($Mycourses)): ?>
                <div class="text-center bg-white rounded-lg shadow-md p-8">
                    <h4 class="text-xl text-gray-700">Vous n'avez pas encore de cours</h4>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($Mycourses as $course): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                            <!-- Course Image -->
                            <div class="relative">
                                <img class="w-full h-48 object-cover" src="<?= $course['imgPrincipale_cours'] ?>" alt="Course Image">
                            </div>
                            
                            <!-- Course Info -->
                            <div class="p-6">
                                <a href="./CourseDetails.php?id=<?= $course['id_cour'] ?>" class="block mb-4">
                                    <h3 class="text-xl font-semibold text-gray-800 hover:text-blue-600 transition-colors">
                                        <?= $course['titre_cour'] ?>
                                    </h3>
                                </a>
                                
                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                                
                                <!-- Course Meta -->
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="far fa-clock mr-2"></i>
                                    <span>Inscrit le: <?= $course['date_insc'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-2xl font-bold mb-4">YouDemy</h2>
                    <p class="text-gray-400">YouDemy est une plateforme de formation en ligne qui propose des cours dans divers domaines. Nous offrons des ressources éducatives pour vous aider à améliorer vos compétences.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                    <div class="flex space-x-2">
                        <input type="email" placeholder="Votre adresse e-mail" class="flex-1 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:border-blue-500">
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