<div id="confirmationModal" class="confirmation-modal" style="display: none">
    <div class="modal-background"></div>
    <div class="modal-card text-center">
        <p id="message" ></p><br>
        <div class="modal-card-actions">
            <button onclick="document.getElementById('confirmationModal').style.display = 'none';" type="button" class="btn btn-info">{{ __('buttons.cancel') }}</button>&nbsp;&nbsp;&nbsp;
            <button id="button" type="button" class="btn btn-info"></button>
        </div>
    </div>
</div>