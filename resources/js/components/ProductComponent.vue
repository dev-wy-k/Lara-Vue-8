<template>
  <div class="container my-5">
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
            <form>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" />
                <button type="submit" class="input-group-text btn btn-primary">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-md-4">
        <div class="card">
          <h4 class="card-header">{{ isEditMode ? 'Edit' : 'Create'}}</h4>
          <div class="card-body">
            <form @submit.prevent=" isEditMode ? update() : store() ">
              <div class="mb-3">
                <label class="form-label">Name :</label>
                <input
                  v-model="product.name"
                  type="text"
                  class="form-control"
                />
              </div>

              <div class="mb-3">
                <label class="form-label">Price :</label>
                <input
                  v-model="product.price"
                  type="number"
                  class="form-control"
                />
              </div>

              <button class="btn btn-primary" type="submit">
                <i class="fas fa-save me-1"></i>
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-8">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="product in products" :key="product.id">
              <td>{{ product.id }}</td>
              <td>{{ product.name }}</td>
              <td>{{ product.price }}</td>
              <td>
                <button class="btn btn-success btn-sm" @click="edit(product)">
                  <i class="fas fa-edit me-1"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm" @click="destroy(product.id)">
                  <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductComponent",
  data() {
    return {
        isEditMode : false ,
        products: [],
        product: {
            id : "",
            name: "",
            price: "",
      },
    };
  },
  methods: {
    view() {
      axios
        .get("/api/product")
        .then((result) => {
          this.products = result.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    store() {
      axios
        .post("/api/product", this.product)
        .then((result) => {
          this.view();
          this.product = {
            id : "",
            name: "",
            price: "",
          };
        })
        .catch((err) => {
          console.log(err);
        });
    },

    create() {
        this.isEditMode = false ,
        this.product.id  = "",
        this.product.name = "",
        this.product.price = ""
    },

    edit(product) {
        this.isEditMode = true ,
        this.product.id  = product.id,
        this.product.name = product.name,
        this.product.price = product.price
     
    },

    update() {
        axios
        .put(`/api/product/${this.product.id}`, this.product)
        .then((result) => {
          this.view();
          this.product = {
            name: "",
            price: "",
          };
          this.isEditMode = false ;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    destroy(id) {

      if( ! confirm('Are you sure to delete ?')){
          return ;
      }  
      axios.delete(`/api/product/${id}`)
      .then((result) => {
          this.view();
      }).catch((err) => {
            
      });
    },

  },  

  created() {
    this.view();
  },
};
</script>