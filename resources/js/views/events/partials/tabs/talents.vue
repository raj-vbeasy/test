<template>
  <div>
    <b-row>
      <b-col>
        <b-tabs justified nav-class="nav-tabs-custom" content-class="p-3 text-muted">
          <b-tab>
            <template v-slot:title>
              <span class="d-inline-block d-sm-none">
                <i class="fas fa-home"></i>
              </span>
              <span class="d-none d-sm-inline-block">Summary</span>
            </template>

            <b-row class="mt-3">
              <b-col>
                <b-card class="activity stage-activity"
                        :title="stage.name"
                        v-for="stage in talentSummary"
                        :key="stage.id"
                        style="box-shadow: 1px 1px 8px 0"
                >
                  <b-row class="mt-4">
                    <b-col>
                      <b-tabs justified nav-class="nav-tabs-custom" content-class="p-3 text-muted">
                        <b-tab v-for="(slotObj, idx) in stage.slots" :key="idx">
                          <template v-slot:title>
                            <span class="d-inline-block d-sm-none">
                              <i class="fas fa-home"></i>
                            </span>
                            <span class="d-none d-sm-inline-block">{{ slotObj.formatted }}</span>
                          </template>

                          <b-row>
                            <b-col>
                              <b-list-group>
                                <b-list-group-item
                                    v-for="(artist, index) in slotObj.artists"
                                    class="d-flex justify-content-between align-items-center"
                                    :key="index"
                                    href="javascript:void(0)"
                                    v-on:click="edit(artist)"
                                >
                                  {{ artist.hold_position }} - {{ artist.name }}
                                  <b-img :src="artist.image" rounded="circle" width="50px"></b-img>
                                </b-list-group-item>
                              </b-list-group>
                            </b-col>
                          </b-row>
                        </b-tab>
                      </b-tabs>
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
              <span class="d-none d-sm-inline-block">Management</span>
            </template>

            <b-row class="mb-5">
              <b-col>
                <b-button variant="outline-primary" v-if="initiated" v-on:click="add">Add Talent</b-button>
              </b-col>
            </b-row>

            <b-row class="mt-3">
              <b-col>
                <b-card style="box-shadow: 1px 1px 8px 0">
                  <b-card-title class="talent_activity1">Headliners</b-card-title>
                  <b-row class="mt-4">
                    <b-col md="4" v-for="headliner in headliners" :key="headliner.id">
                      <b-card :title="headliner.title" style="box-shadow: 1px 1px 8px 0">
                        <b-card-header v-if="fetchStatus(headliner.status,'key') === 7">
                          <vue-countdown-timer
                              :start-time="currentUtcDate('YYYY-MM-DD HH:mm:ss')"
                              :end-time="utcTimestamp(headliner.offer_expiration_date)"
                              :interval="1000"
                              :start-label="'Start:'"
                              :end-label="'End:'"
                              label-position="begin"
                              :end-text="'Offer Expired'"
                              :day-txt="'Days'"
                              :hour-txt="'Hours'"
                              :minutes-txt="'Min'"
                              :seconds-txt="'Sec'">
                          </vue-countdown-timer>
                        </b-card-header>
                        <b-card-header v-if="[5, 12].includes(fetchStatus(headliner.status, 'key')) && !!event.challenge">
                          <vue-countdown-timer
                              :start-time="currentUtcDate('YYYY-MM-DD HH:mm:ss')"
                              :end-time="utcTimestamp(event.challenge.end_at)"
                              :interval="1000"
                              :start-label="'Start:'"
                              :end-label="'Challenge Expires In:-'"
                              label-position="begin"
                              :end-text="'Challenge Expired!'"
                              :day-txt="'Days'"
                              :hour-txt="':'"
                              :minutes-txt="':'"
                              :seconds-txt="''">
                          </vue-countdown-timer>
                        </b-card-header>
                        <b-card-title>
                          <span v-if="headliner.status === 'Archived' || headliner.status === 'Released By Artist' || headliner.status === 'Rescinded By Venue'" class="artist_status_text" style="background-color:#ffffff;color:#808080">{{ headliner.status }}</span>
                          <span v-else class="artist_status_text" :style="headliner.status_color">{{ headliner.status }}</span>
                          <span v-if="headliner.status === 'Declined' || headliner.status === 'Not Available' || headliner.status === 'Released By Artist' || headliner.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ headliner.hold_position }}</span>
                          <span v-else class="artist_hold_text" :style="headliner.hold_position_color">{{ headliner.hold_position }}</span>
                        </b-card-title>
                        <hr v-if="headliner.status === 'Mutually Agreed Date' || headliner.status === 'Declined'">
                        <p v-if="headliner.status === 'Mutually Agreed Date' || headliner.status === 'Declined'">
                          <span>{{ headliner.date_notes }}</span>
                        </p>
                        <hr v-if="[5, 12].includes(fetchStatus(headliner.status, 'key'))">
                        <p v-if="[5, 12].includes(fetchStatus(headliner.status, 'key')) && !!event.challenge">
                  <span>
                    Hold position 1 ( {{ event.challenge.to.name }}) is challenged by Hold position 2 ({{ event.challenge.by.name }})
                  </span>
                        </p>
                        <hr>
                        <b-card-text>
                          <b-img :src="headliner.image" class="rounded-circle" width="50px" height="50px"></b-img>
                          <span style="font-size: 16px">{{ headliner.name }}</span>
                          <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ headliner.amount }})</span><br>
                        </b-card-text>
                        <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                          <p class="ml-5">{{ headliner.email }}</p>
                          <b-card-sub-title class="ml-5" v-for="(activity, idx) in headliner.my_activities" :key="activity.stage.id">
                            <b class="font-size-14">{{ activity.stage.name }} </b><br>
                            Time Slots:-
                            <span v-for="(time_slot, tsIdx) in activity.time_slots" :key="tsIdx">
                      {{ formatDate(time_slot.start, 'hh:mm A') }} - {{ formatDate(time_slot.end, 'hh:mm A') }}<span v-if="tsIdx !== activity.time_slots.length - 1">, </span>
                    </span>
                            <br v-if="idx !== headliner.my_activities.length - 1"/>
                            <br v-if="idx !== headliner.my_activities.length - 1"/>
                          </b-card-sub-title>
                          <span class="ml-5">
                  {{ headliner.notes }}
                </span>
                        </b-card-text>
                        <b-button v-on:click="edit(headliner)" variant="outline-primary">Edit</b-button>
                        <b-button v-on:click="remove(headliner)" variant="outline-danger">Delete</b-button>
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
                    <b-col md="4" v-for="support in supports" :key="support.id">
                      <b-card :title="support.title" style="box-shadow: 1px 1px 8px 0">
                        <b-card-header v-if="fetchStatus(support.status,'key') === 7">
                          <vue-countdown-timer
                              :start-time="currentUtcDate('YYYY-MM-DD HH:mm:ss')"
                              :end-time="utcTimestamp(support.offer_expiration_date)"
                              :interval="1000"
                              :start-label="'Start:'"
                              :end-label="'End:'"
                              label-position="begin"
                              :end-text="'Offer Expired'"
                              :day-txt="'Days'"
                              :hour-txt="'Hours'"
                              :minutes-txt="'Min'"
                              :seconds-txt="'Sec'">
                          </vue-countdown-timer>
                        </b-card-header>
                        <b-card-header v-if="[5, 12].includes(fetchStatus(support.status, 'key')) && !!event.challenge">
                          <vue-countdown-timer
                              :start-time="currentUtcDate('YYYY-MM-DD HH:mm:ss')"
                              :end-time="utcTimestamp(event.challenge.end_at)"
                              :interval="1000"
                              :start-label="'Start:'"
                              :end-label="'Challenge Expires In:-'"
                              label-position="begin"
                              :end-text="'Challenge Expired!'"
                              :day-txt="'Days'"
                              :hour-txt="':'"
                              :minutes-txt="':'"
                              :seconds-txt="''">
                          </vue-countdown-timer>
                        </b-card-header>
                        <b-card-title>
                          <span v-if="support.status === 'Archived' || support.status === 'Released By Artist' || support.status === 'Rescinded By Venue'" class="artist_status_text" style="background-color:#ffffff;color:#808080">{{ support.status }}</span>
                          <span v-else class="artist_status_text" :style="support.status_color">{{ support.status }}</span>
                          <span v-if="support.status === 'Declined' || support.status === 'Not Available' || support.status === 'Released By Artist' || support.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ support.hold_position }}</span>
                          <span v-else class="artist_hold_text" :style="support.hold_position_color">{{ support.hold_position }}</span>
                        </b-card-title>
                        <hr v-if="support.status === 'Mutually Agreed Date'">
                        <p v-if="support.status === 'Mutually Agreed Date'">
                          <span>{{ support.date_notes }}</span>
                        </p>
                        <hr v-if="[5,12].includes(fetchStatus(support.status, 'key'))">
                        <p v-if="[5,12].includes(fetchStatus(support.status, 'key')) && !!event.challenge">
                  <span>
                    Hold position 1 ( {{ event.challenge.to.name }}) is challenged by Hold position 2 ({{ event.challenge.by.name }})
                  </span>
                        </p>
                        <hr>
                        <b-card-text>
                          <b-img :src="support.image" class="rounded-circle" width="50px" height="50px"></b-img>
                          <span style="font-size: 16px">{{ support.name }}</span>
                          <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ support.amount }})</span>
                        </b-card-text>
                        <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                          <b-card-sub-title class="ml-5" v-for="(activity, idx) in support.my_activities" :key="activity.stage.id">
                            <b class="font-size-14">{{ activity.stage.name }} </b><br>
                            Time Slots:-
                            <span v-for="(time_slot, tsIdx) in activity.time_slots" :key="tsIdx">
                      {{ formatDate(time_slot.start, 'hh:mm A') }} - {{ formatDate(time_slot.end, 'hh:mm A') }}<span v-if="tsIdx !== activity.time_slots.length - 1">, </span>
                    </span>
                            <br v-if="idx !== support.my_activities.length - 1"/>
                            <br v-if="idx !== support.my_activities.length - 1"/>
                          </b-card-sub-title>
                          <span class="ml-5">{{ support.notes }}</span>
                        </b-card-text>
                        <b-button v-on:click="edit(support)" variant="outline-primary">Edit</b-button>
                        <b-button v-on:click="remove(support)" variant="outline-danger">Delete</b-button>
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
                    <b-col md="4" v-for="artist in historical" :key="artist.id">
                      <b-card :title="artist.title" style="box-shadow: 1px 1px 8px 0">
                        <b-card-title>
                          <span v-if="artist.status === 'Archived' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_status_text" style="background-color:#ffffff;color:#808080">{{ artist.status }}</span>
                          <span v-else class="artist_status_text" :style="artist.status_color">{{ artist.status }}</span>
                          <span v-if="artist.status === 'Declined' || artist.status === 'Not Available' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ artist.hold_position }}</span>
                          <span v-else class="artist_hold_text" :style="artist.hold_position_color">{{ artist.hold_position }}</span>
                        </b-card-title>
                        <hr v-if="artist.status === 'Mutually Agreed Date'">
                        <p v-if="artist.status === 'Mutually Agreed Date'">
                          <span>{{ artist.date_notes }}</span>
                        </p>
                        <hr>
                        <b-card-text>
                          <b-img :src="artist.image" class="rounded-circle" width="50px" height="50px"></b-img>
                          <span style="font-size: 16px">{{ artist.name }}</span>
                          <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ artist.amount }})</span>
                        </b-card-text>
                        <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                          <b-card-sub-title class="ml-5" v-for="(activity,idx) in artist.my_activities" :key="activity.stage.id">
                            <b class="font-size-14">{{ activity.stage.name }} </b><br>
                            Time Slots:-
                            <span v-for="(time_slot, tsIdx) in activity.time_slots" :key="tsIdx">
                      {{ formatDate(time_slot.start, 'hh:mm A') }} - {{ formatDate(time_slot.end, 'hh:mm A') }}<span v-if="tsIdx !== activity.time_slots.length - 1">, </span>
                    </span>
                            <br v-if="idx !== artist.my_activities.length - 1"/>
                            <br v-if="idx !== artist.my_activities.length - 1"/>
                          </b-card-sub-title>
                          <span class="ml-5">{{ artist.notes }}</span>
                        </b-card-text>
                        <b-button v-on:click="edit(artist)" variant="outline-primary">Edit</b-button>
                        <b-button v-on:click="remove(artist)" variant="outline-danger">Delete</b-button>
                      </b-card>
                    </b-col>
                  </b-row>
                </b-card>
              </b-col>
            </b-row>
          </b-tab>
        </b-tabs>
      </b-col>
    </b-row>

    <b-modal
        v-model="modal.show"
        :title="modal.title"
        title-class="text-black font-18"
        body-class="p-3"
        hide-footer
        :no-close-on-backdrop="true"
        :no-close-on-esc="true"
        :hide-header-close="true"
    >
      <b-form @submit.prevent="handle">
        <b-row>
          <b-col>
            <b-form-group label="Name" label-for="artist_name">
              <multiselect
                  id="artist_name"
                  v-model="form.id"
                  :options="filteredArtists"
                  @search-change="search"
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

        <b-row v-if="form.stages_time_slots.length > 0">
          <b-col cols="12">
            <h6>Selected Stages:</h6>
          </b-col>
          <b-col cols="12" v-for="(val, idx) in form.stages_time_slots" :key="idx">
            <p v-if="val.time_slots.length > 0">
              {{ val.stage.name }}:
              <span v-for="(slot, index) in val.time_slots" :key="index">
                {{ formatDate(slot.start, 'hh:mm A') }} - {{ formatDate(slot.end, 'hh:mm A') }}
                <span v-if="index+1 < val.time_slots.length">, </span>
              </span>
            </p>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label-for="talent_stage" label="Stages">
              <b-form-select v-model="selectedStage" :options="stages" @change="showTimeSlotsForStage()"></b-form-select>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="selectedStage !== null">
          <b-col>
            <b-form-group label="Time Slots:">
              <b-form-checkbox-group
                  id="checkbox-group-1"
                  v-model="selectedTimeSlots"
                  :options="timeSlots"
                  name="time_slots"
                  @change="updateTimeSlotsForStage"
              ></b-form-checkbox-group>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label-for="talent_amount" label="Amount">
              <b-form-input
                  class="col-3"
                  id="talent_amount"
                  v-model.number="form.amount"
                  placeholder="0"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Promoter Profit" label-for="promoter_profit_enable">
              <switches
                  v-model="form.promoter_profit_enable"
                  type-bold="false"
                  color="info"
                  class="mt-1"
                  id="promoter_profit_enable"
              ></switches>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.promoter_profit_enable">
          <b-col>
            <b-form-group label-for="promoter_profit" label="Profit">
              <b-form-input
                  class="col-3"
                  id="promoter_profit"
                  v-model.number="form.promoter_profit"
                  placeholder="0%"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Status" label-for="artist_status">
              <b-form-select v-model="form.status" :options="statuses" @input="setChallengeData();setHoldPositions(form.status)"></b-form-select>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 10 || form.status === 11">
          <b-col>
            <b-form-group label-for="cancellation_terms" label="Cancellation Terms">
              <b-form-textarea
                  class=""
                  id="cancellation_terms"
                  v-model="form.cancellation_terms"
                  placeholder="Ex: deposit, full refund or partial refund and Artist and Venue will reconsider Mutually Agreeable Date for 2022-2023"
                  rows="3"
                  max-rows="6"
              ></b-form-textarea>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 5">
          <b-col>
            <h5 style="padding: 5px 0;background-color: yellow">{{ firstHoldArtistName }}</h5>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 12">
          <b-col>
            <h5 style="padding: 5px 0;background-color: yellow">{{ secondHoldArtistName }}</h5>
          </b-col>
        </b-row>

        <b-row v-if="form.type !== 'historical'">
          <b-col>
            <b-form-group label="Talent type" label-for="artist_type">
              <b-form-radio
                  v-model="form.type"
                  name="artist_type"
                  value="headliner">Headliner</b-form-radio>
              <b-form-radio
                  v-model="form.type"
                  name="artist_type"
                  value="support"
                  class="ml-3">Support</b-form-radio>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 3 || form.status === 9">
          <b-col>
            <label v-if="form.status === 3">Mutually Agreed Date Note</label>
            <label v-else>Reason</label>
            <b-form-group label-for="date_notes">
              <b-form-textarea
                  class=""
                  id="date_notes"
                  v-model="form.date_notes"
                  placeholder="Enter something..."
                  rows="3"
                  max-rows="6"
              ></b-form-textarea>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 5">
          <b-col>
            <b-form-group label-for="challenged_hours" label="Hours Challenged Hold Expires In (like: 24,48,72)">
              <b-form-input
                  type="number"
                  class="col-3"
                  id="challenged_hours"
                  v-model.number="form.challenged_hours"
                  placeholder="0"
                  min="0"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 7">
          <b-col>
            <b-form-group label-for="offer_expiration_time" label="Offer Expires In (like: 24,48,72)">
              <b-form-input
                  type="number"
                  class="col-3"
                  id="offer_expiration_time"
                  v-model.number="form.offer_expiration_time"
                  placeholder="24"
                  min="0"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Hold Position" label-for="artist_hold_position">
              <b-form-select v-model="form.hold_position" :options="holdPositions" :disabled="[5,6].includes(form.status)"></b-form-select>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="representativeData.dates.length > 0">
          <b-col>
            <h6>Explore Mutually Agreeable Dates for Future Consideration</h6>
          </b-col>
        </b-row>
        <b-row v-if="representativeData.dates.length > 0">
          <b-col>
            <b-table :fields="representativeDataFields" :items="representativeData.dates"></b-table>
          </b-col>
        </b-row>

        <b-row v-if="representativeData.notes">
          <b-col>
            <p>
              <strong>Artist Representative Notes:- </strong>{{ representativeData.notes }}
            </p>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label-for="notes" label="Notes">
              <b-form-textarea
                  class=""
                  id="notes"
                  v-model="form.notes"
                  placeholder="Enter something..."
                  rows="3"
                  max-rows="6"
              ></b-form-textarea>
            </b-form-group>
          </b-col>
        </b-row>

        <!-- Agency, management, publicity html -->
        <b-row>
          <b-col>
            <b-form-group>
              <b-radio-group v-model="selectedRadio">
                <b-form-radio value="agency">Agency Details</b-form-radio>
                <b-form-radio value="management">Management Details</b-form-radio>
                <b-form-radio value="publicity">Publicity Details</b-form-radio>
              </b-radio-group>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="selectedRadio === 'agency'">
          <b-col cols="12">
            <b-form-group label-for="agency_name" label="Agency Name:">
              <b-form-input id="agency_name" v-model="form.agency.name" placeholder="Enter Agency Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="agent_name" label="Agent Name:">
              <b-form-input id="agent_name" v-model="form.agency.agent_name" placeholder="Enter Agent Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="agent_phone">
              <template slot="label">
                Agent Phone: <a v-if="form.agency.agent_phone" :href="'tel:' + form.agency.agent_phone"><i class="fa fa-phone"></i></a>
              </template>
              <b-form-input
                  id="agent_phone"
                  v-model="form.agency.agent_phone"
                  placeholder="Enter Agent Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="agent_email">
              <template slot="label">
                Agent Email: <a v-if="form.agency.agent_email" :href="'mailto:' + form.agency.agent_email"><i class="fa fa-envelope"></i></a>
              </template>
              <b-form-input
                  id="agent_email"
                  v-model="form.agency.agent_email"
                  placeholder="Enter Agent Email"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="agent_assistant_name" label="Agent Assistant Name:">
              <b-form-input
                  id="agent_assistant_name"
                  v-model="form.agency.agent_assistant_name"
                  placeholder="Enter Agent Assistant Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="agent_assistant_phone">
              <template slot="label">
                Agent Assistant Phone: <a v-if="form.agency.agent_assistant_phone" :href="'tel:' + form.agency.agent_assistant_phone"><i class="fa fa-phone"></i></a>
              </template>
              <b-form-input
                  id="agent_assistant_phone"
                  v-model="form.agency.agent_assistant_phone"
                  placeholder="Enter Agent Assistant Phone"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="selectedRadio === 'management'">
          <b-col cols="12">
            <b-form-group label-for="management_firm_name" label="Management Firm Name:">
              <b-form-input
                  id="management_firm_name"
                  v-model="form.management_firm.name"
                  placeholder="Enter Management Firm Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_name" label="Manager Name:">
              <b-form-input
                  id="manager_name"
                  v-model="form.management_firm.manager_name"
                  placeholder="Enter Manager Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_phone">
              <template slot="label">
                Manager Phone: <a v-if="form.management_firm.manager_phone" :href="'tel:' + form.management_firm.manager_phone"><i class="fa fa-phone"></i></a>
              </template>
              <b-form-input
                  id="manager_phone"
                  v-model="form.management_firm.manager_phone"
                  placeholder="Enter Manager Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_email">
              <template slot="label">
                Manager Email: <a v-if="form.management_firm.manager_email" :href="'mailto:' + form.management_firm.manager_email"><i class="fa fa-envelope"></i></a>
              </template>
              <b-form-input
                  id="manager_email"
                  v-model="form.management_firm.manager_email"
                  placeholder="Enter Manager Email"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_assistant_name" label="Manager Assistant Name:">
              <b-form-input
                  id="manager_assistant_name"
                  v-model="form.management_firm.manager_assistant_name"
                  placeholder="Enter Manager Assistant Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_assistant_phone">
              <template slot="label">
                Manager Assistant Phone: <a v-if="form.management_firm.manager_assistant_phone"
                                            :href="'tel:' + form.management_firm.manager_assistant_phone"><i class="fa fa-phone"></i></a>
              </template>
              <b-form-input
                  id="manager_assistant_phone"
                  v-model="form.management_firm.manager_assistant_phone"
                  placeholder="Enter Manager Assistant Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_assistant_email">
              <template slot="label">
                Manager Assistant Email: <a v-if="form.management_firm.manager_assistant_email"
                                            :href="'mailto:' + form.management_firm.manager_assistant_email"><i class="fa fa-envelope"></i></a>
              </template>
              <b-form-input
                  id="manager_assistant_email"
                  v-model="form.management_firm.manager_assistant_email"
                  placeholder="Enter Manager Assistant Email"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="selectedRadio === 'publicity'">
          <b-col cols="12">
            <b-form-group label-for="publicity_firm_name" label="Publicity Firm Name:">
              <b-form-input
                  id="publicity_firm_name"
                  v-model="form.publicity_firm.name"
                  placeholder="Enter Publicity Firm Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_name" label="Publicist Name:">
              <b-form-input
                  id="publicist_name"
                  v-model="form.publicity_firm.publicist_name"
                  placeholder="Enter Publicist Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_phone">
              <template slot="label">
                Publicist Phone: <a v-if="form.publicity_firm.publicist_phone"
                                            :href="'tel:' + form.publicity_firm.publicist_phone"><i class="fa fa-phone"></i></a>
              </template>
              <b-form-input
                  id="publicist_phone"
                  v-model="form.publicity_firm.publicist_phone"
                  placeholder="Enter Publicist Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_email">
              <template slot="label">
                Publicist Email: <a v-if="form.publicity_firm.publicist_email"
                                    :href="'mailto:' + form.publicity_firm.publicist_email"><i class="fa fa-envelope"></i></a>
              </template>
              <b-form-input
                  id="publicist_email"
                  v-model="form.publicity_firm.publicist_email"
                  placeholder="Enter Publicist Email"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_assistant_name" label="Publicist Assistant Name:">
              <b-form-input
                  id="publicist_assistant_name"
                  v-model="form.publicity_firm.publicist_assistant_name"
                  placeholder="Enter Publicist Assistant Name"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_assistant_phone">
              <template slot="label">
                Publicist Assistant Phone: <a v-if="form.publicity_firm.publicist_assistant_phone"
                                    :href="'tel:' + form.publicity_firm.publicist_assistant_phone"><i class="fa fa-phone"></i></a>
              </template>
              <b-form-input
                  id="publicist_assistant_phone"
                  v-model="form.publicity_firm.publicist_assistant_phone"
                  placeholder="Enter Publicist Assistant Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_assistant_email">
              <template slot="label">
                Publicist Assistant Email: <a v-if="form.publicity_firm.publicist_assistant_email"
                                    :href="'mailto:' + form.publicity_firm.publicist_assistant_email"><i class="fa fa-envelope"></i></a>
              </template>
              <b-form-input
                  id="publicist_assistant_email"
                  v-model="form.publicity_firm.publicist_assistant_email"
                  placeholder="Enter Publicist Assistant Email"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicity_doc" label="Upload Doc:">
              <b-form-file
                  id="publicity_doc"
                  placeholder="Upload Doc"></b-form-file>
            </b-form-group>
          </b-col>

          <!-- Social Links -->
          <b-col cols="12">
            <b-form-group label-for="publicist_facebook" label="Facebook:">
              <b-form-input
                  id="publicist_facebook"
                  v-model="form.publicity_firm.facebook"
                  placeholder="Enter Facebook Link"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_twitter" label="Twitter:">
              <b-form-input
                  id="publicist_twitter"
                  v-model="form.publicity_firm.twitter"
                  placeholder="Enter Twitter Link"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_instagram" label="Instagram:">
              <b-form-input
                  id="publicist_instagram"
                  v-model="form.publicity_firm.instagram"
                  placeholder="Enter Instagram Link"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_website" label="Website:">
              <b-form-input
                  id="publicist_website"
                  v-model="form.publicity_firm.website"
                  placeholder="Enter Website Link"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_apple_music" label="Apple Music:">
              <b-form-input
                  id="publicist_apple_music"
                  v-model="form.publicity_firm.apple_music"
                  placeholder="Enter Apple Music Link"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_spotify" label="Spotify:">
              <b-form-input
                  id="publicist_spotify"
                  v-model="form.publicity_firm.spotify"
                  placeholder="Enter Spotify Link"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_sound_cloud" label="Description:">
              <b-form-textarea
                  id="publicist_sound_cloud"
                  v-model="form.publicity_firm.sound_cloud"
                  placeholder="Enter Description" rows="5"></b-form-textarea>
            </b-form-group>
          </b-col>
          <!-- Social Links -->
        </b-row>
        <!-- Agency, management, publicity html -->

        <b-row class="mb-5">
          <b-col>
            <b-button variant="outline-secondary float-right ml-2" @click="cancel">Cancel</b-button>
            <b-button variant="outline-info float-right" type="submit">Submit</b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
  </div>
