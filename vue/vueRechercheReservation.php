<div class="page-reservations-structure">
<h1>Liste des réservations pour la structure : <?= htmlspecialchars($structure) ?></h1>

<form method="post" action="">
    <label for="structure">Saisir le nom de la structure :</label>
    <input type="text" id="structure" name="structure" value="<?= htmlspecialchars($structure) ?>">

    <button type="submit">Rechercher</button>
</form>

<?php if (!empty($listeReservations)) { ?>
    <table border="1">
        <thead>
            <tr>
                <th>Période</th>
                <th>Date de réservation</th>
                <th>État</th>
                <th>Structure</th>
                <th>Capacité</th>
                <th>Salle</th>
                <th>Créateur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listeReservations as $reservation) { ?>
                <tr>
                    <td><?= $reservation['Période'] ?></td>
                    <td><?= $reservation['DateReservation'] ?></td>
                    <td><?= $reservation['Etat'] ?></td>
                    <td><?= $reservation['NomStructure'] ?></td>
                    <td><?= $reservation['Capacite'] ?> personnes</td>
                    <td><?= $reservation['Salle'] ?></td>
                    <td><?= $reservation['Createur'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>Veuillez entrer le nom de la structure.</p>
<?php } ?>
</div>