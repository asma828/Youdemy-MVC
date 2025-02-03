<?php

use classes\Tag;
require_once '../classes/Database.php';
require_once '../classes/Tag.php';
session_start();

$TagModel = new Tag();
if (isset($_GET['id'])) {
    $tagObj = $TagModel->getTagById($_GET['id']);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>YouDemy - Modifier des Tags</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .page-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60%;
            height: 3px;
            background: #FF6600;
            border-radius: 2px;
        }

        .tag-input-group {
            position: relative;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .tag-input-group:hover {
            transform: translateX(5px);
        }

        .form-control {
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #FF6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.15);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #FF6600;
            border: none;
        }

        .btn-primary:hover {
            background: #e65c00;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 92, 0, 0.2);
        }

        .btn-outline-primary {
            color: #FF6600;
            border-color: #FF6600;
        }

        .btn-outline-primary:hover {
            background: #FF6600;
            color: white;
        }

        .btn-remove {
            position: absolute;
            right: -40px;
            top: 50%;
            transform: translateY(-50%);
            color: #dc3545;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s;
        }

        .tag-input-group:hover .btn-remove {
            opacity: 1;
            right: -50px;
        }

        .add-tag-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tag-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .animation-container {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="../adminPages/TagsPanel.php" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
                </a>
                <h3 class="page-title mb-0">Mofifier un tag</h3>
            </div>

            <form id="courseForm" method="POST" action="../actions/ModifierTag_action.php">
                <input type="hidden" name="id_tag" value="<?= $tagObj->id_tag ?>">
                <div id="group_inputs">
                    <div class="tag-input-group animation-container">
                        <label class="tag-label" for="tag_1">nom de Tag</label>
                        <input type="text" value="<?= $tagObj->tag_name ?>" class="form-control" id="tag_1"
                            name="tag_name" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Modifier le tag
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>