<?php
session_start();
require_once '../middlewares/SeConnecterRedirect.php';
seConnecterRedirect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Login</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #3B82F6, #2563EB);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .auth-gradient {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(37, 99, 235, 0.8));
        }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center bg-red">
    <div class="min-h-screen auth-gradient flex items-center justify-center px-4">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <!-- Logo and Title -->
             <!-- erreur message for ensignant register -->
             <?php if (isset($_SESSION['success_register'])): ?>
            <div class="alert alert-sucees" role="alert">
        <?php 
        echo $_SESSION['success_register'];
        unset($_SESSION['success_register']); 
        ?>
    </div>
             <?php endif; ?>

          <?php if (isset($_SESSION['error_register'])): ?>
         <div class="alert alert-danger" role="alert">
        <?php 
        echo $_SESSION['error_register'];
        unset($_SESSION['error_register']); 
        ?>
    </div>
           <?php endif; ?>
            <div class="text-center mb-8">
                <a href="../index.php" class="inline-flex items-center space-x-2">
                    <i class="fas fa-book-reader text-3xl text-blue-600"></i>
                    <span class="text-2xl font-bold gradient-text">YouDemy</span>
                </a>
                <p class="text-gray-600 mt-3">Bienvenue ! Veuillez vous connecter à votre compte.</p>
            </div>

            <!-- Error Messages -->
            <?php if (isset($_SESSION['error_access'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <?php echo $_SESSION['error_access']; unset($_SESSION['error_access']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_enseignant'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <?php echo $_SESSION['error_enseignant']; unset($_SESSION['error_enseignant']); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form id="loginForm" method="post" action="../actions/SeConnecter_action.php" class="space-y-4">
                <!-- Email Input -->
                <div>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                           placeholder="Adresse e-mail" required>
                    <p class="text-red-500 text-sm mt-1 hidden" id="emailError">Veuillez entrer une adresse e-mail valide.</p>
                    <?php if (isset($_SESSION['error_email'])): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?php echo $_SESSION['error_email']; unset($_SESSION['error_email']); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Password Input -->
                <div>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                           placeholder="Mot de passe" required>
                    <?php if (isset($_SESSION['error_password'])): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?php echo $_SESSION['error_password']; unset($_SESSION['error_password']); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Connexion
                </button>
            </form>
            <!-- erreur massege for ensignant seconnecter  -->
            <?php if (isset($_SESSION['error_enseignant'])): ?>
        <div class="alert alert-danger" role="alert">
        <?php 
        echo $_SESSION['error_enseignant'];
        unset($_SESSION['error_enseignant']); 
        ?>
      </div>
             <?php endif; ?>


            <!-- Register Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Vous n'avez pas de compte? 
                    <a href="./Sinscrire.php" class="text-blue-600 hover:text-blue-700 font-medium">
                        Inscrivez-vous maintenant
                    </a>
                </p>
            </div>
        </div>
    </div>
        
    <!-- Form Validation Script -->
    <script>
        let email = document.getElementById('email');
        let emailError = document.getElementById('emailError');

        email.addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                email.classList.add('border-red-500');
                emailError.classList.remove('hidden');
            } else {
                email.classList.remove('border-red-500');
                emailError.classList.add('hidden');
            }
        });
    </script>
</body>
</html>