<template>
  <div>
    <b-row class="mb-5">
      <b-col>
        <b-button variant="outline-primary" v-on:click="add">Add Talent</b-button>
      </b-col>
    </b-row>

    <b-row class="mt-3">
      <b-col>
        <b-card style="box-shadow: 1px 1px 8px 0">
          <b-card-title class="talent_activity1">Headliners</b-card-title>
          <b-row class="mt-4">
            <b-col md="4" v-for="headliner in headliners" :key="headliner.id">
              <b-card :title="headliner.title" style="box-shadow: 1px 1px 8px 0">
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
                <hr v-if="headliner.status === 'Challenged By'">
                <p v-if="headliner.status === 'Challenged By'">
                <span>
                  Challenged by Artist : {{ headliner.challenged_by_artist[0]['name'] }}<br>
                  Hours Challenged Hold Expires In : {{ headliner.challenged_hours }}
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
                  <b-card-sub-title class="ml-5" v-for="activity in headliner.activities" :key="activity.stage.id">
                    <b class="font-size-14">{{ activity.stage.name }} </b><br>
                    Start:- {{ activity.start ? formatDate(activity.start, 'hh:mm A') : '' }} <br/>
                    End  :- {{ activity.end ? formatDate(activity.end, 'hh:mm A') : '' }}<br/><br/>
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
                <hr v-if="support.status === 'Challenged By'">
                <p v-if="support.status === 'Challenged By'">
                  <span>Challenged by Artist : {{ support.challenged_by_artist[0]['name'] }}<br> Hours Challenged Hold Expires In : {{ support.challenged_hours }}</span>
                </p>
                <hr>
                <b-card-text>
                  <b-img :src="support.image" class="rounded-circle" width="50px" height="50px"></b-img>
                  <span style="font-size: 16px">{{ support.name }}</span>
                  <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ support.amount }})</span>
                </b-card-text>
                <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                  <b-card-sub-title class="ml-5" v-for="activity in support.activities" :key="activity.stage.id">
                    <b class="font-size-14">{{ activity.stage.name }} </b><br>
                    Start:- {{ activity.start ? formatDate(activity.start, 'hh:mm A') : '' }} <br/>
                    End  :- {{ activity.end ? formatDate(activity.end, 'hh:mm A') : '' }}<br/><br/>
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
                <b-card-header v-if="artist.status === 'Challenged By'">
                  <vue-countdown-timer
                      :start-time="artist.challenged.updated_from"
                      :end-time="artist.challenged.updated_to"
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
                  <span v-if="artist.status === 'Declined' || artist.status === 'Not Available' || artist.status === 'Released By Artist' || artist.status === 'Rescinded By Venue'" class="artist_hold_text" style="background-color:#808080;color:#000000">{{ artist.hold_position }}</span>
                  <span v-else class="artist_hold_text" :style="artist.hold_position_color">{{ artist.hold_position }}</span>
                </b-card-title>
                <hr v-if="artist.status === 'Mutually Agreed Date'">
                <p v-if="artist.status === 'Mutually Agreed Date'">
                  <span>{{ artist.date_notes }}</span>
                </p>
                <hr v-if="artist.status === 'Challenged By'">
                <p v-if="artist.status === 'Challenged By'">
                  <span>
                    Challenged by Artist : {{ artist.challenged.by }}<br>
                    Hours Challenged Hold Expires In : {{ artist.challenged.hours }}
                  </span>
                </p>
                <hr>
                <b-card-text>
                  <b-img :src="artist.image" class="rounded-circle" width="50px" height="50px"></b-img>
                  <span style="font-size: 16px">{{ artist.name }}</span>
                  <span class="ml-1" :style="{fontWeight: 'bold', color: 'royalblue'}">(${{ artist.amount }})</span>
                </b-card-text>
                <b-card-text class="ml-2 mb-4" style="margin-top: -20px;">
                  <b-card-sub-title class="ml-5" v-for="activity in artist.activities" :key="activity.stage.id">
                    <b class="font-size-14">{{ activity.stage.name }} </b><br>
                    Start:- {{ activity.start ? formatDate(activity.start, 'hh:mm A') : '' }} <br/>
                    End  :- {{ activity.end ? formatDate(activity.end, 'hh:mm A') : '' }}<br/><br/>
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
            <b-form-group label-for="agency_phone" label="Agency Phone:">
              <b-form-input
                  id="agency_phone"
                  v-model="form.agency.phone"
                  placeholder="Enter Agency Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="agency_email" label="Agency Email:">
              <b-form-input
                  id="agency_email"
                  v-model="form.agency.email"
                  placeholder="Enter Agency Email"></b-form-input>
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
            <b-form-group label-for="agent_assistant_phone" label="Agent Assistant Phone:">
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
            <b-form-group label-for="manager_phone" label="Manager Phone:">
              <b-form-input
                  id="manager_phone"
                  v-model="form.management_firm.manager_phone"
                  placeholder="Enter Manager Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_email" label="Manger Email:">
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
            <b-form-group label-for="manager_assistant_phone" label="Manager Assistant Phone:">
              <b-form-input
                  id="manager_assistant_phone"
                  v-model="form.management_firm.manager_assistant_phone"
                  placeholder="Enter Manager Assistant Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="manager_assistant_email" label="Manager Assistant Email:">
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
            <b-form-group label-for="publicist_phone" label="Publicist Phone:">
              <b-form-input
                  id="publicist_phone"
                  v-model="form.publicity_firm.publicist_phone"
                  placeholder="Enter Publicist Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_email" label="Publicist Email:">
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
            <b-form-group label-for="publicist_assistant_phone" label="Publicist Assistant Phone:">
              <b-form-input
                  id="publicist_assistant_phone"
                  v-model="form.publicity_firm.publicist_assistant_phone"
                  placeholder="Enter Publicist Assistant Phone"></b-form-input>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label-for="publicist_assistant_email" label="Publicist Assistant Email:">
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
        </b-row>
        <!-- Agency, management, publicity html -->

        <b-row>
          <b-col>
            <b-form-group label="Status" label-for="artist_status">
              <b-form-select v-model="form.status" :options="statuses"></b-form-select>
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
            <b-form-group label-for="challenged_by" label="Challenged by Artist">
              <b-select
                  class=""
                  id="date_notes"
                  v-model="form.challenged_by"
              >
                <option selected="selected">Select challenged by artist</option>
                <option v-for="artist in event.artists" :key="artist.id" :value="artist.id">{{ artist.name }}</option>
              </b-select>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 5">
          <b-col>
            <b-form-group label-for="challenged_hours" label="Hours Challenged Hold Expires In (like: 24,48,72)">
              <b-form-input
                  class="col-3"
                  id="challenged_hours"
                  v-model.number="form.challenged_hours"
                  placeholder="0"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.status === 7">
          <b-col>
            <b-form-group label-for="offer_expiration_date" label="Offer Expiration By">
              <date-picker
                  v-model="form.offer_expiration_date"
                  :first-day-of-week="1"
                  lang="en"
                  confirm
                  value-type="timestamp"
                  format="MMM DD, YYYY dddd"></date-picker>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Hold Position" label-for="artist_hold_position">
              <b-form-select v-model="form.hold_position" :options="holdPositions"></b-form-select>
            </b-form-group>
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
import DatePicker from 'vue2-datepicker';

