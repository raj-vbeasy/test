<template>
  <div>
    <b-row>
      <b-col>
        <b-button variant="outline-info" v-on:click="add">Add Task</b-button>
      </b-col>
    </b-row>
    <b-row class="mt-3">
      <b-col>
        <DataTable custom-ref="event_tasks_table"
                   :fields="table.fields"
                   :slots="table.slots"
                   :total-items="table.totalRows"
                   :items="tasks"
                   :sort-by="table.sortBy">
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
            <b-form-group id="task_name_group" label="Name" label-for="task_name">
              <b-form-input id="task_name" v-model.trim="form.name" placeholder="Name"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="task_description_group" label="Description" label-for="task_description">
              <b-textarea rows="5" id="task_description" v-model.trim="form.description" placeholder="Description"></b-textarea>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="task_due_date_group" label="Due Date" label-for="task_due_date">
              <date-picker
                  v-model="form.due_date"
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
              <b-form-input id="task_status" v-model.trim="form.status"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="task_assignee_group" label="Assignee" label-for="task_assignee">
              <b-form-input id="task_assignee" v-model.trim="form.assignee"></b-form-input>
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
import {cloneDeep} from "lodash";
import moment from 'moment';
import DatePicker from 'vue2-datepicker';

export default {
  name: "tasks-tab",
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
      tasks: [],
      modal: this.default('modal'),
      form: this.default('form')
    }
  },
  methods: {
    setData() {
      if (this.event.hasOwnProperty('tasks')) {
        this.tasks = cloneDeep(this.event.tasks);
      }
    },
    add() {
      this.modal.add = true;
      this.modal.show = true
      this.modal.title = 'Add Task';
    },
    edit(info) {
      this.form = cloneDeep(info);
      this.modal.show = true;
      this.modal.title = 'Edit Task';
      this.modal.edit = true;
    },
    remove(info) {
      this.form.id = info.id;
      this.modal.delete = true;
      this.handle();
    },
    default(type) {
      let result = {};
      switch (type) {
        case 'form':
          result = {
            id: '',
            name: '',
            description: '',
            due_date: '',
            status: '',
            assignee: ''
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
      let loader = this.$loading.show();
      let customRequest = null;
      if (this.modal.delete) {
        customRequest = this.$http.delete('events/' + this.event.id + '/tasks/' + this.form.id);
      } else if (this.modal.edit) {
        let postParam = this.form;
        postParam.due_date = moment(postParam.due_date).utc().valueOf();
        customRequest = this.$http.put('events/' + this.event.id + '/tasks/' + this.form.id, postParam);
      } else if (this.modal.add) {
        let postParam = this.form;
        postParam.due_date = moment(postParam.due_date).utc().valueOf();
        postParam.insert_id = true;
        customRequest = this.$http.post('events/' + this.event.id + '/tasks', postParam);
      }
      if (customRequest !== null) {
        customRequest
            .then(response => {
              if (this.modal.add) {
                this.$emit('taskEvent', {
                  type: 'add',
                  data: {
                    ...this.form,
                    id: response.data.data.id,
                    due_date: moment(this.form.due_date).format('MMM DD, YYYY dddd')
                  }
                })
              } else if (this.modal.edit) {
                this.$emit('taskEvent', {
                  type: 'update',
                  id: this.form.id,
                  data: {
                    ...this.form,
                    due_date: moment(this.form.due_date).format('MMM DD, YYYY dddd')
                  }
                })
              } else if (this.modal.delete) {
                this.$emit('taskEvent', {
                  type: 'remove',
                  id: this.form.id
                })
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
            }).then(() => {loader.hide()});
      } else {
        loader.hide();
      }
    }
  }
}
</script>