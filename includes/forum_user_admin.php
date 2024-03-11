<section id="user">
    <form id="user-edit">
        <h2>Administration du profil</h2>
        <label for="pseudo">Pseudo</label>
        <input type="text" id="username" name="username">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
        <label for="password">Mot de passe</label>
        <input type="text" id="password" name="password" placeholder="Nouveau mot de passe">
        <label for="lastname">Nom</label>
        <input type="text" id="lastname" name="lastname" placeholder="Votre nom">
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" name="firstname" placeholder="Votre prénom">
        <label for="address">Adresse</label>
        <input type="text" id="address" name="address">
        <label for="zip">Code postal</label>
        <input type="text" id="zipcode" name="zipcode" >
        <label for="city">Ville</label>
        <input type="text" id="city" name="city" >
        <label for="city">Pays</label>
        <input type="text" id="country" name="country" >
        <input type="hidden" name="id" value="<?= $_SESSION['id'];?>">
        <button>Enregistré</button>
    </form>
</section>
<script>
    var id = <?= $_SESSION['id']; ?>;
</script>
<script src="../assets/js/userAdmin.js"></script>