   {{-- delete --}}
   <div class="modal fade" id="delete-category-{{ $category->id }}">
       <div class="modal-dialog">
           <div class="modal-content border-danger">
               <div class="modal-header border-danger">
                   <h3 class="h5 modal-title text-danger">
                       <i class="fa-solid fa-trash"></i> Delete Category
                   </h3>
               </div>
               <div class="modal-body">
                   Are you sure you want to delete
                   <span class="fw-bold">{{ $category->name }}</span>?
                   <p>This action will affect all the posts under this category.
                       Posts without a category will fall under Uncategorized.
                   </p>
               </div>

               <div class="modal-footer border-0">
                   <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                       @csrf
                       @method('DELETE')
                       <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                       <button type="submit" class="btn btn-danger">Delete
                       </button>
                   </form>
               </div>
           </div>
       </div>
   </div>
