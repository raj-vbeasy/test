<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>
		<b-row>
			<b-col>
				<b-card>
					<b-card-body>
						<b-form ref="createArtist" @submit.prevent="createArtist">
							<form-wizard color="#556ee6">
								<tab-content icon="mdi mdi-account-circle">
									<b-row>
										<b-col>
											<h4 class="text-center mb-5">Artist Details</h4>
										</b-col>
									</b-row>
									<b-row>
										<b-col>
											<b-form-group id="band-name-group" label="Band Name" label-for="band_name">
												<b-form-input
													id="band_name"
													v-model.trim="form.band_name"
													placeholder="Band Name"
													autofocus
													:class="{ 'is-invalid': submitted && $v.form.band_name.$error }"
												></b-form-input>
												<b-form-invalid-feedback v-if="submitted && $v.form.band_name.$error">
													<span v-if="!$v.form.band_name.required">Band Name is required.</span>
												</b-form-invalid-feedback>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="artist-name-group" label="Artist Name" label-for="artist_name">
												<b-form-input
														id="artist_name"
														v-model.trim="form.artist_name"
														placeholder="Artist Name"
														:class="{ 'is-invalid': submitted && $v.form.artist_name.$error }"
												></b-form-input>
												<b-form-invalid-feedback v-if="submitted && $v.form.artist_name.$error">
													<span v-if="!$v.form.artist_name.required">Artist Name is required.</span>
												</b-form-invalid-feedback>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="phone-group" label="Phone Name" label-for="phone">
												<b-form-input
														id="phone"
														v-model.trim="form.phone"
														placeholder="Phone Name"
														:class="{ 'is-invalid': submitted && $v.form.phone.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="office-number-group" label="Office Number" label-for="office_number">
												<b-form-input
														id="office_number"
														v-model.trim="form.office_number"
														placeholder="Office Number"
														:class="{ 'is-invalid': submitted && $v.form.office_number.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="email-group" label="Email" label-for="email">
												<b-form-input
														id="email"
														v-model.trim="form.email"
														placeholder="Email"
														:class="{ 'is-invalid': submitted && $v.form.email.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="facebook-group" label="Facebook" label-for="facebook">
												<b-form-input
														id="facebook"
														v-model.trim="form.facebook"
														placeholder="Facebook"
														:class="{ 'is-invalid': submitted && $v.form.facebook.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="youtube-group" label="Youtube" label-for="youtube">
												<b-form-input
														id="youtube"
														v-model.trim="form.youtube"
														placeholder="Youtube"
														:class="{ 'is-invalid': submitted && $v.form.youtube.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="instagram-group" label="Instagram" label-for="instagram">
												<b-form-input
														id="instagram"
														v-model.trim="form.instagram"
														placeholder="Instagram"
														:class="{ 'is-invalid': submitted && $v.form.instagram.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="twitter-group" label="Twitter" label-for="twitter">
												<b-form-input
														id="twitter"
														v-model.trim="form.twitter"
														placeholder="Twitter"
														:class="{ 'is-invalid': submitted && $v.form.twitter.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="tiktok-group" label="Tiktok" label-for="tiktok">
												<b-form-input
														id="tiktok"
														v-model.trim="form.tiktok"
														placeholder="Tiktok"
														:class="{ 'is-invalid': submitted && $v.form.tiktok.$error }"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="status-group" label="Status" label-for="status">
												<b-form-select v-model.trim="form.status">
													<b-form-select-option value="0">In-active</b-form-select-option>
													<b-form-select-option value="1">Active</b-form-select-option>
												</b-form-select>
											</b-form-group>
										</b-col>
									</b-row>
								</tab-content>

								<tab-content icon="mdi mdi-assistant">
									<b-row>
										<b-col>
											<h4 class="text-center mb-5">Artist's Assistant Details</h4>
										</b-col>
									</b-row>
									<b-row>
										<b-col>
											<b-form-group id="assistant-name-group" label="Name" label-for="assistant_name">
												<b-form-input
														id="assistant_name"
														v-model.trim="form.assistant.name"
														placeholder="Name"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="assistant-email-group" label="Email" label-for="assistant_email">
												<b-form-input
														id="assistant_email"
														v-model.trim="form.assistant.email"
														placeholder="Email"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="assistant-cell-group" label="Name" label-for="assistant_cell">
												<b-form-input
														id="assistant_cell"
														v-model.trim="form.assistant.cell"
														placeholder="Cell"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="assistant-phone-group" label="Phone" label-for="assistant_phone">
												<b-form-input
														id="assistant_phone"
														v-model.trim="form.assistant.phone"
														placeholder="Phone"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="assistant-status-group" label="Name" label-for="assistant_status">
												<b-form-select v-model="form.assistant.status">
													<b-form-select-option value="0">Pending</b-form-select-option>
													<b-form-select-option value="1">Cancelled</b-form-select-option>
													<b-form-select-option value="2">Accepted</b-form-select-option>
												</b-form-select>
											</b-form-group>
										</b-col>
									</b-row>
								</tab-content>

								<tab-content icon="mdi mdi-face-agent">
									<b-row>
										<b-col>
											<h4 class="text-center mb-5">Artist's Agent Details</h4>
										</b-col>
									</b-row>
									<b-row>
										<b-col>
											<b-form-group id="agent-organization-name-group" label="Organization Name" label-for="agent_organization_name">
												<b-form-input
														id="agent_organization_name"
														v-model.trim="form.agent.organization_name"
														placeholder="Organization Name"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="agent-group" label="Agent Name" label-for="agent_name">
												<b-form-input
														id="agent_name"
														v-model.trim="form.agent.name"
														placeholder="Agent Name"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="agent-phone-group" label="Agent Phone" label-for="agent_phone">
												<b-form-input
														id="agent_phone"
														v-model.trim="form.agent.phone"
														placeholder="Agent Phone"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="agent-office-number-group" label="Agent Office Number" label-for="agent_office_number">
												<b-form-input
														id="agent_office_number"
														v-model.trim="form.agent.office_number"
														placeholder="Office Number"
												></b-form-input>
											</b-form-group>
										</b-col>
									</b-row>

									<b-row>
										<b-col>
											<b-form-group id="agent-email-group" label="Email" label-for="agent_email">
												<b-form-input
														id="agent_email"
														v-model.trim="form.agent.email"
														placeholder="Email"
												></b-form-input>
											</b-form-group>
										</b-col>
										<b-col>
											<b-form-group id="agent-status-group" label="Status" label-for="agent_status">
												<b-form-select v-model="form.agent.status">
													<b-form-select-option value="2">Move</b-form-select-option>
													<b-form-select-option value="0">Inactive</b-form-select-option>
												</b-form-select>
											</b-form-group>
										</b-col>
									</b-row>
								</tab-content>
							</form-wizard>
						</b-form>
					</b-card-body>
				</b-card>
			</b-col>
		</b-row>
	</Layout>
