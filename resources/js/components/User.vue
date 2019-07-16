<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModel()">Create New User</button>
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
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Registered Date</th>
                  <th>User Type</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.first_name }}</td>
                  <td>{{ user.last_name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.created_at }}</td>
                  <td>{{ user.type }}</td>
                  <td>
                    <a href="#" @click="editModel(user)">
                      <li class="fa fa-edit"></li>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
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
    <!-- Create User Model -->
    <div
      class="modal fade"
      id="adduser"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!isEdite" class="modal-title" id="adduserLabel">Add New User</h5>
            <h5 v-show="isEdite" class="modal-title" id="adduserLabel">Update Users</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="isEdite ? updateUser() : adduser()">
            <div class="modal-body">
              <div class="form-group">
                <label>First Name</label>
                <input
                  v-model="form.first_name"
                  type="text"
                  name="first_name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('first_name') }"
                />
                <has-error :form="form" field="first_name"></has-error>
              </div>

              <div class="form-group">
                <label>Last Name</label>
                <input
                  v-model="form.last_name"
                  type="text"
                  name="last_name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('last_name') }"
                />
                <has-error :form="form" field="last_name"></has-error>
              </div>

              <div class="form-group">
                <label>Email Address</label>
                <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <label>Select User Type</label>
                <select
                  v-model="form.type"
                  name="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <label>Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
              <div class="form-group">
                <label>Confirme Password</label>
                <input
                  v-model="form.password_confirmation"
                  type="password"
                  name="password_confirmation"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="!isEdite" type="submit" class="btn btn-primary">Save User</button>
              <button v-show="isEdite" type="submit" class="btn btn-primary">Update User</button>
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
      users: {},
      form: new Form({
        id: "",
        first_name: "",
        last_name: "",
        password: "",
        email: "",
        type: "user",
        photo: "",
        password_confirmation: ""
      })
    };
  },
  methods: {
    newModel() {
      this.isEdite = false;
      this.form.reset();
      $("#adduser").modal("show");
    },
    editModel(userData) {
      this.isEdite = true;
      this.form.reset();
      $("#adduser").modal("show");
      this.form.fill(userData);
    },
    deleteUser(id) {
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
            .delete("api/user/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.getusers();
            })
            .catch(() => {
              Swal.fire("Faild!", "There Was Something Wrong", "warning");
            });
        }
      });
    },
    adduser() {
      this.form
        .post("api/user")
        .then(() => {
          $("#adduser").modal("hide");
          const Toast = Swal.fire({
            position: "top-end",
            type: "success",
            title: "New User has been Created",
            showConfirmButton: false,
            timer: 1500
          });
          this.created();
        })
        .catch();
    },
    getusers() {
      if (this.$gate.isAdmin()) {
        axios.get("api/user").then(({ data }) => (this.users = data.data));
      }
    },
    created() {
      this.getusers();
    },
    updateUser() {
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          $("#adduser").modal("hide");
          const Toast = Swal.fire({
            position: "top-end",
            type: "success",
            title: "User has been Updated",
            showConfirmButton: false,
            timer: 1500
          });
          this.created();
        })
        .catch(() => {});
    }
  },

  mounted() {
    this.getusers();
  }
};
</script>
