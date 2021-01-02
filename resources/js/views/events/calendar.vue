<template>
  <Layout>
    <PageHeader :title="title" :items="items"/>
    <b-row>
      <b-col>
        <b-card>
          <b-card-body>
            <div class="app-calendar">
              <FullCalendar
                  ref="eventCalendar"
                  default-view="dayGridMonth"
                  :header="calendarHeader"
                  :editable="true"
                  :droppable="true"
                  :eventDrop="dropEvent"
                  :plugins="calendarPlugins"
                  :events="fetchEvents"
                  :weekends="true"
                  :event-drop="dropEvent"
                  :theme-system="themeSystem"
                  @eventDrop="dropEvent"
                  @dateClick="addEvent"
                  @eventClick="eventClick"/>
            </div>
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
    >
      <b-form @submit.prevent="handleEvent">
        <b-row>
          <b-col>
            <b-form-group
                id="status-group"
                label-for="status">
              <b-button-group class="btn-group-toggle mt-2 mt-xl-0">
                <label class="btn btn-outline-info" :class="event.status === 'hold' ? 'active' : ''">
                  <input id="hold-status" type="radio" name="status" v-model="event.status" value="hold" checked /> Hold
                </label>

                <label class="btn btn-outline-info" :class="event.status === 'confirmed' ? 'active' : ''">
                  <input id="confirmed-status" type="radio" name="status" v-model="event.status" value="confirmed" /> Confirmed
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
              <b-form-checkbox v-model="event.promoter.outside" switch>
                <label>Outside Promoter</label>
              </b-form-checkbox>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row :class="event.promoter.outside === true ? '' : 'd-none'">
          <b-col>
            <b-form-group id="promoter-group" label="Promoter Name" label-for="promoter_name">
              <b-form-input
                  id="agent_organization_name"
                  v-model.trim="event.promoter.name"
                  placeholder="Promoter Name"
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="name-group" label="Event Name" label-for="event_name">
              <b-form-input
                  id="event_name"
                  v-model.trim="event.name"
                  placeholder="Event Name"
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="event-email-group" label="Email" label-for="event_email">
              <b-form-input
                  id="event_email"
                  v-model.trim="event.email"
                  placeholder="Email"
              ></b-form-input>
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
                  @input="populateStage">
                <template v-slot:beforeList>
                  <li class="multiselect-add-new">
                    <a href="/performance-locations/create" target="_blank">Add New Location</a>
                  </li>
                </template>
              </multiselect>
            </b-form-group>
          </b-col>
          <b-col cols="1">
            <a href="javascript:void(0)" @click="fetchEventFormDetails('performance locations', true)" style="font-size: 25px;line-height: 80px;">
              <i class="mdi mdi-refresh"></i>
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
                  :hideSelected="true">
                <template v-slot:beforeList>
                  <li class="multiselect-add-new">
                    <a href="/stages/create" target="_blank">Add New Stage</a>
                  </li>
                </template>
              </multiselect>
            </b-form-group>
          </b-col>
          <b-col cols="1">
            <a href="javascript:void(0)" @click="fetchEventFormDetails('stages', true)" style="font-size: 25px;line-height: 80px;">
              <i class="mdi mdi-refresh"></i>
            </a>
          </b-col>
        </b-row>

        <b-row class="mb-5">
          <b-col>
            <b-button variant="outline-secondary float-right ml-2" @click="cancelEventForm">Cancel</b-button>
            <b-button variant="outline-info float-right" type="submit">Submit</b-button>
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
import interactionPlugin from "@fullcalendar/interaction";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import appConfig from "@/app.config.json";
import Multiselect from "vue-multiselect";
import moment from "moment";
import "moment-timezone";

