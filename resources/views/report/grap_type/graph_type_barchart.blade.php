
<figure class="highcharts-figure" style="overflow-x:scroll;">
    <div class="inChartTitle"></div>
    <hr/>
    <div id="bar_container" style="float:left;width:auto; height: 400px; margin: 0 auto"></div>
</figure>
<script type="text/javascript">

// {
//     name: "Chrome",
//     y: 62.74,
//     drilldown: "Chrome"
// },
let bartitle = '{{$title}}';
let barsubTitle = '';
let bardata =  [];
let totalRow = 0;
let totalOthers = 0;

@if ($list)
    @foreach ($list as $item)
        @if ($loop->index <=10)
            bardata.push({
                name: '{{$item->name}}',
                y: {{$item->total}},
            });
            totalRow = totalRow + 1;
            @else
            totalOthers = totalOthers + {{$item->total}};
        @endif
    @endforeach
    bardata.push({
        name: 'SELAIN',
        y: totalOthers
    });
@endif
$('#bar_container').css({'width':(200 + (totalRow*50) + 'px')});
$('.title-report span').text(bartitle);
$('.inChartTitle').text(bartitle);

if(bardata.length > 0){
    bardata = _.sortBy(bardata, o => o.y).reverse();
}


Highcharts.setOptions({
    marginTop: '100px',
    lang: {
      thousandsSep: ',',
      numericSymbols: [' Ribu', ' Juta']
    },
    credits: {
        enabled: false
    },
  });

// Create the chart
Highcharts.chart('bar_container', {
    chart: {
        type: 'column',
        backgroundColor: 'rgba(0,0,0,0)'
    },
    title: {
        text: ''
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        labels: {
            style: {
                fontSize: '10px !important',
                color: '#000000'
            }
        },
        type: 'category'
    },
    yAxis: {
        labels: {
            style: {
                fontSize: '12px !important',
                color: '#000000'
            }
        },
        title: {
            text: 'Jumlah Kenderaan'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: false,
                format: 'Jumlah {point.y: ,.0f}'
            }
        }
    },
    tooltip: {
        distance:0,
        headerFormat: '<h3 style="font-size:13px; margin-bottom:10px;">{point.key}</h3><br/>',
        pointFormat: '<br/><br/>',
        footerFormat: '<b style="padding-top:10px;">Jumlah : {point.y:,.0f}</b>'
    },

    series: [
        {
            name: "",
            colorByPoint: true,
            data: bardata
        }
    ]
});

Highcharts.setOptions({
    lang: {
      thousandsSep: ','
    }
  });
</script>
