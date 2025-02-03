<?php
use Classes\AfficherListeCoursModel;
use classes\Tag;
use classes\Etudiant;
use classes\Inscription;
use classes\Utilisateur;

require_once '../classes/Database.php';
require_once '../classes/Utilisateur.php';
require_once '../classes/Etudiant.php';
require_once '../classes/Tag.php';
require_once '../classes/Inscription.php';
require_once '../middlewares/ConnectionAccess.php';
require_once '../Classes/AfficherListeCoursModel.php';

session_start();
ConnectionAccess();

$inscriptionModel = new Inscription("","");
$etudiantModel = new Etudiant("", "", "");
$courseModel = new AfficherListeCoursModel();
$TagModel = new Tag();

$utilisateurData = $etudiantModel->SelectedEtudiant($_SESSION['utilisateur']['id_utilisateur']);
$utilisateur_id = $utilisateurData['id_etudiant'];
$isBanned = $utilisateurData['is_baned'];

if ($isBanned == 1) {
    $_SESSION['Banned'] = "Vous avez été banni par l'administrateur. Contacter l'administrateur pour plus d'informations.";
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $isInscription = $inscriptionModel->getUserInscriptions($utilisateur_id, $_GET['id']);
    $course = $courseModel->AfficherCoursDetaille($id);
    $courseTags = $TagModel->getCoursTags($id) ;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Course Details</title>
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="../index.php" class="flex items-center space-x-2">
                    <i class="fas fa-book-reader text-2xl text-blue-600"></i>
                    <span class="text-xl font-bold gradient-text">Youdemy</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="../index.php" class="text-gray-600 hover:text-blue-600 transition-colors">Accueil</a>
                    <a href="./courses.php" class="text-gray-600 hover:text-blue-600 transition-colors">Cours</a>
                    <a href="./ListCategory.php" class="text-gray-600 hover:text-blue-600 transition-colors">Categories</a>
                </div>

                <div class="flex items-center space-x-4">
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
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Détail du cours</h1>
            <div class="flex items-center justify-center space-x-2 text-gray-600">
                <a href="../index.php">Accueil</a>
                <i class="fas fa-chevron-right text-sm"></i>
                <span>Détail du cours</span>
            </div>
        </div>
    </div>

    <!-- Course Details -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Course Title -->
                <div class="mb-8">
                    <span class="text-blue-600 font-medium">ID du cours: #<?= $course->id_cour ?></span>
                    <h1 class="text-3xl font-bold mt-2"><?= $course->titre_cour ?></h1>
                </div>

                <!-- Course Image -->
                <div class="mb-8">
                    <img src="<?= $course->imgPrincipale_cours ?>" alt="Course Image" class="w-full h-96 object-cover rounded-xl shadow-lg">
                </div>

                <!-- Course Description -->
                <div class="bg-white rounded-xl p-6 shadow-md mb-8">
                    <h2 class="text-2xl font-bold mb-4">Description du cours</h2>
                    <p class="text-gray-600 leading-relaxed"><?= $course->description_cours ?></p>
                </div>

                <!-- Course Content -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4">Contenu du cours</h2>
                    <div class="space-y-4">
                        <?php if ($course->is_video == 1): ?>
                            <a href="<?= $course->contenu_cours ?>" target="_blank" 
                               class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-play-circle text-blue-600 text-xl mr-4"></i>
                                <div>
                                    <span class="font-medium">Vidéo du cours</span>
                                    <p class="text-gray-500 text-sm">30 minutes</p>
                                </div>
                            </a>
                        <?php else: ?>
                            <a href="<?= $course->contenu_cours ?>" target="_blank"
                               class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-file-pdf text-blue-600 text-xl mr-4"></i>
                                <div>
                                    <span class="font-medium">Documentation du cours</span>
                                    <p class="text-gray-500 text-sm">PDF/WORD</p>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Status Messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        <?php echo $_SESSION['success']; ?>
                    </div>
                <?php endif; ?>

                <!-- Course Features -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                    <div class="bg-blue-600 py-4 px-6">
                        <h3 class="text-white font-bold">Caractéristiques du cours</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Catégorie</span>
                            <span class="font-medium"><?= $course->category_id ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Enseignant</span>
                            <span class="font-medium"><?= $course->id_enseignant ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID du cours</span>
                            <span class="font-medium">#<?= $course->id_cour ?></span>
                        </div>
                        
                        <?php if ($isInscription): ?>
                            <div class="bg-blue-100 text-blue-800 p-4 rounded-lg text-center">
                                Vous êtes déjà inscrit à ce cours
                            </div>
                        <?php else: ?>
                            <?php if (isset($_SESSION['utilisateur'])): ?>
                                <a href="../actions/Inscrivez_vous.php?id_cour=<?= $course->id_cour ?>" 
                                   class="block w-full text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                                    Inscrivez-vous
                                </a>
                            <?php else: ?>
                                <a href="./seConnecter.php?id_page=<?= $course->id_cour ?>" 
                                   class="block w-full text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                                    Se connecter
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Instructor Info -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4">Enseignant du cours</h3>
                    <div class="flex items-center mb-4">
                        <div>
                            <h4 class="font-bold"><?= $course->id_enseignant ?></h4>
                            <p class="text-gray-600 text-sm">Expert en développement web</p>
                        </div>
                    </div>
                    <p class="text-gray-600">Enseignant expert avec plus de 10 ans d'expérience dans le développement web et l'enseignement.</p>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4">Mots-clés</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($courseTags as $tag): ?>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                <?= $tag['tag_name'] ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-2xl font-bold mb-4">YouDemy</h2>
                    <p class="text-gray-400">YouDemy est une plateforme de formation en ligne qui propose des cours et des formations dans divers domaines. Nous offrons des ressources éducatives et des outils pour vous aider à améliorer vos compétences.</p>
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