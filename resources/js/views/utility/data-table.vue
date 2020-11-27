<template>
	<div>
		<b-row class="mt-4">
			<b-col sm="12" md="6">
				<div id="tickets-table_length" class="dataTables_length">
					<label class="d-inline-flex align-items-center">
						Show&nbsp;
						<b-form-select v-model="perPage" size="sm" :options="pageOptions"></b-form-select>&nbsp;entries
					</label>
				</div>
			</b-col>

			<!-- Search -->
			<b-col sm="12" md="6">
				<div id="tickets-table_filter" class="dataTables_filter text-md-right">
					<label class="d-inline-flex align-items-center">
						Search:
						<b-form-input
								v-model="filter"
								type="search"
								placeholder="Search..."
								class="form-control form-control-sm ml-2"
						></b-form-input>
					</label>
				</div>
			</b-col>
			<!-- End search -->
		</b-row>

		<!-- Table -->
		<div class="table-responsive mb-0">
			<b-table :id="customRef" hover show-empty :items="items" :filter="filter" :fields="fields" :responsive=true :current-page="currentPage" :per-page="perPage">
				<template v-for="slot in slots" v-slot:[`cell(${slot})`]="data">
					<slot :name="slot" :tbl="data"></slot>
				</template>
			</b-table>
		</div>

		<b-row>
			<b-col>
				<div class="dataTables_paginate paging_simple_numbers float-right">
					<ul class="pagination pagination-rounded mb-0">
						<!-- pagination -->
						<b-pagination v-model="currentPage" :total-rows="totalItems" :per-page="perPage"></b-pagination>
					</ul>
				</div>
			</b-col>
		</b-row>
	</div>
</template>

<script>
export default {
  name: "data-table",
  props: {
    items: [Array, Function],
    sortBy: [String],
    fields: [Array],
    totalItems: [Number],
    slots: [Array],
    customRef: [String]
  },
  data() {
    return {
      pageOptions: [10, 25, 50, 100],
      perPage: 10,
      filter: null,
      currentPage: 1
    }
  }
}
</script>