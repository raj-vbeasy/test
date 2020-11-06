<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>
		<b-row>
			<b-col>
				<b-card>
					<b-row>
						<b-col>
							<b-button variant="primary-outline">
								<span><i class="mdi mdi-calendar-account-outline"></i>{{ event.formattedDate }}</span>
							</b-button>

							<b-button variant="primary-outline">
								<span>
									<i class="mdi mdi-map-marker-outline"></i>
									{{ event.location }}
									<span class="grey">
										(<span v-for="(item, index) in event.stages" :key="item.id">
											{{ item.name }}<span v-if="index+1 < event.stages.length">, </span>
									</span>)
									</span>
								</span>
							</b-button>
						</b-col>
					</b-row>
					<hr/>
					<b-row>
						<b-col>
							<b-tabs justified nav-class="nav-tabs-custom" content-class="p-3 text-muted">
								<b-tab active>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Dashboard</span>
									</template>
									<b-row class="mt-3">
										<b-col>
											<b-card class="activity stage-activity" :title="name" v-for="(list, name) in dashboard.values" :key="name" style="box-shadow: 1px 1px 8px 0">
												<b-row class="mt-4">
													<b-col>
														<DataTable :fields="dashboard.fields" :total-items="dashboard.totalRows" :items="dashboard.values[name]" :sort-by="dashboard.sortBy"></DataTable>
													</b-col>
												</b-row>
											</b-card>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Talent</span>
									</template>
									<b-row class="mb-5">
										<b-col>
											<b-button variant="outline-primary" v-on:click="addArtist">Add Talent</b-button>
										</b-col>
									</b-row>

									<b-row class="mt-3">
                                        <b-col>
                                            <b-card style="box-shadow: 1px 1px 8px 0">
                                                <b-card-title class="talent_activity1">Headliners</b-card-title>
                                                <b-row class="mt-4">
                                                    <b-col md="4" v-for="artist in event.artists_headliners" :key="artist.id">
                                                        <b-card :title="artist.title" style="box-shadow: 1px 1px 8px 0">
                                                            <b-card-title>
                                                                <span v-if="artist.status === 'Archived' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_status_text" style="background-color:#ffffff;color:#808080">{{ artist.status }}</span>
                                                                <span v-else class="artist_status_text" :style="artist.status_color">{{ artist.status }}</span>
                                                                <!--{{ artist.type | capitalize }}-->
                                                                <span v-if="artist.status === 'Declined' || artist.status === 'Not Available' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ artist.hold_position }}</span>
                                                                <span v-else class="artist_hold_text" :style="artist.hold_position_color">{{ artist.hold_position }}</span>
                                                            </b-card-title>
                                                            <span v-if="artist.status === 'Mutually Agreed Date' || artist.status === 'Declined'">
                                                                <hr>
                                                                <p>{{ artist.date_notes }}</p>
                                                            </span>
                                                            <span v-if="artist.status === 'Challenged By'">
                                                                <hr>
                                                                <p>Challenged by Artist : {{ artist.challenged_by_artist[0]['name'] }}<br> Hours Challenged Hold Expires In : {{ artist.challenged_hours }}</p>
                                                            </span>
                                                            <hr>
                                                            <b-card-text>
                                                                <b-img :src="artist.image" class="rounded-circle" width="50px" height="50px"></b-img>
                                                                <span style="font-size: 16px">{{ artist.name }}</span>
                                                                <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ artist.amount }})</span><br>
                                                            </b-card-text>
                                                            <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                                                                <p class="ml-5">{{ artist.email }}</p>
                                                                <b-card-sub-title class="ml-5" v-for="stage in artist.stages" v-if="stage.event_id === event.id" :key="stage.id">
                                                                    <b class="font-size-14">{{ stage.name }} </b><br>
                                                                    Start:- {{ stage.start ? formatDate(stage.start, 'hh:mm A') : '' }} <br/>
                                                                    End  :- {{ stage.end ? formatDate(stage.end, 'hh:mm A') : '' }}<br/><br/>
                                                                </b-card-sub-title>
                                                                <span class="ml-5">
                                                                    {{ artist.notes }}
                                                                </span>
                                                            </b-card-text>
                                                            <b-button v-on:click="editArtist(artist)" variant="outline-primary">Edit</b-button>
                                                            <b-button v-on:click="deleteArtist(artist)" variant="outline-danger">Delete</b-button>
                                                        </b-card>
                                                    </b-col>
                                                </b-row>
                                            </b-card>
                                        </b-col>
                                    </b-row>

                                    <b-row class="mt-3">
                                        <b-col>
                                            <b-card style="box-shadow: 1px 1px 8px 0">
                                                <b-card-title class="talent_activity2">Support</b-card-title>
                                                <b-row class="mt-4">
                                                    <b-col md="4" v-for="artist in event.artists_support" :key="artist.id">
                                                        <b-card :title="artist.title" style="box-shadow: 1px 1px 8px 0">
                                                            <b-card-title>
                                                                <span v-if="artist.status === 'Archived' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_status_text" style="background-color:#ffffff;color:#808080">{{ artist.status }}</span>
                                                                <span v-else class="artist_status_text" :style="artist.status_color">{{ artist.status }}</span>
                                                                <!--{{ artist.type | capitalize }}-->
                                                                <span v-if="artist.status === 'Declined' || artist.status === 'Not Available' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ artist.hold_position }}</span>
                                                                <span v-else class="artist_hold_text" :style="artist.hold_position_color">{{ artist.hold_position }}</span>
                                                            </b-card-title>
                                                            <span v-if="artist.status === 'Mutually Agreed Date'">
                                                                <hr>
                                                                <p>{{ artist.date_notes }}</p>
                                                            </span>
                                                            <span v-if="artist.status === 'Challenged By'">
                                                                <hr>
                                                                <p>Challenged by Artist : {{ artist.challenged_by_artist[0]['name'] }}<br> Hours Challenged Hold Expires In : {{ artist.challenged_hours }}</p>
                                                            </span>
                                                            <hr>
                                                            <b-card-text>
                                                                <b-img :src="artist.image" class="rounded-circle" width="50px" height="50px"></b-img>
                                                                <span style="font-size: 16px">{{ artist.name }}</span>
                                                                <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ artist.amount }})</span>
                                                            </b-card-text>
                                                            <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                                                                <b-card-sub-title class="ml-5" v-for="stage in artist.stages" v-if="stage.event_id === event.id" :key="stage.id">
                                                                    <b class="font-size-14">{{ stage.name }} </b><br>
                                                                    Start:- {{ stage.start ? formatDate(stage.start, 'hh:mm A') : '' }} <br/>
                                                                    End  :- {{ stage.end ? formatDate(stage.end, 'hh:mm A') : '' }}<br/><br/>
                                                                </b-card-sub-title>
                                                                <span class="ml-5">{{ artist.notes }}</span>
                                                            </b-card-text>
                                                            <b-button v-on:click="editArtist(artist)" variant="outline-primary">Edit</b-button>
                                                            <b-button v-on:click="deleteArtist(artist)" variant="outline-danger">Delete</b-button>
                                                        </b-card>
                                                    </b-col>
                                                </b-row>
                                            </b-card>
                                        </b-col>
									</b-row>

                                    <b-row class="mt-3">
                                        <b-col>
                                            <b-card style="box-shadow: 1px 1px 8px 0">
                                                <b-card-title class="talent_activity3">Historical</b-card-title>
                                                <b-row class="mt-4">
                                                    <b-col md="4" v-for="artist in event.artists_historical" :key="artist.id">
                                                        <b-card :title="artist.title" style="box-shadow: 1px 1px 8px 0">
                                                            <b-card-header v-if="artist.status === 'Challenged By'">
                                                                <vue-countdown-timer
                                                                    :start-time="artist.challenged_by_updated_from"
                                                                    :end-time="artist.challenged_by_updated_to.date"
                                                                    :interval="1000"
                                                                    :start-label="'Start:'"
                                                                    :end-label="'End:'"
                                                                    label-position="begin"
                                                                    :end-text="'Event Ended!'"
                                                                    :day-txt="'Days'"
                                                                    :hour-txt="'Hours'"
                                                                    :minutes-txt="'Min'"
                                                                    :seconds-txt="'Sec'">
                                                                </vue-countdown-timer>
                                                            </b-card-header>
                                                            <b-card-title>
                                                                <span v-if="artist.status === 'Archived' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_status_text" style="background-color:#ffffff;color:#808080">{{ artist.status }}</span>
                                                                <span v-else class="artist_status_text" :style="artist.status_color">{{ artist.status }}</span>
                                                                <!--{{ artist.type | capitalize }}-->
                                                                <span v-if="artist.status === 'Declined' || artist.status === 'Not Available' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ artist.hold_position }}</span>
                                                                <span v-else class="artist_hold_text" :style="artist.hold_position_color">{{ artist.hold_position }}</span>
                                                            </b-card-title>
                                                            <span v-if="artist.status === 'Mutually Agreed Date'">
                                                                <hr>
                                                                <p>{{ artist.date_notes }}</p>
                                                            </span>
                                                            <span v-if="artist.status === 'Challenged By'">
                                                                <hr>
                                                                <p>Challenged by Artist : {{ artist.challenged_by_artist[0]['name'] }}<br> Hours Challenged Hold Expires In : {{ artist.challenged_hours }}</p>
                                                            </span>
                                                            <hr>
                                                            <b-card-text>
                                                                <b-img :src="artist.image" class="rounded-circle" width="50px" height="50px"></b-img>
                                                                <span style="font-size: 16px">{{ artist.name }}</span>
                                                                <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ artist.amount }})</span>
                                                            </b-card-text>
                                                            <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                                                                <b-card-sub-title class="ml-5" v-for="stage in artist.stages" v-if="stage.event_id === event.id" :key="stage.id">
                                                                    <b class="font-size-14">{{ stage.name }} </b><br>
                                                                    Start:- {{ stage.start ? formatDate(stage.start, 'hh:mm A') : '' }} <br/>
                                                                    End  :- {{ stage.end ? formatDate(stage.end, 'hh:mm A') : '' }}<br/><br/>
                                                                </b-card-sub-title>
                                                                <span class="ml-5">{{ artist.notes }}</span>
                                                            </b-card-text>
                                                            <b-button v-on:click="editArtist(artist)" variant="outline-primary">Edit</b-button>
                                                            <b-button v-on:click="deleteArtist(artist)" variant="outline-danger">Delete</b-button>
                                                        </b-card>
                                                    </b-col>
                                                </b-row>
                                            </b-card>
                                        </b-col>
                                    </b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Tasks</span>
									</template>

									<b-row>
										<b-col>
											<b-button variant="outline-info" v-on:click="addTask">Add Task</b-button>
										</b-col>
									</b-row>
									<b-row class="mt-3">
										<b-col>
											<DataTable custom-ref="event_tasks_table" :fields="table.task.fields" :slots="table.task.slots" :total-items="table.task.totalRows" :items="event.tasks" :sort-by="table.task.sortBy">
												<template slot="actions" slot-scope="data">
													<b-button variant="outline-danger" @click="deleteTask(data.tbl.item)">
														<b-icon-x/>
													</b-button>
													<b-button variant="outline-info" @click="editTask(data.tbl.item)">
														<b-icon-pencil/>
													</b-button>
												</template>
											</DataTable>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Run of show</span>
									</template>
									<b-row>
										<b-col>
                                            <b-button right variant="outline-info" style="margin-bottom: 15px;">Print/Mail</b-button>
                                            <br/>

											<b-card class="activity stage-activity" title="Stage Activity e.g. Bands, Announce, Awards, DJ" style="box-shadow: 1px 1px 8px 0">
												<b-row class="mt-4">
													<b-col>
														<b-button variant="outline-primary" v-on:click="addActivity('stage')">Add Stage Activity</b-button>
													</b-col>
												</b-row>
												<b-row class="mt-4">
													<b-col>
														<DataTable custom-ref="event_stage_activity_table" :fields="table.activity.stage.fields" :slots="table.activity.stage.slots" :total-items="table.activity.stage.totalRows" :items="event.activities.stage" :sort-by="table.activity.stage.sortBy">
															<template slot="actions" slot-scope="data">
																<b-button variant="outline-danger" @click="deleteActivity(data.tbl.item)">
																	<b-icon-x/>
																</b-button>
																<b-button variant="outline-info" @click="editActivity(data.tbl.item)">
																	<b-icon-pencil/>
																</b-button>
															</template>
                                                            <template slot="start" slot-scope="data">
                                                                {{ data.tbl.item.start ? formatDate(data.tbl.item.start, 'hh:mm A') : '' }}
                                                            </template>
                                                            <template slot="end" slot-scope="data">
                                                                {{ data.tbl.item.end ? formatDate(data.tbl.item.end, 'hh:mm A') : '' }}
                                                            </template>
														</DataTable>
													</b-col>
												</b-row>
											</b-card>

											<b-card class="activity crew_activity" title="Responsible Entity" style="box-shadow: 1px 1px 8px 0">
												<b-row class="mt-4">
													<b-col>
														<b-button variant="outline-primary" v-on:click="addActivity('crew')">Add Responsible Entity</b-button>
													</b-col>
												</b-row>
												<b-row class="mt-4">
													<b-col>
														<DataTable custom-ref="event_crew_activity_table" :fields="table.activity.crew.fields" :slots="table.activity.crew.slots" :total-items="table.activity.crew.totalRows" :items="event.activities.crew" :sort-by="table.activity.crew.sortBy">
															<template slot="actions" slot-scope="data">
																<b-button variant="outline-danger" @click="deleteActivity(data.tbl.item)">
																	<b-icon-x/>
																</b-button>
																<b-button variant="outline-info" @click="editActivity(data.tbl.item)">
																	<b-icon-pencil/>
																</b-button>
															</template>
                                                            <template slot="start" slot-scope="data">
                                                                {{ data.tbl.item.start ? formatDate(data.tbl.item.start, 'hh:mm A') : '' }}
                                                            </template>
                                                            <template slot="end" slot-scope="data">
                                                                {{ data.tbl.item.end ? formatDate(data.tbl.item.end, 'hh:mm A') : '' }}
                                                            </template>
														</DataTable>
													</b-col>
												</b-row>
											</b-card>

											<b-card class="activity other_activity" title="Other Activities" style="box-shadow: 1px 1px 8px 0">
												<b-row class="mt-4">
													<b-col>
														<b-button variant="outline-primary" v-on:click="addActivity('other')">Add Other Activity</b-button>
													</b-col>
												</b-row>
												<b-row class="mt-4">
													<b-col>
														<DataTable custom-ref="event_other_activity_table" :fields="table.activity.other.fields" :slots="table.activity.other.slots" :total-items="table.activity.other.totalRows" :items="event.activities.other" :sort-by="table.activity.other.sortBy">
															<template slot="actions" slot-scope="data">
																<b-button variant="outline-danger" @click="deleteActivity(data.tbl.item)">
																	<b-icon-x/>
																</b-button>
																<b-button variant="outline-info" @click="editActivity(data.tbl.item)">
																	<b-icon-pencil/>
																</b-button>
															</template>
                                                            <template slot="start" slot-scope="data">
                                                                {{ data.tbl.item.start ? formatDate(data.tbl.item.start, 'hh:mm A') : '' }}
                                                            </template>
                                                            <template slot="end" slot-scope="data">
                                                                {{ data.tbl.item.end ? formatDate(data.tbl.item.end, 'hh:mm A') : '' }}
                                                            </template>
														</DataTable>
													</b-col>
												</b-row>
											</b-card>

											<b-card class="activity important_notes" title="Important Notes" style="box-shadow: 1px 1px 8px 0">
												<b-row class="mt-4">
													<b-col>
														<b-button variant="outline-primary" v-on:click="addActivity('important')">Add Important Notes</b-button>
													</b-col>
												</b-row>
												<b-row class="mt-4">
													<b-col>
														<DataTable custom-ref="event_important_activity_table" :fields="table.activity.important.fields" :slots="table.activity.important.slots" :total-items="table.activity.important.totalRows" :items="event.activities.important" :sort-by="table.activity.important.sortBy">
															<template slot="actions" slot-scope="data">
																<b-button variant="outline-danger" @click="deleteActivity(data.tbl.item)">
																	<b-icon-x/>
																</b-button>
																<b-button variant="outline-info" @click="editActivity(data.tbl.item)">
																	<b-icon-pencil/>
																</b-button>
															</template>
														</DataTable>
													</b-col>
												</b-row>
											</b-card>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Contacts</span>
									</template>
									<b-row>
										<b-col>
											<b-button variant="outline-info" v-on:click="addContact">Add Contact</b-button>
										</b-col>
									</b-row>
									<b-row class="mt-3">
										<b-col>
											<DataTable custom-ref="event_contacts_table" :fields="table.contact.fields" :slots="table.contact.slots" :total-items="table.contact.totalRows" :items="event.contacts" :sort-by="table.contact.sortBy">
												<template slot="actions" slot-scope="data">
													<b-button variant="outline-danger" @click="deleteContact(data.tbl.item)">
														<b-icon-x/>
													</b-button>
													<b-button variant="outline-info" @click="editContact(data.tbl.item)">
														<b-icon-pencil/>
													</b-button>
												</template>
											</DataTable>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-sticky-note"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Notes</span>
									</template>
									<b-row class="mb-5">
										<b-col>
											<b-button variant="outline-primary" v-on:click="addNote">Add Note</b-button>
										</b-col>
									</b-row>
									<b-row>
										<b-col md="3" v-for="note in event.notes" :key="note.id">
											<b-card :title="note.title" style="box-shadow: 1px 1px 8px 0">
												<b-card-text>
                                                    <b>Start : {{ note.start }}<br>
                                                        End : {{ note.end }}<br></b>
                                                    {{ note.text }}
                                                </b-card-text>
												<b-button v-on:click="editNote(note)" variant="outline-primary">Edit</b-button>
												<b-button v-on:click="deleteNote(note)" variant="outline-danger">delete</b-button>
											</b-card>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Expenses</span>
									</template>
									<b-row>
										<b-col>
											<b-button variant="outline-info" v-on:click="addExpense">Add Expense</b-button>
										</b-col>
									</b-row>
									<b-row class="mt-3">
										<b-col>
											<DataTable custom-ref="event_expense_table" :fields="table.expense.fields" :slots="table.expense.slots" :total-items="table.expense.totalRows" :items="event.expenses" :sort-by="table.expense.sortBy">
												<template slot="actions" slot-scope="data">
													<b-button variant="outline-danger" @click="deleteExpense(data.tbl.item)">
														<b-icon-x/>
													</b-button>
													<b-button variant="outline-info" @click="editExpense(data.tbl.item)">
														<b-icon-pencil/>
													</b-button>
												</template>
												<template slot="amount" slot-scope="data">
													<span>${{ data.tbl.item.amount }}</span>
												</template>
												<template slot="datetime" slot-scope="data">
													<span>{{ formatDate(data.tbl.item.datetime, 'MMM DD, YYYY dddd HH:mm') }}</span>
												</template>
											</DataTable>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Settlement</span>
									</template>

									<b-row>
										<b-col>
											<p>
												Below is preview of settlement <b-button variant="outline-info" style="float: right">Download</b-button>
											</p>
										</b-col>
									</b-row>
									<b-row class="mt-3">
										<b-col>
											<b-card style="box-shadow: 1px 1px 8px 0">
												<p>Gross Ticket Revenue <span class="pull-right">$0.00</span></p>
												<p>Taxes & Fees <span class="pull-right">$0.00</span></p>
												<p>Adj. Ticket Gross <span class="pull-right">$0.00</span></p>
												<p>Additional Revenue <span class="pull-right">$0.00</span></p>
												<p>Total Expenses <span class="pull-right">$0.00</span></p>
												<hr>
												<p><strong>Net Profit <span class="pull-right">$0.00</span></strong></p>
												<hr>
												<p>Actual Attendance <span class="pull-right">0</span></p>
											</b-card>
										</b-col>
									</b-row>
								</b-tab>
								<b-tab>
									<template v-slot:title>
                                        <span class="d-inline-block d-sm-none">
                                            <i class="fas fa-home"></i>
                                        </span>
										<span class="d-none d-sm-inline-block">Overview</span>
									</template>
								</b-tab>
							</b-tabs>
						</b-col>
					</b-row>
				</b-card>
			</b-col>
		</b-row>

		<!--Modal for notes-->
		<b-modal
			v-model="modal.note.show"
			:title="modal.note.title"
			title-class="text-black font-18"
			body-class="p-3"
			hide-footer
		>
			<b-form @submit.prevent="handleNote">
				<b-row>
					<b-col>
						<b-form-group id="note_title_group" label="Note Title" label-for="note_title">
							<b-form-input id="note_title" v-model.trim="form.note.title" placeholder="Note Title"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>
                <b-row>
                    <b-col>
                        <b-form-group id="note_start_date" label="Start Date" label-for="start_date">
                            <date-picker
                                id="start_date"
                                v-model="form.note.start"
                                :first-day-of-week="1"
                                lang="en"
                                confirm
                                format="MMM DD, YYYY dddd"></date-picker>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-group id="note_end_date" label="End Date" label-for="end_date">
                            <date-picker
                                id="end_date"
                                v-model="form.note.end"
                                :first-day-of-week="1"
                                lang="en"
                                confirm
                                format="MMM DD, YYYY dddd"></date-picker>
                        </b-form-group>
                    </b-col>
                </b-row>
				<b-row>
					<b-col>
						<b-form-group id="note_text_group" label="Note Text" label-for="note_text">
							<b-textarea rows="5" id="note_text" v-model.trim="form.note.text" placeholder="Note Text"></b-textarea>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row class="mb-5">
					<b-col>
						<b-button variant="outline-secondary float-right ml-2" @click="cancelNoteModal">Cancel</b-button>
						<b-button variant="outline-info float-right" type="submit">Submit</b-button>
					</b-col>
				</b-row>
			</b-form>
		</b-modal>
		<!--Modal for notes-->

		<!--Model for add artist-->
		<b-modal
			v-model="modal.artist.show"
			:title="modal.artist.title"
			title-class="text-black font-18"
			body-class="p-3"
			hide-footer
		>
			<b-form @submit.prevent="handleArtist">
				<b-row>
					<b-col>
						<b-form-group label="Name" label-for="artist_name">
							<multiselect
									id="artist_name"
									v-model="form.artist.id"
									:options="filteredArtists"
									@search-change="searchArtist"
									:loading="isSearching"
									:limit="10"
									:internal-search="false"
									:max-height="400"
									:clear-on-select="true"
									:close-on-select="true"
									:searchable="true"
									track-by="value"
									label="label"
							></multiselect>
						</b-form-group>
					</b-col>
				</b-row>

                <b-row>
                    <b-col>
                        <b-form-group label-for="artist_email" label="Agent Email, Management Email and Other">
                            <b-form-input
                                id="artist_email"
                                v-model="form.artist.email"
                                placeholder="Emails"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

				<b-row>
					<b-col>
						<b-form-group label-for="talent_amount" label="Amount">
							<b-form-input
									class="col-3"
									id="talent_amount"
									v-model.number="form.artist.amount"
									placeholder="0"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group label="Talent type" label-for="artist_type">
							<b-form-radio
									v-model="form.artist.type"
									name="artist_type"
									value="headliner">Headliner</b-form-radio>
							<b-form-radio
									v-model="form.artist.type"
									name="artist_type"
									value="support"
									class="ml-3">Support</b-form-radio>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group label="Promoter Profit" label-for="promoter_profit_enable">
							<switches
									v-model="form.artist.promoter_profit_enable"
									type-bold="false"
									color="info"
									class="mt-1"
									id="promoter_profit_enable"
							></switches>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row v-if="form.artist.promoter_profit_enable">
					<b-col>
						<b-form-group label-for="promoter_profit" label="Profit">
							<b-form-input
									class="col-3"
									id="promoter_profit"
									v-model.number="form.artist.promoter_profit"
									placeholder="0%"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group label="Status" label-for="artist_status">
							<b-form-select v-model="form.artist.status" :options="artistStatus"></b-form-select>
						</b-form-group>
					</b-col>
				</b-row>

                <b-row v-if="form.artist.status === 3 || form.artist.status === 9">
                    <b-col>
                        <label v-if="form.artist.status === 3">Mutually Agreed Date Note</label>
                        <label v-else>Reason</label>
                        <b-form-group label-for="date_notes">
                            <b-form-textarea
                                class=""
                                id="date_notes"
                                v-model="form.artist.date_notes"
                                placeholder="Enter something..."
                                rows="3"
                                max-rows="6"
                            ></b-form-textarea>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.artist.status === 5">
                    <b-col>
                        <b-form-group label-for="challenged_by" label="Challenged by Artist">
                            <b-select
                                class=""
                                id="date_notes"
                                v-model="form.artist.challenged_by"
                            >
                                <option selected="selected">Select challenged by artist</option>
                                <option v-for="artist in event.artists" :value="artist.id">{{ artist.name }}</option>
                            </b-select>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.artist.status === 5">
                    <b-col>
                        <b-form-group label-for="challenged_hours" label="Hours Challenged Hold Expires In (like: 24,48,72)">
                            <b-form-input
                                class="col-3"
                                id="challenged_hours"
                                v-model.number="form.artist.challenged_hours"
                                placeholder="0"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label="Hold Position" label-for="artist_hold_position">
                            <b-form-select v-model="form.artist.hold_position" :options="artistHoldPosition"></b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label-for="notes" label="Notes">
                            <b-form-textarea
                                class=""
                                id="notes"
                                v-model="form.artist.notes"
                                placeholder="Enter something..."
                                rows="3"
                                max-rows="6"
                            ></b-form-textarea>
                        </b-form-group>
                    </b-col>
                </b-row>

				<b-row class="mb-5">
					<b-col>
						<b-button variant="outline-secondary float-right ml-2" @click="cancelArtistModal">Cancel</b-button>
						<b-button variant="outline-info float-right" type="submit">Submit</b-button>
					</b-col>
				</b-row>
			</b-form>
		</b-modal>
		<!--Model for add artist-->

		<!--Modal for contact-->
		<b-modal
				v-model="modal.contact.show"
				:title="modal.contact.title"
				title-class="text-black font-18"
				body-class="p-3"
				hide-footer
		>
			<b-form @submit.prevent="handleContact">
				<b-row>
					<b-col>
						<b-form-group id="contact_company_group" label="Company" label-for="contact_company">
							<b-form-input id="contact_company" v-model.trim="form.contact.company" placeholder="Company"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="contact_position_group" label="Position" label-for="contact_position">
							<b-form-input id="contact_position" v-model.trim="form.contact.position" placeholder="position"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="contact_name_group" label="Name" label-for="contact_name">
							<b-form-input id="contact_name" v-model.trim="form.contact.name" placeholder="Name"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="contact_phone_group" label="Phone" label-for="contact_phone">
							<b-form-input id="contact_phone" v-model.trim="form.contact.phone" placeholder="phone"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

                <b-row>
                    <b-col>
                        <b-form-group id="contact_email_group" label="Email" label-for="contact_email">
                            <b-form-input id="contact_email" v-model.trim="form.contact.email" placeholder="Email"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
					<b-col>
						<b-form-group id="contact_notes_group" label="Contact Notes" label-for="contact_notes">
							<b-textarea rows="5" id="contact_notes" v-model.trim="form.contact.notes" placeholder="Contact Notes"></b-textarea>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="event_notes_group" label="Event Notes" label-for="event_notes">
							<b-textarea rows="5" id="event_notes" v-model.trim="form.contact.event_notes" placeholder="Event Notes"></b-textarea>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row class="mb-5">
					<b-col>
						<b-button variant="outline-secondary float-right ml-2" @click="cancelContactModal">Cancel</b-button>
						<b-button variant="outline-info float-right" type="submit">Submit</b-button>
					</b-col>
				</b-row>
			</b-form>
		</b-modal>
		<!--Modal for contact-->

		<!--Modal for Task-->
		<b-modal
				v-model="modal.task.show"
				:title="modal.task.title"
				title-class="text-black font-18"
				body-class="p-3"
				hide-footer
		>
			<b-form @submit.prevent="handleTask">
				<b-row>
					<b-col>
						<b-form-group id="task_name_group" label="Name" label-for="task_name">
							<b-form-input id="task_name" v-model.trim="form.task.name" placeholder="Name"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="task_description_group" label="Description" label-for="task_description">
							<b-textarea rows="5" id="task_description" v-model.trim="form.task.description" placeholder="Description"></b-textarea>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="task_due_date_group" label="Due Date" label-for="task_due_date">
							<date-picker
									v-model="form.task.due_date"
									:first-day-of-week="1"
									lang="en"
									confirm
									format="MMM DD, YYYY dddd"></date-picker>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="task_status_group" label="Status" label-for="task_status">
							<b-form-input id="task_status" v-model.trim="form.task.status"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="task_assignee_group" label="Assignee" label-for="task_assignee">
							<b-form-input id="task_assignee" v-model.trim="form.task.assignee"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row class="mb-5">
					<b-col>
						<b-button variant="outline-secondary float-right ml-2" @click="cancelTaskModal">Cancel</b-button>
						<b-button variant="outline-info float-right" type="submit">Submit</b-button>
					</b-col>
				</b-row>
			</b-form>
		</b-modal>
		<!--Modal for Task-->

		<!--Modal for Activity-->
		<b-modal
				v-model="modal.activity.show"
				:title="modal.activity.title"
				title-class="text-black font-18"
				body-class="p-3"
				hide-footer
		>
			<b-form @submit.prevent="handleActivity">
				<b-row v-if="form.activity.type === 'stage'">
					<b-col>
						<b-form-group label="Talent" label-for="activity_talent">
							<b-form-select v-model="form.activity.artist_id">
								<b-form-select-option :value="null">Please select talent</b-form-select-option>
								<b-form-select-option v-for="artist in event.artists" :key="artist.id" :value="artist.id">
									{{ artist.name | capitalize }}
								</b-form-select-option>
							</b-form-select>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row v-if="form.activity.type === 'stage'">
					<b-col cols="9">
						<b-form-group label="Stage" label-for="activity_stage">
							<b-form-select v-model="form.activity.stage_id">
								<b-form-select-option :value="null">Please select stage</b-form-select-option>
								<b-form-select-option v-for="stage in event.stages" :key="stage.id" :value="stage.id">
									{{ stage.name | capitalize }}
								</b-form-select-option>
							</b-form-select>
						</b-form-group>
					</b-col>
					<b-col cols="3" style="line-height: 86px;">
						<a href="javascript:void(0)" @click="addNewStage" class="btn btn-outline-info">
							<i class="mdi mdi-plus"></i>
						</a>
						<a href="javascript:void(0)" @click="refreshStages" class="btn btn-outline-success">
							<i class="mdi mdi-refresh"></i>
						</a>
					</b-col>
				</b-row>

				<b-row v-if="form.activity.type === 'crew'">
					<b-col>
						<b-form-group label="Responsible Member" label-for="crew_member">
							<b-form-input id="crew_member" v-model.trim="form.activity.crew" placeholder="Responsible member name"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

                <b-row>
                    <b-col>
                        <b-form-group label="Cell Phone" label-for="crew_cell_phone">
                            <b-form-input id="crew_cell_phone" v-model.trim="form.activity.cell_phone" placeholder="Cell phone"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label="Radio Channel" label-for="crew_radio_channel">
                            <b-form-input id="crew_radio_channel" v-model.trim="form.activity.radio_channel" placeholder="Radio channel"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label="Email" label-for="crew_email">
                            <b-form-input id="crew_email" v-model.trim="form.activity.email" placeholder="Email"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

				<b-row v-if="['other', 'crew', 'stage'].includes(form.activity.type)">
					<b-col>
						<b-form-group label="Start Time" label-for="start_time">
							<date-picker
									v-model="form.activity.start"
									type="time"
									lang="en"
									confirm
									:show-time-header="true"
									time-title-format="hh:mm A"
									format="hh:mm A"
									:show-second="false"
									value-type="timestamp"></date-picker>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row v-if="['other', 'crew', 'stage'].includes(form.activity.type)">
					<b-col>
						<b-form-group label="End Time" label-for="end_time">
							<date-picker
									v-model="form.activity.end"
									type="time"
									lang="en"
									confirm
									:show-time-header="true"
									time-title-format="hh:mm A"
									format="hh:mm A"
									:show-second="false"
									value-type="timestamp"></date-picker>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group label="Description" label-for="activity_description">
							<b-textarea rows="5" id="activity_description" v-model.trim="form.activity.description" placeholder="Description"></b-textarea>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row class="mb-5">
					<b-col>
						<b-button variant="outline-secondary float-right ml-2" @click="cancelActivityModal">Cancel</b-button>
						<b-button variant="outline-info float-right" type="submit">Submit</b-button>
					</b-col>
				</b-row>
			</b-form>
		</b-modal>
		<!--Modal for Activity-->

		<!--Modal for Expense-->
		<b-modal
				v-model="modal.expense.show"
				:title="modal.expense.title"
				title-class="text-black font-18"
				body-class="p-3"
				hide-footer
		>
			<b-form @submit.prevent="handleExpense">
				<b-row>
					<b-col>
						<b-form-group id="expense_crew_group" label="Crew Member Name" label-for="expense_crew_name">
							<b-form-input id="expense_crew_name" v-model.trim="form.expense.crew" placeholder="Crew member name"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="expense_amount_group" label="Amount" label-for="expense_amount">
							<b-form-input id="expense_amount" v-model.trim="form.expense.amount" placeholder="0"></b-form-input>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="expense_description_group" label="Description" label-for="expense_description">
							<b-textarea rows="5" id="expense_description" v-model.trim="form.expense.description" placeholder="Description"></b-textarea>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row>
					<b-col>
						<b-form-group id="expense_datetime_group" label="Date" label-for="expense_datetime">
							<date-picker
									type="datetime"
									v-model="form.expense.datetime"
									:first-day-of-week="1"
									lang="en"
									confirm
									format="MMM DD, YYYY dddd HH:mm"
									value-type="timestamp"></date-picker>
						</b-form-group>
					</b-col>
				</b-row>

				<b-row class="mb-5">
					<b-col>
						<b-button variant="outline-secondary float-right ml-2" @click="cancelExpenseModal">Cancel</b-button>
						<b-button variant="outline-info float-right" type="submit">Submit</b-button>
					</b-col>
				</b-row>
			</b-form>
		</b-modal>
		<!--Modal for Expense-->
	</Layout>
