<template>
   <section class="content">
     <div class="container-fluid">
         <div class="row">
 
           <div class="col-12">
         
             <div class="card" v-if="$gate.isAdmin()">
               <div class="card-header">
                 <h3 class="card-title">Book List</h3>
 
                 <div class="card-tools">
                   
                   <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                       <i class="fa fa-plus-square"></i>
                       Add New
                   </button>
                 </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body table-responsive p-0">
                 <table class="table table-hover">
                   <thead>
                     <tr>
                       <th>ID</th>
                       <th>Title</th>
                       <th>Author</th>
                       <th>Genre</th>
                       <th>Image</th>
                       <th>Published</th>
                       <th>Publisher</th>
                       <th>Action</th>
                     </tr>
                   </thead>
                   <tbody>
                      <tr v-for="book in books.data" :key="book.id">
 
                       <td>{{book.id}}</td>
                       <td class="text-capitalize">{{book.title}}</td>
                       <td>{{book.author}}</td>
                       <td>{{book.genre}}</td>
                       <td><img v-bind:src="'/bookImage/' + book.image" width="60" alt="book"></td>
                       <td>{{book.published}}</td>
                       <td>{{book.publisher}}</td>
                       <td>
 
                         <a href="#" @click="editModal(book)">
                             <i class="fa fa-edit blue"></i>
                         </a>
                         /
                         <a href="#" @click="deleteBook(book.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                       </td>
                     </tr>
                   </tbody>
                 </table>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">
                   <pagination :data="books" @pagination-change-page="getResults"></pagination>
               </div>
             </div>
             <!-- /.card -->
           </div>
         </div>
 
 
         <div v-if="!$gate.isAdmin()">
             <not-found></not-found>
         </div>
 
         <!-- Modal -->
         <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" v-show="!editmode">Create New Book</h5>
                     <h5 class="modal-title" v-show="editmode">Update Book</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
 
                 <!-- <form @submit.prevent="createUser"> -->
 
                 <form @submit.prevent="editmode ? updateBook() : createBook()">
                     <div class="modal-body">
                         <div class="form-group">
                             <label>Title</label>
                             <input v-model="form.title" type="text" name="title"
                                 class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                             <has-error :form="form" field="title"></has-error>
                         </div>
                         <div class="form-group">
                             <label>Author</label>
                             <input v-model="form.author" type="text" name="author"
                                 class="form-control" :class="{ 'is-invalid': form.errors.has('author') }">
                             <has-error :form="form" field="author"></has-error>
                         </div>

                         <div class="form-group">
                             <label>Genre</label>
                             <input v-model="form.genre" type="text" name="genre"
                                 class="form-control" :class="{ 'is-invalid': form.errors.has('genre') }">
                             <has-error :form="form" field="genre"></has-error>
                         </div>

                         <div class="form-group">
                             <label>Description</label>
                            <textarea v-model="form.description" name="description"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }" placeholder="Enter Description..." rows="2" max-rows="1">
                            </textarea> <has-error :form="form" field="description"></has-error>
                         </div>

                         <div class="form-group">
                             <label>ISBN</label>
                             <input v-model="form.isbn" type="text" name="isbn"
                                 class="form-control" :class="{ 'is-invalid': form.errors.has('isbn') }">
                             <has-error :form="form" field="isbn"></has-error>
                         </div>

                         <div class="form-group">
                             <label>Published</label>
                             <input v-model="form.published" type="date" name="published"
                                 class="form-control" :class="{ 'is-invalid': form.errors.has('published') }">
                             <has-error :form="form" field="published"></has-error>
                         </div>

                         <div class="form-group">
                             <label>Publisher</label>
                             <input v-model="form.publisher" type="text" name="publisher"
                                 class="form-control" :class="{ 'is-invalid': form.errors.has('publisher') }">
                             <has-error :form="form" field="publisher"></has-error>
                         </div>

                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                         <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                     </div>
                   </form>
                 </div>
             </div>
         </div>
     </div>
   </section>
 </template>
 
 <script>
     export default {
         data () {
             return {
                 editmode: false,
                 books : {},
                 form: new Form({
                    id : '',
                    title : '',
                    author: '',
                    genre: '',
                    description: '',
                    isbn:  '',
                    image: '',
                    published: '',
                    publisher: '',
                 })
             }
         },
         methods: {
 
             getResults(page = 1) {
 
                   this.$Progress.start();
                   
                   axios.get('/api/book?page=' + page).then(({ data }) => (this.books = data.data));
 
                   this.$Progress.finish();
             },
             updateBook(){
                 this.$Progress.start();
                 this.form.put('/api/book/'+this.form.id)
                 .then((response) => {
                     // success
                     $('#addNew').modal('hide');
                     Toast.fire({
                       icon: 'success',
                       title: response.data.message
                     });
                     this.$Progress.finish();
                         //  Fire.$emit('AfterCreate');
 
                     this.loadBooks();
                 })
                 .catch(() => {
                     this.$Progress.fail();
                 });
 
             },
             
             deleteBook(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/book/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadBooks();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
            },

            editModal(book){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(book);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            loadBooks(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/book").then(({ data }) => (this.books = data.data));
                }
            },
            
            createBook(){

                this.form.post('/api/book')
                .then((response)=>{
                    $('#addNew').modal('hide');

                    Toast.fire({
                            icon: 'success',
                            title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadBooks();
                })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadBooks();
            this.$Progress.finish();
        }
     }
 </script>
 