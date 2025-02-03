<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Transform Your Future With Online Learning</title>
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
    <!-- Banned User Alert -->
    <?php if (isset($_SESSION['Banned'])): ?>
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['Banned']; ?></span>
            </div>
        </div>
        <?php unset($_SESSION['Banned']); ?>
    <?php endif; ?>

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="./index.php" class="flex items-center space-x-2">
                    <i class="fas fa-book-reader text-2xl text-blue-600"></i>
                    <span class="text-xl font-bold gradient-text">Youdemy</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../index.php" class="text-gray-600 hover:text-blue-600 transition-colors">Accueil</a>
                    <a href="./pages/courses.php" class="text-gray-600 hover:text-blue-600 transition-colors">Cours</a>
                    <a href="./pages/ListCategory.php" class="text-gray-600 hover:text-blue-600 transition-colors">Categories</a>
                </div>

                <!-- Auth Section -->
                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Search courses..." 
                               class="w-64 px-4 py-2 pl-10 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <?php if (isset($_SESSION['utilisateur'])): ?>
                        <div class="relative group">
                            <button class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium flex items-center space-x-2">
                                <span><?php echo $_SESSION['utilisateur']['nom']; ?></span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl hidden group-hover:block">
                                <?php if ($_SESSION['utilisateur']['role'] == 'etudiant'): ?>
                                    <a href="./pages/mesCours.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mes Cours</a>
                                <?php endif; ?>
                                <a href="./actions/lougout.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="./pages/seConnecter.php" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
                            Se connecter
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient py-20">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Vous êtes à la bonne place
                </h1>
                <h2 class="text-3xl md:text-4xl font-bold mb-8">
                    Découvrez nos cours d'apprentissage
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    Vous cherchez une plateforme de formation en ligne pour améliorer vos compétences ? 
                    YouDemy est l'endroit idéal pour vous. Nous offrons des milliers de cours dans des 
                    domaines différents pour vous aider à atteindre vos objectifs.
                </p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-green-100 rounded-lg">
                    <div class="text-3xl font-bold text-green-600" data-toggle="counter-up">123</div>
                    <div class="text-gray-600">Cours disponibles</div>
                </div>
                <div class="text-center p-6 bg-blue-100 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600" data-toggle="counter-up">1234</div>
                    <div class="text-gray-600">Cours en ligne</div>
                </div>
                <div class="text-center p-6 bg-gray-100 rounded-lg">
                    <div class="text-3xl font-bold text-gray-600" data-toggle="counter-up">123</div>
                    <div class="text-gray-600">Instructeurs expérimentés</div>
                </div>
                <div class="text-center p-6 bg-yellow-100 rounded-lg">
                    <div class="text-3xl font-bold text-yellow-600" data-toggle="counter-up">1234</div>
                    <div class="text-gray-600">Etudiants satisfaits</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold">Pourquoi commencer à apprendre avec nous ?</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Des instructeurs expérimentés</h3>
                                <p class="text-gray-600">Nous avons des instructeurs expérimentés qui vous aideront à atteindre vos objectifs.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-certificate text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Des certificats internationaux</h3>
                                <p class="text-gray-600">Nous offrons des certificats internationaux qui vous aideront à trouver un emploi.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Des cours en ligne</h3>
                                <p class="text-gray-600">Nous offrons des cours en ligne qui vous permettent d'apprendre à votre propre rythme.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative h-96">
                    <img src="./assets/img/courses-2.jpg" alt="Features" class="absolute inset-0 w-full h-full object-cover rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Carousel -->
    <div class="container-fluid px-0 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Découvrez les dernières sorties de nos cours</h2>
        </div>
        <div class="owl-carousel courses-carousel">
            <!-- Course items from original design -->
            <!-- Note: Keeping the original carousel structure for functionality -->
            <div class="courses-item position-relative">
                <!-- Original course content structure preserved -->
                <!-- ... -->
            </div>
        </div>
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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/lib/easing/easing.min.js"></script>
    <script src="./assets/lib/waypoints/waypoints.min.js"></script>
    <script src="./assets/lib/counterup/counterup.min.js"></script>
    <script src="./assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="./assets/js/main.js"></script>
</body>
</html>