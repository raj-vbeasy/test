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
            <b-row>
              <b-col md="4">
                <b-form-group>
                  <b-form-input
                    id="search-calendar"
                    v-model="event_search"
                    type="text"
                    class="form-control"
                    placeholder="Search by Artist name, Event name, Location"
                  />
                </b-form-group>
              </b-col>
              <b-col md="1">
                <b-button
                  variant="outline-info float-right"
                  @click="searchEvents"
                >
                  Search
                </b-button>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <div class="app-calendar">
                  <FullCalendar
                    ref="eventCalendar"
                    :options="calendarOptions"
                  />
                </div>
              </b-col>
            </b-row>
          </b-card-body>
        </b-card>
      </b-col>
    </b-row>

    <!-- New Event Modal -->
    <b-modal
      v-model="showModal"
      :title="formTitle"
      title-class="text-black font-18"
      body-class="p-3"
      hide-footer
      :no-close-on-backdrop="true"
      :no-close-on-esc="true"
      :hide-header-close="true"
    >
      <b-form @submit.prevent="handleEvent">
        <b-row>
          <b-col>
            <b-form-group
              id="status-group"
              label-for="status"
            >
              <b-button-group class="btn-group-toggle mt-2 mt-xl-0">
                <label
                  class="btn btn-outline-info"
                  :class="event.status === 'hold' ? 'active' : ''"
                >
                  <input
                    id="hold-status"
                    v-model="event.status"
                    type="radio"
                    name="status"
                    value="hold"
                    checked
                  > Hold
                </label>

                <label
                  class="btn btn-outline-info"
                  :class="event.status === 'confirmed' ? 'active' : ''"
                >
                  <input
                    id="confirmed-status"
                    v-model="event.status"
                    type="radio"
                    name="status"
                    value="confirmed"
                  > Confirmed
                </label>
              </b-button-group>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <b-form-group
              id="outside-promoter-group"
            >
              <b-form-checkbox
                v-model="event.promoter.outside"
                switch
              >
                <label>Outside Promoter</label>
              </b-form-checkbox>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row :class="event.promoter.outside === true ? '' : 'd-none'">
          <b-col>
            <b-form-group
              id="promoter-group"
              label="Promoter Name"
              label-for="promoter_name"
            >
              <b-form-input
                id="agent_organization_name"
                v-model.trim="event.promoter.name"
                placeholder="Promoter Name"
              />
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group
              id="name-group"
              label="Event Name"
              label-for="event_name"
            >
              <b-form-input
                id="event_name"
                v-model.trim="event.name"
                placeholder="Event Name"
              />
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group
              id="event-email-group"
              label="Email"
              label-for="event_email"
            >
              <b-form-input
                id="event_email"
                v-model.trim="event.email"
                placeholder="Email"
              />
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="11">
            <b-form-group
              id="performance-location-group"
              label="Performance Location"
              label-for="performance-location"
            >
              <multiselect
                id="performance-location"
                v-model.trim="event.performance_location_id"
                :options="performanceLocationsForSelect"
                label="label"
                track-by="value"
                :loading="isLocationLoading"
                @input="populateStage"
              >
                <template #beforeList>
                  <li class="multiselect-add-new">
                    <a
                      href="/performance-locations/create"
                      target="_blank"
                    >Add New Location</a>
                  </li>
                </template>
              </multiselect>
            </b-form-group>
          </b-col>
          <b-col cols="1">
            <a
              href="javascript:void(0)"
              style="font-size: 25px;line-height: 80px;"
              @click="fetchEventFormDetails('performance locations', true)"
            >
              <i class="mdi mdi-refresh" />
            </a>
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="11">
            <b-form-group
              id="stage-group"
              label="Stage"
              label-for="stage"
            >
              <multiselect
                id="stage"
                v-model.trim="event.stages"
                :options="stagesForSelect"
                label="label"
                track-by="value"
                :multiple="true"
                :loading="isStagesLoading"
                :hide-selected="true"
              >
                <template #beforeList>
                  <li class="multiselect-add-new">
                    <a
                      href="/stages/create"
                      target="_blank"
                    >Add New Stage</a>
                  </li>
                </template>
              </multiselect>
            </b-form-group>
          </b-col>
          <b-col cols="1">
            <a
              href="javascript:void(0)"
              style="font-size: 25px;line-height: 80px;"
              @click="fetchEventFormDetails('stages', true)"
            >
              <i class="mdi mdi-refresh" />
            </a>
          </b-col>
        </b-row>

        <b-row
          v-for="idx in total_time_slots"
          :key="idx"
        >
          <b-col cols="10">
            <b-form-group label="Time Slot">
              <date-picker
                v-model="event.time_slots[idx - 1]"
                :range="true"
                type="time"
                lang="en"
                confirm
                :show-time-header="true"
                time-title-format="hh:mm A"
                format="hh:mm A"
                :show-second="false"
                value-type="timestamp"
              />
            </b-form-group>
          </b-col>
          <b-col cols="2">
            <a
              v-show="idx === total_time_slots"
              href="javascript:void(0)"
              class="fas fa-minus-circle"
              style="font-size: 25px;line-height: 80px;"
              @click="total_time_slots--"
            />
            <a
              v-show="idx === total_time_slots && total_time_slots <= 7"
              href="javascript:void(0)"
              class="fas fa-plus-circle"
              style="font-size: 25px;line-height: 80px;"
              @click="total_time_slots++"
            />
          </b-col>
        </b-row>

        <b-row class="mb-5">
          <b-col>
            <b-button
              variant="outline-secondary float-right ml-2"
              @click="cancelEventForm"
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
    </b-modal>
  </Layout>
