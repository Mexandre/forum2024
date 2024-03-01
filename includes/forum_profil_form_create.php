<?php
if(!isset($_GET['type'])) {
    $sql = "SELECT id, nom FROM genre";
    $result = $cnx->query($sql);
    ?>
    <section id="profil">
        <form id="profil-create">
            <h2>Profil</h2>
            <label for="nom">Nom</label><input type="text" name="nom" id="nom">
            <label for="prenom">Prenom</label><input type="text" name="prenom" id="prenom">
            <label for="genre">Genre</label>
            <select name="genre" id="genre">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nom"] . '</option>';
                    }
                }
            ?>
            </select>
            <label for="adresse">Adresse</label><input type="text" name="adresse" id="adresse">
            <label for="pays">Pays</label><input type="text" name="pays" id="pays">
            <label for="cp">Code Postal</label><input type="text" name="cp" id="cp">
            <label for="ville">Ville</label><input type="text" name="ville" id="ville">
            <button>Renseigner le profil</button>
        </form>
    </section>
    <h2 id="msg"></h2>
   <?php
}
?>
<script src="../assets/js/profilCreate.js"></script>