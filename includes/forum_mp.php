<h1>Boîte de message</h1>

<button id="nouveauMessageBtn">Nouveau Message</button>

<form id="mpForum">
    <label for="destinataire">Destinataire:</label>
    <input name="destinataire" type="text" id="destinataire">
    <input type="hidden" name="userId" value="<?= $_GET['id'];?>">
    <ul id="search-destinataire" ></ul>

    <label  for="sujetmp">Sujet:</label>
    <input name="sujetmp" type="text" id="sujetmp">

    <label for="message">Message:</label>
    <textarea name="message" id="message"></textarea>

    <button id="envoyerBtn">Envoyer</button>
    <button id="fermerBtn">Fermer</button>
</form>
<script src="../assets/js/forumMp.js" defer></script>
<style>
#mpForum {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    a {
    cursor: pointer; /* Définissez le curseur sur pointer */
}

</style>