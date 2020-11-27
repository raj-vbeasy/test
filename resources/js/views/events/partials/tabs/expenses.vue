<template>
  <div>
    <b-row>
      <b-col>
        <b-button variant="outline-info" v-on:click="add">Add Expense</b-button>
      </b-col>
    </b-row>
    <b-row class="mt-3">
      <b-col>
        <DataTable custom-ref="event_expense_table" :fields="table.fields" :slots="table.slots" :total-items="table.totalRows" :items="expenses" :sort-by="table.sortBy">
          <template slot="actions" slot-scope="data">
            <b-button variant="outline-danger" @click="remove(data.tbl.item)">
              <b-icon-x/>
            </b-button>
            <b-button variant="outline-info" @click="edit(data.tbl.item)">
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
            <b-form-group id="expense_crew_group" label="Crew Member Name" label-for="expense_crew_name">
              <b-form-input id="expense_crew_name" v-model.trim="form.crew" placeholder="Crew member name"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="expense_amount_group" label="Amount" label-for="expense_amount">
              <b-form-input id="expense_amount" v-model.trim="form.amount" placeholder="0"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="expense_description_group" label="Description" label-for="expense_description">
              <b-textarea rows="5" id="expense_description" v-model.trim="form.description" placeholder="Description"></b-textarea>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="expense_datetime_group" label="Date" label-for="expense_datetime">
              <date-picker
                  type="datetime"
                  v-model="form.datetime"
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
            <b-button variant="outline-secondary float-right ml-2" @click="cancel">Cancel</b-button>
            <b-button variant="outline-info float-right" type="submit">Submit</b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import {cloneDeep} from "lodash";
import DatePicker from "vue2-datepicker";
import DataTable from "@/views/utility/data-table";

export default {
  name: "expenses-tab",
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
  data() {
    return {
      table: {
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
      },
      expenses: [],
      modal: this.default('modal'),
      form: this.default('form')
    }
  },
  methods: {
    setData() {
      if (this.event.hasOwnProperty('expenses')) {
        this.expenses = cloneDeep(this.event.expenses);
      }
    },
    add() {
      this.modal.add = true;
      this.modal.show = true
      this.modal.title = 'Add Expense';
    },
    edit(info) {
      this.form = cloneDeep(info);
      this.modal.show = true;
      this.modal.title = 'Edit Expense';
      this.modal.edit = true;
    },
    remove(info) {
      this.form.id = info.id;
      this.modal.delete = true;
      this.handle();
    },
    handle() {
      let loader = this.$loading.show();
      let customRequest = null;
      if (this.modal.delete) {
        customRequest = this.$http.delete('events/' + this.event.id + '/expenses/' + this.form.id);
      } else if (this.modal.edit) {
        customRequest = this.$http.put('events/' + this.event.id + '/expenses/' + this.form.id, this.form);
      } else if (this.modal.add) {
        let postParam = this.form;
        postParam.insert_id = true;
        customRequest = this.$http.post('events/' + this.event.id + '/expenses', postParam);
      }

      if (customRequest !== null) {
        customRequest
            .then(response => {
              if (this.modal.add) {
                this.$emit('expenseEvent', {
                  type: 'add',
                  data: {
                    ...this.form,
                    id: response.data.data.id
                  }
                })
              } else if (this.modal.edit) {
                this.$emit('expenseEvent', {
                  type: 'update',
                  id: this.form.id,
                  data: {
                    ...this.form
                  }
                })
              } else if (this.modal.delete) {
                this.$emit('expenseEvent', {
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
    },
    cancel() {
      this.modal = this.default('modal');
      this.form = this.default('form');
    },
    default(type) {
      let result = {};
      switch (type) {
        case 'form':
          result = {
            id: null,
            amount: 0,
            description: '',
            datetime: null,
            crew: ''
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
    }
  }
}
</script>