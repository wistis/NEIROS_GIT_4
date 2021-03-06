var chartHolder = document.querySelector('.js-analytics');

if (chartHolder) {
    var chartHolderWidth = chartHolder.parentNode.clientWidth;
    chartHolder.style.width = chartHolderWidth + 'px';
    var chart = echarts.init(chartHolder);
    var labelOption = {
        normal: {
            show: false,
            position: 'insideBottom',
            distance: 40,
            align: 'left',
            verticalAlign: 'middle',
            rotate: 90,
            // formatter: '{c}  {name|{a}}',
            fontSize: 14 // rich: {
            //     name: {
            //         textBorderColor: '#fff'
            //     }
            // }

        } // specify chart configuration item and data

    };
    var option = {
        title: {
            text: 'График',left: 'center'
        },
        color: ['#003366', '#006699', '#4cabce', '#e5323e'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            data: ['Сделки', 'Визиты', 'Посетители' ,'Конверсия'],
            orient: 'vertical',
            left: 'right',
            top: 'center',
        },
        toolbox: {
            show: true,
            orient: 'horizontal',
            left: 'left',
            top: 'top',
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: false,
                    readOnly: false
                },
                magicType: {
                    show: true,
                    type: ['line', 'bar', 'stack', ]
                },
                restore: {
                    show: false
                },

            }
        },
        calculable: true,
        xAxis: [{
            type: 'category',
            axisTick: {
                show: false
            },
            data:datatotable['dates']// ['2012', '2013', '2014', '2015', '2016']
        }],
        yAxis: [{
            type: 'value'
        }],
        series: [{
            name: 'Сделки',
            type: 'line',
            barGap: 0,
            label: labelOption,
            data: datatotable['leads']//[320, 332, 301, 334, 390]
        }, {
            name: 'Визиты',
            type: 'line',
            label: labelOption,
            data: datatotable['visit']//[220, 182, 191, 234, 290]
        }, {
            name: 'Посетители',
            type: 'line',
            label: labelOption,
            data: datatotable['posetitel'] //[150, 232, 201, 154, 190]
        } , {
            name: 'Конверсия',
            type: 'line',
            label: labelOption,
            data: datatotable['conversion'] //[150, 232, 201, 154, 190]
        } ]
    }; // use configuration item and data specified to show chart

    chart.setOption(option);
}
