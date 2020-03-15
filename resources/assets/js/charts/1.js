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
    option = {
        title: {
            text: 'Воронка',
            subtext: 'Посетитель в заявку'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}%"
        },
        toolbox: {
            feature: {
                dataView: {readOnly: false},
                restore: {},
                saveAsImage: {}
            }
        },
        legend: {
            data: ['Посетители','Сделки' ]
        },
        series: [
            {
                name: '预期',
                type: 'funnel',
                left: '10%',
                width: '80%',
                label: {
                    normal: {
                        formatter: '{b} '
                    },
                    emphasis: {
                        position:'inside',
                        formatter: '{b} : {c}%'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                itemStyle: {
                    normal: {
                        opacity: 0.7
                    }
                },
                data: [
                    {value: 100, name: '50%'},
                    {value: 80, name: '50%'},


                ]
            }, {
                name: 'Воронка 1',
                type: 'funnel',
                left: '10%',
                width: '80%',
                label: {
                    normal: {
                        formatter: '{b} '
                    },
                    emphasis: {
                        position:'inside',
                        formatter: '{b} : {c}%'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                itemStyle: {
                    normal: {
                        opacity: 0.7
                    }
                },
                data: [
                    {value: 100, name: 'Посетители ('+datatotable['posetitel']+')' },
                    {value: datatotable['conversion'], name: 'Сделки ('+datatotable['leads']+')'},

                ]
            }

        ]
    };


    chart.setOption(option);
}