<template>
  <div>
    <b-row>
      <b-col>
        <b-button right variant="outline-info" style="margin-bottom: 15px;">Print/Mail</b-button>
        <br/>

        <b-card class="activity stage-activity" title="Stage Activity e.g. Bands, Announce, Awards, DJ" style="box-shadow: 1px 1px 8px 0">
          <b-row class="mt-4" v-if="false">
            <b-col>
              <b-button variant="outline-primary" v-on:click="add('stage')">Add Stage Activity</b-button>
            </b-col>
          </b-row>
          <b-row class="mt-4">
            <b-col>
              <DataTable custom-ref="event_stage_activity_table" :fields="table.stage.fields" :slots="table.stage.slots" :total-items="table.stage.totalRows" :items="activities.stage" :sort-by="table.stage.sortBy">
                <template slot="actions" slot-scope="data">
                  <b-button variant="outline-danger" @click="remove(data.tbl.item)">
                    <b-icon-x/>
                  </b-button>
                  <b-button variant="outline-info" @click="edit(data.tbl.item)">
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
              <b-button variant="outline-primary" v-on:click="add('crew')">Add Responsible Entity</b-button>
            </b-col>
          </b-row>
          <b-row class="mt-4">
            <b-col>
              <DataTable custom-ref="event_crew_activity_table" :fields="table.crew.fields" :slots="table.crew.slots" :total-items="table.crew.totalRows" :items="activities.crew" :sort-by="table.crew.sortBy">
                <template slot="actions" slot-scope="data">
                  <b-button variant="outline-danger" @click="remove(data.tbl.item)">
                    <b-icon-x/>
                  </b-button>
                  <b-button variant="outline-info" @click="edit(data.tbl.item)">
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
              <b-button variant="outline-primary" v-on:click="add('other')">Add Other Activity</b-button>
            </b-col>
          </b-row>
          <b-row class="mt-4">
            <b-col>
              <DataTable custom-ref="event_other_activity_table" :fields="table.other.fields" :slots="table.other.slots" :total-items="table.other.totalRows" :items="activities.other" :sort-by="table.other.sortBy">
                <template slot="actions" slot-scope="data">
                  <b-button variant="outline-danger" @click="remove(data.tbl.item)">
                    <b-icon-x/>
                  </b-button>
                  <b-button variant="outline-info" @click="edit(data.tbl.item)">
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
              <b-button variant="outline-primary" v-on:click="add('important')">Add Important Notes</b-button>
            </b-col>
          </b-row>
          <b-row class="mt-4">
            <b-col>
              <DataTable custom-ref="event_important_activity_table" :fields="table.important.fields" :slots="table.important.slots" :total-items="table.important.totalRows" :items="activities.important" :sort-by="table.important.sortBy">
                <template slot="actions" slot-scope="data">
                  <b-button variant="outline-danger" @click="remove(data.tbl.item)">
                    <b-icon-x/>
                  </b-button>
                  <b-button variant="outline-info" @click="edit(data.tbl.item)">
                    <b-icon-pencil/>
                  </b-button>
                </template>
              </DataTable>
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
        <b-row v-if="form.type === 'stage'">
          <b-col>
            <b-form-group label="Talent" label-for="activity_talent">
              <b-form-select v-model="form.artist_id">
                <b-form-select-option :value="null">Please select talent</b-form-select-option>
                <b-form-select-option v-for="artist in event.artists" :key="artist.id" :value="artist.id">
                  {{ artist.name | capitalize }}
                </b-form-select-option>
              </b-form-select>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="form.type === 'stage'">
          <b-col cols="9">
            <b-form-group label="Stage" label-for="activity_stage">
              <b-form-select v-model="form.stage_id">
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

        <b-row v-if="form.type === 'crew'">
          <b-col>
            <b-form-group label="Responsible Member" label-for="crew_member">
              <b-form-input id="crew_member" v-model.trim="form.crew" placeholder="Responsible member name"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Cell Phone" label-for="crew_cell_phone">
              <b-form-input id="crew_cell_phone" v-model.trim="form.cell_phone" placeholder="Cell phone"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Radio Channel" label-for="crew_radio_channel">
              <b-form-input id="crew_radio_channel" v-model.trim="form.radio_channel" placeholder="Radio channel"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group label="Email" label-for="crew_email">
              <b-form-input id="crew_email" v-model.trim="form.email" placeholder="Email"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row v-if="['other', 'crew', 'stage'].includes(form.type)">
          <b-col>
            <b-form-group label="Start Time" label-for="start_time">
              <date-picker
                  v-model="form.start"
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

        <b-row v-if="['other', 'crew', 'stage'].includes(form.type)">
          <b-col>
            <b-form-group label="End Time" label-for="end_time">
              <date-picker
                  v-model="form.end"
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
              <b-textarea rows="5" id="activity_description" v-model.trim="form.description" placeholder="Description"></b-textarea>
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
import DataTable from "@/views/utility/data-table";
import DatePicker from "vue2-datepicker";
import {cloneDeep} from "lodash";