</template>

<script>
	import Layout from '@/views/layouts/main';
	import PageHeader from "@/components/page-header";
	import appConfig from "@/app.config.json"
	import moment from 'moment';
	import "moment-timezone";
	import Multiselect from 'vue-multiselect';
	import Switches from "vue-switches";
	import DataTable from "@/views/utility/data-table";
	import DatePicker from 'vue2-datepicker';

	export default {
		name: "dashboard",
		components: {DataTable, Layout, PageHeader, Multiselect, Switches, DatePicker},
		page: {
			title: "Event Dashboard",
			meta: [{ name: "description", content: appConfig.description }]
		},
		data () {
			return {
				event: {
					id: '',
					name: '',
					email: '',
					stages: '',
					location: '',
					promoter: '',
					date: '',
					status: '',
					notes: [],
					artists: [],
					contacts: [],
					tasks: [],
					activities: {
						stage: [],
						other: [],
                        crew: [],
						important: []
					}
				},
				title: '',
				items: [
					{
						text: "Dashboard",
						href: "/"
					},
					{
						text: "Events",
						href: "/events"
					}
				],
				form: {
					note: {
						title: '',
                        start: '',
                        end: '',
						text: '',
						id: ''
					},
					artist: {
						id: '',
                        email: '',
						type: 'headliner',
						promoter_profit_enable: false,
						promoter_profit: 0,
						status: null,
                        date_notes: '',
                        challenged_by: '',
                        challenged_hours: '',
                        hold_position: null,
						amount: 0
					},
					contact: {
						id: '',
						email: '',
						company: '',
						position: '',
						name: '',
						phone: '',
						notes: '',
						event_notes: ''
					},
					task: {
						id: '',
						name: '',
						description: '',
						due_date: '',
						status: '',
						assignee: ''
					},
					activity: {
						id: null,
						artist_id: null,
						stage_id: null,
						crew: null,
                        cell_phone: null,
                        radio_channel: null,
                        email: null,
						start: null,
						end: null,
						description: '',
						type: null
					},
					expense: {
						id: null,
						amount: 0,
						description: '',
						datetime: null,
						crew: ''
					}
				},
				modal: {
					note: {
						title: '',
						show: false,
						add: false,
						edit: false,
						delete: false
					},
					artist: {
						show: false,
						title: '',
						add: false,
						edit: false,
						delete: false
					},
					contact: {
						show: false,
						title: '',
						add: false,
						edit: false,
						delete: false
					},
					task: {
						show: false,
						title: '',
						add: false,
						edit: false,
						delete: false
					},
					activity: {
						title: '',
						show: false,
						add: false,
						edit: false,
						delete: false
					},
					expense: {
						show: false,
						title: '',
						add: false,
						edit: false,
						delete: false
					}
				},
				table: {
					contact: {
						sortBy: "name",
						fields: [
							{ key: "company", sortable: true },
							{ key: "position", sortable: true },
							{ key: "name", sortable: true },
							{ key: "phone", sortable: true },
                            { key: "email", sortable: true },
							{ key: "notes", label: 'Contact Notes', sortable: false },
							{ key: "event_notes", label: 'Event Notes', sortable: false },
							{ key: 'actions', sortable: false }
						],
						totalRows: 0,
						slots: ['actions']
					},
					task: {
						sortBy: "task",
						fields: [
							{ key: "name", label: 'task', sortable: true },
							{ key: "description", sortable: true },
							{ key: "due_date", sortable: true },
							{ key: "status", sortable: true },
							{ key: "assignee", sortable: true },
							{ key: 'actions', sortable: false }
						],
						totalRows: 0,
						slots: ['actions']
					},
					activity: {
						stage: {
							sortBy: "start",
							fields: [
								{ key: "stage.name", label: "Stage", sortable: false},
								{ key: "start", sortable: true },
								{ key: "end", sortable: true },
                                { key: "artist.name", label: 'Talent', sortable: true },
								{ key: "description", sortable: false },
								{ key: 'actions', sortable: false }
							],
							totalRows: 0,
							slots: ['actions', 'start', 'end']
						},
						crew: {
							sortBy: "crew",
							fields: [
								{ key: "crew", label: 'Responsible Name', sortable: true },
								{ key: "cell_phone", sortable: true },
                                { key: "radio_channel", sortable: true },
                                { key: "email", sortable: true },
                                { key: "description", sortable: false },
                                { key: "start", sortable: true },
                                { key: "end", sortable: true },
								{ key: 'actions', sortable: false }
							],
							totalRows: 0,
							slots: ['actions', 'start', 'end']
						},
						other: {
							sortBy: "date",
							fields: [
								{ key: "description", sortable: false },
                                { key: "start", sortable: true },
                                { key: "end", sortable: true },
								{ key: 'actions', sortable: false }
							],
							totalRows: 0,
							slots: ['actions', 'start', 'end']
						},
						important: {
							sortBy: "date",
							fields: [
								{ key: "description", sortable: false },
								{ key: "date", label: 'Date', sortable: true },
								{ key: 'actions', sortable: false }
							],
							totalRows: 0,
							slots: ['actions']
						}
					},
					expense: {
						sortBy: "datetime",
						fields: [
							{ key: "crew", label: 'Crew Member', sortable: true },
							{ key: "amount", sortable: true },
							{ key: "description", sortable: false },
							{ key: "datetime", sortable: true },
							{ key: 'actions', sortable: false }
						],
						totalRows: 0,
						slots: ['actions', 'amount', 'datetime']
					}
				},
				filteredArtists: [],
				isSearching: false,
				artistStatus: [
					{
						value: null, text: 'Please select status'
					}
				],
                artistHoldPosition: [
                    {
                        value: null, text: 'Please select hold position'
                    }
                ],
				dashboard: {
					sortBy: "start",
					fields: [
						{ key: "artist.name", label: 'Talent', sortable: true },
						{ key: "stage.name", label: "Stage", sortable: false},
						{ key: "start", sortable: true },
						{ key: "end", sortable: true },
						{ key: "description", sortable: false }
					],
					totalRows: 0,
					values: {}
				}
			}
		},
		methods: {
			formatDate (timestamp, format) {
				return moment.utc(timestamp).local().format(format);
			},
			addNote () {
				this.modal.note.add = true;
				this.modal.note.show = true
				this.modal.note.title = 'Add Note';
			},
			editNote (note) {
				this.form.note.title = note.title;
                this.form.note.start = note.start;
                this.form.note.end = note.end;
				this.form.note.text = note.text;
				this.form.note.id = note.id;
				this.modal.note.show = true;
				this.modal.note.title = 'Edit Note';
				this.modal.note.edit = true;
			},
			deleteNote (note) {
				this.form.note.id = note.id;
				this.modal.note.delete = true;
				this.handleNote();
			},
			handleNote () {
				let customRequest = '';
				if (this.modal.note.delete) {
					customRequest = this.$http.delete('events/' + this.event.id + '/notes/' + this.form.note.id);
				} else if (this.modal.note.edit) {
					customRequest = this.$http.put('events/' + this.event.id + '/notes/' + this.form.note.id, this.form.note);
				} else if (this.modal.note.add) {
					let postParam = this.form.note;
					postParam.insert_id = true;
					customRequest = this.$http.post('events/' + this.event.id + '/notes', postParam);
				} else {
					customRequest = new Promise((resolve, reject) => {
						resolve();
					});
				}

				customRequest
					.then(response => {
						if (this.modal.note.add) {
							this.event.notes.push({
								'id': response.data.data.id,
								'text': this.form.note.text,
                                'start': this.form.note.start,
                                'end': this.form.note.end,
								'title': this.form.note.title
							});
						} else if (this.modal.note.edit) {
							for (let i = 0; i < this.event.notes.length; i++) {
								if (this.event.notes[i].id === this.form.note.id) {
									this.event.notes[i].text = this.form.note.text;
                                    this.event.notes[i].start = this.form.note.start;
                                    this.event.notes[i].end = this.form.note.end;
									this.event.notes[i].title = this.form.note.title;
									break;
								}
							}
						} else if (this.modal.note.delete) {
							for (let i = 0; i < this.event.notes.length; i++) {
								if (this.event.notes[i].id === this.form.note.id) {
									this.event.notes.splice(i, 1);
									break;
								}
							}
						}
						this.cancelNoteModal();
						this.$toastr.fire({
							toast: true,
							icon: 'success',
							title: response.data.message
						});
					})
					.catch(error => {
						this.$toastr.fire({
							toast: true,
							icon: 'error',
							title: error.response.data.message
						});
					});
			},
			cancelNoteModal () {
				this.modal.note.show = false;
				this.form.note.text = '';
                this.form.note.start_date = '';
                this.form.note.end_date = '';
				this.form.note.title = '';
				this.form.note.id = '';
				this.modal.note.title = '';
				this.modal.note.edit = false;
				this.modal.note.add = false;
				this.modal.note.delete = false;
			},
			addArtist () {
				this.modal.artist.show = true;
				this.modal.artist.title = 'Add Artist';
				this.modal.artist.add = true;
			},
			editArtist (info) {
				this.modal.artist.show = true;
				this.modal.artist.title = 'Edit Artist';
				this.modal.artist.edit = true;
				this.form.artist.id = {label: info.name, value: info.id};
				this.form.artist.email = info.email;
				this.form.artist.type = info.type;
				this.form.artist.promoter_profit_enable = Number(info.promoter_profit) > 0;
				this.form.artist.promoter_profit = Number(info.promoter_profit);
				this.form.artist.status = this.fetchArtistStatus(info.status, 'key');
				this.form.artist.date_notes = info.date_notes;
                this.form.artist.challenged_by = info.challenged_by;
                this.form.artist.challenged_hours = info.challenged_hours;
                this.form.artist.hold_position = this.fetchArtistHoldPosition(info.hold_position, 'key');
                this.form.artist.notes = info.notes;
				this.form.artist.amount = info.amount;
			},
			deleteArtist (info) {
				this.modal.artist.delete = true;
				this.form.artist.id = info.id;
				this.handleArtist();
			},
			searchArtist (name) {
				if (name.length >= 3) {
					this.isSearching = true;
					this.$http.get('artists?filter=' + name + '&per-page=10&event=' + this.event.id)
						.then(response => {
							this.filteredArtists = [];
							for (let i = 0; i < response.data.data.data.length; i++) {
								this.filteredArtists.push({
									label: response.data.data.data[i].name,
									value: response.data.data.data[i].id,
									image: response.data.data.data[i].image_url
								});
							}
							this.isSearching = false;
						})
						.catch(error => {
							this.$toastr.fire({
								icon: 'error',
								title: error.response.data.message
							});
						});
				}
			},
			cancelArtistModal () {
				this.modal.artist.show = false;
				this.form.artist.id = '';
				this.form.artist.email = '';
				this.form.artist.type = '';
				this.form.artist.promoter_profit_enable = false;
				this.form.artist.promoter_profit = 0;
				this.form.artist.status = null;
				this.form.artist.date_notes = null;
				this.form.artist.challenged_by = null;
				this.form.artist.challenged_hours = '';
				this.form.artist.hold_position = null;
				this.form.artist.notes = null;
				this.form.artist.amount = 0;
				this.modal.artist.delete = false;
				this.modal.artist.add = false;
				this.modal.artist.edit = false;
			},
			handleArtist () {
				let customRequest = '';
				if (this.modal.artist.delete) {
					customRequest = this.$http.delete('events/' + this.event.id + '/artists/' + this.form.artist.id);
				} else if (this.modal.artist.edit) {
					let postParam = {
					    email: this.form.artist.email,
						type: this.form.artist.type,
						promoter_profit: this.form.artist.promoter_profit_enable ? this.form.artist.promoter_profit : 0,
						status: this.form.artist.status,
                        date_notes: this.form.artist.date_notes,
                        challenged_by: this.form.artist.challenged_by,
                        challenged_hours: this.form.artist.challenged_hours,
                        hold_position: this.form.artist.hold_position,
                        notes: this.form.artist.notes,
						amount: this.form.artist.amount
					};
					customRequest = this.$http.put('events/' + this.event.id + '/artists/' + this.form.artist.id.value, postParam);
				} else if (this.modal.artist.add) {
					let postParam = {
						artist_id: this.form.artist.id.value,
                        email: this.form.artist.email,
						type: this.form.artist.type,
						promoter_profit: this.form.artist.promoter_profit_enable ? this.form.artist.promoter_profit : 0,
						status: this.form.artist.status,
                        date_notes: this.form.artist.date_notes,
                        challenged_by: this.form.artist.challenged_by,
                        challenged_hours: this.form.artist.challenged_hours,
                        hold_position: this.form.artist.hold_position,
                        notes: this.form.artist.notes,
						amount: this.form.artist.amount
					};
					customRequest = this.$http.post('events/' + this.event.id + '/artists', postParam);
				} else {
					customRequest = new Promise((resolve, reject) => {
						resolve();
					});
				}

				customRequest
					.then(response => {
						if (this.modal.artist.add) {
							this.event.artists.push({
								id: this.form.artist.id.value,
                                email: this.form.artist.email,
								name: this.form.artist.id.label,
								image: this.form.artist.id.image,
								type: this.form.artist.type,
								promoter_profit: this.form.artist.promoter_profit,
								status: this.fetchArtistStatus(this.form.artist.status, 'value'),
                                date_notes: this.form.artist.date_notes,
                                challenged_by: this.form.artist.challenged_by,
                                challenged_hours: this.form.artist.challenged_hours,
                                hold_position: this.fetchArtistHoldPosition(this.form.artist.hold_position, 'value'),
                                notes: this.form.artist.notes,
                                amount: this.form.artist.amount
							});
						} else if (this.modal.artist.edit) {
							for (let i = 0; i < this.event.artists.length; i++) {
								if (this.event.artists[i].id === this.form.artist.id.value) {
								    this.event.artists[i].email = this.form.artist.email;
									this.event.artists[i].type = this.form.artist.type;
									this.event.artists[i].promoter_profit = this.form.artist.promoter_profit;
									this.event.artists[i].status = this.fetchArtistStatus(this.form.artist.status, 'value');
									this.event.artists[i].date_notes = this.form.artist.date_notes;
									this.event.artists[i].challenged_by = this.form.artist.challenged_by;
									this.event.artists[i].challenged_hours = this.form.artist.challenged_hours;
                                    this.event.artists[i].hold_position = this.fetchArtistHoldPosition(this.form.artist.hold_position, 'value');
                                    this.event.artists[i].notes = this.form.artist.notes,
                                    this.event.artists[i].amount = this.form.artist.amount;
									break;
								}
							}
						} else if (this.modal.artist.delete) {
							for (let i = 0; i < this.event.artists.length; i++) {
								if (this.event.artists[i].id === this.form.artist.id) {
									this.event.artists.splice(i, 1);
									break;
								}
							}
						}
						this.cancelArtistModal();
						this.$toastr.fire({
							icon: 'success',
							title: response.data.message
						});
					})
					.catch(error => {
						this.$toastr.fire({
							icon: 'error',
							title: error.response.data.message
						});
					});
			},
			addContact () {
				this.modal.contact.add = true;
				this.modal.contact.show = true
				this.modal.contact.title = 'Add Contact';
			},
			editContact (note) {
				this.form.contact = note;
				this.modal.contact.show = true;
				this.modal.contact.title = 'Edit Contact';
				this.modal.contact.edit = true;
			},
			deleteContact (note) {
				this.form.contact.id = note.id;
				this.modal.contact.delete = true;
				this.handleContact();
			},
			handleContact () {
				let customRequest = '';
				if (this.modal.contact.delete) {
					customRequest = this.$http.delete('events/' + this.event.id + '/contacts/' + this.form.contact.id);
				} else if (this.modal.contact.edit) {
					customRequest = this.$http.put('events/' + this.event.id + '/contacts/' + this.form.contact.id, this.form.contact);
				} else if (this.modal.contact.add) {
					let postParam = this.form.contact;
					postParam.insert_id = true;
					customRequest = this.$http.post('events/' + this.event.id + '/contacts', postParam);
				} else {
					customRequest = new Promise((resolve, reject) => {
						resolve();
					});
				}

				customRequest
					.then(response => {
						if (this.modal.contact.add) {
							this.form.contact.id = response.data.data.id;
							this.event.contacts.push(Object.assign({}, this.form.contact));
						} else if (this.modal.contact.edit) {
							for (let i = 0; i < this.event.contacts.length; i++) {
								if (this.event.contacts[i].id === this.form.contact.id) {
									this.event.contacts[i] = Object.assign({}, this.form.contact);
									break;
								}
							}
						} else if (this.modal.contact.delete) {
							for (let i = 0; i < this.event.contacts.length; i++) {
								if (this.event.contacts[i].id === this.form.contact.id) {
									this.event.contacts.splice(i, 1);
									break;
								}
							}
						}
						this.cancelContactModal();
						this.$toastr.fire({
							toast: true,
							icon: 'success',
							title: response.data.message
						});
					})
					.catch(error => {
						this.$toastr.fire({
							toast: true,
							icon: 'error',
							title: error.response.data.message
						});
					});
			},
			cancelContactModal () {
				this.modal.contact.show = false;
				this.modal.contact.title = '';
				this.modal.contact.edit = false;
				this.modal.contact.add = false;
				this.modal.contact.delete = false;
				this.form.contact.id = '';
				this.form.contact.email = '';
				this.form.contact.company = '';
				this.form.contact.position = '';
				this.form.contact.name = '';
				this.form.contact.phone = '';
				this.form.contact.notes = '';
				this.form.contact.event_notes = '';
			},
			addTask () {
				this.modal.task.add = true;
				this.modal.task.show = true
				this.modal.task.title = 'Add Task';
			},
			editTask (task) {
				this.form.task = JSON.parse(JSON.stringify(task));
				this.modal.task.show = true;
				this.modal.task.title = 'Edit Task';
				this.modal.task.edit = true;
			},
			deleteTask (info) {
				this.form.task.id = info.id;
				this.modal.task.delete = true;
				this.handleTask();
			},
			handleTask () {
				let customRequest = '';
				if (this.modal.task.delete) {
					customRequest = this.$http.delete('events/' + this.event.id + '/tasks/' + this.form.task.id);
				} else if (this.modal.task.edit) {
					let postParam = this.form.task;
					postParam.due_date = moment(postParam.due_date).utc().valueOf();
					customRequest = this.$http.put('events/' + this.event.id + '/tasks/' + this.form.task.id, postParam);
				} else if (this.modal.task.add) {
					let postParam = this.form.task;
					postParam.due_date = moment(postParam.due_date).utc().valueOf();
					postParam.insert_id = true;
					customRequest = this.$http.post('events/' + this.event.id + '/tasks', postParam);
				} else {
					customRequest = new Promise((resolve, reject) => {
						resolve();
					});
				}

				customRequest
					.then(response => {
						if (this.modal.task.add) {
							this.form.task.id = response.data.data.id;
							this.form.task.due_date = moment(this.form.task.due_date).format('MMM DD, YYYY dddd');
							this.event.tasks.push(Object.assign({}, this.form.task));
						} else if (this.modal.task.edit) {
							for (let i = 0; i < this.event.tasks.length; i++) {
								if (this.event.tasks[i].id === this.form.task.id) {
									this.form.task.due_date = moment(this.form.task.due_date).format('MMM DD, YYYY dddd');
									this.event.tasks[i] = Object.assign({}, this.form.task);
									break;
								}
							}
						} else if (this.modal.task.delete) {
							for (let i = 0; i < this.event.tasks.length; i++) {
								if (this.event.tasks[i].id === this.form.task.id) {
									this.event.tasks.splice(i, 1);
									break;
								}
							}
						}
						this.cancelTaskModal();
						this.$toastr.fire({
							toast: true,
							icon: 'success',
							title: response.data.message
						});
					})
					.catch(error => {
						this.$toastr.fire({
							toast: true,
							icon: 'error',
							title: error.response.data.message
						});
					});
			},
			cancelTaskModal () {
				this.modal.task.show = false;
				this.modal.task.title = '';
				this.modal.task.edit = false;
				this.modal.task.add = false;
				this.modal.task.delete = false;
				this.form.task.id = '';
				this.form.task.name = '';
				this.form.task.description = '';
				this.form.task.status = '';
				this.form.task.assignee = '';
				this.form.task.due_date = '';
			},
			fetchArtistStatus (value, type) {
				let returnValue = '';
				let keyToMatch = type === 'key' ? 'text' : 'value';
				let keyToReturn = type === 'key' ? 'value' : 'text';

				for (let i = 0; i < this.artistStatus.length; i++) {
					if (this.artistStatus[i][keyToMatch] === value) {
						returnValue = this.artistStatus[i][keyToReturn];
						break;
					}
				}
				return returnValue;
			},
            fetchArtistHoldPosition (value, type) {
                let returnValue = '';
                let keyToMatch = type === 'key' ? 'text' : 'value';
                let keyToReturn = type === 'key' ? 'value' : 'text';

                for (let i = 0; i < this.artistHoldPosition.length; i++) {
                    if (this.artistHoldPosition[i][keyToMatch] === value) {
                        returnValue = this.artistHoldPosition[i][keyToReturn];
                        break;
                    }
                }
                return returnValue;
            },
			addActivity (type) {
				this.modal.activity.add = true;
				this.modal.activity.show = true
				this.modal.activity.title = 'Add ' + this.$options.filters.capitalize(type) + ' Activity';
				this.form.activity.type = type;
			},
			editActivity (activity) {
				this.form.activity = JSON.parse(JSON.stringify(activity));
				this.modal.activity.show = true;
				this.modal.activity.title = 'Edit ' + this.$options.filters.capitalize(activity .type) + ' Activity';
				this.modal.activity.edit = true;
			},
			deleteActivity (info) {
				this.form.activity.id = info.id;
				this.form.activity.type = info.type;
				this.modal.activity.delete = true;
				this.handleActivity();
			},
			handleActivity () {
				const loader = this.$loading.show();
				let customRequest = '';
				if (this.modal.activity.delete) {
					customRequest = this.$http.delete('events/' + this.event.id + '/activities/' + this.form.activity.id);
				} else if (this.modal.activity.edit) {
					customRequest = this.$http.put('events/' + this.event.id + '/activities/' + this.form.activity.id, this.form.activity);
				} else if (this.modal.activity.add) {
					let postParam = this.form.activity;
					postParam.insert_id = true;
					customRequest = this.$http.post('events/' + this.event.id + '/activities', postParam);
				} else {
					customRequest = new Promise((resolve, reject) => {
						resolve();
					});
				}

				customRequest
					.then(response => {
						if (this.modal.activity.add) {
							let newActivity = JSON.parse(JSON.stringify(this.form.activity));
							newActivity.id = response.data.data.id;
							for (let i = 0; i < this.event.artists.length; i++) {
								if (newActivity.artist_id === this.event.artists[i].id) {
									newActivity.artist = JSON.parse(JSON.stringify(this.event.artists[i]));
									break;
								}
							}

							for (let i = 0; i < this.event.stages.length; i++) {
								if (newActivity.stage_id === this.event.stages[i].id) {
									newActivity.stage = JSON.parse(JSON.stringify(this.event.stages[i]));
									break;
								}
							}
							this.event.activities[this.form.activity.type].push(newActivity);
							if (newActivity.hasOwnProperty('stage')) {
								this.dashboard.values[newActivity.stage.name].push(newActivity);
							}
						} else if (this.modal.activity.edit) {
							for (let i = 0; i < this.event.activities[this.form.activity.type].length; i++) {
								if (this.event.activities[this.form.activity.type][i].id === this.form.activity.id) {
									let editedActivity = Object.assign(
										this.event.activities[this.form.activity.type][i],
										JSON.parse(JSON.stringify(this.form.activity))
									);
									for (let i = 0; i < this.event.artists.length; i++) {
										if (editedActivity.artist_id === this.event.artists[i].id) {
											editedActivity.artist = JSON.parse(JSON.stringify(this.event.artists[i]));
											break;
										}
									}

									for (let i = 0; i < this.event.stages.length; i++) {
										if (editedActivity.stage_id === this.event.stages[i].id) {
											editedActivity.stage = JSON.parse(JSON.stringify(this.event.stages[i]));
											break;
										}
									}
									this.event.activities[this.form.activity.type][i] = editedActivity;
									break;
								}
							}
						} else if (this.modal.activity.delete) {
							for (let i = 0; i < this.event.activities[this.form.activity.type].length; i++) {
								if (this.event.activities[this.form.activity.type][i].id === this.form.activity.id) {
									this.event.activities[this.form.activity.type].splice(i, 1);
									break;
								}
							}
						}
						this.cancelActivityModal();
						this.$toastr.fire({
							toast: true,
							icon: 'success',
							title: response.data.message
						});
					})
					.catch(error => {
						this.$toastr.fire({
							toast: true,
							icon: 'error',
							title: error.response.data.message
						});
					})
					.then(() => {
						loader.hide();
					});
			},
			cancelActivityModal () {
				this.modal.activity.title = '';
				this.modal.activity.show = false;
				this.modal.activity.add = false;
				this.modal.activity.edit = false;
				this.modal.activity.delete = false;
				this.form.activity.id = null;
				this.form.activity.artist_id = null;
				this.form.activity.crew = null;
                this.form.activity.crew_cell_phone = null;
                this.form.activity.crew_radio_channel = null;
                this.form.activity.crew_email = null;
				this.form.activity.start = null;
				this.form.activity.end = null;
				this.form.activity.description = '';
				this.form.activity.type = null;
			},
			addExpense () {
				this.modal.expense.add = true;
				this.modal.expense.show = true
				this.modal.expense.title = 'Add Expense';
			},
			editExpense (expense) {
				this.form.expense = JSON.parse(JSON.stringify(expense));
				this.modal.expense.show = true;
				this.modal.expense.title = 'Edit Expense';
				this.modal.expense.edit = true;
			},
			deleteExpense (expense) {
				this.form.expense.id = expense.id;
				this.modal.expense.delete = true;
				this.handleExpense();
			},
			handleExpense () {
				let customRequest = '';
				if (this.modal.expense.delete) {
					customRequest = this.$http.delete('events/' + this.event.id + '/expenses/' + this.form.expense.id);
				} else if (this.modal.expense.edit) {
					let postParam = this.form.expense;
					customRequest = this.$http.put('events/' + this.event.id + '/expenses/' + this.form.expense.id, postParam);
				} else if (this.modal.expense.add) {
					let postParam = this.form.expense;
					postParam.insert_id = true;
					customRequest = this.$http.post('events/' + this.event.id + '/expenses', postParam);
				} else {
					customRequest = new Promise((resolve, reject) => {
						resolve();
					});
				}

				customRequest
					.then(response => {
						if (this.modal.expense.add) {
							this.event.expenses.push({
								id: response.data.data.id,
								crew: this.form.expense.crew,
								amount: this.form.expense.amount,
								description: this.form.expense.description,
								datetime: this.form.expense.datetime
							});
						} else if (this.modal.expense.edit) {
							for (let i = 0; i < this.event.expenses.length; i++) {
								if (this.event.expenses[i].id === this.form.expense.id) {
									Object.assign(this.event.expenses[i], {
										crew: this.form.expense.crew,
										amount: this.form.expense.amount,
										description: this.form.expense.description,
										datetime: this.form.expense.datetime
									});
									break;
								}
							}
						} else if (this.modal.expense.delete) {
							for (let i = 0; i < this.event.expenses.length; i++) {
								if (this.event.expenses[i].id === this.form.expense.id) {
									this.event.expenses.splice(i, 1);
									break;
								}
							}
						}
						this.cancelExpenseModal();
						this.$toastr.fire({
							toast: true,
							icon: 'success',
							title: response.data.message
						});
					})
					.catch(error => {
						this.$toastr.fire({
							toast: true,
							icon: 'error',
							title: error.response.data.message
						});
					});
			},
			cancelExpenseModal () {
				this.modal.expense.show = false;
				this.modal.expense.title = '';
				this.modal.expense.edit = false;
				this.modal.expense.add = false;
				this.modal.expense.delete = false;
				this.form.expense.id = null;
				this.form.expense.crew = '';
				this.form.expense.amount = 0;
				this.form.expense.description = '';
				this.form.expense.datetime = null;
			},
			addNewStage () {
				window.open(window.location.origin + '/stages/create?event_id=' + this.$route.params.id, '_blank');
			},
			refreshStages () {
				const loader = this.$loading.show();
				this.$http.get('stages?event_id=' + this.$route.params.id)
					.then(response => {
						this.event.stages = response.data.data.data;
					})
					.catch(error => {
						this.$toastr.fire({
							toast: true,
							icon: 'error',
							title: error.response.data.message
						});
					})
					.then(() => {
						loader.hide();
					});
			}
		},
		created() {
			const loader = this.$loading.show();
			this.$http.get('events/' + this.$route.params.id)
				.then(response => {
					this.title = response.data.data.name;
					this.items.push({
						text: this.title,
						active: true
					});
					response.data.data.formattedDate = moment.utc(response.data.data.date).local().format('MMM DD, YYYY dddd');
					this.event = response.data.data;

					let stageActivities = this.event.activities.stage;

					for (let i = 0; i < this.event.stages.length; i++) {
						let totalStageActivities = stageActivities.length;
						let stageName = this.event.stages[i].name;

						if (!this.dashboard.values.hasOwnProperty(this.event.stages[i].name)) {
							this.dashboard.values[stageName] = [];

							for (let j = 0; j < totalStageActivities; j++) {
								if (stageActivities[j].stage.name === stageName) {
									this.dashboard.values[stageName].push(stageActivities[j]);
								}
							}
						}
					}
				})
				.catch(error => {
					this.$router.push({name: 'events-calendar'})
					this.$toastr.fire({
						toast: true,
						icon: 'error',
						title: error.response.data.message
					});
				})
				.then(() => {
					loader.hide();
				});

			this.$http.get('events/' + this.$route.params.id + '/artists/create')
				.then(response => {
					for (let i = 0; i < response.data.data.artist_status.length; i++) {
						this.artistStatus.push({
							text: response.data.data.artist_status[i],
							value: i
						});
					}
                    for (let i = 0; i < response.data.data.artist_hold_position.length; i++) {
                        this.artistHoldPosition.push({
                            text: response.data.data.artist_hold_position[i],
                            value: i
                        });
                    }
				})
				.catch(error => {
					this.$toastr.fire({
						toast: true,
						icon: 'error',
						title: error.response.data.message
					});
				});
		},
		filters: {
			capitalize: function (value) {
				if (!value) return '';
				value = value.toString();
				return value.charAt(0).toUpperCase() + value.slice(1);
			}
		}
	}
