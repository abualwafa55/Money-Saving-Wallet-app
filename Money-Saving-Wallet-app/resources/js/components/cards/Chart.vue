<template>
  <div class="container">
    <center><h1>Vue laravel Chartjs</h1></center>
    <canvas ref="chart"></canvas>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  mounted() {
    let uri = "http://127.0.0.1:8000/api/chart";
    this.axios
      .get(uri)
      .then((response) => {
        var chart = this.$refs.chart;
        var ctx = chart.getContext("2d");
        var myChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: response.data.month,

            datasets: [
              {
                label: "expenses",
                borderColor: "#FC2525",
                pointBackgroundColor: "white",
                borderWidth: 1,
                pointBorderColor: "white",
                backgroundColor: this.gradient,
                data: response.data.expenses,
              },
              {
                label: "incomes",
                borderColor: "#05CBE1",
                pointBackgroundColor: "white",
                pointBorderColor: "white",
                borderWidth: 1,
                backgroundColor: this.gradient2,
                data: response.data.incomes,
              },
            ],
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true,
                  },
                },
              ],
            },
          },
        });
      })
      .catch((error) => {
        console.log(error);
        this.errored = true;
      });
  },
};
</script>