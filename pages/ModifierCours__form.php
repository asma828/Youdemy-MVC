<?php

use classes\Category;
use Classes\CourseModel;
use classes\Tag;

require_once '../classes/Category.php';
require_once '../classes/CourseModel.php';
require_once '../classes/Tag.php';
require_once '../classes/Database.php';

session_start();

$CategoryModel = new Category();
$TagModel = new Tag();
$courseModel = new CourseModel();
$categoryObj = $CategoryModel->getAllCategories();
$tagsObj = $TagModel->getAllTags();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $courseObj = $courseModel->getCourseById($id);
    $coursesTags = $TagModel->getCoursTags($id);

}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>YouDemy - Modifier Course</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <style>
        .form-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 40px auto;
        }

        .form-title {
            color: #FF6600;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .form-control:focus {
            border-color: #FF6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }

        .btn-primary {
            background-color: #FF6600;
            border-color: #FF6600;
        }

        .btn-primary:hover {
            background-color: #e65c00;
            border-color: #e65c00;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="form-container">
            <div class="d-flex justify-content-between">
                <a href="../enseignantPages/CoursesPanel.php" class="btn btn-outline-primary">Retour au tableau de
                    bord</a>
                <h3 class="text-primary">Modifier un cours</h3>
            </div>
            <hr>
            <form id="courseForm" method="POST" action="../actions/ModifierCours_action.php">

                <input type="hidden" name="id_cour" value="<?= $courseObj->id_cour ?>">
                <input type="hidden" name="is_video" value="<?= $courseObj->is_video ?>">
                <div class="form-group">
                    <label for="titre_cour">Titre du cours</label>
                    <input type="text" value="<?= $courseObj->titre_cour ?>" class="form-control" id="titre_cour"
                        name="titre_cour" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="imgPrincipale_cours">URL de l'image principale</label>
                            <input type="url" value="<?= $courseObj->imgPrincipale_cours ?>" class="form-control"
                                id="imgPrincipale_cours" name="imgPrincipale_cours" required>
                            <img id="mainPreview" class="preview-image" src="/api/placeholder/200/200"
                                alt="Aperçu de l'image principale">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="imgSecondaire_cours">URL de l'image secondaire</label>
                            <input type="url" value="<?= $courseObj->imgSecondaire_cours ?>" class="form-control"
                                id="imgSecondaire_cours" name="imgSecondaire_cours" required>
                            <img id="secondaryPreview" class="preview-image" src="/api/placeholder/200/200"
                                alt="Aperçu de l'image secondaire">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description_cours">Description du cours</label>
                    <textarea class="form-control" id="description_cours" name="description_cours" rows="4"
                        required><?= $courseObj->description_cours ?></textarea>
                </div>

                <div class="form-group" id="contenu_cours_group">
                    <?php if ($courseObj->is_video): ?>
                        <input type="url" value="<?= $courseObj->contenu_cours ?>" class="form-control mt-3"
                            id="contenu_cours" name="contenu_cours_video" placeholder="URL de la vidéo" required>
                    <?php else: ?>
                        <input type="url" class="form-control mt-3" value="<?= $courseObj->contenu_cours ?>"
                            id="contenu_cours" name="contenu_cours_document" placeholder="URL du Fichier Document" required>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="category_id">Catégorie</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Sélectionnez une catégorie</option>
                        <?php foreach ($categoryObj as $category): ?>
                            <?php if ($category->id_category == $courseObj->category_id): ?>
                                <option value="<?php echo $category->id_category; ?>" selected>
                                    <?php echo $category->category_name; ?>
                                </option>
                            <?php else: ?>
                                <option value="<?php echo $category->id_category; ?>">
                                    <?php echo $category->category_name; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tags">Tags</label><br>
                    <select class="form-control" id="tags" name="tags[]" multiple required>
                        <option value="">Sélectionnez des mots-clés</option>
                        <?php foreach ($tagsObj as $tag): ?>
                            <?php if (in_array($tag->id_tag, array_column($coursesTags, 'id_tag'))): ?>
                                <option value="<?= htmlspecialchars($tag->id_tag); ?>" selected>
                                    <?= htmlspecialchars($tag->tag_name); ?>
                                </option>
                            <?php else: ?>
                                <option value="<?= htmlspecialchars($tag->id_tag); ?>">
                                    <?= htmlspecialchars($tag->tag_name); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>



                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">Modifier le cours</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2 on the Tags dropdown
            $('#tags').select2({
                placeholder: "Sélectionnez des tags",
                allowClear: true,
                width: '90%'
            });
        });
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>