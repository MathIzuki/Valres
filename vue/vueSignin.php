
    <?php if (!estConnecte()) { ?>
    <div class="inscription">
        <form action="../../modele/data_process.php" method="post">
            <h3>CONNEXION</h3>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Votre e-mail" id="email" name="email" required>

            <label for="motdepasse">Mot de passe</label>
            <input type="password" placeholder="Votre mot de passe" id="motdepasse" name="motdepasse" required>
            <button>Se connecter</button>
        </form>
    </div>
    
    <?php } else { ?>
        <div class="page-deconnexion">
            <h1>Déconnexion</h1>
            <h3>Vous êtes déjà connecté, si vous voulez vous déconnecter allez <a href="/controleur/logout.php">ici</a></h3>
        </div>
         <?php } ?>

