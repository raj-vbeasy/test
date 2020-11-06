<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>
		<b-row>
			<b-col>
				<b-card>
					<b-card-body>
						<b-form ref="updatePerformanceLocation" @submit.prevent="updatePerformanceLocation">
							<b-row>
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
							</b-row>

							<b-row>
								<b-col>
									<b-form-group
											id="location-group"
											label="Location"
											label-for="location"
									>
										<b-form-input
												id="location"
												v-model.trim="form.location"
												placeholder="Please enter location"
												:class="{ 'is-invalid': submitted && $v.form.location.$error }"></b-form-input>
										<b-form-invalid-feedback v-if="submitted && $v.form.location.$error">
											<span v-if="!$v.form.location.required">Location is required.</span>
										</b-form-invalid-feedback>
									</b-form-group>
								</b-col>
							</b-row>

							<b-row>
								<b-col md="6">
									<b-form-group
											id="tax-rate-group"
											label="Tax Rate"
											label-for="tax_rate"
									>
										<b-form-input
												id="tax_rate"
												v-model.trim="form.tax_rate"
												placeholder="Please enter tax rate"
												:class="{ 'is-invalid': submitted && $v.form.tax_rate.$error }"></b-form-input>
										<b-form-invalid-feedback v-if="submitted && $v.form.tax_rate.$error">
											<span v-if="!$v.form.tax_rate.numeric">Tax Rate should be numeric.</span>
										</b-form-invalid-feedback>
									</b-form-group>
								</b-col>
								<b-col md="6">
									<b-form-group
											id="facility-fee-group"
											label="Facility Fee"
											label-for="facility_fee"
									>
										<b-form-input
												id="facility_fee"
												v-model.trim="form.facility_fee"
												placeholder="Please enter facility fee"
												:class="{ 'is-invalid': submitted && $v.form.facility_fee.$error }"></b-form-input>
										<b-form-invalid-feedback v-if="submitted && $v.form.facility_fee.$error">
											<span v-if="!$v.form.facility_fee.numeric">Facility fee should be numeric.</span>
										</b-form-invalid-feedback>
									</b-form-group>
								</b-col>
							</b-row>

							<b-row>
								<b-col md="6">
									<b-form-group
											id="timezone-group"
											label="Timezone"
											label-for="timezone"
									>
										<multiselect
												id="timezone"
												v-model.trim="form.timezone"
												:options="timezones"
												:class="{ 'is-invalid': submitted && $v.form.timezone.$error }"
												label="label"
												track-by="value"></multiselect>
										<b-form-invalid-feedback v-if="submitted && $v.form.timezone.$error">
											<span v-if="!$v.form.timezone.required">Timezone is required.</span>
										</b-form-invalid-feedback>
									</b-form-group>
								</b-col>
								<b-col md="6">
									<b-form-group
											id="currency-group"
											label="Currency"
											label-for="currency"
									>
										<multiselect
												id="currency"
												v-model.trim="form.currency"
												:options="currencies"
												:class="{ 'is-invalid': submitted && $v.form.currency.$error }"
												label="label"
												track-by="value"></multiselect>
										<b-form-invalid-feedback v-if="submitted && $v.form.currency.$error">
											<span v-if="!$v.form.currency.required">Currency is required.</span>
										</b-form-invalid-feedback>
									</b-form-group>
								</b-col>
							</b-row>

							<b-row>
								<b-col md="6">
									<b-form-group
											id="event-template-group"
											label="Default Event Template"
											label-for="event_template"
									>
										<multiselect
												id="event_template"
												v-model.trim="form.event_template"
												:options="eventTemplates"
												label="label"
												track-by="value"></multiselect>
									</b-form-group>
								</b-col>
								<b-col md="6">
									<b-form-group
											id="logo-group"
											label="Logo"
											label-for="logo"
									>
										<multiselect
												id="logo"
												v-model.trim="form.logo"
												:options="logos"
												label="label"
												track-by="value"></multiselect>
									</b-form-group>
								</b-col>
							</b-row>

							<b-row>
								<b-col>
									<b-button variant="outline-secondary float-right ml-2" :to="{name: 'performance-locations'}">Cancel</b-button>
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
    import { required, numeric, decimal } from 'vuelidate/lib/validators';

    export default {
        page: {
            title: "Edit Performance Location",
            meta: [{ name: "description", content: appConfig.description }]
        },
        components: { Layout, PageHeader, Multiselect },
        validations: {
            form: {
                name: {
                    required
                },
                capacity: {
                    numeric
                },
                location: {
                    required
                },
                tax_rate: {
                    decimal
                },
                facility_fee: {
                    decimal
                },
                timezone: {
                    required
                },
                currency: {
                    required
                }
            }
        },
        data () {
            return {
                submitted: false,
                title: 'Edit Performance Location',
                items: [
                    {
                        text: "Dashboard",
                        href: "/"
                    },
                    {
                        text: "Performance Locations",
                        href: "performance-locations"
                    },
                    {
                        text: "Edit",
                        active: true
                    }
                ],
                timezones: [],
                currencies: [],
                eventTemplates: [],
                logos: [],
                form: {
                    name: '',
                    capacity: '',
                    location: '',
                    tax_rate: '',
                    facility_fee: '',
                    timezone: null,
                    currency: null,
                    event_template: null,
                    logo: null
                }
            }
        },
        methods: {
            updatePerformanceLocation() {
                this.submitted = true;
                this.$v.$touch();

                if (this.$v.$invalid === false) {
                    const loader = this.$loading.show();
                    let formData = new FormData();
                    formData.append('_method', 'PUT');
                    for (let key in this.form) {
                        if (this.form[key]) {
                            if (['timezone', 'currency', 'event_template', 'logo'].includes(key)) {
                                let tempKey = key;
                                if (key === 'timezone') {
                                    tempKey = 'timezone_id';
                                }
                                formData.append(tempKey, this.form[key].value);
                            } else {
                                formData.append(key, this.form[key]);
                            }
                        }
                    }

                    this.$http.post('performance-locations/' + this.$route.params.id, formData)
                        .then(response => {
                            this.$refs.updatePerformanceLocation.reset();
                            this.$toastr.fire({
                                toast: true,
                                icon: 'success',
                                title: response.data.message
                            });
                            this.submitted = false;
                            this.$router.push({name: 'performance-locations'}).catch(error => {});
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
            let editUrl = 'performance-locations/' + this.$route.params.id +'/edit';
            this.$http.get(editUrl)
	            .then(response => {
	                let data = response.data.data;
                    this.form.name = data.performance_location.name;
                    this.form.capacity = data.performance_location.capacity;
                    this.form.location = data.performance_location.location;
                    this.form.tax_rate = data.performance_location.tax_rate;
                    this.form.facility_fee = data.performance_location.facility_fee;

                    for (let i = 0; i < data.timezones.length; i++) {
                        this.timezones.push(data.timezones[i]);
                        if (data.timezones[i].value === data.performance_location.timezone_id) {
                            this.form.timezone = data.timezones[i];
                        }
                    }
                    for (let i = 0; i < data.currencies.length; i++) {
                        this.currencies.push(data.currencies[i]);
                        this.form.currency = data.currencies[i];
                    }
                    for (let i = 0; i < data.event_templates.length; i++) {
                        this.eventTemplates.push(data.event_templates[i]);
                        this.form.event_template = data.event_templates[i];
                    }
                    for (let i = 0; i < data.logos.length; i++) {
                        this.logos.push(data.logos[i]);
                        this.form.logo = data.logos[i];
                    }
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
</script>

<style scoped>
	.is-invalid >>> .multiselect__tags {
		border-color: #f46a6a !important;
	}
</style>
