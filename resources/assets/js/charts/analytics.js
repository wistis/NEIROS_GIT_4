const chartHolder = document.querySelector('.js-analytics')

if (chartHolder) {
  const chartHolderWidth = chartHolder.parentNode.clientWidth
  chartHolder.style.width = chartHolderWidth + 'px'

  const chart = echarts.init(chartHolder)

  const labelOption = {
    normal: {
      show: false,
      position: 'insideBottom',
      distance: 40,
      align: 'left',
      verticalAlign: 'middle',
      rotate: 90,
      // formatter: '{c}  {name|{a}}',
      fontSize: 14
    }
  }


  // specify chart configuration item and data
  const option = {
    title: {
      text: 'График'
    },
    color: [ '#003366', '#006699', '#4cabce', '#e5323e' ],
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow'
      }
    },
    legend: {
      type: 'scroll',
      orient: 'vertical',
      right: 10,
      top: 30,
      bottom: 20,
      data: [ 'Forest', 'Steppe', 'Desert', 'Wetland' ]
    },
    toolbox: {
      show: true,
      orient: 'horizontal',
      top: 23,
      left: 0,
      itemsSize: 20,
      feature: {
        magicType: { show: true, type: [ 'line', 'bar', 'stack' ] }
      }
    },
    calculable: true,
    xAxis: [
      {
        type: 'category',
        axisTick: { show: false },
        data: [ '2012', '2013', '2014', '2015', '2016' ]
      }
    ],
    yAxis: [
      {
        type: 'value'
      }
    ],
    series: [
      {
        name: 'Forest',
        type: 'line',
        label: labelOption,
        data: [ 320, 332, 301, 334, 390 ]
      },
      {
        name: 'Steppe',
        type: 'line',
        label: labelOption,
        data: [ 220, 182, 191, 234, 290 ]
      },
      {
        name: 'Desert',
        type: 'line',
        label: labelOption,
        data: [ 150, 232, 201, 154, 190 ]
      },
      {
        name: 'Wetland',
        type: 'line',
        label: labelOption,
        data: [ 98, 77, 101, 99, 40 ]
      }
    ]
  }

// use configuration item and data specified to show chart
  chart.setOption(option)
}


