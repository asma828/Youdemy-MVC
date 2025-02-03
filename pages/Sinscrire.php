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
    <title>Youdemy - Register</title>
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
<body class="min-h-screen bg-cover bg-center">
    <div class="min-h-screen auth-gradient flex items-center justify-center px-4">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <a href="../index.php" class="inline-flex items-center space-x-2">
                    <i class="fas fa-book-reader text-3xl text-blue-600"></i>
                    <span class="text-2xl font-bold gradient-text">YouDemy</span>
                </a>
                <p class="text-gray-600 mt-3">Créez votre compte pour commencer à apprendre</p>
            </div>

            <!-- Registration Form -->
            <form id="registerForm" method="POST" action="../actions/Sinscrire_action.php" class="space-y-4">
                <!-- Name Input -->
                <div>
                    <input type="text" id="name" name="name" 
                           class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                           placeholder="Nom complet" required>
                    <p class="text-red-500 text-sm mt-1 hidden" id="nameError">Veuillez entrer votre nom correct.</p>
                </div>

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

                <!-- Role Selection -->
                <div>
                    <select id="role" name="role" required
                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="">Choisissez un rôle</option>
                        <option value="etudiant">Etudiant</option>
                        <option value="enseignant">Enseignant</option>
                    </select>
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

                <!-- Confirm Password Input -->
                <div>
                    <input type="password" id="confirmPassword" name="confirmPassword" 
                           class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                           placeholder="Confirmez le mot de passe" required>
                    <p class="text-red-500 text-sm mt-1 hidden" id="passwordError">Les mots de passe ne correspondent pas.</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    S'inscrire
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Déjà un compte? 
                    <a href="./seConnecter.php" class="text-blue-600 hover:text-blue-700 font-medium">
                        Connexion
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Form Validation Script -->
    <script>
        let name = document.getElementById('name');
        let email = document.getElementById('email');
        let password = document.getElementById('password');
        let confirmPassword = document.getElementById('confirmPassword');
        let nameError = document.getElementById('nameError');
        let emailError = document.getElementById('emailError');
        let passwordError = document.getElementById('passwordError');

        name.addEventListener('input', function() {
            const nameRegex = /^[A-Za-z\s]+$/;
            if (!nameRegex.test(name.value)) {
                name.classList.add('border-red-500');
                nameError.classList.remove('hidden');
            } else {
                name.classList.remove('border-red-500');
                nameError.classList.add('hidden');
            }
        });

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

        confirmPassword.addEventListener('input', function() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('border-red-500');
                passwordError.classList.remove('hidden');
            } else {
                confirmPassword.classList.remove('border-red-500');
                passwordError.classList.add('hidden');
            }
        });
    </script>
</body>
</html>