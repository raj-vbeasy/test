<template>
  <div>
    <b-row class="mb-5">
      <b-col>
        <b-button variant="outline-primary" v-on:click="add">Add Note</b-button>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="3" v-for="note in notes" :key="note.id">
        <b-card :title="note.title" style="box-shadow: 1px 1px 8px 0">
          <b-card-text>
            <b>Start : {{ note.start }}<br>
              End : {{ note.end }}<br></b>
            {{ note.text }}
          </b-card-text>
          <b-button v-on:click="edit(note)" variant="outline-primary">Edit</b-button>
          <b-button v-on:click="remove(note)" variant="outline-danger">delete</b-button>
        </b-card>
      </b-col>
    </b-row>

    <b-modal
        v-model="modal.show"
        :title="modal.title"
        title-class="text-black font-18"
        body-class="p-3"
        hide-footer
    >
      <b-form @submit.prevent="handle">
        <b-row>
          <b-col>
            <b-form-group id="note_title_group" label="Note Title" label-for="note_title">
              <b-form-input id="note_title" v-model.trim="form.title" placeholder="Note Title"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <b-form-group id="note_start_date" label="Start Date" label-for="start_date">
              <date-picker
                  id="start_date"
                  v-model="form.start"
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
                  v-model="form.end"
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
              <b-textarea rows="5" id="note_text" v-model.trim="form.text" placeholder="Note Text"></b-textarea>
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

export default {
  name: "notes-tab",
  components: { DatePicker },
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
      notes: [],
      modal: this.default('modal'),
      form: this.default('form')
    }
  },
  methods: {
    setData() {
      if (this.event.hasOwnProperty('notes')) {
        this.notes = cloneDeep(this.event.notes);
      }
    },
    add() {
      this.modal.add = true;
      this.modal.show = true
      this.modal.title = 'Add Note';
    },
    edit(info) {
      this.form = cloneDeep(info);
      this.modal.show = true;
      this.modal.title = 'Edit Note';
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
        customRequest = this.$http.delete('events/' + this.event.id + '/notes/' + this.form.id);
      } else if (this.modal.edit) {
        customRequest = this.$http.put('events/' + this.event.id + '/notes/' + this.form.id, this.form);
      } else if (this.modal.add) {
        let postParam = this.form;
        postParam.insert_id = true;
        customRequest = this.$http.post('events/' + this.event.id + '/notes', postParam);
      }

      if (customRequest !== null) {
        customRequest
            .then(response => {
              if (this.modal.add) {
                this.$emit('notesEvent', {
                  type: 'add',
                  data: {
                    ...this.form,
                    id: response.data.data.id
                  }
                })
              } else if (this.modal.edit) {
                this.$emit('notesEvent', {
                  type: 'update',
                  id: this.form.id,
                  data: {
                    ...this.form
                  }
                })
              } else if (this.modal.delete) {
                this.$emit('notesEvent', {
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
            title: '',
            start: '',
            end: '',
            text: ''
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