</template>

<script>

import { cloneDeep } from 'lodash';
import VueCountdownTimer from 'vuejs-countdown-timer';
import Multiselect from 'vue-multiselect';
import Switches from "vue-switches";
import Vue from 'vue';
import moment from "moment";
Vue.use(VueCountdownTimer);

export default {
  name: "talent-tab",
  components: { Multiselect, Switches },
  props: {
    event: [Object]
  },
  watch: {
    event: {
      handler: function() {
        if (this.initiated) {
          this.setData();
        }
      },
      deep: true
    }
  },
  data () {
    return {
      artists: [],
      filteredArtists: [],
      isSearching: false,
      statuses: [],
      rawStatuses: [],
      holdPositions: [],
      rawHoldPositions: [],
      assignedHoldPositions: [],
      statusColor: [],
      holdPositionColor: [],
      modal: this.default('modal'),
      form: this.default('form'),
      selectedRadio: 'agency',
      representativeDataFields: [
        {
          key: 'month',
          label: 'Month'
        },
        {
          key: 'day',
          label: 'Day of Week'
        },
        {
          key: 'year',
          label: 'Year'
        }
      ],
      representativeData: {
        notes: '',
        dates: []
      },
      initiated: false,
      challengeData: {
        to: {
          name: '',
          id: ''
        },
        by: {
          name: '',
          id: ''
        },
        hours: null,
        timestamp: null
      },
      stages: [],
      rawTimeSlots: [],
      timeSlots: [],
      selectedStage: null,
      selectedTimeSlots: [],
      activities: {}
    }
  },
  computed: {
    headliners: function () {
      return this.artists.filter(function (artist) {
        return artist.type === 'headliner';
      }).sort(function(a, b){return a.hold_position_order - b.hold_position_order});
    },
    supports: function () {
      return this.artists.filter(function (artist) {
        return artist.type === 'support';
      }).sort(function(a, b){return a.hold_position_order - b.hold_position_order});
    },
    historical: function () {
      return this.artists.filter(function (artist) {
        return artist.type === 'historical';
      }).sort(function(a, b){return a.hold_position_order - b.hold_position_order});
    },
    firstHoldArtistName: function () {
      let name = '';
      for (let i = 0; i < this.artists.length; i++) {
        if (this.fetchHoldPosition(this.artists[i].hold_position, 'key') === 2) {
          name = this.artists[i].name
          break;
        }
      }
      return name;
    },
    secondHoldArtistName: function () {
      let name = '';
      for (let i = 0; i < this.artists.length; i++) {
        if (this.fetchHoldPosition(this.artists[i].hold_position, 'key') === 3) {
          name = this.artists[i].name
          break;
        }
      }
      return name;
    },
    talentSummary: function () {
      let summary = [];
      let activities = cloneDeep(this.activities.stage) || [];

      for (let i = 0; i < activities.length; i++) {
        let flag = true;

        for (let j = 0; j < summary.length; j++) {
          if (activities[i].stage.id === summary[j].id) {
            let isTimePresent = false;
            for (let k = 0; k < summary[j].slots.length; k++) {
              if (summary[j].slots[k].time === (this.utcTimestamp(activities[i].start) + ',' + this.utcTimestamp(activities[i].end))) {
                let isArtistPresent = false;
                for (let l = 0; l < summary[j].slots[k].artists.length; l++) {
                  if (summary[j].slots[k].artists[l].id === activities[i].artist_id) {
                    isArtistPresent = true;
                    break;
                  }
                }
                if (isArtistPresent === false) {
                  let tempArtist = this.artists.filter(artist => artist.id === activities[i].artist_id);
                  if (tempArtist.length > 0) {
                    summary[j].slots[k].artists.push(tempArtist[0]);
                  }
                }
                isTimePresent = true;
                break;
              }
            }

            if (isTimePresent === false) {
              summary[j].slots.push({
                time: this.utcTimestamp(activities[i].start) + ',' + this.utcTimestamp(activities[i].end),
                formatted: this.anotherFormat(activities[i].start, 'HH:mm') + '-' + this.anotherFormat(activities[i].end, 'HH:mm'),
                artists: this.artists.filter(artist => artist.id === activities[i].artist_id)
              });
            }

            flag = false;
            break;
          }
        }

        if (flag === true) {
          summary.push({
            ...activities[i].stage,
            slots: [
              {
                time: this.utcTimestamp(activities[i].start) + ',' + this.utcTimestamp(activities[i].end),
                formatted: this.anotherFormat(activities[i].start, 'HH:mm') + '-' + this.anotherFormat(activities[i].end, 'HH:mm'),
                artists: this.artists.filter(artist => artist.id === activities[i].artist_id)
              }
            ]
          });
        }
      }

      return summary;
    }
  },
  methods: {
    setData() {
      if (this.event.hasOwnProperty('artists')) {
        this.artists = cloneDeep(this.event.artists);
      }

      this.stages = [{
        text: 'Select Stage',
        value: null
      }];
      if (this.event.hasOwnProperty('stages')) {
        for (let i = 0; i < this.event.stages.length; i++) {
          this.stages.push({
            text: this.event.stages[i].name,
            value: this.event.stages[i].id
          });
        }
      }

      this.rawTimeSlots = [];
      if (this.event.hasOwnProperty('time_slots')) {
        for (let i = 0; i < this.event.time_slots.length; i++) {
          this.rawTimeSlots.push({
            text: moment.utc(this.event.time_slots[i][0]).local().format('hh:mm A') + ' - ' + moment.utc(this.event.time_slots[i][1]).local().format('hh:mm A'),
            value: this.event.time_slots[i][0] + ',' + this.event.time_slots[i][1]
          });
        }
      }

      if (this.event.hasOwnProperty('activities')) {
        this.activities = cloneDeep(this.event.activities);
      }
    },
    add() {
      this.modal.show = true;
      this.modal.title = 'Add Artist';
      this.modal.add = true;
      this.setStatuses();
      this.setAssignedHoldPositions();
      this.setHoldPositions();
    },
    edit(info) {
      this.modal.show = true;
      this.modal.title = 'Edit Artist';
      this.modal.edit = true;

      this.form.id = {label: info.name, value: info.id};
      this.form.type = info.type;
      this.form.promoter_profit_enable = Number(info.promoter_profit) > 0;
      this.form.promoter_profit = Number(info.promoter_profit);
      this.form.status = this.fetchStatus(info.status, 'key');
      this.form.date_notes = info.date_notes;
      if (info.challenged) {
        this.form.challenged_by = info.challenged.by;
        this.form.challenged_hours = info.challenged.hours;
      }
      this.form.hold_position = this.fetchHoldPosition(info.hold_position, 'key');
      this.form.notes = info.notes;
      this.form.amount = info.amount;

      this.form.agency = cloneDeep(info.agency);
      this.form.management_firm = cloneDeep(info.management_firm);
      this.form.publicity_firm = cloneDeep(info.publicity_firm);

      this.representativeData = cloneDeep(info.artist_representative_mad);

      this.form.cancellation_terms = info.cancellation_terms;
      this.form.stages_time_slots = cloneDeep(info.my_activities);
      this.setStatuses();
      this.setAssignedHoldPositions();
      this.setHoldPositions(this.form.status);
    },
    remove(info) {
      this.form.id = info.id;
      this.modal.delete = true;
      this.$swal.fire({
        text: 'You want to delete this artist?',
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.isConfirmed) {
          this.handle();
        }
      });
    },
    search(name) {
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
    cancel() {
      this.filteredArtists = [];
      this.modal = this.default('modal');
      this.form = this.default('form');
      this.representativeData = cloneDeep({
        notes: '',
        dates: []
      });
      this.selectedStage = null;
      this.selectedTimeSlots = [];
    },
    handle () {
      let params = {
        title: '',
        text: 'You have changed the Status and/or the artist\'s Hold position. Do you want to send an email to update the artist\'s representative?',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
      };
      if (this.form.status === 11) {
        params = {
          icon: 'info',
          showCancelButton: false,
          title: '',
          text: 'This status is for emergency purposes only such as event cancellation, postponement, facility disasters, artist sickness or unforeseen circumstances. A custom email needs to be drafted.',
          confirmButtonText: 'Okay'
        };
      }

      this.$swal.fire(params).then((result) => {
        this.save(result.isConfirmed);
      });
    },
    default (type) {
      let result = {};
      switch (type) {
        case 'form':
          result = {
            id: '',
            type: 'headliner',
            promoter_profit_enable: false,
            promoter_profit: 0,
            status: null,
            date_notes: '',
            challenged_by: '',
            challenged_hours: 0,
            hold_position: null,
            amount: 0,
            offer_expiration_time: 0,
            agency: {
              name: '',
              agent_name: '',
              agent_phone: '',
              agent_email: '',
              agent_assistant_name: '',
              agent_assistant_phone: ''
            },
            management_firm: {
              name: '',
              manager_name: '',
              manager_phone: '',
              manager_email: '',
              manager_assistant_name: '',
              manager_assistant_phone: '',
              manager_assistant_email: ''
            },
            publicity_firm: {
              name: '',
              publicist_name: '',
              publicist_phone: '',
              publicist_email: '',
              publicist_assistant_name: '',
              publicist_assistant_phone: '',
              publicist_assistant_email: '',
              facebook: "",
              twitter: "",
              instagram: "",
              website: "",
              apple_music: "",
              spotify: "",
              sound_cloud: ""
            },
            cancellation_terms: '',
            stages_time_slots: []
          };
          break;
        case 'modal':
          result = {
            show: false,
            title: '',
            add: false,
            edit: false,
            delete: false
          };
          break;
      }
      return result;
    },
    fetchStatus (value, type) {
      if (type === 'key') {
        for (let i = 0; i < this.rawStatuses.length; i++) {
          if (this.rawStatuses[i] === value) {
            return i;
          }
        }
      } else {
        return this.rawStatuses[value];
      }
    },
    fetchHoldPosition (value, type) {
      if (type === 'key') {
        for (let i = 0; i < this.rawHoldPositions.length; i++) {
          if (this.rawHoldPositions[i] === value) {
            return i;
          }
        }
      } else {
        return this.rawHoldPositions[value];
      }
    },
    save (sendEmail = false) {
      let loader = this.$loading.show();
      let customRequest = null;
      if (this.modal.delete) {
        customRequest = this.$http.delete('events/' + this.event.id + '/artists/' + this.form.id);
      } else if (this.modal.edit) {
        let postParam = cloneDeep({
          ...this.form,
          promoter_profit: this.form.promoter_profit_enable ? this.form.promoter_profit : 0,
          send_email: sendEmail
        });
        customRequest = this.$http.put('events/' + this.event.id + '/artists/' + this.form.id.value, postParam);
      } else if (this.modal.add) {
        let postParam = cloneDeep({
          ...this.form,
          promoter_profit: this.form.promoter_profit_enable ? this.form.promoter_profit : 0,
          id: null,
          artist_id: this.form.id.value,
          send_email: sendEmail
        });
        customRequest = this.$http.post('events/' + this.event.id + '/artists', postParam);
      }

      if (customRequest !== null) {
        customRequest
            .then(response => {
              if (this.modal.add) {
                this.$emit('artistEvent', {
                  type: 'add',
                  data: {
                    id: this.form.id.value,
                    name: this.form.id.label,
                    image: this.form.id.image,
                    type: this.form.type,
                    category: [0,3,4,6,9,10,11].includes(this.form.status) ? 'historical' : this.form.type,
                    promoter_profit: this.form.promoter_profit_enable ? this.form.promoter_profit : 0,
                    status: this.fetchStatus(this.form.status, 'value'),
                    date_notes: this.form.date_notes,
                    hold_position: this.fetchHoldPosition(this.form.hold_position, 'value'),
                    notes: this.form.notes,
                    amount: this.form.amount,
                    status_color: this.statusColor[this.fetchStatus(this.form.status, 'value')],
                    hold_position_order: this.form.hold_position,
                    hold_position_color: this.holdPositionColor[this.fetchHoldPosition(this.form.hold_position, 'value')],
                    agency: this.form.agency,
                    management_firm: this.form.management_firm,
                    publicity_firm: this.form.publicity_firm,
                    artist_representative_mad: {'dates': [], 'notes': ''},
                    my_activities: this.form.stages_time_slots
                  }
                });
              } else if (this.modal.edit) {
                let oldPosition = null,
                    updateArtist = false;
                for (let i = 0; i < this.artists.length; i++) {
                  if (this.artists[i].id === this.form.id.value) {
                    // Update other artists hold positions
                    oldPosition = this.fetchHoldPosition(this.artists[i].hold_position, 'key');

                    if (this.fetchStatus(this.artists[i].status, 'key') === 5) {
                      let firstHoldPosArtist = this.artists.find(val => {
                        return this.fetchHoldPosition(val.hold_position, 'key') === 2;
                      });

                      this.$emit('artistEvent', {
                        type: 'update',
                        id: firstHoldPosArtist.id,
                        data: {
                          status: this.fetchStatus(12, 'value'),
                          status_color: this.statusColor[this.fetchStatus(12, 'value')]
                        }
                      });

                      this.$emit('eventUpdate', {
                        challenge: {
                          to: {id: firstHoldPosArtist.id, name: firstHoldPosArtist.name},
                          by: {id: this.artists[i].id, name: this.artists[i].name},
                          end_at: moment.utc().add(this.form.challenged_hours, 'hours').format('YYYY-MM-DD HH:mm:ss')
                        }
                      });
                    }

                    this.$emit('artistEvent', {
                      type: 'update',
                      id: this.form.id.value,
                      data: {
                        type: this.form.type,
                        category: [0,3,4,6,9,10,11].includes(this.form.status) ? 'historical' : this.form.type,
                        promoter_profit: this.promoter_profit_enable ? this.form.promoter_profit : 0,
                        status: this.fetchStatus(this.form.status, 'value'),
                        date_notes: this.form.date_notes,
                        hold_position: this.fetchHoldPosition(this.form.hold_position, 'value'),
                        notes: this.form.notes,
                        amount: this.form.amount,
                        status_color: this.statusColor[this.fetchStatus(this.form.status, 'value')],
                        hold_position_order: this.form.hold_position,
                        hold_position_color: this.holdPositionColor[this.fetchHoldPosition(this.form.hold_position, 'value')],
                        agency: this.form.agency,
                        management_firm: this.form.management_firm,
                        publicity_firm: this.form.publicity_firm,
                        offer_expiration_date: this.form.status === 7 ? moment.utc().add(this.form.offer_expiration_time, 'hours').format('YYYY-MM-DD HH:mm:ss') : null,
                        cancellation_terms: this.form.cancellation_terms,
                        my_activities: this.form.stages_time_slots
                      }
                    });

                    if ([2,3,4,5,6].includes(oldPosition)) {
                      if (oldPosition !== this.form.hold_position) {
                        updateArtist = true;
                      }
                    }
                    break;
                  }
                }

                if (updateArtist === true) {
                  let posToUpdate = [];
                  for (let i = 6; i > oldPosition; i--) {
                    posToUpdate.push(i);
                  }

                  for (let i = 0; i < this.artists.length; i++) {
                    let currPos = this.fetchHoldPosition(this.artists[i].hold_position, 'key');
                    if ((this.artists[i].id !== this.form.id.value) && posToUpdate.includes(currPos) && (currPos > oldPosition)) {
                      let posName = this.fetchHoldPosition(currPos - 1, 'value')
                      this.$emit('artistEvent', {
                        type: 'update',
                        id: this.artists[i].id,
                        data: {
                          hold_position: posName,
                          hold_position_order: currPos - 1,
                          hold_position_color: this.holdPositionColor[posName],
                        }
                      });
                    }
                  }
                }
              } else if (this.modal.delete) {
                let oldPosition = null,
                    updateArtist = false;
                for (let i = 0; i < this.artists.length; i++) {
                  if (this.artists[i].id === this.form.id) {
                    // Update other artists hold positions
                    oldPosition = this.fetchHoldPosition(this.artists[i].hold_position, 'key');
                    if ([2,3,4,5,6].includes(oldPosition)) {
                      updateArtist = true;
                    }
                    break;
                  }
                }

                if (updateArtist === true) {
                  let posToUpdate = [];
                  for (let i = 6; i > oldPosition; i--) {
                    posToUpdate.push(i);
                  }

                  for (let i = 0; i < this.artists.length; i++) {
                    let currPos = this.fetchHoldPosition(this.artists[i].hold_position, 'key');
                    if ((this.artists[i].id !== this.form.id) && posToUpdate.includes(currPos) && (currPos > oldPosition)) {
                      let posName = this.fetchHoldPosition(currPos - 1, 'value')
                      this.$emit('artistEvent', {
                        type: 'update',
                        id: this.artists[i].id,
                        data: {
                          hold_position: posName,
                          hold_position_order: currPos - 1,
                          hold_position_color: this.holdPositionColor[posName],
                        }
                      });
                    }
                  }
                }

                this.$emit('artistEvent', {
                  type: 'remove',
                  id: this.form.id
                });
              }
              this.cancel();
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
            }).then(() => {loader.hide()});
      } else {
        loader.hide();
      }
    },
    setHoldPositions (status = null) {
      if (status === 6) {
        return;
      }
      if (this.form.id === '') {
        this.form.hold_position = null;
      }
      this.holdPositions = [{
        value: null, text: 'Please select hold position'
      }];
      let hidePositions = [];

      switch (status) {
        case 0:
          hidePositions.push(1,2,3,4,5,6,7);
          this.form.type = 'headliner';
          break;
        case 1:
          hidePositions.push(1,2,3,4,5,6,7);
          this.form.type = 'historical';
          break;
        case 2:
          hidePositions.push(1,7, ...this.assignedHoldPositions);
          this.form.type = 'headliner';
          break;
        case 3:
          hidePositions.push(2,3,4,5,6);
          this.form.type = 'historical';
          break;
        case 4:
          hidePositions.push(1,2,3,4,5,6);
          this.form.type = 'historical';
          break;
        case 5:
          hidePositions.push(0,1,4,5,6,7);
          this.form.type = 'headliner';
          break;
        case 6:
          hidePositions.push(1);
          this.form.type = 'historical';
          break;
        case 7:
          hidePositions.push(0,2,3,4,5,6,7);
          this.form.type = 'headliner';
          break;
        case 8:
          hidePositions.push(0,2,3,4,5,6,7);
          this.form.type = 'headliner';
          break;
        case 9:
          hidePositions.push(2,3,4,5,6);
          this.form.type = 'historical';
          break;
        case 10:
          hidePositions.push(1,2,3,4,5,6);
          this.form.type = 'historical';
          break;
        case 11:
          hidePositions.push(0,2,3,4,5,6,7);
          this.form.type = 'historical';
          break;
        default:
          if (this.assignedHoldPositions.length > 0) {
            hidePositions.push(...this.assignedHoldPositions);
          }
          break;
      }

      let selectionExists = false;

      for (let i = 0; i < this.rawHoldPositions.length; i++) {
        if ((hidePositions.length === 0) || !hidePositions.includes(i)) {
          this.holdPositions.push({
            value: i,
            text: this.rawHoldPositions[i]
          });
          if (i === this.form.hold_position) {
            selectionExists = true;
          }
        }
      }
      if (selectionExists === false) {
        this.form.hold_position = null;
      }
    },
    setAssignedHoldPositions () {
      this.assignedHoldPositions = [];
      let artistId = this.form.id !== '' ? this.form.id.value : '';
      for (let i = 0; i < this.artists.length; i++) {
        if (artistId !== this.artists[i].id) {
          this.assignedHoldPositions.push(this.fetchHoldPosition(this.artists[i].hold_position, 'key'));
        }
      }
    },
    setStatuses () {
      this.statuses = [{
        value: null, text: 'Please select status'
      }];

      let firstHoldPresent = false;
      for (let i = 0; i < this.artists.length; i++) {
        if (this.fetchHoldPosition(this.artists[i].hold_position, 'key') === 2) {
          firstHoldPresent = true;
        }
      }

      for (let i = 0; i < this.rawStatuses.length; i++) {
        let canPush = false;
        if (this.form.status === i) {
          canPush = true;
        } else if (i === 12 && this.modal.edit === true && this.form.status === 12) {
          canPush = true;
        } else if ((i !== 12) && ((i !== 5) || (firstHoldPresent && (this.form.hold_position === 3)))) {
          canPush = true;
        }

        if (canPush === true) {
          this.statuses.push({
            value: i,
            text: this.rawStatuses[i]
          });
        }
      }
    },
    setChallengeData () {
      if (this.event.challenge === null) {
        this.challengeData = cloneDeep(this.event.challenge);
      } else {
        for (let i = 0; i < this.artists.length; i++) {
          let tempPos = this.fetchHoldPosition(this.artists[i].status, 'key');
          if (tempPos === 2) {
            // this.challengeData
          }
        }
      }
      // this.challengeData;
    },
    async updateTimeSlotsForStage () {
      await this.$nextTick();
      let idx = this.form.stages_time_slots.findIndex(val => {
        return val.stage.id === this.selectedStage;
      });

      let timeSlots = [];
      for (let i = 0; i < this.selectedTimeSlots.length; i++) {
        let tempSlots = this.selectedTimeSlots[i].split(',');
        timeSlots.push({
          start: Number(tempSlots[0]),
          end: Number(tempSlots[1])
        })
      }

      if ((timeSlots.length === 0) && (idx > -1)) {
        this.form.stages_time_slots.splice(idx, 1);
      } else {
        if (idx === -1) {
          let tempStage = this.stages.find(stage => {
            return stage.value === this.selectedStage;
          });
          this.form.stages_time_slots.push({
            stage: {
              id: tempStage.value,
              name: tempStage.text
            },
            time_slots: cloneDeep(timeSlots)
          });
        } else {
          this.form.stages_time_slots[idx].time_slots = cloneDeep(timeSlots);
        }
      }
    },
    async showTimeSlotsForStage () {
      await this.$nextTick();
      this.timeSlots = [];
      this.selectedTimeSlots = [];

      for (let i = 0; i < this.rawTimeSlots.length; i++) {
        let flag = true;

        for (let j = 0; j < this.form.stages_time_slots.length; j++) {
          let isSameStage = this.form.stages_time_slots[j].stage.id === this.selectedStage;

          for (let k = 0; k < this.form.stages_time_slots[j].time_slots.length; k++) {
            let timeslotStr = this.form.stages_time_slots[j].time_slots[k].start + ',' + this.form.stages_time_slots[j].time_slots[k].end;

            if (this.rawTimeSlots[i].value === timeslotStr) {
              if (isSameStage === true) {
                this.selectedTimeSlots.push(this.rawTimeSlots[i].value);
              } else {
                flag = false;
              }
            }
          }
        }

        if (flag === true) {
          this.timeSlots.push(cloneDeep(this.rawTimeSlots[i]));
        }
      }
    }
  },
  created() {
    this.$http.get('events/' + this.$route.params.id + '/artists/create')
        .then(response => {
          if (response.data.data.hasOwnProperty('statuses')) {
            this.rawStatuses = cloneDeep(response.data.data.statuses);
          }

          if (response.data.data.hasOwnProperty('hold_positions')) {
            this.rawHoldPositions = cloneDeep(response.data.data.hold_positions);
          }

          if (response.data.data.hasOwnProperty('status_colors')) {
            this.statusColor = response.data.data.status_colors;
          }

          if (response.data.data.hasOwnProperty('hold_positions_colors')) {
            this.holdPositionColor = response.data.data.hold_positions_colors;
          }
        })
        .catch(error => {
          this.$toastr.fire({
            toast: true,
            icon: 'error',
            title: error.response.data.message
          });
        })
        .then(() => {
          this.initiated = true;
          this.setData();
        });
  }
}
</script>