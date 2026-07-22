<div class="modal fade" id="delete-customer-{{ $customer->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="modal-title text-danger">
                    <i class="fa-solid fa-circle-exclamation"></i> Delete Customer
                </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this customer?</p>
                <p class="mb-0 text-muted">
                    {{ $customer->name }} ({{ $customer->email }})
                </p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
