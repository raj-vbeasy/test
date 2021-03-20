<template>
  <div>
    <b-row>
      <b-col>
        <p>
          Below is preview of settlement
          <b-button
            variant="outline-info"
            style="float: right"
          >
            Download
          </b-button>
        </p>
      </b-col>
    </b-row>
    <b-row class="mt-3">
      <b-col>
        <b-card style="box-shadow: 1px 1px 8px 0">
          <p>Gross Ticket Revenue <span class="pull-right">$0.00</span></p>
          <p>Taxes & Fees <span class="pull-right">$0.00</span></p>
          <p>Adj. Ticket Gross <span class="pull-right">$0.00</span></p>
          <p>Additional Revenue <span class="pull-right">$0.00</span></p>
          <p>Total Expenses <span class="pull-right">$0.00</span></p>
          <hr>
          <p>
            <strong>Net Profit <span class="pull-right">$0.00</span></strong>
          </p>
          <hr>
          <p>Actual Attendance <span class="pull-right">0</span></p>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: "SettlementTab"
};
</script>

<style scoped></style>