export default {
  name: "talent-tab",
  components: { VueCountdownTimer, Multiselect, Switches, DatePicker },
  props: {
    event: [Object]
  },
  watch: {
    event: {
      handler: function() {
        this.setData();
      },
      deep: true
    }
  },
  data () {
    return {
      artists: [],
      filteredArtists: [],
      isSearching: false,
      statuses: [
        {
          value: null, text: 'Please select status'
        }
      ],
      holdPositions: [
        {
          value: null, text: 'Please select hold position'
        }
      ],
      statusColor: [],
      holdPositionColor: [],
      modal: this.default('modal'),
      form: this.default('form'),
      selectedRadio: 'agency'
    }
  },
  computed: {
    headliners: function () {
      return this.artists.filter(function (artist) {
        return artist.category === 'headliner';
      }).sort(function(a, b){return a.hold_position_order - b.hold_position_order});
    },
    supports: function () {
      return this.artists.filter(function (artist) {
        return artist.category === 'support';
      }).sort(function(a, b){return a.hold_position_order - b.hold_position_order});
    },
    historical: function () {
      return this.artists.filter(function (artist) {
        return artist.category === 'historical';
      }).sort(function(a, b){return a.hold_position_order - b.hold_position_order});
    }
  },
  methods: {
    setData() {
      let tempActivities = [];
      if (this.event.hasOwnProperty('activities')) {
        tempActivities = cloneDeep(this.event.activities['stage']);
      }
      if (this.event.hasOwnProperty('artists')) {
        this.artists = cloneDeep(this.event.artists).map(function (artist) {
          artist.activities = [];
          for (let i = 0; i < tempActivities.length; i++) {
            if (tempActivities[i].artist_id === artist.id) {
              artist.activities.push(tempActivities[i])
            }
          }
          return artist;
        });
      }
    },
    add() {
      this.modal.show = true;
      this.modal.title = 'Add Artist';
      this.modal.add = true;
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
      this.form.challenged_by = info.challenged_by;
      this.form.challenged_hours = info.challenged_hours;
      this.form.hold_position = this.fetchHoldPosition(info.hold_position, 'key');
      this.form.notes = info.notes;
      this.form.amount = info.amount;

      this.form.agency = cloneDeep(info.agency);
      this.form.management_firm = cloneDeep(info.management_firm);
      this.form.publicity_firm = cloneDeep(info.publicity_firm);
    },
    remove(info) {
      this.form.id = info.id;
      this.modal.delete = true;
      this.handle();
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
      this.modal = this.default('modal');
      this.form = this.default('form');
    },
    handle () {
      let loader = this.$loading.show();
      let customRequest = null;
      if (this.modal.delete) {
        customRequest = this.$http.delete('events/' + this.event.id + '/artists/' + this.form.id);
      } else if (this.modal.edit) {
        let postParam = cloneDeep({
          ...this.form,
          promoter_profit: this.form.promoter_profit_enable ? this.form.promoter_profit : 0
        });
        customRequest = this.$http.put('events/' + this.event.id + '/artists/' + this.form.id.value, postParam);
      } else if (this.modal.add) {
        let postParam = cloneDeep({
          ...this.form,
          promoter_profit: this.form.promoter_profit_enable ? this.form.promoter_profit : 0,
          id: null,
          artist_id: this.form.id.value
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
                    challenged: {
                      by: this.form.challenged_by,
                      hours: this.form.challenged_hours,
                      updated_from: '',
                      updated_to: ''
                    },
                    hold_position: this.fetchHoldPosition(this.form.hold_position, 'value'),
                    notes: this.form.notes,
                    amount: this.form.amount,
                    status_color: this.statusColor[this.fetchStatus(this.form.status, 'value')],
                    hold_position_order: this.form.hold_position,
                    hold_position_color: this.holdPositionColor[this.fetchHoldPosition(this.form.hold_position, 'value')],
                    agency: this.form.agency
                  }
                });
              } else if (this.modal.edit) {
                for (let i = 0; i < this.artists.length; i++) {
                  if (this.artists[i].id === this.form.id.value) {
                    this.$emit('artistEvent', {
                      type: 'update',
                      id: this.form.id.value,
                      data: {
                        type: this.form.type,
                        category: [0,3,4,6,9,10,11].includes(this.form.status) ? 'historical' : this.form.type,
                        promoter_profit: this.promoter_profit_enable ? this.form.promoter_profit : 0,
                        status: this.fetchStatus(this.form.status, 'value'),
                        date_notes: this.form.date_notes,
                        challenged: {
                          by: this.form.challenged_by,
                          hours: this.form.challenged_hours,
                          updated_from: '',
                          updated_to: ''
                        },
                        hold_position: this.fetchHoldPosition(this.form.hold_position, 'value'),
                        notes: this.form.notes,
                        amount: this.form.amount,
                        status_color: this.statusColor[this.fetchStatus(this.form.status, 'value')],
                        hold_position_order: this.form.hold_position,
                        hold_position_color: this.holdPositionColor[this.fetchHoldPosition(this.form.hold_position, 'value')],
                      }
                    });
                    break;
                  }
                }
              } else if (this.modal.delete) {
                this.$emit('artistEvent', {
                  type: 'remove',
                  id: this.form.id
                })
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
            challenged_hours: '',
            hold_position: null,
            amount: 0,
            offer_expiration_date: null,
            agency: {
              name: '',
              phone: '',
              email: '',
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
              publicist_assistant_email: ''
            }
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
      let returnValue = '';
      let keyToMatch = type === 'key' ? 'text' : 'value';
      let keyToReturn = type === 'key' ? 'value' : 'text';

      for (let i = 0; i < this.statuses.length; i++) {
        if (this.statuses[i][keyToMatch] === value) {
          returnValue = this.statuses[i][keyToReturn];
          break;
        }
      }
      return returnValue;
    },
    fetchHoldPosition (value, type) {
      let returnValue = '';
      let keyToMatch = type === 'key' ? 'text' : 'value';
      let keyToReturn = type === 'key' ? 'value' : 'text';

      for (let i = 0; i < this.holdPositions.length; i++) {
        if (this.holdPositions[i][keyToMatch] === value) {
          returnValue = this.holdPositions[i][keyToReturn];
          break;
        }
      }
      return returnValue;
    }
  },
  created() {
    this.$http.get('events/' + this.$route.params.id + '/artists/create')
        .then(response => {
          if (response.data.data.hasOwnProperty('statuses')) {
            for (let i = 0; i < response.data.data.statuses.length; i++) {
              this.statuses.push({
                value: i,
                text: response.data.data.statuses[i]
              });
            }
          }

          if (response.data.data.hasOwnProperty('hold_positions')) {
            for (let i = 0; i < response.data.data.hold_positions.length; i++) {
              this.holdPositions.push({
                text: response.data.data.hold_positions[i],
                value: i
              });
            }
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
        });

    window.setInterval(() => {
      this.count++;
    },800);
  }
}
</script>