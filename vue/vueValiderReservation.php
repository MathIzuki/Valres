<!-- vueValiderReservation.php -->
<div class="page-validation-reservations">
    <h1>Validation des réservations</h1>

    <form action="index.php?action=ValidationReservation" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>Numéro de réservation</th>
                    <th>Période</th>
                    <th>Date</th>
                    <th>Structure</th>
                    <th>État</th>
                    <th>Salle</th>
                    <th>Confirmer</th>
                    <th>Annuler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listeReservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['NuméroReservation']) ?></td>
                        <td><?= htmlspecialchars($reservation['Période']) ?></td>
                        <td><?= htmlspecialchars($reservation['DateReservation']) ?></td>
                        <td><?= htmlspecialchars($reservation['NomStructure']) ?></td>
                        <td><?= htmlspecialchars($reservation['Etat']) ?></td>
                        <td><?= htmlspecialchars($reservation['Salle']) ?></td>
                        <td><input type="checkbox" name="confirm_<?= $reservation['NuméroReservation'] ?>"></td>
                        <td><input type="checkbox" name="cancel_<?= $reservation['NuméroReservation'] ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <input type="submit" value="Enregistrer">
    </form>
</div>