export default {
  name: "run-of-show-tab",
  components: { DataTable, DatePicker },
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
      table: {
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
      activities: [],
      stages: [],
      modal: this.default('modal'),
      form: this.default('form')
    }
  },
  methods: {
    setData() {
      if (this.event.hasOwnProperty('activities')) {
        this.activities = cloneDeep(this.event.activities);
      }

      if (this.event.hasOwnProperty('stages')) {
        this.stages = cloneDeep(this.event.stages);
      }
    },
    add(type) {
      this.modal.add = true;
      this.modal.show = true
      this.modal.title = 'Add ' + this.$options.filters.capitalize(type) + ' Activity';
      this.form.type = type;
    },
    edit(info) {
      this.form = cloneDeep(info);
      this.modal.show = true;
      this.modal.title = 'Edit ' + this.$options.filters.capitalize(info.type) + ' Activity';
      this.modal.edit = true;
    },
    remove(info) {
      this.form.id = info.id;
      this.form.type = info.type;
      this.modal.delete = true;
      this.handle();
    },
    default(type) {
      let result = {};
      switch (type) {
        case 'form':
          result = {
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
    cancel() {
      this.modal = this.default('modal');
      this.form = this.default('form');
    },
    handle() {
      const loader = this.$loading.show();
      let customRequest = null;
      if (this.modal.delete) {
        customRequest = this.$http.delete('events/' + this.event.id + '/activities/' + this.form.id);
      } else if (this.modal.edit) {
        customRequest = this.$http.put('events/' + this.event.id + '/activities/' + this.form.id, this.form);
      } else if (this.modal.add) {
        let postParam = this.form;
        postParam.insert_id = true;
        customRequest = this.$http.post('events/' + this.event.id + '/activities', postParam);
      }

      if (customRequest !== null) {
        customRequest
            .then(response => {
              if (this.modal.add) {
                this.$emit('runOfShowEvent', {
                  type: 'add',
                  data: {
                    ...this.form,
                    id: response.data.data.id,
                    artist: cloneDeep(this.event.artists.find((artist) => {
                      return artist.id === this.form.artist_id;
                    })),
                    stage: cloneDeep(this.event.stages.find((stage) => {
                      return stage.id === this.form.stage_id;
                    }))
                  }
                });
              } else if (this.modal.edit) {
                this.$emit('runOfShowEvent', {
                  type: 'update',
                  id: this.form.id,
                  data: {
                    ...this.form,
                    artist: cloneDeep(this.event.artists.find((artist) => {
                      return artist.id === this.form.artist_id;
                    })),
                    stage: cloneDeep(this.event.stages.find((stage) => {
                      return stage.id === this.form.stage_id;
                    }))
                  }
                });
              } else if (this.modal.delete) {
                this.$emit('runOfShowEvent', {
                  type: 'remove',
                  id: this.form.id,
                  data: {
                    type: this.form.type
                  }
                });
              }
              this.cancel();
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
            .then(() => {loader.hide();});
      } else {
        loader.hide();
      }
    },
    addNewStage() {
      window.open(window.location.origin + '/stages/create?event_id=' + this.$route.params.id, '_blank');
    },
    refreshStages() {
      const loader = this.$loading.show();
      this.$http.get('stages?event_id=' + this.$route.params.id)
        .then(response => {
          this.$emit('runOfShowEvent', {
            type: 'refresh',
            key: 'stages',
            data: response.data.data.data
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
    }
  }
}
</script>