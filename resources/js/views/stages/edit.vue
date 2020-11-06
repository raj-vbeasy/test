<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>
		<b-row>
			<b-col>
				<b-card>
					<b-card-body>
						<b-form @submit.prevent="updateStage">
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
												track-by="value"></multiselect>
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
												:class="{ 'is-invalid': submitted && $v.form.name.$error }"></b-form-input>
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
												:class="{ 'is-invalid': submitted && $v.form.capacity.$error }"></b-form-input>
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
											<verte v-model="form.calendar_color" :model="'hex'" menuPosition="right"></verte>
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
												track-by="value"></multiselect>
										<b-form-invalid-feedback v-if="submitted && $v.form.status.$error">
											<span v-if="!$v.form.status.required">Status is required.</span>
										</b-form-invalid-feedback>
									</b-form-group>
								</b-col>
							</b-row>

							<b-row class="mb-5">
								<b-col>
									<b-button variant="outline-secondary float-right ml-2" :to="{name: 'stages'}">Cancel</b-button>
									<b-button variant="outline-info float-right" type="submit">Submit</b-button>
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
    import appConfig from '@/app.config.json';
    import Multiselect from 'vue-multiselect';
    import Layout from '@/views/layouts/main';
    import PageHeader from '@/components/page-header';
    import { required, numeric } from 'vuelidate/lib/validators';
    import Verte from 'verte';

    export default {
        page: {
            title: "Edit Stage",
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
                title: 'Edit Stage',
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
                        text: "Edit",
                        active: true
                    }
                ],
                performanceLocations: [],
                form: {
                    performance_location_id: '',
                    name: '',
                    capacity: 0,
                    calendar_color: '',
                    status: {
                        value: 0, label: 'In Active'
                    }
                }
            }
        },
        methods: {
            updateStage() {
                this.submitted = true;
                this.$v.$touch();

                if (this.$v.$invalid === false) {
                    const loader = this.$loading.show();
                    let formData = new FormData();
                    formData.append('_method', 'PUT');
                    for (let key in this.form) {
                        if (this.form[key]) {
                            if (['status', 'performance_location_id'].includes(key)) {
                                formData.append(key, this.form[key].value);
                            } else {
                                formData.append(key, this.form[key]);
                            }
                        }
                    }

                    this.$http.post('stages/' + this.$route.params.id, formData)
                        .then(response => {
                            this.form.performance_location_id = '';
                            this.form.name = '';
                            this.form.capacity = 0;
                            this.form.calendar_color = '';
                            this.form.status = {
                                value: 0, label: 'In Active'
                            };
                            this.$toastr.fire({
                                toast: true,
                                icon: 'success',
                                title: response.data.message
                            });
                            this.submitted = false;
                        })
                        .catch(error => {
                            this.$toastr.fire({
                                toast: true,
                                icon: 'error',
                                title: error.response.message
                            });
                        })
                        .then(() => {
                            loader.hide();
                        })
                }
            }
        },
        created() {
            const loader = this.$loading.show();
            this.$http.get('stages/' + this.$route.params.id + '/edit')
                .then(response => {
                    for (let i = 0; i < response.data.data.performance_locations.length; i++) {
                        this.performanceLocations.push(response.data.data.performance_locations[i]);
                    }
					this.form.performance_location_id = {
					    value: response.data.data.stage.performance_location.id,
						label: response.data.data.stage.performance_location.name
					};
					this.form.name = response.data.data.stage.name;
					this.form.capacity = response.data.data.stage.capacity;
					this.form.calendar_color = response.data.data.stage.calendar_color;
					let statusLabel = response.data.data.stage.status === 0 ? 'In Active' : 'Active';
					this.form.status = {
							value: response.data.data.stage.status, label: statusLabel
	                    };
                })
                .catch(error => {
                    console.log(error);
                    this.$toastr.fire({
                        toast: true,
                        icon: 'error',
                        title: error.response.message
                    });
                })
                .then(() => {
                    loader.hide();
                })
        }
    }
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