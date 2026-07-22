<div class="modal fade" id="delete-customer-{{ $customer->id }}"
    tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            {{-- ×ボタン --}}
            <div class="modal-header border-0 pb-0">
                <button type="button"
                    class="btn-close ms-auto"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body text-center px-5 pt-0 pb-5">

                {{-- ゴミ箱アイコン --}}
                <div class="d-inline-flex justify-content-center align-items-center
                            bg-danger-subtle text-danger rounded-circle p-4 mb-3">
                    <i class="fa-solid fa-trash-can display-4 fw-bolder"></i>
                </div>

                {{-- タイトル --}}
                <h3 class="fs-4 fw-semibold text-dark mb-2">
                    Delete this customer?
                </h3>

                {{-- 説明 --}}
                <p class="text-muted mb-1">
                    You're about to permanently delete
                    {{ $customer->name }}  ({{ $customer->email }})
                </p>

                <p class="text-danger fw-semibold small mb-4">
                    This action cannot be undone.
                </p>

                {{-- 削除フォーム --}}
                <form action="{{ route('admin.customers.destroy', $customer->id) }}"
                    method="post">

                    @csrf
                    @method('DELETE')

                    <div class="d-flex justify-content-center gap-4">

                        <button type="button"
                            class="btn btn-light border px-4 py-2"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                            class="btn btn-danger px-4 py-2">
                            Delete Customer
                        </button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
