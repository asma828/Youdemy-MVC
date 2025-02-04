<?php session_start();

use classes\Tag;
require_once '../classes/Database.php';
require_once '../classes/Tag.php';
require_once '../middlewares/AdminAccess.php';
$TagModel = new Tag();

$tagsObj = $TagModel->getAllTags();
AdminAcess();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Tags Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                <a href="./UtilisateursPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="./CoursesPanel.php" class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Courses</span>
                </a>
                <a href="./TagsPanel.php" class="flex items-center space-x-2 p-3 rounded-lg bg-blue-50 text-blue-600">
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
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Tags Management</h2>
                <p class="text-gray-600">Manage course tags efficiently</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="../pages/AjouterTag__form.php" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Tag
                </a>
                <a href="../actions/logout.php" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Tags Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tag Name</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($tagsObj as $tag): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $tag->id_tag ?></td>
                                    <td class="px-6 py-4"><?= $tag->tag_name ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="../pages/ModifierTag__form.php?id=<?= $tag->id_tag ?>"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm rounded-md text-white bg-blue-600 hover:bg-blue-700 mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../actions/SupprimerTag_action.php?id=<?= $tag->id_tag ?>"
                                           onclick="return confirm('Are you sure you want to delete this tag?')"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm rounded-md text-white bg-red-600 hover:bg-red-700">
                                            <i class="fas fa-trash-alt"></i>
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