</script>

<style scoped>
	.mdi.mdi-map-marker-outline,
	.mdi.mdi-calendar-account-outline {
		color: #6f42c1;
		font-size: xx-large;
	}
	.grey {
		color: grey;
	}
	.autocomplete-results {
		padding: 0;
		margin: 0;
		border: 1px solid #eeeeee;
		height: 120px;
		overflow: auto;
	}
	.autocomplete-result {
		list-style: none;
		text-align: left;
		padding: 4px 2px;
		cursor: pointer;
	}
	.autocomplete-result:hover {
		background-color: #4AAE9B;
		color: white;
	}
	.custom-control.custom-radio {
		display: inline;
	}
	.pull-right {
		float: right;
	}
	.artist_status_text {
		color: #ffffff;
		padding: 3px;
        font-size: 14px;
        /*display: table;*/
	}
    .artist_hold_text {
        color: #ffffff;
        padding: 3px;
        font-size: 14px;
        float: right;
        /*display: table;
        margin-top: 5px;*/
    }
	.activity .card-title {
		padding: 5px 3px;
		color: #ffffff;
		text-align: center;
	}
	.stage-activity .card-title{
		background: green;
	}
	.crew_activity .card-title {
		background: yellow;
		color: #000000;
	}
    .talent_activity1 {
        background-color: green;
        color: #ffffff;
        text-align: center;
        padding: 5px 3px;
    }
    .talent_activity2 {
        background-color: orange;
        color: #ffffff;
        text-align: center;
        padding: 5px 3px;
    }
    .talent_activity3 {
        background-color: grey;
        color: #ffffff;
        text-align: center;
        padding: 5px 3px;
    }
    .other_activity .card-title {
		background: purple;
	}
	.important_notes .card-title {
		background: red;
	}
</style>
