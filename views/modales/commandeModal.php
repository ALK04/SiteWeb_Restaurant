<div id="commandeModal" class="modal" style="display:none;">
    <div class="modal-content-commande">
        <span class="close" id="closeModal">&times;</span>
        <h2 class="commande-title">Table N ° <span id="tableNum"></span></h2>
        <div id="commandeDetails" class="commande-details">Chargement...</div>
        <div class="commande-submit">
            <button id="payerBtn" class="submit-button">C’est payé</button>
        </div>
    </div>
</div>



<!--<div id="reserveeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" id="closeReserveeModal">&times;</span>
        <h1>Page Réservée</h1>
    </div>
</div>
-->

<div id="reserveeModal" class="modal" style="display:none;">
    <div class="modal-content-reservation">
        <span class="close" id="closeReserveeModal">&times;</span>
        <h1 class="reservation-title">Réservation</h1>

        <form id="reservationForm" class="reservation-form">
            <div class="form-row">
                <label>Nom :</label>
                <input type="text" id="resNom">
            </div>
            <div class="form-row">
                <label>Téléphone :</label>
                <input type="text" id="resTel">
            </div>
            <div class="form-row">
                <label>Date :</label>
                <input type="text" id="resDate" disabled>
            </div>
            <div class="form-row">
                <label>Horaire :</label>
                <input type="text" id="resHoraire">
            </div>
            <div class="form-row">
                <label>Nb personnes :</label>
                <input type="number" id="resNb">
            </div>

            <div class="reservation-submit">
                <button type="button" id="supprimerBtn" class="delete-button">Supprimer la réservation</button>
                <button type="submit" class="submit-button">OK</button>
            </div>
        </form>

        <hr class="reservation-separator">

        <h3>Autre réservation</h3>
        <div id="autresReservations" class="other-reservations"></div>
    </div>
</div>
