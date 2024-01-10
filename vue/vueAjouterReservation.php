<div class="form-ajout-reservation">
    <h1>Ajouter une nouvelle réservation</h1>

    <form method="post" action="index.php?action=AjouterReservation">
        <label for="date">Date de la réservation:</label>
        <input type="date" id="date" name="date" required>

        <label for="periode">Période:</label>
        <select id="periode" name="periode">
            <?php foreach ($listePeriode as $periode) : ?>
                <option value="<?= $periode['idPeriode'] ?>"><?= htmlspecialchars($periode['libelle']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="utilisateur">Personne :</label>
        <select id="utilisateur" name="utilisateur">
            <?php foreach ($listeUtilisateur as $utilisateur) : ?>
                <option value="<?= $utilisateur['idUtilisateur'] ?>"><?= htmlspecialchars($utilisateur['nom']) . ' ' . htmlspecialchars($utilisateur['prenom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="salle">Nom de la salle :</label>
        <select id="salle" name="salle">
            <?php foreach ($listeSalle as $salle) : ?>
                <option value="<?= $salle['idSalle'] ?>"><?= htmlspecialchars($salle['salle_nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Ajouter la réservation</button>
    </form>
    <?php if (isset($_SESSION['alerte'])): ?>
        <script type="text/javascript">
            alert("<?php echo $_SESSION['alerte']; ?>");
            <?php unset($_SESSION['alerte']); ?>
        </script>
    <?php endif; ?>
    
</div>