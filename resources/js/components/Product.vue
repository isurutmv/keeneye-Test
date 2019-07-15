<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Product Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModel()">Create New Product</button>
              <!-- <div class="input-group input-group-sm" style="width: 150px;">
                <input
                  type="text"
                  name="table_search"
                  class="form-control float-right"
                  placeholder="Search"
                />

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>Stock Status</th>
                  <th>Description</th>
                  <th>Crteated Date</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products" :key="product.id">
                  <td>{{ product.id }}</td>
                  <td>{{ product.product_name }}</td>
                  <td>{{ product.price }}</td>
                  <td>{{ product.status }}</td>
                  <td>{{ product.description }}</td>
                  <td>{{ product.created_at }}</td>
                  <td>
                    <a href="#" @click="editModel(product)">
                      <li class="fa fa-edit"></li>
                    </a>
                    /
                    <a href="#" @click="deleteProduct(product.id)">
                      <li class="fa fa-trash" style="color:red;"></li>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Create Product Model -->
    <div
      class="modal fade"
      id="addproduct"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!isEdite" class="modal-title" id="addProductLabel">Add New Product</h5>
            <h5 v-show="isEdite" class="modal-title" id="addProductLabel">Update Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="isEdite ? updateProduct() : addProduct()">
            <div class="modal-body">
              <div class="form-group">
                <label>Product Name</label>
                <input
                  v-model="form.product_name"
                  type="text"
                  name="product_name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('product_name') }"
                />
                <has-error :form="form" field="product_name"></has-error>
              </div>

              <div class="form-group">
                <label>Product Price</label>
                <input
                  v-model="form.price"
                  type="text"
                  name="price"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('price') }"
                />
                <has-error :form="form" field="price"></has-error>
              </div>

              <div class="form-group">
                <label>Product Description</label>
                <textarea
                  rows="4"
                  cols="50"
                  v-model="form.description"
                  name="description"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('description') }"
                ></textarea>
                <has-error :form="form" field="description"></has-error>
              </div>

              <div class="form-group">
                <label>Stock Avilability</label>
                <select
                  v-model="form.status"
                  name="status"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('status') }"
                >
                  <option value="Available">Available</option>
                  <option value="Out Of Stock">Out Of Stock</option>
                </select>
                <has-error :form="form" field="status"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="!isEdite" type="submit" class="btn btn-primary">Save Product</button>
              <button v-show="isEdite" type="submit" class="btn btn-primary">Update Product</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isEdite: false,
      products: {},
      form: new Form({
        id: "",
        product_name: "",
        price: "",
        description: "",
        status: "Available",
        photo: ""
      })
    };
  },
  methods: {
    newModel() {
      this.isEdite = false;
      this.form.reset();
      $("#addproduct").modal("show");
    },
    editModel(productData) {
      this.isEdite = true;
      this.form.reset();
      $("#addproduct").modal("show");
      this.form.fill(productData);
    },
    deleteProduct(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          this.form
            .delete("api/product/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.getProducts();
            })
            .catch(() => {
              Swal.fire("Faild!", "There Was Something Wrong", "warning");
            });
        }
      });
    },
    addProduct() {
      this.form
        .post("api/product")
        .then(() => {
          $("#addproduct").modal("hide");
          const Toast = Swal.fire({
            position: "top-end",
            type: "success",
            title: "New Product has been Created",
            showConfirmButton: false,
            timer: 1500
          });
          this.created();
        })
        .catch();
    },
    getProducts() {
      axios.get("api/product").then(({ data }) => (this.products = data.data));
    },
    created() {
      this.getProducts();
    },
    updateProduct() {
      this.form
        .put("api/product/" + this.form.id)
        .then(() => {
          $("#addproduct").modal("hide");
          const Toast = Swal.fire({
            position: "top-end",
            type: "success",
            title: "Product has been Updated",
            showConfirmButton: false,
            timer: 1500
          });
          this.created();
        })
        .catch(() => {});
    }
  },

  mounted() {
    this.getProducts();
  }
};
</script>
