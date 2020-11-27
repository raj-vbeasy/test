<template>
  <div>
    <b-row>
      <b-col>
        <b-button variant="outline-info" v-on:click="add">Add Contact</b-button>
      </b-col>
    </b-row>
    <b-row class="mt-3">
      <b-col>
        <DataTable custom-ref="event_contacts_table"
                   :fields="table.fields"
                   :slots="table.slots"
                   :total-items="table.totalRows"
                   :items="contacts"
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
            <b-form-group id="contact_company_group" label="Company" label-for="contact_company">
              <b-form-input id="contact_company" v-model.trim="form.company" placeholder="Company"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="contact_position_group" label="Position" label-for="contact_position">
              <b-form-input id="contact_position" v-model.trim="form.position" placeholder="position"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="contact_name_group" label="Name" label-for="contact_name">
              <b-form-input id="contact_name" v-model.trim="form.name" placeholder="Name"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="contact_phone_group" label="Phone" label-for="contact_phone">
              <b-form-input id="contact_phone" v-model.trim="form.phone" placeholder="phone"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="contact_email_group" label="Email" label-for="contact_email">
              <b-form-input id="contact_email" v-model.trim="form.email" placeholder="Email"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="contact_notes_group" label="Contact Notes" label-for="contact_notes">
              <b-textarea rows="5" id="contact_notes" v-model.trim="form.notes" placeholder="Contact Notes"></b-textarea>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-form-group id="event_notes_group" label="Event Notes" label-for="event_notes">
              <b-textarea rows="5" id="event_notes" v-model.trim="form.event_notes" placeholder="Event Notes"></b-textarea>
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

export default {
  name: "contacts-tab",
  components: { DataTable },
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
      contacts: [],
      modal: this.default('modal'),
      form: this.default('form')
    }
  },
  methods: {
    setData() {
      if (this.event.hasOwnProperty('contacts')) {
        this.contacts = cloneDeep(this.event.contacts);
      }
    },
    add() {
      this.modal.add = true;
      this.modal.show = true
      this.modal.title = 'Add Contact';
    },
    edit(info) {
      this.form = cloneDeep(info);
      this.modal.show = true;
      this.modal.title = 'Edit Contact';
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
        customRequest = this.$http.delete('events/' + this.event.id + '/contacts/' + this.form.id);
      } else if (this.modal.edit) {
        customRequest = this.$http.put('events/' + this.event.id + '/contacts/' + this.form.id, this.form);
      } else if (this.modal.add) {
        let postParam = this.form;
        postParam.insert_id = true;
        customRequest = this.$http.post('events/' + this.event.id + '/contacts', postParam);
      }

      if (customRequest !== null) {
        customRequest
            .then(response => {
              if (this.modal.add) {
                this.$emit('contactEvent', {
                  type: 'add',
                  data: {
                    ...this.form,
                    id: response.data.data.id
                  }
                })
              } else if (this.modal.edit) {
                this.$emit('contactEvent', {
                  type: 'update',
                  id: this.form.id,
                  data: {
                    ...this.form
                  }
                })
              } else if (this.modal.delete) {
                this.$emit('contactEvent', {
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
            id: '',
            email: '',
            company: '',
            position: '',
            name: '',
            phone: '',
            notes: '',
            event_notes: ''
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

<style scoped>

</style>