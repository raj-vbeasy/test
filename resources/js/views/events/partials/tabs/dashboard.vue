<template>
  <b-row class="mt-3">
    <b-col>
      <b-row class="mt-3">
        <b-col>
          <b-card class="activity stage-activity"
                  :title="stage.name"
                  v-for="stage in stages"
                  :key="stage.name"
                  style="box-shadow: 1px 1px 8px 0"
          >
            <b-row class="mt-4">
              <b-col>
                <DataTable :fields="fields" :total-items="totalRows" :items="stage.activities" :sort-by="sortBy"/>
              </b-col>
            </b-row>
          </b-card>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>

<script>

import { cloneDeep } from 'lodash';
import DataTable from "@/views/utility/data-table";

export default {
  name: "dashboard-tab",
  components: {DataTable},
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
      stages: [],
      sortBy: "start",
      fields: [
        { key: "artist.name", label: 'Talent', sortable: true },
        { key: "stage.name", label: "Stage", sortable: false},
        { key: "start", sortable: true },
        { key: "end", sortable: true },
        { key: "description", sortable: false }
      ],
      totalRows: 0,
      values: {}
    }
  },
  methods: {
    setData() {
      this.stages = [];
      for (let i = 0; i < this.event.stages.length; i++) {
        let activities = [];

        for (let j = 0; j < this.event.activities.stage.length; j++) {
          if (this.event.activities.stage[j].stage_id === this.event.stages[i].id) {
            activities.push(cloneDeep(this.event.activities.stage[j]));
          }
        }

        this.stages.push({
          name: this.event.stages[i].name,
          activities: activities
        });
      }
    }
  }
}
</script>