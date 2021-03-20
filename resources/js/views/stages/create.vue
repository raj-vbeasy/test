<template>
  <Layout>
    <PageHeader
      :title="title"
      :items="items"
    />
    <b-row>
      <b-col>
        <b-card>
          <b-card-body>
            <b-form @submit.prevent="createStage">
              <b-row>
                <b-col md="6">
                  <b-form-group
                    id="performance-location-group"
                    label="Performance Location"
                    label-for="performance-location"
                  >
                    <multiselect
                      id="performance-location"
                      v-model.trim="form.performance_location_id"
                      :options="performanceLocations"
                      :class="{ 'is-invalid': submitted && $v.form.performance_location_id.$error }"
                      label="label"
                      track-by="value"
                    />
                    <b-form-invalid-feedback v-if="submitted && $v.form.performance_location_id.$error">
                      <span v-if="!$v.form.performance_location_id.required">Performance Location is required.</span>
                    </b-form-invalid-feedback>
                  </b-form-group>
                </b-col>

                <b-col md="6">
                  <b-form-group
                    id="name-group"
                    label="Name"
                    label-for="name"
                  >
                    <b-form-input
                      id="name"
                      v-model.trim="form.name"
                      placeholder="Please enter name"
                      autofocus
                      :class="{ 'is-invalid': submitted && $v.form.name.$error }"
                    />
                    <b-form-invalid-feedback v-if="submitted && $v.form.name.$error">
                      <span v-if="!$v.form.name.required">Name is required.</span>
                    </b-form-invalid-feedback>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col md="6">
                  <b-form-group
                    id="capacity-group"
                    label="Capacity"
                    label-for="capacity"
                  >
                    <b-form-input
                      id="capacity"
                      v-model.trim="form.capacity"
                      placeholder="Please enter capacity"
                      :class="{ 'is-invalid': submitted && $v.form.capacity.$error }"
                    />
                    <b-form-invalid-feedback v-if="submitted && $v.form.capacity.$error">
                      <span v-if="!$v.form.capacity.required">Capacity is required.</span>
                    </b-form-invalid-feedback>
                  </b-form-group>
                </b-col>

                <b-col md="6">
                  <b-form-group
                    id="calendar-color-group"
                    label="Calendar Color"
                    label-for="calendar-color"
                  >
                    <div class="float-left">
                      <verte
                        v-model="form.calendar_color"
                        :model="'hex'"
                        menu-position="right"
                      />
                    </div>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col md="6">
                  <b-form-group
                    id="status-group"
                    label="Status"
                    label-for="status"
                  >
                    <multiselect
                      id="status"
                      v-model="form.status"
                      :options="[{value: 0, label: 'In Active'}, {value: 1, label: 'Active'}]"
                      :class="{ 'is-invalid': submitted && $v.form.status.$error }"
                      label="label"
                      track-by="value"
                    />
                    <b-form-invalid-feedback v-if="submitted && $v.form.status.$error">
                      <span v-if="!$v.form.status.required">Status is required.</span>
                    </b-form-invalid-feedback>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row class="mb-5">
                <b-col>
                  <b-button
                    variant="outline-secondary float-right ml-2"
                    :to="{name: 'stages'}"
                  >
                    Cancel
                  </b-button>
                  <b-button
                    variant="outline-info float-right"
                    type="submit"
                  >
                    Submit
                  </b-button>
                </b-col>
              </b-row>
            </b-form>
          </b-card-body>
        </b-card>
      </b-col>
    </b-row>
  </Layout>
</template>

<script>
import appConfig from "@/app.config.json";
import Multiselect from "vue-multiselect";
import Layout from "@/views/layouts/main";
import PageHeader from "@/components/page-header";
import { required, numeric } from "vuelidate/lib/validators";
import Verte from "verte";

export default {
  page: {
    title: "New Stage",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { Layout, PageHeader, Multiselect, Verte },
  validations: {
    form: {
      performance_location_id: {
        required
      },
      name: {
        required
      },
      capacity: {
        numeric
      },
      calendar_color: {
        required
      },
      status: {
        required
      }
    }
  },
  data () {
    return {
      submitted: false,
      title: "New Stage",
      items: [
        {
          text: "Dashboard",
          href: "/"
        },
        {
          text: "Stages",
          href: "stages"
        },
        {
          text: "New",
          active: true
        }
      ],
      performanceLocations: [],
      form: {
        event_id: "",
        performance_location_id: "",
        name: "",
        capacity: 0,
        calendar_color: "",
        status: {
          value: 0, label: "In Active"
        }
      }
    };
  },
  created() {
    const loader = this.$loading.show();
    let params = {};
    if (Object.prototype.hasOwnProperty.call(this.$route.query, "event_id")) {
      if ((this.$route.query.event_id !== "") && (this.$route.query.event_id !== null)) {
        params.event_id = this.$route.query.event_id;
        this.form.event_id = this.$route.query.event_id;
      }
    }
    this.$http.get("stages/create", {params: params})
      .then(response => {
        if (response.data.data.length > 0) {
          for (let i = 0; i < response.data.data.length; i++) {
            this.performanceLocations.push(response.data.data[i]);
          }
          if (response.data.data.length === 1) {
            this.form.performance_location_id = response.data.data[0];
          }
        } else {
          this.$toastr.fire({
            toast: true,
            icon: "error",
            title: response.data.message
          });
          this.$router.push({name: "create-performance-location"});
        }
      })
      .catch(error => {
        this.$toastr.fire({
          toast: true,
          icon: "error",
          title: error.response.message
        });
      })
      .then(() => {
        loader.hide();
      });
  },
  methods: {
    createStage() {
      this.submitted = true;
      this.$v.$touch();

      if (this.$v.$invalid === false) {
        const loader = this.$loading.show();
        let formData = new FormData();
        for (let key in this.form) {
          if (this.form[key]) {
            if (["status", "performance_location_id"].includes(key)) {
              formData.append(key, this.form[key].value);
            } else {
              formData.append(key, this.form[key]);
            }
          }
        }

        this.$http.post("stages", formData)
          .then(response => {
            this.form.performance_location_id = "";
            this.form.name = "";
            this.form.capacity = 0;
            this.form.calendar_color = "";
            this.form.status = {
              value: 0, label: "In Active"
            };
            this.$toastr.fire({
              toast: true,
              icon: "success",
              title: response.data.message
            });
            this.submitted = false;
          })
          .catch(error => {
            this.$toastr.fire({
              toast: true,
              icon: "error",
              title: error.response.message
            });
          })
          .then(() => {
            loader.hide();
          });
      }
    }
  }
};
</script>

<style scoped>
	@import "~verte/dist/verte.css";
	.is-invalid >>> .multiselect__tags {
		border-color: #f46a6a !important;
	}
	.card {
		height: auto;
	}
</style>