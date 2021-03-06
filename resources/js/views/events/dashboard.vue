<template>
  <Layout>
    <PageHeader
      :title="title"
      :items="items"
    />
    <b-row>
      <b-col>
        <b-card>
          <b-row>
            <b-col>
              <b-button variant="primary-outline">
                <span><i class="mdi mdi-calendar-account-outline" />{{ event.formattedDate }}</span>
              </b-button>

              <b-button variant="primary-outline">
                <span>
                  <i class="mdi mdi-map-marker-outline" />
                  {{ event.location }}
                  <span class="grey">
                    (<span
                      v-for="(item, index) in event.stages"
                      :key="item.id"
                    >
                      {{ item.name }}<span v-if="index+1 < event.stages.length">, </span>
                    </span>)
                  </span>
                </span>
              </b-button>
            </b-col>
          </b-row>
          <hr>
          <b-row>
            <b-col>
              <b-tabs
                justified
                nav-class="nav-tabs-custom"
                content-class="p-3 text-muted"
              >
                <b-tab v-if="false">
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Dashboard</span>
                  </template>
                  <DashboardTab :event="event" />
                </b-tab>

                <b-tab>
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Talent</span>
                  </template>
                  <TalentsTab
                    :event="event"
                    @artistEvent="artistEvent"
                    @eventUpdate="eventUpdate"
                  />
                </b-tab>

                <b-tab>
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Run of show</span>
                  </template>
                  <RunOfShowTab
                    :event="event"
                    @runOfShowEvent="runOfShowEvent"
                  />
                </b-tab>

                <b-tab>
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Task</span>
                  </template>
                  <TasksTab
                    :event="event"
                    @taskEvent="taskEvent"
                  />
                </b-tab>

                <b-tab>
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Contact</span>
                  </template>
                  <ContactsTab
                    :event="event"
                    @contactEvent="contactEvent"
                  />
                </b-tab>

                <b-tab v-if="false">
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Note</span>
                  </template>
                  <NotesTab
                    :event="event"
                    @notesEvent="notesEvent"
                  />
                </b-tab>

                <b-tab>
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Finance</span>
                  </template>
                  <b-row>
                    <b-col>
                      <b-tabs
                        justified
                        nav-class="nav-tabs-custom"
                        content-class="p-3 text-muted"
                      >
                        <b-tab>
                          <template #title>
                            <span class="d-inline-block d-sm-none">
                              <i class="fas fa-home" />
                            </span>
                            <span class="d-none d-sm-inline-block">Expense</span>
                          </template>
                          <ExpensesTab
                            :event="event"
                            @expenseEvent="expenseEvent"
                          />
                        </b-tab>

                        <b-tab>
                          <template #title>
                            <span class="d-inline-block d-sm-none">
                              <i class="fas fa-home" />
                            </span>
                            <span class="d-none d-sm-inline-block">Settlement</span>
                          </template>
                          <SettlementTab />
                        </b-tab>
                      </b-tabs>
                    </b-col>
                  </b-row>
                </b-tab>

                <b-tab v-if="false">
                  <template #title>
                    <span class="d-inline-block d-sm-none">
                      <i class="fas fa-home" />
                    </span>
                    <span class="d-none d-sm-inline-block">Overview</span>
                  </template>
                  <OverviewTab />
                </b-tab>
              </b-tabs>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </Layout>
</template>
<script>
import Layout from "@/views/layouts/main";
import PageHeader from "@/components/page-header";
import appConfig from "@/app.config.json";
import moment from "moment";
import "moment-timezone";
import { cloneDeep } from "lodash";
import DashboardTab from "./partials/tabs/dashboard";
import RunOfShowTab from "./partials/tabs/run-of-show";
import ContactsTab from "./partials/tabs/contacts";
import ExpensesTab from "./partials/tabs/expenses";
import SettlementTab from "./partials/tabs/settlement";
import OverviewTab from "./partials/tabs/overview";
import TalentsTab from "./partials/tabs/talents";
import TasksTab from "./partials/tabs/tasks";
import NotesTab from "./partials/tabs/notes";