</template>

<script>
    import appConfig from '@/app.config.json';
    import Layout from '@/views/layouts/main';
    import PageHeader from '@/components/page-header';
    import { required, numeric } from 'vuelidate/lib/validators';
	import { FormWizard, TabContent } from 'vue-form-wizard';

    export default {
        page: {
            title: "New Artist",
            meta: [{ name: "description", content: appConfig.description }]
        },
        components: { Layout, PageHeader, FormWizard, TabContent },
        validations: {
            form: {
                band_name: {
                    required
                },
                artist_name: {
                    required
                }
            }
        },
	    data () {
            return {
                submitted: false,
				title: 'New Artist',
                items: [
                    {
                        text: "Dashboard",
                        href: "/"
                    },
                    {
                        text: "Artists",
                        href: "artists"
                    },
                    {
                        text: "New",
                        active: true
                    }
                ],
	            form: {
				    band_name: '',
		            artist_name: '',
		            phone: '',
		            office_number: '',
		            email: '',
		            facebook: '',
		            youtube: '',
                    instagram: '',
		            twitter: '',
		            tiktok: '',
		            status: 0,
		            assistant: {
						name: '',
			            email: '',
			            cell: '',
			            phone: '',
			            status: 0
		            },
                    agent: {
                        organization_name: '',
	                    name: '',
                        phone: '',
	                    office_number: '',
	                    email: '',
	                    status: 0
                    }
	            }
            }
	    },
        methods: {
			createArtist() {
			    this.submitted = true;
				this.$v.$touch();

				if (this.$v.$invalid === false) {
				    const loader = this.$loading.show();
                    let formData = new FormData();
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

				    this.$http.post('performance-locations', formData)
					    .then(response => {
							this.$refs.createPerformanceLocation.reset();
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
        }
    }
</script>

<style scoped>
	.is-invalid >>> .multiselect__tags {
		border-color: #f46a6a !important;
	}
</style>