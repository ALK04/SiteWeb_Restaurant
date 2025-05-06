<!-- views/modales/reservationModal.php -->
<div id="reservationModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Réservation</h2>
        <form method="post" action="controllers/reservationM.php" class="reservation-form">
            <div class="form-row">
                <label for="nom">NOM :</label>
                <input type="text" id="nom" name="nom_client" required>
            </div>
            <div class="form-row">
                <label for="horaire">HORAIRE :</label>
                <input type="time" id="horaire" name="horaire" required>
            </div>
            <div class="form-row">
                <label for="date">DATE :</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-row">
                <label for="telephone">TÉLÉPHONE :</label>
                <input type="tel" id="telephone" name="telephone" required>
            </div>
            <div class="form-row">
                <label for="id_table">N° TABLE :</label>
                <input type="number" id="id_table" name="id_table" required>
            </div>
            <div class="form-row">
                <label for="nombre_personne">NOMBRE DE PERSONNE :</label>
                <input type="number" id="nombre_personne" name="nombre_personne" required>
            </div>
            <div class="form-submit">
                <button type="submit" class="submit-button">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('reservationModal').style.display = 'block';
    }
    function closeModal() {
        document.getElementById('reservationModal').style.display = 'none';
    }
</script>

