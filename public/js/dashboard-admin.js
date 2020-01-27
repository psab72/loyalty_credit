/**
 * Created by USER on 10/12/2018.
 */
$(document).ready(function() {
    $('#execute-date-range').on('click', function() {
        executeDateRange();
    });

    executeDateRange();

    function executeDateRange() {
        var fromYear = !isEmpty($('.month-range-from-year').val()) ? $('.month-range-from-year').val() : '';
        var fromMonth =  !isEmpty($('.month-range-from-month').val()) ? $('.month-range-from-month').val() : '';

        var from = fromYear + '-' + fromMonth + '-01';

        var toYear = !isEmpty($('.month-range-to-year').val()) ? $('.month-range-to-year').val() : '';
        var toMonth = !isEmpty($('.month-range-to-month').val()) ? $('.month-range-to-month').val() : '';

        var to = toYear + '-' + toMonth + '-01';
        to = moment(to).endOf('month').format('YYYY-MM-DD');

        var dateStart = moment(from);
        var dateEnd = moment(to).endOf('month');
        var timeValues = [];

        while (dateEnd > dateStart || dateStart.format('M') === dateEnd.format('M')) {
            timeValues.push(dateStart.format('MMM YY'));
            dateStart.add(1,'month');
        }

        $.get(url + '/sales-data?from=' + from + '&to=' + to, function(data) {
            var countAmountLentPerMonth = data.amount_lent.length;
            var countAmountAtRiskPerMonth = data.amount_at_risk.length;
            var countLateBillsPerMonth = data.late_bills.length;
            var countRepaidPerMonth = data.repaid.length;
            var historyAmountLentData = [];
            var historyAmountAtRiskData = [];
            var historyLateBillsData = [];
            var historyRepaidData = [];
            var currAmountLentDataPerMonth;
            var currAmountAtRiskPerMonth;
            var currLateBillsPerMonth;
            var currRepaidPerMonth;

            var fromYear = !isEmpty($('.month-range-from-year').val()) ? $('.month-range-from-year').val() : '';
            var fromMonth =  !isEmpty($('.month-range-from-month').val()) ? $('.month-range-from-month').val() : '';

            var from = fromYear + '-' + fromMonth + '-01';

            var toYear = !isEmpty($('.month-range-to-year').val()) ? $('.month-range-to-year').val() : '';
            var toMonth = !isEmpty($('.month-range-to-month').val()) ? $('.month-range-to-month').val() : '';

            var to = toYear + '-' + toMonth + '-01';
            to = moment(to).endOf('month').format('YYYY-MM-DD');

            var dateStart = moment(from);
            var dateEnd = moment(to).endOf('month');
            var timeValues = [];

            while (dateEnd > dateStart || dateStart.format('M') === dateEnd.format('M')) {
                timeValues.push(dateStart.format('MMM YY'));
                dateStart.add(1,'month');
            }

            var currTimeValue;
            for(var i=0;i<timeValues.length;i++) {
                currTimeValue = timeValues[i];
                for(var j=0;j<countAmountLentPerMonth;j++) {
                    currAmountLentDataPerMonth = data.amount_lent[j];
                    if(currAmountLentDataPerMonth.month == currTimeValue) {
                        historyAmountLentData[i] = currAmountLentDataPerMonth.amount;
                    }
                }

                for(var k=0;k<countAmountAtRiskPerMonth;k++) {
                    currAmountAtRiskPerMonth = data.amount_at_risk[k];
                    if(currAmountAtRiskPerMonth.month == currTimeValue) {
                        historyAmountAtRiskData[i] = currAmountAtRiskPerMonth.amount;
                    }
                }

                for(var l=0;l<countLateBillsPerMonth;l++) {
                    currLateBillsPerMonth = data.late_bills[l];
                    if(currLateBillsPerMonth.month == currTimeValue) {
                        historyLateBillsData[i] = currLateBillsPerMonth.amount;
                    }
                }

                for(var m=0;m<countRepaidPerMonth;m++) {
                    currRepaidPerMonth = data.repaid[m];
                    if(currRepaidPerMonth.month == currTimeValue) {
                        historyRepaidData[i] = currRepaidPerMonth.amount;
                    }
                }
            }

            var currHistoryAmountLentData;
            for(var i=0;i<historyAmountLentData.length;i++) {
                currHistoryAmountLentData = historyAmountLentData[i];

                if(isEmpty(currHistoryAmountLentData)) {
                    historyAmountLentData[i] = 0.00;
                }
            }

            var currHistoryAmountAtRiskData;
            for(var i=0;i<historyAmountAtRiskData.length;i++) {
                currHistoryAmountAtRiskData = historyAmountAtRiskData[i];
                if(isEmpty(currHistoryAmountAtRiskData)) {
                    historyAmountAtRiskData[i] = 0.00;
                }
            }

            var currHistoryLateBillsData;
            for(var i=0;i<historyLateBillsData.length;i++) {
                currHistoryLateBillsData = historyLateBillsData[i];
                if(isEmpty(currHistoryLateBillsData)) {
                    historyLateBillsData[i] = 0.00;
                }
            }

            var currHistoryRepaidData;
            for(var i=0;i<historyRepaidData.length;i++) {
                currHistoryRepaidData = historyRepaidData[i];
                if(isEmpty(currHistoryRepaidData)) {
                    historyRepaidData[i] = 0.00;
                }
            }

            updateConfigByMutating(myChart, timeValues, historyAmountLentData, historyAmountAtRiskData, historyLateBillsData, historyRepaidData);
        })
    }

    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
//                    labels: amountLentHistoryLabels,
            datasets: [{
//                        lineTension: 0,
                label: '',
                data: [],
            }]
        },
        options: {
            pointHitDetectionRadius: 1,
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            elements: {
                line: {
                    borderWidth: 2
                },
                point: {
                    radius: 0,
                    hitRadius: 10,
                    hoverRadius: 4,
                    hoverBorderWidth: 2,
                }
            },
        }
    });

    $('.datatable').DataTable( {
        "ordering": false
    } );

    function updateConfigByMutating(chart, timeValues, amountLentData, amountAtRiskData, lateBillsData, repaidData) {
//                chart.options.title.text = 'new title';
        chart.data.labels = timeValues;

        var countAmountLentData = amountLentData.length;
        var amountLentHistoryData = [];
        chart.data.datasets = [];
        for(var i=0;i<countAmountLentData;i++) {
            amountLentHistoryData.push(amountLentData[i]);
        }
        chart.data.datasets[0] = {
            label: 'Amount Lent',
            data: amountLentHistoryData,
            // borderWidth: 1,
            backgroundColor:'transparent',
            borderColor: [
                '#63c2de',
            ],
            pointHoverBackgroundColor: '#63c2de',
            pointHoverBorderColor: '#63c2de',
            pointBorderWidth: 2
        };

        var countAmountAtRiskData = amountAtRiskData.length;
        var amountAtRiskHistoryData = [];
        // chart.data.datasets = [];
        for(var i=0;i<countAmountAtRiskData;i++) {
            amountAtRiskHistoryData.push(amountAtRiskData[i]);
        }
        chart.data.datasets[1] = {
            label: 'Amount At Risk',
            data: amountAtRiskHistoryData,
            // borderWidth: 1,
            backgroundColor: 'transparent',
            borderColor: [
                '#f86c6b',
            ],
            pointHoverBackgroundColor:'#f86c6b',
            pointHoverBorderColor:'#f86c6b',
            pointHoverBorderWidth: 2
        };

        var countLateBillsData = lateBillsData.length;
        var lateBillsHistoryData = [];
        // chart.data.datasets = [];
        for(var i=0;i<countLateBillsData;i++) {
            lateBillsHistoryData.push(lateBillsData[i]);
        }
        chart.data.datasets[2] = {
            label: 'Late Bills',
            data: lateBillsHistoryData,
            // borderWidth: 1,
            backgroundColor:'transparent',
            borderColor: [
                '#ffc107',
            ],
            pointHoverBackgroundColor: '#ffc107',
            pointHoverBorderColor: '#ffc107',
            pointHoverBorderWidth: 2
        };

        var countRepaidData = repaidData.length;
        var repaidHistoryData = [];
        // chart.data.datasets = [];
        for(var i=0;i<countRepaidData;i++) {
            repaidHistoryData.push(repaidData[i]);
        }
        chart.data.datasets[3] = {
            label: 'Repaid',
            data: repaidHistoryData,
            // borderWidth: 1,
            backgroundColor:'transparent',
            borderColor: [
                '#4dbd74',
            ],
            pointHoverBackgroundColor: '#4dbd74',
            pointHoverBorderColor: '#4dbd74',
            pointBorderWidth: 2
        };


        chart.update();
    }

    function addData(chart, label, data) {
        chart.data.labels.push(label);
        chart.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
        chart.update();
    }

    function removeData(chart) {
        chart.data.labels.pop();
        chart.data.datasets.forEach((dataset) => {
            dataset.data.pop();
        });
        chart.update();
    }
});