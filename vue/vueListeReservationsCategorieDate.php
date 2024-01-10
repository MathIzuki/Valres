<div class="page-reservations-liste">
<h1>Liste des réservations</h1>

<form method="post" action="">
    <label for="date">Sélectionner une date :</label>
    <input type="date" id="date" name="date" value="<?= isset($date) ? htmlspecialchars($date) : '' ?>">

    <label for="categorie">Sélectionner une catégorie :</label>
    <select id="categorie" name="categorie">
        <option value="1" <?= ($categorie == "1") ? "selected" : "" ?>>Salle de réunion</option>
        <option value="2" <?= ($categorie == "2") ? "selected" : "" ?>>Salle avec équipements</option>
        <option value="3" <?= ($categorie == "3") ? "selected" : "" ?>>Amphithéâtre</option>
    </select>

    <button type="submit">Filtrer</button>
</form>

<?php if (empty($listeReservations)) { ?>
    <p>Il n'y a aucune réservation à cette date avec cette catégorie.</p>
<?php } else { ?>
    <table border="1">
        <thead>
            <tr>
                <th>Période</th>
                <th>Nom de la structure</th>
                <th>Salle</th>
                <th>Capacité</th>
                <th>État</th>
                <th>Créateur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listeReservations as $reservation) { ?>
                <tr>
                    <td><?= $reservation['Période'] ?></td>
                    <td><?= $reservation['NomStructure'] ?></td>
                    <td><?= $reservation['Salle'] ?></td>
                    <td><?= $reservation['Capacite']?> personnes</td>
                    <td><?= $reservation['Etat'] ?></td>
                    <td><?= $reservation['Createur'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
</div>