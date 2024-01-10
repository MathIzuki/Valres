<div class="form-ajout-utilisateur">
        <h1>Ajouter un nouvel utilisateur</h1>
        <form method="post" action="index.php?action=AjouterUtilisateur">
            <!-- Nom -->
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <!-- Prénom -->
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <!-- Email -->
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <!-- Mot de Passe -->
            <label for="motDePasse">Mot de Passe :</label>
            <input type="password" id="motDePasse" name="motDePasse" required>

            <!-- Structure -->
            <label for="structure">Structure :</label>
            <select id="structure" name="structure">
                <?php foreach ($listeStructures as $structure) : ?>
                    <option value="<?= $structure['idStructure'] ?>"><?= htmlspecialchars($structure['structure_nom']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Accès -->
            <label for="acces">Type d'accès :</label>
            <select id="acces" name="acces">
                <?php foreach ($listeAcces as $acces) : ?>
                    <option value="<?= $acces['idAccees'] ?>"><?= htmlspecialchars($acces['libelle']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Ajouter l'utilisateur</button>
        </form>
        <?php if (isset($_SESSION['alerte'])): ?>
            <script type="text/javascript">
                alert("<?php echo $_SESSION['alerte']; ?>");
                <?php unset($_SESSION['alerte']); ?>
            </script>
        <?php endif; ?>
    </div>