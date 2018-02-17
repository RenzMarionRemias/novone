var month = [
    'January',
    'February',
    'March',
    'Apply',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
]
/*
var ctx = document.getElementById("salesChart").getContext('2d');
ctx.height = 200;
ctx.width = 200;
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

*/


function generateChart(data) {

    var colors = [];

    return new Chart(data.element, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: data.datasets[0].label,
                    data: data.datasets[0].data,
                    borderWidth: 1,
                    backgroundColor:randomColors( data.datasets[0].data.length)

                }
            ]
        },
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: true
                        }
                    }
                ]
            }
        }
    });
}

//clientMonthlyRegisterChart

// DASHBOARD
function generateSalesReport(element,type,range) {
    console.log(range);
    range = range ? range : {}
    $.ajax({
        url: '/novone/public/api/reports/sales?type='+type,
        data:range,
        success: function (result) {
            var recentSales = {
                element: document
                    .getElementById(element)
                    .getContext('2d'),
                labels: result
                    .map(function (e,index) {
                        if(type == 'month'){
                            return month[index]
                        }
                        return e.date
                    }),
                datasets: [
                    {
                        data: result
                            .map(function (e) {
                                return e.total
                            }),
                        label: 'No of sales',
                        borderWidth: 1
                    }
                ]

            }

            generateChart(recentSales)
        }
    });
}

generateSalesReport('salesChart','date',{});
generateSalesReport('monthlySalesChart','month',{});

function generateUserChart(element) {
    var colors = [];
    $.ajax({
        url: '/novone/public/api/reports/clients',
        success: function (result) {
            var recentSales = {
                element: document
                    .getElementById(element)
                    .getContext('2d'),
                labels: result
                    .map(function (e,index) {
                        console.log(e.date)
                        return month[e.date - 1]
                    }),
                datasets: [
                    {
                        data: result
                            .map(function (e) {
                                return e.client
                            }),
                        label: 'No of clients',
                        borderWidth: 1
                    }
                ]

            }

            generateChart(recentSales)
        }
    });
}
//<div class="panel-body">A Basic Panel</div>
function getCriticalLevelProducts() {
    var template = '';
    
    $.ajax({
        method:'get',
        url: '/novone/public/api/products/critical',
        success: function (result) {
            result.map(function(e) {
                e = '<div class="panel-body" style="padding:0px;margin:0px; text-transform: capitalize;"><b style="text-transform: capitalize;">Product Name:</b>'+e.product_name+' <b>Quantity:</b>'+e.quantity+'</div>';
                $('#criticalProductDiv').append(e);
            })
        }
    });
}

function topProducts(){

    var element = document
    .getElementById('topProducts')
    .getContext('2d'),
    colors = [];

    $.ajax({
        url: '/novone/public/api/products/totalsales',
        success: function (result) {


            var data = {
                datasets: [{
                    data: result.map(function(e){
                        return e.total_bundle
                    }),
                    backgroundColor: randomColors(result.length),
                    borderColor: 'rgba(200, 200, 200, 0.75)'
                }],
                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: result.map(function(e){
                    return e.product_name
                })
            };
            console.log(data);

            var myPieChart = new Chart(element,{
                type: 'pie',
                data: data
            });
        }
    })
    

    
}



function randomColors(length) {

    var colors = [];
    for(var x=0;x<length;x++){
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        colors[x] =  "rgb(" + r + "," + g + "," + b + ")";
    }

    return colors;
}


// FILTERING

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    console.log('start ' + start.format('YYYY-MM-DD') + 'end '+ end.format('YYYY-MM-DD') )
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var range = {
        start:start.format('YYYY-MM-DD'),
        end: end.format('YYYY-MM-DD')
    }
    generateSalesReport('monthlySalesChart','range',range);
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);


getCriticalLevelProducts();
generateUserChart('clientMonthlyRegisterChart')
topProducts()