export default {
  name: "EventDashboard",
  components: {
    PageHeader,
    Layout,
    DashboardTab,
    TalentsTab,
    TasksTab,
    RunOfShowTab,
    ContactsTab,
    NotesTab,
    ExpensesTab,
    SettlementTab,
    OverviewTab
  },
  page: {
    title: "Event Dashboard",
    meta: [{ name: "description", content: appConfig.description }]
  },
  data () {
    return {
      title: "",
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
      event: {}
    };
  },
  created() {
    const loader = this.$loading.show();
    this.$http.get("events/" + this.$route.params.id)
      .then(response => {
        console.log(response);
        this.title = response.data.data.name;
        this.items.push({
          text: this.title,
          active: true
        });
        response.data.data.formattedDate = moment.utc(response.data.data.date).local().format("MMM DD, YYYY dddd");
        this.event = cloneDeep(response.data.data);
      })
      .catch(error => {
        this.$router.push({name: "events-calendar"});
        this.$toastr.fire({
          toast: true,
          icon: "error",
          title: error.response.data.message
        });
      })
      .then(() => {loader.hide();});
  },
  methods: {
    artistEvent (args) {
      switch (args.type) {
      case "update":
        for (let i = 0; i < this.event.artists.length; i++) {
          if (this.event.artists[i].id === args.id) {
            for (const argsKey in args.data) {
              if (Object.prototype.hasOwnProperty.call(args.data, argsKey)) {
                this.event.artists[i][argsKey] = args.data[argsKey];
              }
            }
            break;
          }
        }
        break;
      case "add":
        this.event.artists.push({
          "challenged": [],
          ...args.data
        });
        break;
      case "remove":
        for (let i = 0; i < this.event.artists.length; i++) {
          if (this.event.artists[i].id === args.id) {
            this.event.artists.splice(i, 1);
            break;
          }
        }
        break;
      }
    },
    taskEvent (args) {
      switch (args.type) {
      case "add":
        this.event.tasks.push(args.data);
        break;
      case "update":
        for (let i = 0; i < this.event.tasks.length; i++) {
          if (this.event.tasks[i].id === args.id) {
            for (const argsKey in args.data) {
              if (Object.prototype.hasOwnProperty.call(args.data, argsKey)) {
                this.event.tasks[i][argsKey] = args.data[argsKey];
              }
            }
            break;
          }
        }
        break;
      case "remove":
        for (let i = 0; i < this.event.tasks.length; i++) {
          if (this.event.tasks[i].id === args.id) {
            this.event.tasks.splice(i, 1);
            break;
          }
        }
        break;
      }
    },
    runOfShowEvent (args) {
      switch (args.type) {
      case "add":
        this.event.activities[args.data.type].push(args.data);
        break;
      case "update":
        for (let i = 0; i < this.event.activities[args.data.type].length; i++) {
          if (this.event.activities[args.data.type][i].id === args.id) {
            for (const argsKey in args.data) {
              if (Object.prototype.hasOwnProperty.call(args.data, argsKey)) {
                this.event.activities[args.data.type][i][argsKey] = args.data[argsKey];
              }
            }
            break;
          }
        }
        break;
      case "remove":
        for (let i = 0; i < this.event.activities[args.data.type].length; i++) {
          if (this.event.activities[args.data.type][i].id === args.id) {
            this.event.activities[args.data.type].splice(i, 1);
            break;
          }
        }
        break;
      case "refresh":
        this.event.stages = cloneDeep(args.data);
        break;
      }
    },
    contactEvent (args) {
      switch (args.type) {
      case "add":
        this.event.contacts.push(args.data);
        break;
      case "update":
        for (let i = 0; i < this.event.contacts.length; i++) {
          if (this.event.contacts[i].id === args.id) {
            for (const argsKey in args.data) {
              if (Object.prototype.hasOwnProperty.call(args.data, argsKey)) {
                this.event.contacts[i][argsKey] = args.data[argsKey];
              }
            }
            break;
          }
        }
        break;
      case "remove":
        for (let i = 0; i < this.event.contacts.length; i++) {
          if (this.event.contacts[i].id === args.id) {
            this.event.contacts.splice(i, 1);
            break;
          }
        }
        break;
      }
    },
    notesEvent (args) {
      switch (args.type) {
      case "add":
        this.event.notes.push(args.data);
        break;
      case "update":
        for (let i = 0; i < this.event.notes.length; i++) {
          if (this.event.notes[i].id === args.id) {
            for (const argsKey in args.data) {
              if (Object.prototype.hasOwnProperty.call(args.data, argsKey)) {
                this.event.notes[i][argsKey] = args.data[argsKey];
              }
            }
            break;
          }
        }
        break;
      case "remove":
        for (let i = 0; i < this.event.notes.length; i++) {
          if (this.event.notes[i].id === args.id) {
            this.event.notes.splice(i, 1);
            break;
          }
        }
        break;
      }
    },
    expenseEvent (args) {
      switch (args.type) {
      case "add":
        this.event.expenses.push(args.data);
        break;
      case "update":
        for (let i = 0; i < this.event.expenses.length; i++) {
          if (this.event.expenses[i].id === args.id) {
            for (const argsKey in args.data) {
              if (Object.prototype.hasOwnProperty.call(args.data, argsKey)) {
                this.event.expenses[i][argsKey] = args.data[argsKey];
              }
            }
            break;
          }
        }
        break;
      case "remove":
        for (let i = 0; i < this.event.expenses.length; i++) {
          if (this.event.expenses[i].id === args.id) {
            this.event.expenses.splice(i, 1);
            break;
          }
        }
        break;
      }
    },
    eventUpdate (args) {
      for (const arg in args) {
        if (Object.prototype.hasOwnProperty.call(args, arg)) {
          this.event[arg] = cloneDeep(args[arg]);
        }
      }
    }
  }
};
</script>

<style>
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