export default {
  name: "event-calendar",
  components: { FullCalendar, Layout, PageHeader, Multiselect },
  page: {
    title: "Events",
    meta: [{ name: "description", content: appConfig.description }]
  },
  data () {
    return {
      title: 'Events',
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
      calendarPlugins: [
        dayGridPlugin,
        interactionPlugin,
        bootstrapPlugin
      ],
      themeSystem: "bootstrap",
      calendarEvents: [],
      calendarHeader: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      showModal: false,
      eventModal: false,
      event: {
        id: null,
        status: 'hold',
        promoter: {
          outside: false,
          name: ''
        },
        name: '',
        email: '',
        performance_location_id: '',
        primary_contact: {
          email: '',
          company: '',
          position: '',
          name: '',
          phone: '',
          notes: ''
        },
        stages: [],
        date: ''
      },
      editing: false,
      performanceLocations: [],
      performanceLocationsForSelect: [],
      stagesForSelect: [],
      submitted: false,
      formTitle: '',
      isLocationLoading: false,
      isStagesLoading: false
    }
  },
  methods: {
    addEvent (info) {
      this.event.date = moment(info.date).utc().valueOf()
      this.formTitle = 'Add New Event';
      this.showModal = true;
    },
    eventClick (info) {
      if (info.event.extendedProps.status === 'confirmed') {
        this.$router.push({name: 'event-dashboard', params: { id: info.event.id }});
      } else {
        this.formTitle = 'Edit Event';
        this.event.status = info.event.extendedProps.status;
        this.event.promoter = {
          outside: info.event.extendedProps.promoter !== '',
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
          })
        }
        this.event.date = moment(info.event.start).utc().valueOf();
        this.event.id = info.event.id;
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
          if (key === 'stages') {
            formData[key] = [];
            for (let i = 0; i < this.event[key].length; i++) {
              formData[key].push(this.event[key][i].value);
            }
          } else if (key === 'performance_location_id') {
            formData[key] = this.event[key].value;
          } else if (key === 'promoter') {
            if (this.event[key].outside === true) {
              formData[key] = this.event[key].name
            }
          } else {
            formData[key] = this.event[key];
          }
        }
      }

      let httpRequest = '';
      if (this.editing === true) {
        httpRequest = this.$http.put('events/' + this.event.id, formData);
      } else {
        httpRequest = this.$http.post('events', formData);
      }
      httpRequest
          .then(response => {
            this.$toastr.fire({
              toast: true,
              icon: 'success',
              title: response.data.message
            });
            (this.$refs.eventCalendar.getApi()).refetchEvents();
            this.cancelEventForm();
          })
          .catch(error => {
            this.$toastr.fire({
              toast: true,
              icon: 'error',
              title: error.response.message
            });
          })
          .then(() => {
            this.submitted = false;
            this.editing = false;
            loader.hide();
          })
    },
    fetchEvents (evt, success, error) {
      const loader = this.$loading.show();
      const url = 'events?start=' + evt.start.getTime() + '&end=' + evt.end.getTime();
      this.$http.get(url)
          .then(response => {
            let events = [];
            if (response.data.data.data.length > 0) {
              for (let i = 0; i < response.data.data.data.length; i++) {
                events.push({
                  id: response.data.data.data[i].id,
                  start: moment.utc(response.data.data.data[i].date).local().format('YYYY-MM-DD'),
                  title: response.data.data.data[i].name,
                  allDay: true,
                  editable: response.data.data.data[i].status === 'hold',
                  backgroundColor: response.data.data.data[i].status === 'hold' ? 'blue' : 'green',
                  extendedProps: {
                    status: response.data.data.data[i].status,
                    stages: response.data.data.data[i].stages,
                    performance_location: response.data.data.data[i].performance_location,
                    email: response.data.data.data[i].email,
                    promoter: response.data.data.data[i].promoter
                  }
                })
              }
            }
            success(events);
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
    },
    populateStage (input) {
      this.isStagesLoading = true;
      this.event.stages = [];
      for (let i = 0; i < this.performanceLocations.length; i++) {
        if (this.performanceLocations[i].id === input.value) {
          this.stagesForSelect = [];
          if (this.performanceLocations[i].hasOwnProperty('stages')) {
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
      this.formTitle = '';
      this.event.status = 'hold';
      this.event.promoter.outside = false;
      this.event.promoter.name = '';
      this.event.name = '';
      this.event.email = '';
      this.event.performance_location_id = '';
      this.event.primary_contact.email = '';
      this.event.primary_contact.company = '';
      this.event.primary_contact.position = '';
      this.event.primary_contact.name = '';
      this.event.primary_contact.phone = '';
      this.event.primary_contact.notes = '';
      this.event.stages = [];
      this.event.date = '';
    },
    dropEvent (dropInfo) {
      this.cancelEventForm();
      this.event.date = moment(dropInfo.event.start).utc().valueOf();
      this.event.id = dropInfo.event.id;
      this.editing = true;
      this.handleEvent();
    },
    fetchEventFormDetails (type = '', refresh = false) {
      let flag = true;
      if (refresh === true) {
        if (type === 'performance locations') {
          this.isLocationLoading = true;
        } else if (type === 'stages') {
          if (this.event.performance_location_id === '') {
            flag = false;
            this.$toastr.fire({
              toast: true,
              icon: 'error',
              title: 'Select performance location first'
            });
          } else {
            this.isStagesLoading = true;
          }
        }
      }
      if (flag === true) {
        this.$http.get('events/create')
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
                  if (type === 'stages') {
                    this.populateStage(this.event.performance_location_id);
                  }
                  this.$toastr.fire({
                    toast: true,
                    icon: 'success',
                    title: type + ' refreshed'
                  });
                }
              } else {
                this.$toastr.fire({
                  toast: true,
                  icon: 'error',
                  title: response.data.message
                });
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
              this.isLocationLoading = false;
              this.isStagesLoading = false;
            });
      }
    }
  },
  created () {
    this.fetchEventFormDetails();
  }
}
</script>

<style scoped>
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