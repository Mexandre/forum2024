<?php
 if($_SESSION['niveau'] > 2) {
?>
<section id="user">
    <form id="user-edit">
        <h2>Administration du profil</h2>
        <fieldset>
            <legend>Connexion</legend>
            <label for="pseudo">Pseudo</label>
            <input type="text" id="username" name="username">
            <label for="email">Email</label>
            <input type="text" id="email" name="email">
            <label for="password">Mot de passe</label>
            <input type="text" id="password" name="password" placeholder="Nouveau mot de passe">
            <label class="toggler-wrapper banned">
				<input type="checkbox" name="blocked" id="blocked">
				<div class="toggler-slider email-blocked" value="1">
					<div class="toggler-knob"></div>
				</div>
			</label>
            <label class="toggler-wrapper email-blocked">
				<input type="checkbox" name="email-blocked" id="email-blocked">
				<div class="toggler-slider">
					<div class="toggler-knob"></div>
				</div>
			</label>
        </fieldset>
        <fieldset>
            <legend>Identité</legend>
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
        </fieldset>
        <input type="hidden" id="id" name="id" value="<?= $_GET['id'];?>">
        <button>Enregistré</button><a href="#" id="delete-user">Supprimer</a>
    </form>
</section>
<script src="../assets/js/userAdmin.js"></script>
<?php
 }
 ?>