
<?php
$type = $_GET['type'] ?? 'subject'; // 'defaultType' est une valeur par défaut de votre choix
$step = $_GET['step'] ?? 'list'; // 'defaultStep' est une valeur par défaut de votre choix
$caseKey = $type . '-' . $step;
// Définition et exécution de la fonction correspondante
(content($caseKey))();

function content($caseKey) {
    return match ($caseKey) {
        'subject-create' => function() {
            // Insérez ici le code pour 'subject-create'
            ?>
            <h1>Créer un sujet</h1>
            <form id="create-subject">
                <input type="hidden" id="id_theme" name="id_theme">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre">
                <input type="submit" value="Créer le sujet">
            </form>
            <?php
                // Plus de code HTML/PHP pour le formulaire de création
        },
        'subject-edit' => function() {
            // Insérez ici le code pour 'subject-edit'
            ?>
            <h1>Modifier le sujet</h1>
            <form id="edit-subject">
                <input type="hidden" id="id_theme" name="id_theme">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre">
                <input type="submit" value="Modifier le sujet">
            </form>
            <?php
                // Plus de code HTML/PHP pour le formulaire de modification
        },
        'msg-create' => function() {
            // Insérez ici le code pour 'subject-edit'
            ?>
            <h1>Répondre</h1>
            <form id="edit-subject">
                <input type="hidden" id="id_theme" name="id_theme">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre">
                <input type="submit" value="Modifier le sujet">
            </form>
            <?php
                // Plus de code HTML/PHP pour le formulaire de modification
        },
        'msg-edit' => function() {
            // Insérez ici le code pour 'subject-edit'
            ?>
            <h1>Modifier mon message</h1>
            <form id="edit-subject">
                <input type="hidden" id="id_theme" name="id_theme">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre">
                <input type="submit" value="Modifier le sujet">
            </form>
            <?php
                // Plus de code HTML/PHP pour le formulaire de modification
        },
        // Définissez d'autres cas comme nécessaire
        default => fn() => null, // Fonction par défaut qui ne fait rien
    };
}