</template>

<script>
import Layout from "@/views/layouts/main";
import PageHeader from "@/components/page-header";
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import listPlugin from "@fullcalendar/list";
import appConfig from "@/app.config.json";
import Multiselect from "vue-multiselect";
import moment from "moment";
import "moment-timezone";
import DatePicker from "vue2-datepicker";
import {cloneDeep} from "lodash";

export default {
  name: "EventCalendar",
  components: { FullCalendar, Layout, PageHeader, Multiselect, DatePicker },
  page: {
    title: "Events",
    meta: [{ name: "description", content: appConfig.description }]
  },
  data () {
    return {
      title: "Events",
      items: [
        {
          text: "Dashboard",
          href: "/"
        },
        {
          text: "Events",
          active: true
        }
      ],
      calendarOptions: {
        initialView: "dayGridMonth",
        plugins: [
          dayGridPlugin,
          interactionPlugin,
          bootstrapPlugin,
          timeGridPlugin,
          listPlugin
        ],
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay,listYear"
        },
        editable: true,
        droppable: true,
        events: this.fetchEvents,
        weekends: true,
        themeSystem: "bootstrap",
        views: {
          listYear: {
            buttonText: "Year"
          }
        },
        eventDrop: this.dropEvent,
        dateClick: this.addEvent,
        eventClick: this.eventClick
      },
      calendarEvents: [],
      showModal: false,
      eventModal: false,
      event: {
        id: null,
        status: "hold",
        promoter: {
          outside: false,
          name: ""
        },
        name: "",
        email: "",
        performance_location_id: "",
        primary_contact: {
          email: "",
          company: "",
          position: "",
          name: "",
          phone: "",
          notes: ""
        },
        stages: [],
        date: "",
        time_slots: []
      },
      editing: false,
      performanceLocations: [],
      performanceLocationsForSelect: [],
      stagesForSelect: [],
      submitted: false,
      formTitle: "",
      isLocationLoading: false,
      isStagesLoading: false,
      total_time_slots: 1,
      event_search: ""
    };
  },
  created () {
    this.fetchEventFormDetails();
  },
  methods: {
    addEvent (info) {
      console.log(info);
      this.event.date = moment(info.date).utc().valueOf();
      this.formTitle = "Add New Event";
      this.showModal = true;
    },
    eventClick (info) {
      if (info.event.extendedProps.status === "confirmed") {
        this.$router.push({name: "event-dashboard", params: { id: info.event.id }});
      } else {
        this.formTitle = "Edit Event";
        this.event.status = info.event.extendedProps.status;
        this.event.promoter = {
          outside: info.event.extendedProps.promoter !== "",
          name: info.event.extendedProps.promoter
        };
        this.event.name = info.event.title;
        this.event.email = info.event.extendedProps.email;
        this.event.performance_location_id = {
          value: info.event.extendedProps.performance_location.id,
          label: info.event.extendedProps.performance_location.name
        };
        let totalStages = info.event.extendedProps.stages.length;
        this.event.stages = [];
        for (let i = 0; i < totalStages; i++) {
          this.event.stages.push({
            value: info.event.extendedProps.stages[i].id,
            label: info.event.extendedProps.stages[i].name
          });
        }
        this.event.date = moment(info.event.start).utc().valueOf();
        this.event.id = info.event.id;

        this.total_time_slots = info.event.extendedProps.time_slots.length;
        for (let i = 0; i < this.total_time_slots; i++) {
          this.event.time_slots.push([
            moment.utc(info.event.extendedProps.time_slots[i].start, "HH:mm:ss").valueOf(),
            moment.utc(info.event.extendedProps.time_slots[i].end, "HH:mm:ss").valueOf()
          ]);
        }
        this.showModal = true;
        this.editing = true;
      }
    },
    handleEvent () {
      this.submitted = true;
      const loader = this.$loading.show();
      let formData = {};
      for (let key in this.event) {
        if (this.event[key]) {
          if (key === "stages") {
            formData[key] = [];
            for (let i = 0; i < this.event[key].length; i++) {
              formData[key].push(this.event[key][i].value);
            }
          } else if (key === "performance_location_id") {
            formData[key] = this.event[key].value;
          } else if (key === "promoter") {
            if (this.event[key].outside === true) {
              formData[key] = this.event[key].name;
            }
          } else if (key === "time_slots") {
            formData[key] = [];
            for (let i = 0; i < this.event.time_slots.length; i++) {
              formData[key].push(this.event.time_slots[i]);
            }
          } else {
            formData[key] = this.event[key];
          }
        }
      }

      let httpRequest = "";
      if (this.editing === true) {
        httpRequest = this.$http.put("events/" + this.event.id, formData);
      } else {
        httpRequest = this.$http.post("events", formData);
      }
      httpRequest
        .then(response => {
          this.$toastr.fire({
            toast: true,
            icon: "success",
            title: response.data.message
          });
          (this.$refs.eventCalendar.getApi()).refetchEvents();
          this.cancelEventForm();
        })
        .catch(error => {
          this.$toastr.fire({
            toast: true,
            icon: "error",
            title: error.response.data.message
          });
        })
        .then(() => {
          this.submitted = false;
          this.editing = false;
          loader.hide();
        });
    },
    fetchEvents (evt, success, error) {
      const loader = this.$loading.show();
      const url = "events?start=" + evt.start.getTime() + "&end=" + evt.end.getTime() + "&search=" + this.event_search;
      this.$http.get(url)
        .then(response => {
          let events = [];
          if (response.data.data.data.length > 0) {
            for (let i = 0; i < response.data.data.data.length; i++) {
              events.push({
                id: response.data.data.data[i].id,
                start: moment.utc(response.data.data.data[i].date).local().format("YYYY-MM-DD"),
                title: response.data.data.data[i].name,
                allDay: true,
                editable: response.data.data.data[i].status === "hold",
                backgroundColor: response.data.data.data[i].status === "hold" ? "blue" : "green",
                extendedProps: {
                  status: response.data.data.data[i].status,
                  stages: cloneDeep(response.data.data.data[i].stages),
                  performance_location: cloneDeep(response.data.data.data[i].performance_location),
                  email: response.data.data.data[i].email,
                  promoter: response.data.data.data[i].promoter,
                  time_slots: cloneDeep(response.data.data.data[i].time_slots)
                }
              });
            }
          }
          success(events);
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
    populateStage (input) {
      this.isStagesLoading = true;
      this.event.stages = [];
      for (let i = 0; i < this.performanceLocations.length; i++) {
        if (this.performanceLocations[i].id === input.value) {
          this.stagesForSelect = [];
          if (this.performanceLocations[i].hasOwnProperty("stages")) {
            this.stagesForSelect = [];
            for (let j = 0; j < this.performanceLocations[i].stages.length; j++) {
              this.stagesForSelect.push({
                value: this.performanceLocations[i].stages[j].id,
                label: this.performanceLocations[i].stages[j].name
              });
            }
          }
          break;
        }
      }
      this.isStagesLoading = false;
    },
    cancelEventForm () {
      this.submitted = false;
      this.showModal = false;
      this.formTitle = "";
      this.event.status = "hold";
      this.event.promoter.outside = false;
      this.event.promoter.name = "";
      this.event.name = "";
      this.event.email = "";
      this.event.performance_location_id = "";
      this.event.primary_contact.email = "";
      this.event.primary_contact.company = "";
      this.event.primary_contact.position = "";
      this.event.primary_contact.name = "";
      this.event.primary_contact.phone = "";
      this.event.primary_contact.notes = "";
      this.event.stages = [];
      this.event.date = "";
      this.total_time_slots = 1;
      this.event.time_slots = [];
    },
    dropEvent (dropInfo) {
      this.cancelEventForm();
      this.event.date = moment(dropInfo.event.start).utc().valueOf();
      this.event.id = dropInfo.event.id;
      this.editing = true;
      this.handleEvent();
    },
    fetchEventFormDetails (type = "", refresh = false) {
      let flag = true;
      if (refresh === true) {
        if (type === "performance locations") {
          this.isLocationLoading = true;
        } else if (type === "stages") {
          if (this.event.performance_location_id === "") {
            flag = false;
            this.$toastr.fire({
              toast: true,
              icon: "error",
              title: "Select performance location first"
            });
          } else {
            this.isStagesLoading = true;
          }
        }
      }
      if (flag === true) {
        this.$http.get("events/create")
          .then(response => {
            if (response.data.data.length > 0) {
              this.performanceLocationsForSelect = [];
              this.performanceLocations = [];

              for (let i = 0; i < response.data.data.length; i++) {
                this.performanceLocationsForSelect.push({
                  value: response.data.data[i].id,
                  label: response.data.data[i].name
                });
                this.performanceLocations.push(response.data.data[i]);
              }
              if (refresh === true) {
                if (type === "stages") {
                  this.populateStage(this.event.performance_location_id);
                }
                this.$toastr.fire({
                  toast: true,
                  icon: "success",
                  title: type + " refreshed"
                });
              }
            } else {
              this.$toastr.fire({
                toast: true,
                icon: "error",
                title: response.data.message
              });
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
            this.isLocationLoading = false;
            this.isStagesLoading = false;
          });
      }
    },
    searchEvents () {
      (this.$refs.eventCalendar.getApi()).refetchEvents();
    }
  }
};
</script>

<style scoped lang="css">
  .multiselect-add-new {
    display: block;
    padding: 12px;
    min-height: 40px;
    line-height: 16px;
    text-decoration: none;
    text-transform: none;
    vertical-align: middle;
    position: relative;
    cursor: pointer;
    white-space: nowrap;
    font-weight: bold;
  }
</style>