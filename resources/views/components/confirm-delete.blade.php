
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-3 border-0">
      <div class="modal-header bg-danger text-white rounded-top">
        <h5 class="modal-title d-flex align-items-center gap-2" id="confirmDeleteLabel">
          <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <p class="mb-0 fs-6">
          Data akan <span class="fw-bold text-danger">dihapus secara permanen</span>. <br>
          Apakah Anda yakin ingin melanjutkan tindakan ini?
        </p>
      </div>

      <!-- Footer -->
      <div class="modal-footer d-flex justify-content-center gap-2 border-0 pb-4">
        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
          Batal
        </button>
        <form action="{{ route('clear-data') }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger px-4">
            <i class="fas fa-trash-alt me-1"></i> Ya, Hapus
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
