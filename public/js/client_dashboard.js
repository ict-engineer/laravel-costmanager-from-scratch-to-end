// Dashboard - Analytics
//----------------------

var revenueLineChartCTX = $("#revenue-line-chart");

var revenueLineChartOptions = {
    responsive: true,
    // maintainAspectRatio: false,
    legend: {
        display: false
    },
    hover: {
        mode: "label"
    },
    scales: {
        xAxes: [
            {
            display: true,
            gridLines: {
                display: false
            },
            ticks: {
                fontColor: "#fff"
            }
            }
        ],
        yAxes: [
            {
            display: true,
            fontColor: "#fff",
            gridLines: {
                display: true,
                color: "rgba(255,255,255,0.3)"
            },
            ticks: {
                beginAtZero: false,
                fontColor: "#fff",
                callback: function(value, index, values) {
                    if(parseInt(value) >= 1000){
                      return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
                      return '$' + value;
                    }
                }
            }
            }
        ]
    }
};



var revenueLineChart;
// setInterval(function () {
//    // Get a random index point
//    var indexToUpdate = Math.round(Math.random() * (revenueLineChartData.labels.length - 1));
//    if (typeof revenueLineChart != "undefined") {
//       // Update one of the points in the second dataset
//       if (revenueLineChartData.datasets[0].data[indexToUpdate]) {
//          revenueLineChartData.datasets[0].data[indexToUpdate] = Math.round(Math.random() * 100);
//       }
//       if (revenueLineChartData.datasets[1].data[indexToUpdate]) {
//          revenueLineChartData.datasets[1].data[indexToUpdate] = Math.round(Math.random() * 100);
//       }
//       revenueLineChart.update();
//    }
// }, 2000);





// Create the chart

$(function () {
    /*
    * STATS CARDS
    */
    // Bar chart ( New Clients)
    $("#clients-bar").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 70, 50, 75, 65, 80, 70, 65, 90, 65, 80, 70, 65, 90], {
        type: "bar",
        height: "25",
        barWidth: 7,
        barSpacing: 4,
        barColor: "#b2ebf2",
        negBarColor: "#81d4fa",
        zeroColor: "#81d4fa"
    });
    // Total Sales - Bar
    $("#sales-compositebar").sparkline([4, 6, 7, 7, 4, 3, 2, 3, 1, 4, 6, 5, 9, 4, 6, 7, 7, 4, 6, 5, 9], {
        type: "bar",
        barColor: "#F6CAFD",
        height: "25",
        width: "100%",
        barWidth: "7",
        barSpacing: 4
    });
    
    // Tristate chart (Today Profit)
    $("#profit-tristate").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 70, 50, 75, 65, 80, 70, 65, 90, 65, 80, 70, 65, 90], {
    type: "bar",
    height: "25",
    barWidth: 7,
    barSpacing: 4,
    barColor: "#b2ebf2",
    negBarColor: "#81d4fa",
    zeroColor: "#81d4fa"
    });
    // Line chart ( New Invoice)
    $("#invoice-line").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 70, 50, 75, 65, 80, 70, 65, 90, 65, 80, 70, 65, 90], {
    type: "bar",
    height: "25",
    barWidth: 7,
    barSpacing: 4,
    barColor: "#b2ebf2",
    negBarColor: "#81d4fa",
    zeroColor: "#81d4fa"
    });
});
 