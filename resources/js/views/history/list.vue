<template>
  <Layout>
    <PageHeader :title="title" :items="items"/>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <DataTable :custom-ref="table.customRef" :fields="table.fields" :slots="table.slots" :total-items="table.totalRows" :items="fetchData" :sort-by="table.sortBy"/>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import appConfig from '@/app.config.json';
import Layout from '@/views/layouts/main';
import PageHeader from '@/components/page-header';
import DataTable from '@/views/utility/data-table';

export default {
  page: {
    title: "History",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { Layout, PageHeader, DataTable },
  data() {
    return {
      title: "History",
      items: [
        {
          text: "Dashboard",
          href: "/"
        },
        {
          text: "History",
          active: true
        }
      ],
      table: {
        sortBy: "created_at",
        fields: [
          { key: 's_no' , label: 'S.No.', sortable: false},
          { key: "event_name", sortable: false },
          { key: "user_name", sortable: false },
          { key: "artist_name", sortable: false },
          { key: "old_status", sortable: false },
          { key: "new_status",sortable: false },
          { key: "description", sortable: false },
          { key: "created_at", sortable: false }
        ],
        totalRows: 0,
        slots: [],
        customRef: 'historyTable'
      }
    }
  },
  methods: {
    fetchData(ctx, callback) {
      const loader = this.$loading.show();
      let url = 'history?filter=' + (ctx.filter ?? '') + '&sort-by=' + ctx.sortBy;
      url = url + '&sort-dir=' + (ctx.sortDesc ? 'desc' : 'asc');
      url = url + '&page=' + ctx.currentPage + '&per-page=' + ctx.perPage;

      this.$http.get(url)
          .then(response => {
            let data = [];
            for (let i = 0; i < response.data.data.data.length; i++) {
              data.push(response.data.data.data[i]);
            }
            this.table.totalRows = response.data.data.total;
            callback(data);
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
          });

      return null;
    }
  }
}
</script>

<style scoped>
img {
  width: 60px;
}
</style>
