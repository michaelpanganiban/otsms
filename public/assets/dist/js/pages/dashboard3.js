/* global Chart:false */
let this_year = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
let last_year = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
$(function () {
  'use strict'
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  const months = ['JAN','FEB','MAR','APR','MAY','JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  $.post('/fetchDashboard', function(r){
    let total_this_year = 0
    let total_last_year = 0
    r.this_year.map(x => {
      this_year[x.month_date-1] = x.amount
      total_this_year = parseFloat(total_this_year) + parseFloat(x.amount)
    })
    $(".total").html(total_this_year.toFixed(2))
    r.last_year.map(x => {
      last_year[x.month_date-1] = x.amount
      total_last_year = parseFloat(total_last_year) + parseFloat(x.amount)
    })
    $(".total-last").html(total_last_year.toFixed(2))
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: months,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: this_year
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: last_year
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }

                return '₱' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
    const type = [0, 0, 0]
    r.type.map(x => {
      if(x.type == 'Sale')
        type[1] = x.order_count
      else
        type[2] = x.order_count
    })
    r.custom.map(x => {
      type[0] = x.custom_count
    })
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Customized',
          'Sales',
          'Rent',
      ],
      datasets: [
        {
          data: type,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
  })
})