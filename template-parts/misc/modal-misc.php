<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Edit Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="currentCardId">
                <div class="mb-1">
                    <label for="cardTitle" class="form-label">Data title</label>
                    <input type="text" class="form-control" id="cardTitle">
                </div>
                <div class="mb-1">
                    <label for="cardNumber" class="form-label">No. of TBs</label>
                    <input type="number" class="form-control" id="cardNumber" min="1" value="1">
                </div>
                <div class="mb-1">
                    <label for="calculatedCost" class="form-label">Card Cost</label>
                    <input type="text" class="form-control" id="calculatedCost" readonly>
                </div>
                <div class="mb-31">
                    <label for="providerSelect" class="form-label">Provider</label>
                    <select class="form-control" id="providerSelect">
                        <!-- Options will be dynamically added here -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveCardData()">Save</button>
            </div>
        </div>
    </div>
</div>