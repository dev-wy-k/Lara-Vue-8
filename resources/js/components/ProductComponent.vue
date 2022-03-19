<template>
  <div class="container my-5">
    <!-- Search  -->
    <div class="row mb-3">
      <div class="col-12">
        <div class="row justify-content-between">
          <div class="col-4"></div>
          <div class="col-3">
            <button class="btn btn-primary" @click="create">
              <i class="fas fa-plus-circle me-1"></i>
              Create
            </button>
          </div>
          <div class="col-2"></div>
          <div class="col-3">
            <form @submit.prevent="view">
              <div class="input-group">
                <input
                  v-model="search"
                  type="text"
                  class="form-control"
                  placeholder="Search"
                />
                <button type="submit" class="input-group-text btn btn-primary">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Search End  -->

    <div class="row">
      <!-- Form  -->
      <div class="col-12 col-md-4">
        <div class="card">
          <h4 class="card-header">{{ isEditMode ? "Edit" : "Create" }}</h4>
          <div class="card-body">
            <form @submit.prevent="isEditMode ? update() : store()">
              <AlertError :form="product" :message="message" ></AlertError>
              <div class="mb-3">
                <label class="form-label">Name :</label>
                <input
                  v-model="product.name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid' : product.errors.has('name') }"
                />
                <HasError :form="product" field="name" ></HasError>
              </div>

              <div class="mb-3">
                <label class="form-label">Price :</label>
                <input
                  v-model="product.price"
                  type="number"
                  class="form-control"
                  :class="{ 'is-invalid' : product.errors.has('price') }"
                />
                <HasError :form="product" field="price" ></HasError>
              </div>

              <button class="btn btn-primary" type="submit">
                <i class="fas fa-save me-1"></i>
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Form End  -->

      <!-- Table  -->
      <div class="col-12 col-md-8">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="product in products.data" :key="product.id">
              <td>{{ product.id }}</td>
              <td>{{ product.name }}</td>
              <td>{{ product.price }}</td>
              <td>
                <button class="btn btn-success btn-sm text-white" @click="edit(product)">
                  <i class="fas fa-edit me-1"></i> Edit
                </button>
                <button
                  class="btn btn-danger btn-sm"
                  @click="destroy(product.id)"
                >
                  <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <pagination
          :data="products"
          @pagination-change-page="view"
        ></pagination>
      </div>
      <!-- Table End -->
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductComponent",
  data() {
    return {
      isEditMode: false,
      message: "",
      search: "",
      products: {},
      product: new Form({
        id: "",
        name: "",
        price: "",
      }),
    };
  },
  methods: {
    view(page = 1) {
      this.$Progress.start();
      let loader = this.$loading.show();
      
      axios
        .get(`/api/product?page=${page}&search=${this.search}`)
        .then((result) => {
          this.products = result.data;  
          this.$Progress.finish();
          loader.hide();
        })
        .catch((err) => {
          this.$Progress.fail();
        });
    },

    store() {
      this.product.post("/api/product")
        .then((result) => {
          this.view();
          this.product.reset();
          Toast.fire({
            icon: 'success',
            title: 'Created successfully'
          })
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
    },

    create() {
        this.product.clear();
        this.isEditMode = false;
        this.product.reset();
    },

    edit(product) {
        this.product.clear();
        this.isEditMode = true ;
        this.product.fill(product);
    },

    update() {
      this.product.put(`/api/product/${this.product.id}`)
        .then((result) => {
          this.view();
          this.product.reset();
          this.isEditMode = false;
          Toast.fire({
            icon: 'success',
            title: 'Updated successfully'
          })
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
    },

    destroy(id) {

      Swal.fire({
        title: 'Are you sure ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it !'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({ icon : 'success' , title : 'Deleted !' });
          axios.delete(`/api/product/${id}`)
          .then((result) => {
            this.view();
          });
          Toast.fire({
            icon: 'success',
            title: 'Deleted successfully'
          })
        }
      });      
      
    },
  },

  created() {
    this.view();
  },
};
</script>