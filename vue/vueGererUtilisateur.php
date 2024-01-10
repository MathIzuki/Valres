<div class="page-gerer-utilisateur">
<form action="index.php?action=GererUtilisateur" method="post">
        <?php foreach ($listeUtilisateurs as $utilisateur): ?>
            <div class="utilisateur">
                <span><?= htmlspecialchars($utilisateur['nom']) . " " . htmlspecialchars($utilisateur['prenom']) ?></span>
                <div class="boutonsaction">
                    <select name="type_acces[<?= $utilisateur['idUtilisateur'] ?>]">
                        <?php foreach ($listeTypesAcces as $typeAcces): ?>
                            <option value="<?= $typeAcces['idAccees'] ?>" <?= $typeAcces['idAccees'] == $utilisateur['idAccees'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($typeAcces['libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Bouton de suppression -->
                    <button type="submit" name="supprimer" value="<?= $utilisateur['idUtilisateur'] ?>">Supprimer</button>
                </div>
                
            </div>
        <?php endforeach; ?>
        <input type="submit" name="enregistrer" value="Enregistrer">
    </form>
    <?php if (isset($_SESSION['alerte'])): ?>
    <script type="text/javascript">
        alert("<?php echo $_SESSION['alerte']; ?>");
        <?php unset($_SESSION['alerte']); ?>
    </script>
<?php endif; ?>

</div>