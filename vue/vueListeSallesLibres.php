<div class="page-salle-libre">
    <h1>Liste des salles libres par période</h1>

    <form method="post" action="">
        <label for="date">Sélectionner une date :</label>
        <input type="date" id="date" name="date" value="<?= isset($date) ? htmlspecialchars($date) : '' ?>">

        <label for="categorie">Sélectionner une catégorie :</label>
        <select id="categorie" name="categorie">
            <!-- Options de catégories -->
            <option value="1" <?= ($categorie == "1") ? "selected" : "" ?>>Salle de réunion</option>
            <option value="2" <?= ($categorie == "2") ? "selected" : "" ?>>Salle avec équipements</option>
            <option value="3" <?= ($categorie == "3") ? "selected" : "" ?>>Amphithéâtre</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <?php if (!empty($disponibilites) && is_array($disponibilites)) { ?>
    <table border="1">
        <thead>
            <tr>
                <th>Période / Salle</th>
                <?php // Assurez-vous que la première clé de $disponibilites existe
                if (!empty($disponibilites) && is_array(current($disponibilites))) {
                    foreach (current($disponibilites) as $nomSalle => $dispo) {
                        echo "<th>" . htmlspecialchars($nomSalle) . "</th>";
                    }
                } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disponibilites as $periode => $salles) { ?>
                <tr>
                    <td><?= htmlspecialchars($periode) ?></td>
                    <?php foreach ($salles as $nomSalle => $dispo) { ?>
                        <td><?= htmlspecialchars($dispo) ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>Aucune salle libre n'a été trouvée pour cette date et catégorie.</p>
<?php } ?>
</div>